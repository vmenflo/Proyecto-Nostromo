<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= BASE_URL ?>js/pl.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/pl.css">
    <script src="<?= BASE_URL ?>js/proximamente.js" defer></script>
    <title>Proximamente</title>
</head>

<body>
    <main>
        <div class="cont-select-cines">
            <label for="elegir-cine">cine: </label>
            <select name="elegir-cine" id="elegir-cine" data-url="<?= DIR_SERV ?>/cines"
                data-url-cartelera="<?= BASE_URL ?>index.php?vista=cartelera">
            </select>
        </div>
        <div id="cont-pl">
        <h1>Próximamente</h1>
            <div class="linea"></div>
            <div id="cartelera"></div>
        </div>
    </main>

</body>

</html>