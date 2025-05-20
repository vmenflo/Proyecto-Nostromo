<?php
session_name("Nostromo");
session_start();
require "src/funciones_ctes.php";

$RUTA_BASE = "../";
include __DIR__ . "/includes/header.php";

// Cierre de sesión
if (isset($_POST["btnCerrarSession"])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Si hay sesión activa, pasamos por seguridad
if (isset($_SESSION["token"])) {
    require "src/seguridad.php";
    $datos_usuario_log = $_SESSION["datos_usuario_log"];
}

if (isset($_SESSION["mensaje_seguridad"])) {
    echo "<p class='mensaje'>" . $_SESSION["mensaje_seguridad"] . "</p>";
    unset($_SESSION["mensaje_seguridad"]);
}

// Controlador central de vistas
$vista = $_GET["vista"] ?? "inicio"; 

switch ($vista) {
    case "cartelera":
        require "vistas/vista_cartelera.php";
        break;

    case "proximamente":
        require "vistas/vista_proximamente.php";
        break;

    case "bitacora":
        require "vistas/vista_bitacora.php";
        break;

    case "perfil":
        if (isset($_SESSION["token"])) {
            require "vistas/vista_perfil.php";
        } else {
            header("Location: index.php?vista=login");
            exit;
        }
        break;

    case "login":
        require "vistas/vista_login.php";
        break;
    
    case "registro":
        require "vistas/vista_registro.php";
        break;

    case "admin":
        if (isset($_SESSION["token"]) && $datos_usuario_log["tipo"] === "admin") {
            require "vistas/vista_admin.php";
        } else {
            die("<p>No tienes permisos para acceder aquí.</p>");
        }
        break;

    case "detalle-bitacora":
        require "vistas/vista_detalle_bitacora.php";
        break;
    
    case "cookies":
        require "vistas/vista_cookies.php";
        break;

    case "seleccion_sesion":
        require "vistas/vista_seleccion_sesion.php";
        break;
    
    case "butacas":
    require "vistas/vista_butacas.php";
    break;

    default:
        require "vistas/vista_inicio.php";
}
include __DIR__ . "/includes/footer.php";
?>
