<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/admin.css">
    <title>Panel Admin</title>
</head>

<body>
    <main>
        <h1>Panel de Administración</h1>
        <div id="cont-gestor">
            <div id="gest-cines">Gestión de cines</div>
            <div id="gest-peliculas">Gestión de peliculas</div>
        </div>
    </main>
    <script>
        document.getElementById("gest-cines").addEventListener("click", () => {
            window.location.href = "index.php?vista=panel-cines";
        });
    </script>

</body>

</html>