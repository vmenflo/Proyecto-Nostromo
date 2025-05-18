<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/inicio.css">
    <script src="<?= BASE_URL ?>js/cargarCines.js" defer></script>
    <title>Cartelera</title>
</head>

<body>
    <main>
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
    </main>
</body>

</html>