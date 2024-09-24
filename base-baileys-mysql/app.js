const { createBot, createProvider, createFlow, addKeyword, EVENTS } = require('@bot-whatsapp/bot');
const QRPortalWeb = require('@bot-whatsapp/portal');
const BaileysProvider = require('@bot-whatsapp/provider/baileys');
const MySQLAdapter = require('@bot-whatsapp/database/mysql');

// Declaramos las conexiones de MySQL
const MYSQL_DB_HOST = 'localhost';
const MYSQL_DB_USER = 'root';
const MYSQL_DB_PASSWORD = '';
const MYSQL_DB_NAME = 'recursos_humanos';
const MYSQL_DB_PORT = '3308';

// Crear una conexión a la base de datos
let connection;

// Función para establecer conexión a la base de datos
async function connectToDatabase() {
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

// Función para validar email
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

// Funciones auxiliares mejoradas para obtener datos

async function getEmployeeData(identifier) {
    try {
        console.log('Buscando empleado con identificador:', identifier);
        let query = 'SELECT * FROM empleados WHERE ';
        let params = [];

        if (isValidEmail(identifier)) {
            query += 'email = ?';
            params.push(identifier);
        } else if (!isNaN(identifier)) {
            query += 'id = ?';
            params.push(parseInt(identifier));
        } else {
            console.log('Identificador inválido:', identifier);
            return null;
        }

        console.log('Ejecutando query:', query, 'con parámetros:', params);
        const [rows] = await connection.execute(query, params);
        console.log('Resultados de la query:', rows);
        return rows.length > 0 ? rows[0] : null;
    } catch (error) {
        console.error('Error al obtener datos del empleado:', error);
        return null;
    }
}


async function getNominaData(identifier) {
    try {
        const employee = await getEmployeeData(identifier);
        if (!employee) {
            console.log('No se encontró el empleado para el identificador:', identifier);
            return null;
        }

        console.log('Buscando nómina para el empleado:', employee.id);
        const [rows] = await connection.execute('SELECT * FROM nomina WHERE empleado_id = ?', [employee.id]);
        console.log('Resultados de la nómina:', rows);
        return rows.length > 0 ? rows[0] : null;
    } catch (error) {
        console.error('Error al obtener datos de la nómina:', error);
        return null;
    }
}

async function getVacationData(identifier) {
    try {
        const employee = await getEmployeeData(identifier);
        if (!employee) {
            console.log('No se encontró el empleado para el identificador:', identifier);
            return null;
        }

        console.log('Buscando vacaciones para el empleado:', employee.id);
        const [rows] = await connection.execute('SELECT * FROM vacaciones WHERE empleado_id = ?', [employee.id]);
        console.log('Resultados de vacaciones:', rows);
        if (rows.length > 0) {
            return {
                dias_solicitados: rows[0].dias_solicitados,
                estado: rows[0].estado,
            };
        }
        return null;
    } catch (error) {
        console.error('Error al obtener datos de vacaciones:', error);
        return null;
    }
}

// Flujos mejorados

const flowInfoPersonal = addKeyword(['info personal', 'información personal'])
    .addAnswer('📋 Aquí puedes consultar tu información personal.')
    .addAnswer('Por favor, proporciona tu correo electrónico o ID para continuar.',
        { capture: true },
        async (ctx, { flowDynamic }) => {
            console.log('Contexto recibido:', ctx);
            const input = ctx.body;
            console.log('Input recibido para info personal:', input);
            
            try {
                const employeeData = await getEmployeeData(input);
                console.log('Datos del empleado obtenidos:', employeeData);
                
                if (employeeData) {
                    await flowDynamic(`👤 Tu información: \nNombre: ${employeeData.name} \nEmail: ${employeeData.email} \nTeléfono: ${employeeData.telefono}`);
                } else {
                    await flowDynamic('❌ No se encontró información para ese identificador. Por favor, verifica e intenta de nuevo.');
                }
            } catch (error) {
                console.error('Error en el flujo de información personal:', error);
                await flowDynamic('❌ Ocurrió un error al procesar tu solicitud. Por favor, intenta más tarde.');
            }
        }
    );

const flowNomina = addKeyword(['nomina', 'mi nomina'])
    .addAnswer('💰 Aquí puedes consultar tu nómina.')
    .addAnswer('Por favor, proporciona tu correo electrónico o ID para continuar.',
        { capture: true },
        async (ctx, { flowDynamic }) => {
            console.log('Contexto recibido:', ctx);
            const input = ctx.body;
            console.log('Input recibido para nómina:', input);
            
            try {
                const nominaData = await getNominaData(input);
                console.log('Datos de nómina obtenidos:', nominaData);
                
                if (nominaData) {
                    await flowDynamic(`💵 Tu nómina: \nSalario Base: ${nominaData.salario_base} \nBonificaciones: ${nominaData.bonificaciones} \nDeducciones: ${nominaData.deducciones}`);
                } else {
                    await flowDynamic('❌ No se encontró información de nómina para ese identificador. Por favor, verifica e intenta de nuevo.');
                }
            } catch (error) {
                console.error('Error en el flujo de nómina:', error);
                await flowDynamic('❌ Ocurrió un error al procesar tu solicitud. Por favor, intenta más tarde.');
            }
        }
    );

const flowVacaciones = addKeyword(['vacaciones', 'mi vacaciones'])
    .addAnswer('🌴 Aquí puedes verificar tus vacaciones.')
    .addAnswer('Por favor, proporciona tu correo electrónico o ID para continuar.',
        { capture: true },
        async (ctx, { flowDynamic }) => {
            console.log('Contexto recibido:', ctx);
            const input = ctx.body;
            console.log('Input recibido para vacaciones:', input);
            
            try {
                const vacationData = await getVacationData(input);
                console.log('Datos de vacaciones obtenidos:', vacationData);
                
                if (vacationData) {
                    await flowDynamic(`🏖️ Vacaciones disponibles: ${vacationData.dias_solicitados} \nEstado de aprobación: ${vacationData.estado}`);
                } else {
                    await flowDynamic('❌ No se encontró información de vacaciones para ese identificador. Por favor, verifica e intenta de nuevo.');
                }
            } catch (error) {
                console.error('Error en el flujo de vacaciones:', error);
                await flowDynamic('❌ Ocurrió un error al procesar tu solicitud. Por favor, intenta más tarde.');
            }
        }
    );

const flowFallback = addKeyword(EVENTS.WELCOME)
    .addAnswer('Lo siento, no entendí tu solicitud. Por favor, elige una de las siguientes opciones:')
    .addAnswer(
        [
            '👉 *info personal* para ver tu información personal',
            '👉 *nomina* para ver tu nómina',
            '👉 *vacaciones* para verificar tus vacaciones',
        ],
        null,
        null,
        [flowInfoPersonal, flowNomina, flowVacaciones]
    );

// Flujo Principal
const flowPrincipal = addKeyword(['ingreso sistema recursos humanos'])
    .addAnswer('🙌 Hola bienvenido apreciable empleado')
    .addAnswer(
        [
            'Te comparto los siguientes links de interés sobre el proyecto',
            '👉 *info personal* para ver tu información personal',
            '👉 *nomina* para ver tu nómina',
            '👉 *vacaciones* para verificar tus vacaciones',
        ],
        null,
        null,
        [flowInfoPersonal, flowNomina, flowVacaciones, flowFallback]
    );

    const main = async () => {
        try {
            await connectToDatabase();
            console.log('Conexión a la base de datos establecida');
    
            const adapterDB = new MySQLAdapter({
                host: MYSQL_DB_HOST,
                user: MYSQL_DB_USER,
                database: MYSQL_DB_NAME,
                password: MYSQL_DB_PASSWORD,
                port: MYSQL_DB_PORT,
            });
            
            const adapterFlow = createFlow([flowPrincipal, flowInfoPersonal, flowNomina, flowVacaciones, flowFallback]);
            const adapterProvider = createProvider(BaileysProvider);
            
            createBot({
                flow: adapterFlow,
                provider: adapterProvider,
                database: adapterDB,
            });
            
            QRPortalWeb();
        } catch (error) {
            console.error('Error en la función main:', error);
        }
    }
    
    main();