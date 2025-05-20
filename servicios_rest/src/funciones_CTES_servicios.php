<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'Firebase/autoload.php';

define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_nostromo");
define("PASSWORD_API", "PASSWORD_DE_MI_APLICACION");



function validateToken()
{

    $headers = apache_request_headers();
    if (!isset($headers["Authorization"]))
        return false;//Sin autorizacion
    else {
        $authorization = $headers["Authorization"];
        $authorizationArray = explode(" ", $authorization);
        $token = $authorizationArray[1];
        try {
            $info = JWT::decode($token, new Key(PASSWORD_API, 'HS256'));
        } catch (\Throwable $th) {
            return false;//Expirado
        }

        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {

            $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
            return $respuesta;
        }

        try {
            $consulta = "select * from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$info->data]);
        } catch (PDOException $e) {
            $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
            $sentencia = null;
            $conexion = null;
            return $respuesta;
        }
        if ($sentencia->rowCount() > 0) {
            $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            $payload['exp'] = time() + 3600;
            $payload['data'] = $respuesta["usuario"]["id_usuario"];
            $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
            $respuesta["token"] = $jwt;
        } else
            $respuesta["mensaje_baneo"] = "El usuario no se encuentra registrado en la BD";

        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

}
// Función login
function login($correo, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where correo=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$correo, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible realizar la consulta:" . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);


        $payload = ['exp' => time() + 3600, 'data' => $respuesta["usuario"]["id_usuario"]];
        $jwt = JWT::encode($payload, PASSWORD_API, 'HS256');
        $respuesta["token"] = $jwt;
    } else
        $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función peliculas
function obtener_peliculas($id_cine = null)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        if ($id_cine) {
            $consulta = "SELECT DISTINCT p.* 
            FROM peliculas p 
            JOIN proyecciones pr ON p.id_pelicula = pr.id_pelicula 
            WHERE pr.id_cine = ? AND disponibilidad = 'cartelera'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id_cine]);
        } else {
            $consulta = "SELECT * FROM peliculas WHERE disponibilidad = 'cartelera'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
        }

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "No hay películas disponibles";
    else
        $respuesta["peliculas"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función próximos lanzamientos
function obtener_lanzamientos($id_cine = null)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        if ($id_cine) {
            $consulta = "SELECT DISTINCT p.* 
                         FROM peliculas p 
                         JOIN proyecciones pr ON p.id_pelicula = pr.id_pelicula 
                         WHERE pr.id_cine = ? AND p.disponibilidad = 'proximamente'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$id_cine]);
        } else {
            $consulta = "SELECT * FROM peliculas WHERE disponibilidad = 'proximamente'";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
        }

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "No hay películas disponibles";
    else
        $respuesta["lanzamientos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Traerme en que cines se encuentra una pelicula concreta
function obtener_cines_con_proyeccion_pelicula ($id_pelicula)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT DISTINCT c.id_cine, c.nombre
            FROM proyecciones p
            JOIN cines c ON p.id_cine = c.id_cine
            WHERE p.id_pelicula = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_pelicula]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() <= 0) {
        $respuesta["cines"] = [];
        $respuesta["mensaje"] = "No hay cines disponibles";
    } else {
        $respuesta["cines"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Traer sesiones
function obtener_sesiones($id_cine, $id_pelicula)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        return ["error" => "Error de conexión: " . $e->getMessage()];
    }

    try {
        $consulta = "SELECT id_proyeccion, fecha, hora 
                     FROM proyecciones 
                     WHERE id_cine = ? AND id_pelicula = ? 
                     ORDER BY fecha, hora";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine, $id_pelicula]);

        if ($sentencia->rowCount() > 0) {
            $sesiones = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return ["sesiones" => $sesiones];
        } else {
            return ["mensaje" => "No hay sesiones disponibles"];
        }
    } catch (PDOException $e) {
        return ["error" => "Error al realizar la consulta: " . $e->getMessage()];
    } finally {
        $conexion = null;
    }
}


// Función pelicula
function obtener_pelicula($cod)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from peliculas where id_pelicula=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }
    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "El producto con cod: " . $cod . " no se encuentra en la BD";
    else
        $respuesta["pelicula"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función cines
function obtener_cines()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from cines";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["cines"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función obtener cines disponibles por pelicula
function obtener_cines_disponibles_pelicula($id_pelicula)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "SELECT c.nombre,c.direccion,c.ciudad,c.cp from cines c join cine_pelicula cp on c.id_cine=cp.id_cine where cp.id_pelicula=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_pelicula]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }
    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "La pélicula con cod: " . $id_pelicula . " no se encuentra en la BD";
    else
        $respuesta["cine_pelicula"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Insertar nuevo usuario
function insertar_usuario($datos_insert)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        return ["error" => "No he podido conectarme a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "INSERT INTO usuarios (nombre, apellidos, correo, clave, suscripcion) VALUES (?, ?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_insert);
    } catch (PDOException $e) {
        return ["error" => "No he podido realizar la consulta: " . $e->getMessage()];
    }

    return ["ult_id" => $conexion->lastInsertId()];
}

// Función articulos
function obtener_articulos()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "SELECT * FROM articulos";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "No hay películas disponibles";
    else
        $respuesta["articulos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función traer articulo concreto

function obtener_articulo($id_articulo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from articulos where id_articulo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_articulo]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }
    if ($sentencia->rowCount() <= 0)
        $respuesta["mensaje"] = "El producto con cod: " . $id_articulo . " no se encuentra en la BD";
    else
        $respuesta["articulo"] = $sentencia->fetch(PDO::FETCH_ASSOC);

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Funciones controladoras

function repetido_insertando($tabla, $columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"] = $sentencia->rowCount() > 0;


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

function repetido_editando($tabla, $columna, $valor, $columna_id, $valor_id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarse a la base de batos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=? and " . $columna_id . "<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $valor_id]);

    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "No he podido realizarse la consulta: " . $e->getMessage();
        return $respuesta;
    }

    $respuesta["repetido"] = $sentencia->rowCount() > 0;


    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
?>