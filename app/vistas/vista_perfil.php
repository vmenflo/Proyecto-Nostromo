<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/perfil.css">
    <script src="<?= BASE_URL ?>js/perfil.js" defer></script>
    <title>Mi perfil</title>
</head>

<body>
    <main>
        <div id="cont-miperfil">
            <div class="detalles">
                <p class="titulo">Mi cuenta</p>
                <div class="perfil-contenido">
                    <picture class="foto-perfil">
                        <source media="(min-width: 768px)"
                            srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/perfil-tablet.png">
                        <img class="foto-cartelera"
                            src="https://nostromo-media.s3.eu-north-1.amazonaws.com/carteleras/perfil-mobile.png"
                            alt="mi-perfil-foto">
                    </picture>
                    <div class="datos-perfil">
                        <p><strong><?php echo $_SESSION["datos_usuario_log"]["nombre"] . " " . $_SESSION["datos_usuario_log"]["apellidos"]; ?></strong>
                        </p>
                        <p>📞 <?php echo $_SESSION["datos_usuario_log"]["telefono"]; ?></p>
                        <p>📧 <?php echo $_SESSION["datos_usuario_log"]["correo"]; ?></p>
                        <p>⭐ Puntos: <?php echo $_SESSION["datos_usuario_log"]["puntos"]; ?></p>
                    </div>
                </div>
            </div>

            <div id="misreservas">
                <p class="titulo">Mis Entradas</p>
                <div id="entradas-futuras"></div>
            </div>

            <div id="historial">
                <p class="titulo">Historial de Entradas</p>
                <div id="entradas-historial"></div>
            </div>
        </div>
    </main>
</body>

</html>