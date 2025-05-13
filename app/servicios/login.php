<?php
session_name("Nostromo");
session_start();

require_once "../src/funciones_ctes.php";

// Leer el JSON recibido
$datos = json_decode(file_get_contents("php://input"), true);

if (!isset($datos["correo"]) || !isset($datos["clave"])) {
    echo json_encode(["status" => "error", "mensaje" => "Faltan campos"]);
    exit;
}

// Preparar datos
$url = DIR_SERV . "/login";
$datos_env = [
    "correo" => $datos["correo"],
    "clave" => md5($datos["clave"])
];

// Llamar al backend REST
$respuesta = consumir_servicios_REST($url, "POST", $datos_env);
$json_login = json_decode($respuesta, true);

// Validar respuesta
if (!$json_login) {
    echo json_encode(["status" => "error", "mensaje" => "Error conectando con el servicio"]);
    exit;
}

if (isset($json_login["error"])) {
    echo json_encode(["status" => "error", "mensaje" => $json_login["error"]]);
    exit;
}

if (isset($json_login["usuario"])) {
    $_SESSION["ultm_accion"] = time();
    $_SESSION["token"] = $json_login["token"];
    echo json_encode(["status" => "ok"]);
    exit;
}

// Si no devuelve usuario
echo json_encode(["status" => "error", "mensaje" => "Correo o contraseña incorrectos"]);
