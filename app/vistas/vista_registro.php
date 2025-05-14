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
    <title>Registro</title>
    <script src="<?= BASE_URL ?>js/registro.js" defer></script>
</head>

<body>
    <div>
        <h2>BIENVENIDO a la NOSTROMO</h2>
        <p>Nos alegra tenerte con nosotros. Rellena todos los campos para crear una cuenta.</p>

        <form id="form-registro" action="javascript:void(0);">
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </p>
            <p>
                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>
            </p>
            <p>
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </p>
            <p>
                <label for="clave">Contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </p>
            <p>
                <label>¿Quieres suscribirte?</label><br>
                <input type="radio" name="suscripcion" id="si" value="1">
                <label for="si">Sí</label>
                <input type="radio" name="suscripcion" id="no" value="0" checked>
                <label for="no">No</label>
            </p>
            <p>
                <button type="submit">Registrar</button>
            </p>
        </form>

    </div>
</body>

</html>