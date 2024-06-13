<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código Recordar Contraseña</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        div {
            box-shadow: 0 0 10px grey;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007BFF;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div>
        <h1>DAILYDASH</h1>
        <p>Aquí tienes el código requerido para cambiar la contraseña en DailyDash,</p>
        <p>si no has sido tu el que ha solicitado este código ponte en contacto con dailydashcontacto@gmail.com</p>
        <p class="code">Código: <br>{{ $token_password }}</p>
    </div>
</body>
</html>