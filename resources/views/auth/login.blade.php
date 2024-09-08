<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Comercial Mauricio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('images/fondologin.png') }}');
            background-size: cover;
            background-position: center;
        }
        .login-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .login-image {
      ;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            height: 300px;
            width: 50%;
            margin-top: -100px;
        }
        .login-image h1 {
            color: white;
            font-size: 100px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            margin-top: 50px;
        }
        .login-image h3 {
            color: white;
            font-size: 50px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            margin-top: 50px;
        }
        .login-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 400px;
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-form .form-control {
            border-radius: 20px;
            padding: 15px 20px;
        }
        .login-form .btn-primary {
            border-radius: 20px;
            padding: 10px 30px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <h1>Bienvenido</h1>
            <h3>Sistema Recursos Humanos</h3>
        </div>
        <div class="login-form">
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Correo Electrónico" name="email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>