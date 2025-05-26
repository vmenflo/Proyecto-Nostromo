<?php
$id_cine = $_GET['id_cine'] ?? '';
$id_pelicula = $_GET['id_pelicula'] ?? '';
$fecha = $_GET['fecha'] ?? '';
$hora = $_GET['hora'] ?? '';
$sala = $_GET['sala'] ?? '';
$butacas = explode(",", $_GET['butacas'] ?? '');
$subtotal = $_GET['subtotal'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pago</title>
</head>

<body>
<?php echo "<p>".$id_cine."</p>"?>
<?php echo "<p>".$id_pelicula."</p>"?>
<?php echo "<p>".$fecha."</p>"?>
<?php echo "<p>".$hora."</p>"?>
<?php echo "<p>".$sala."</p>"?>
<?php echo "<p>".implode(", ", $butacas)."</p>" ?>
<?php echo "<p>".$subtotal."</p>"?>
</body>

</html>