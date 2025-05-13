<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name("Nostromo");
    session_start();
}

if (!defined("BASE_URL")) define("BASE_URL", "/Proyecto-Nostromo/app/");

if (isset($_SESSION["token"]) && !isset($_SESSION["datos_usuario_log"])) {
    require_once __DIR__ . "/../src/seguridad.php";
}

$usuario = $_SESSION["datos_usuario_log"] ?? null;
?>

<header>
    <nav style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="<?= BASE_URL ?>index.php?vista=inicio">Inicio</a>
        </div>

        <div>
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
                <a href="<?= BASE_URL ?>index.php?vista=login" title="Iniciar sesión">
                    <img src="<?= BASE_URL ?>img/icono_usuario.png" alt="Icono de usuario" width="32" height="32">
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>
