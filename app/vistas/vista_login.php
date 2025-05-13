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
    <form id="form-login">
        <p>
            <label for="correo">Correo: </label>
            <input type="text" id="correo" name="correo" />
            <span id="error-correo" class="error"></span>
        </p>
        <p>
            <label for="clave">Contraseña: </label>
            <input type="password" name="clave" id="clave" />
            <span id="error-clave" class="error"></span>
        </p>
        <p><button type="submit">Login</button></p>
    </form>

    <div id="mensaje-error" class="mensaje"></div>

    <?php
    if (isset($_SESSION["mensaje_seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["mensaje_seguridad"] . "</p>";
        unset($_SESSION["mensaje_seguridad"]);
    }
    ?>
</body>

</html>