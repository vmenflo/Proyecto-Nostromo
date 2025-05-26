<?php
$titulo = $_GET['titulo'] ?? '';
$sala = $_GET['sala'] ?? '';
$fecha = $_GET['fecha'] ?? '';
$hora = $_GET['hora'] ?? '';
$butacas = $_GET['butacas'] ?? '';
$subtotal = $_GET['subtotal'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación</title>
</head>

<body>
    <p><?php echo $hora ?></p>
    <p><?php echo $sala ?></p>
    <p><?php echo $fecha ?></p>
    <p><?php echo $butacas ?></p>
    <p><?php echo $subtotal ?></p>

</body>

</html>