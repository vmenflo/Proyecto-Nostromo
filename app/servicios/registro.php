<?php
session_name("Nostromo");
session_start();

require_once "../src/funciones_ctes.php";
ini_set("display_errors", 1);
error_reporting(E_ALL);

// Leer JSON recibido
$datos = json_decode(file_get_contents("php://input"), true);

if (
    !$datos ||
    !isset($datos["nombre"], $datos["apellidos"], $datos["correo"], $datos["clave"], $datos["suscripcion"])
) {
    echo json_encode(["status" => "error", "mensaje" => "Faltan datos"]);
    exit;
}

$nombre = trim($datos["nombre"]);
$apellidos = trim($datos["apellidos"]);
$correo = trim($datos["correo"]);
$clave = trim($datos["clave"]);
$suscripcion = $datos["suscripcion"] == "1" ? 1 : 0;

if ($nombre === "" || $apellidos === "" || $correo === "" || $clave === "") {
    echo json_encode(["status" => "error", "mensaje" => "Todos los campos son obligatorios"]);
    exit;
}

// Comprobamos si ya existe
$url = DIR_SERV . "/repetido/usuarios/correo/" . urlencode($correo);
$respuesta = consumir_servicios_REST($url, "GET");
$json = json_decode($respuesta, true);

if (isset($json["error"])) {
    echo json_encode(["status" => "error", "mensaje" => "Error comprobando duplicado: " . $json["error"]]);
    exit;
}

if ($json["repetido"]) {
    echo json_encode(["status" => "error", "mensaje" => "Ese correo ya está registrado"]);
    exit;
}

// Insertar nuevo usuario
$url = DIR_SERV . "/crearUsuario";
$datos_post = [
    "nombre" => $nombre,
    "apellidos" => $apellidos,
    "email" => $correo,
    "clave" => md5($clave),
    "suscripcion" => $suscripcion
];

$respuesta = consumir_servicios_REST($url, "POST", $datos_post);
$json = json_decode($respuesta, true);

if (isset($json["error"])) {
    echo json_encode(["status" => "error", "mensaje" => "Error al registrar: " . $json["error"]]);
    exit;
}

// Hacer login despues de insertar para dejarlo logueado
$url_login = DIR_SERV . "/login";
$datos_login = [
    "correo" => $correo,
    "clave" => md5($clave)
];

$respuesta_login = consumir_servicios_REST($url_login, "POST", $datos_login);
$json_login = json_decode($respuesta_login, true);

if (!$json_login || isset($json_login["error"])) {
    echo json_encode(["status" => "error", "mensaje" => "Error al iniciar sesión tras el registro"]);
    exit;
}

if (isset($json_login["usuario"])) {
    $_SESSION["ultm_accion"] = time();
    $_SESSION["token"] = $json_login["token"];
    $_SESSION["datos_usuario_log"] = $json_login["usuario"];

    echo json_encode(["status" => "ok"]);
    exit;
}

echo json_encode(["status" => "error", "mensaje" => "No se pudo iniciar sesión tras el registro."]);