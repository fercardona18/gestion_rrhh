const { createBot, createProvider, createFlow, addKeyword } = require('@bot-whatsapp/bot');
const QRPortalWeb = require('@bot-whatsapp/portal');
const BaileysProvider = require('@bot-whatsapp/provider/baileys');
const MySQLAdapter = require('@bot-whatsapp/database/mysql');

// Detalles de conexión MySQL
const MYSQL_DB_HOST = 'localhost';
const MYSQL_DB_USER = 'root';
const MYSQL_DB_PASSWORD = '';
const MYSQL_DB_NAME = 'recursos_humanos';
const MYSQL_DB_PORT = '3308';

// Conexión a la base de datos
let connection;

// Función para establecer la conexión a la base de datos
async function conectarBaseDeDatos() {
    const mysql = require('mysql2/promise');
    try {
        connection = await mysql.createConnection({
            host: MYSQL_DB_HOST,
            user: MYSQL_DB_USER,
            database: MYSQL_DB_NAME,
            password: MYSQL_DB_PASSWORD,
            port: MYSQL_DB_PORT,
        });
        console.log('Conexión a la base de datos establecida con éxito');
    } catch (error) {
        console.error('Error al conectar a la base de datos:', error);
        throw error;
    }
}

// Funciones auxiliares para obtener datos
async function obtenerDatosEmpleadoPorEmail(email) {
    try {
        if (!email) {
            console.error('Email no proporcionado');
            return null;
        }
        const [filas] = await connection.execute('SELECT * FROM empleados WHERE email = ?', [email]);
        return filas.length > 0 ? filas[0] : null;
    } catch (error) {
        console.error('Error al obtener datos del empleado:', error);
        return null;
    }
}

async function validarContraseña(email, password) {
    try {
        console.log('Intentando validar contraseña para email:', email);
        if (!email) {
            console.error('Email no proporcionado para validación');
            return null;
        }
        const empleado = await obtenerDatosEmpleadoPorEmail(email);
        
        if (!empleado) {
            console.log('No se encontró el empleado con el email:', email);
            return null;
        }
        
        console.log('Empleado encontrado:', empleado.email);
        console.log('Contraseña almacenada:', empleado.password);
        console.log('Contraseña ingresada:', password);
        
        const isValid = empleado.password === password;
        console.log('Resultado de la comparación:', isValid);
        
        return isValid ? empleado : null;
    } catch (error) {
        console.error('Error al validar la contraseña:', error);
        return null;
    }
}

async function obtenerDatosNominaPorEmpleadoId(empleadoId) {
    try {
        const [filas] = await connection.execute('SELECT * FROM nominas WHERE empleado_id = ?', [empleadoId]);
        return filas.length > 0 ? filas[0] : null;
    } catch (error) {
        console.error('Error al obtener datos de nómina:', error);
        return null;
    }
}

async function obtenerDatosVacacionesPorEmpleadoId(empleadoId) {
    try {
        const [filas] = await connection.execute('SELECT * FROM vacaciones WHERE empleado_id = ?', [empleadoId]);
        return filas.length > 0 ? filas[0] : null;
    } catch (error) {
        console.error('Error al obtener datos de vacaciones:', error);
        return null;
    }
}

// Función para formatear fechas
function formatearFecha(fecha) {
    if (!fecha) return 'No disponible';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(fecha).toLocaleDateString('es-ES', options);
}

// Mensaje con opciones disponibles
const mensajeOpciones = `
Selecciona una opción:
👉 *info personal* para ver tu información personal
👉 *nomina* para ver tu nómina
👉 *vacaciones* para verificar tus vacaciones
👉 *salir* para terminar la conversación
`;

// Flujo de Información Personal
const flujoInfoPersonal = addKeyword(['info personal', 'información personal'])
    .addAnswer('📋 Aquí puedes consultar tu información personal.')
    .addAnswer(
        '📧 Por favor, proporciona tu correo electrónico para continuar.',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, state }) => {
            const email = ctx.body.toLowerCase().trim();
            console.log('Email recibido:', email);

            const empleadoData = await obtenerDatosEmpleadoPorEmail(email);
            console.log('Datos del empleado:', empleadoData ? 'Encontrado' : 'No encontrado');

            if (empleadoData) {
                await state.update({ email: email });
                await flowDynamic('🔒 Por favor, ingresa tu contraseña para continuar.');
                return;
            } else {
                await flowDynamic('❌ No se encontró información para ese correo electrónico. Intenta de nuevo.');
                return fallBack();
            }
        }
    )
    .addAnswer(
        '🔑 Ingresa tu contraseña:',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, endFlow, state }) => {
            const password = ctx.body;
            console.log('Contraseña recibida: [OCULTA]');

            const currentState = state.getMyState();
            const email = currentState.email;
            console.log('Email actual:', email);

            const empleadoValidado = await validarContraseña(email, password);
            console.log('Resultado de validación:', empleadoValidado ? 'Exitoso' : 'Fallido');

            if (empleadoValidado) {
                const infoPersonal = `
👤 Tu información personal:
Nombre: ${empleadoValidado.name}
Dirección: ${empleadoValidado.direccion}
Teléfono: ${empleadoValidado.telefono}
Email: ${empleadoValidado.email}
DPI: ${empleadoValidado.dpi}
Días de vacaciones disponibles: ${empleadoValidado.dias_vacaciones_disponibles}
Fecha de nacimiento: ${formatearFecha(empleadoValidado.fecha_nacimiento)}
Estado civil: ${empleadoValidado.estado_civil}
Fecha de ingreso: ${formatearFecha(empleadoValidado.fecha_ingreso)}

${mensajeOpciones}
                `;
                await flowDynamic(infoPersonal);
                return endFlow();
            } else {
                await flowDynamic('❌ Contraseña incorrecta. Por favor, intenta de nuevo.');
                return fallBack();
            }
        }
    );

// Flujo de Nómina
const flujoNomina = addKeyword(['nomina', 'mi nomina'])
    .addAnswer('💰 Aquí puedes consultar tu nómina.')
    .addAnswer(
        '📧 Por favor, proporciona tu correo electrónico para continuar.',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, state }) => {
            const email = ctx.body.toLowerCase().trim();
            console.log('Email recibido:', email);

            const empleadoData = await obtenerDatosEmpleadoPorEmail(email);
            if (empleadoData) {
                await state.update({ email: email, empleadoId: empleadoData.id });
                await flowDynamic('🔒 Por favor, ingresa tu contraseña para continuar.');
                return;
            } else {
                await flowDynamic('❌ No se encontró información para ese correo electrónico. Intenta de nuevo.');
                return fallBack();
            }
        }
    )
    .addAnswer(
        '🔑 Ingresa tu contraseña:',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, endFlow, state }) => {
            const password = ctx.body;
            console.log('Contraseña recibida: [OCULTA]');

            const currentState = state.getMyState();
            const email = currentState.email;
            console.log('Email actual:', email);

            const empleadoValidado = await validarContraseña(email, password);
            console.log('Resultado de validación:', empleadoValidado ? 'Exitoso' : 'Fallido');

            if (empleadoValidado) {
                const nominaData = await obtenerDatosNominaPorEmpleadoId(currentState.empleadoId);
                let mensajeNomina;
                if (nominaData) {
                    mensajeNomina = `
💵 Tu nómina:
Salario Base: ${nominaData.salario_base}
Horas Extras: ${nominaData.horas_extras || 'No aplica'}
Deducciones: ${nominaData.deducciones || 'No aplica'}
Bonificaciones: ${nominaData.bonificaciones || 'No aplica'}
Prestaciones: ${nominaData.prestaciones || 'No aplica'}
Total a Pagar: ${nominaData.total_a_pagar}

${mensajeOpciones}
                    `;
                } else {
                    mensajeNomina = `No se encontró información de nómina para tu cuenta.\n\n${mensajeOpciones}`;
                }
                await flowDynamic(mensajeNomina);
                return endFlow();
            } else {
                await flowDynamic('❌ Contraseña incorrecta. Por favor, intenta de nuevo.');
                return fallBack();
            }
        }
    );

// Flujo de Vacaciones
const flujoVacaciones = addKeyword(['vacaciones', 'mis vacaciones'])
    .addAnswer('🌴 Aquí puedes verificar tus vacaciones.')
    .addAnswer(
        '📧 Por favor, proporciona tu correo electrónico para continuar.',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, state }) => {
            const email = ctx.body.toLowerCase().trim();
            console.log('Email recibido:', email);

            const empleadoData = await obtenerDatosEmpleadoPorEmail(email);
            if (empleadoData) {
                await state.update({ email: email, empleadoId: empleadoData.id });
                await flowDynamic('🔒 Por favor, ingresa tu contraseña para continuar.');
                return;
            } else {
                await flowDynamic('❌ No se encontró información para ese correo electrónico. Intenta de nuevo.');
                return fallBack();
            }
        }
    )
    .addAnswer(
        '🔑 Ingresa tu contraseña:',
        { capture: true },
        async (ctx, { flowDynamic, fallBack, endFlow, state }) => {
            const password = ctx.body;
            console.log('Contraseña recibida: [OCULTA]');

            const currentState = state.getMyState();
            const email = currentState.email;
            console.log('Email actual:', email);

            const empleadoValidado = await validarContraseña(email, password);
            console.log('Resultado de validación:', empleadoValidado ? 'Exitoso' : 'Fallido');

            if (empleadoValidado) {
                const vacacionesData = await obtenerDatosVacacionesPorEmpleadoId(currentState.empleadoId);
                let mensajeVacaciones;
                if (vacacionesData) {
                    mensajeVacaciones = `
🏖️ Tus vacaciones:
Fecha de inicio: ${formatearFecha(vacacionesData.fecha_inicio)}
Fecha de fin: ${formatearFecha(vacacionesData.fecha_fin)}
Días solicitados: ${vacacionesData.dias_solicitados}
Estado: ${vacacionesData.estado}

${mensajeOpciones}
                    `;
                } else {
                    mensajeVacaciones = `No se encontró información de vacaciones para tu cuenta.\n\n${mensajeOpciones}`;
                }
                await flowDynamic(mensajeVacaciones);
                return endFlow();
            } else {
                await flowDynamic('❌ Contraseña incorrecta. Por favor, intenta de nuevo.');
                return fallBack();
            }
        }
    );

// Flujo Principal
const flujoPrincipal = addKeyword(['ingreso recursos humanos', 'hola', 'inicio'])
    .addAnswer('🙌 Hola, bienvenido al sistema de Recursos Humanos')
    .addAnswer(mensajeOpciones);

// Flujo de Salida
const flujoSalida = addKeyword(['salir', 'terminar', 'finalizar'])
    .addAnswer('Gracias por usar nuestro sistema de Recursos Humanos. ¡Hasta pronto! 👋')
    .addAction(async (ctx, { endFlow }) => {
        return endFlow();
    });

// Función principal
const main = async () => {
    try {
        await conectarBaseDeDatos();
        
        console.log('Conexión a la base de datos establecida');

        const adapterDB = new MySQLAdapter({
            host: MYSQL_DB_HOST,
            user: MYSQL_DB_USER,
            database: MYSQL_DB_NAME,
            password: MYSQL_DB_PASSWORD,
            port: MYSQL_DB_PORT,
        });

        const adapterFlow = createFlow([flujoPrincipal, flujoInfoPersonal, flujoNomina, flujoVacaciones, flujoSalida]);
        
        const adapterProvider = createProvider(BaileysProvider);

        createBot({
            flow: adapterFlow,
            provider: adapterProvider,
            database: adapterDB,
        });

        QRPortalWeb();
        
    } catch (error) {
       console.error('Error en la función principal:', error);
       setTimeout(main, 5000); // Reintenta después de 5 segundos
    }
};

main();