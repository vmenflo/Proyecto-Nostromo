<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nostromo Inicio</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/lightslider.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/inicio.css">
    <script src="<?= BASE_URL ?>js/jquery-3.7.1.min.js"></script>
    <script src="<?= BASE_URL ?>js/jquery.animate-colors-min.js"></script>
    <script src="<?= BASE_URL ?>js/lightslider.js"></script>
    <script src="<?= BASE_URL ?>js/pl.js"></script>



</head>

<body>
    <main>
        <div id="contenedor-pl-escritorio" class="solo-escritorio">
            <ul id="slider-escritorio"></ul>
        </div>
        <div id="cont-select-cines">
            <label for="elegir-cine">cine: </label>
            <select name="elegir-cine" id="elegir-cine" data-url="<?= DIR_SERV ?>/cines"
                data-url-cartelera="<?= BASE_URL ?>index.php?vista=cartelera">
            </select>
        </div>
        <div>
            <h1><a href="<?= BASE_URL ?>index.php?vista=cartelera">Cartelera</a></h1>
            <div class="linea"></div>
            <div id="cartelera"></div>
        </div>

        <div id="cont-pl">
            <h1><a href="<?= BASE_URL ?>index.php?vista=proximamente">Próximamente</a></h1>
            <div class="linea"></div>
            <div id="contenedor-pl" class="solo-movil">
                <ul id="slider"></ul>
            </div>
        </div>


        <div id="cont-bitacora-inicio">
            <h1><a href="<?= BASE_URL ?>index.php?vista=bitacora">Bitácora Nostromo</a></h1>
            <div class="linea"></div>
            <a href="<?= BASE_URL ?>index.php?vista=bitacora">
                <picture>
                    <source media="(min-width: 768px)"
                        srcset="https://nostromo-media.s3.eu-north-1.amazonaws.com/bitacora/bitacora-tablet.png">
                    <img class="foto-bitacora"
                        src="https://nostromo-media.s3.eu-north-1.amazonaws.com/bitacora/bitacora-mobile.png"
                        alt="foto-bitacora">
                </picture>
            </a>
        </div>
    </main>
    <script src="<?= BASE_URL ?>js/cargarCines.js" defer></script>

</body>

</html>