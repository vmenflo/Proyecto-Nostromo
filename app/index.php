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

    case "admin":
        if (isset($_SESSION["token"]) && $datos_usuario_log["tipo"] === "admin") {
            require "vistas/vista_admin.php";
        } else {
            die("<p>No tienes permisos para acceder aquí.</p>");
        }
        break;

    default:
        require "vistas/vista_inicio.php";
}
?>
