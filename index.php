
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="src/img/ortusLogo.png">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="Styles/FormLogin.css">
</head>
<body>
    <div class="login">
        <div class="conteiner">
            <form action="DB/validacion.php" method="POST">
                <img id="logo" src="src/img/ortus_c.png" alt="">
                <!-- usuario -->
                <div class="Usuario">
                <input placeholder="Usuario" type="text" id="Usuario" name="Usuario" required>
                </div>
                <!-- Contraseña -->
                <div class="contrasña">
                <input placeholder="Contraseña" id="Contraseña" type="password" name="Contraseña" required>
                </div>
                <div class="BTN">
                    <button id="btn_enviar" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>