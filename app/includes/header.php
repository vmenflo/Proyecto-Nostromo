<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("Nostromo");
    session_start();
}

if (!defined("BASE_URL"))
    define("BASE_URL", "/Proyecto-Nostromo/app/");

if (isset($_SESSION["token"]) && !isset($_SESSION["datos_usuario_log"])) {
    require_once __DIR__ . "/../src/seguridad.php";
}

$usuario = $_SESSION["datos_usuario_log"] ?? null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nostromo</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/global.css">
</head>

<body>

    <header>
        <nav id="cont-header">
            <div id="cont-menu">
                <svg id="icono-menu" width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H25V4.16667H0V0ZM0 10.4167H25V14.5833H0V10.4167ZM0 20.8333H25V25H0V20.8333Z"
                        fill="#213140" />
                </svg>
                <ul id="menu">
                    <li><a href="<?= BASE_URL ?>index.php?vista=cartelera">Cartelera</a></li>
                    <div class="linea-menu"></div>
                    <li><a href="<?= BASE_URL ?>index.php?vista=proximamente">Próximamente</a></li>
                    <div class="linea-menu"></div>
                    <li><a href="<?= BASE_URL ?>index.php?vista=bitacora">Bitácora Nostromo</a></li>
                    <div class="linea-menu"></div>
                </ul>
            </div>
            <div id="cont-logo">
                <a href="<?= BASE_URL ?>index.php?vista=inicio">
                    <img id="logo" src="https://nostromo-media.s3.eu-north-1.amazonaws.com/logos/logo-nostromo.png"
                        alt="logotipo-nostromo">
                </a>
            </div>

            <div id="cont-user">
                <?php if (isset($_SESSION["token"])): ?>
                    <span>
                        Hola<?= isset($usuario["nombre"]) ? ", " . htmlspecialchars($usuario["nombre"]) : "" ?>
                    </span>
                    <a href="<?= BASE_URL ?>index.php?vista=perfil" title="Mi perfil">
                        <img src="<?= BASE_URL ?>img/icono_usuario.png" alt="Mi perfil" width="32" height="32">
                    </a>
                    <form action="<?= BASE_URL ?>index.php" method="post" style="display:inline;">
                        <button type="submit" name="btnCerrarSession" title="Cerrar sesión">
                            <img src="<?= BASE_URL ?>img/icono_logout.png" alt="Cerrar sesión" width="32" height="32">
                        </button>
                    </form>
                <?php else: ?>
                    <a ID="no-registrado" href="<?= BASE_URL ?>index.php?vista=login" title="Iniciar sesión">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.375 8.125C9.375 11.2262 11.8988 13.75 15 13.75C18.1012 13.75 20.625 11.2262 20.625 8.125C20.625 5.02375 18.1012 2.5 15 2.5C11.8988 2.5 9.375 5.02375 9.375 8.125ZM25 26.25H26.25V25C26.25 20.1763 22.3237 16.25 17.5 16.25H12.5C7.675 16.25 3.75 20.1763 3.75 25V26.25H25Z"
                                fill="#213140" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <ul id="menu-global">
        <li><a href="<?= BASE_URL ?>index.php?vista=cartelera">Cartelera</a></li>
        <li><a href="<?= BASE_URL ?>index.php?vista=proximamente">Próximamente</a></li>
        <li><a href="<?= BASE_URL ?>index.php?vista=bitacora">Bitácora Nostromo</a></li>
    </ul>
</body>