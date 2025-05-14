<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("Nostromo");
    session_start();
}
if (!defined("BASE_URL"))
    define("BASE_URL", "/Proyecto-Nostromo/app/");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Nostromo</title>
    <style>
        .error {
            color: red
        }

        .mensaje {
            color: blue;
            font-size: 1.25rem
        }
    </style>
    <script src="<?= BASE_URL ?>js/login.js" defer></script>
</head>

<body>

    <h1>Login</h1>
    <form id="form-login" action="javascript:void(0);">
    <p>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <span id="error-correo" class="error"></span>
    </p>
    <p>
        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required>
        <span id="error-clave" class="error"></span>
    </p>
    <p id="mensaje-error" class="error"></p>
    <p>
        <button type="submit">Iniciar sesión</button>
    </p>
</form>


    <div id="mensaje-error" class="mensaje"></div>
    <div>
        <a href="<?= BASE_URL ?>index.php?vista=registro">¿Aún no eres miembro de Nostromo? Click aquí para registrarte</a>
    </div>

</body>

</html>