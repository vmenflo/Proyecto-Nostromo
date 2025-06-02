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
function obtener_cines_con_proyeccion_pelicula($id_pelicula)
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

// Función para traer butacas de una proyección en concreto
function obtener_butacas($id_cine, $id_pelicula, $fecha, $hora)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "No he podido conectarme a la base de datos: " . $e->getMessage();
        return $respuesta;
    }

    try {
        // 1. Obtener id_proyeccion y id_sala
        $consulta = "SELECT id_proyeccion, id_sala FROM proyecciones WHERE id_cine = ? AND id_pelicula = ? AND fecha = ? AND hora = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine, $id_pelicula, $fecha, $hora]);
        $fila = $sentencia->fetch();

        if (!$fila) {
            $respuesta["mensaje"] = "No se ha encontrado ninguna proyección con esos datos.";
            $sentencia = null;
            $conexion = null;
            return $respuesta;
        }

        $id_proyeccion = $fila["id_proyeccion"];
        $id_sala = $fila["id_sala"];
        $sentencia = null;

        // 2. Obtener dimensiones (filas y butacas máximas)
        $consulta = "SELECT MAX(fila) AS filas, MAX(butaca) AS butacas FROM asientos WHERE id_sala = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_sala]);
        $dimensiones = $sentencia->fetch();
        $sentencia = null;

        // 3. Obtener butacas ocupadas
        $consulta = "SELECT a.fila, a.butaca
                     FROM reservas_asientos ra
                     JOIN reservas r ON ra.id_reserva = r.id_reserva
                     JOIN asientos a ON ra.id_asiento = a.id_asiento
                     WHERE r.id_proyeccion = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_proyeccion]);
        $ocupadas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        $respuesta["filas"] = intval($dimensiones["filas"]);
        $respuesta["butacas"] = intval($dimensiones["butacas"]);
        $respuesta["ocupadas"] = $ocupadas;
        $respuesta["fecha"] = $fecha;
        $respuesta["hora"] = $hora;
        $respuesta["id_sala"] = $id_sala;
    } catch (PDOException $e) {
        $respuesta["error"] = "No se ha podido realizar la consulta: " . $e->getMessage();
    }

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}

// Función para realizar reserva
function reservar($datos)
{
    $respuesta = [];

    try {
        // Obtener y validar datos
        $id_usuario = $datos["id_usuario"] ?? null;
        $id_cine = $datos["id_cine"] ?? null;
        $id_pelicula = $datos["id_pelicula"] ?? null;
        $fecha = $datos["fecha"] ?? null;
        $hora = $datos["hora"] ?? null;
        $id_sala = $datos["id_sala"] ?? null;
        $butacas_raw = $datos["butacas"] ?? [];

        // Asegurar que butacas sea un array
        $butacas = is_array($butacas_raw) ? $butacas_raw : explode(",", $butacas_raw);

        if (!$id_usuario || !$id_cine || !$id_pelicula || !$fecha || !$hora || !$id_sala || empty($butacas)) {
            throw new Exception("Faltan datos para realizar la reserva");
        }

        // Conexión
        $conexion = new PDO(
            "mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD,
            USUARIO_BD,
            CLAVE_BD,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
        );

        // Obtener id_proyeccion
        $consulta = "SELECT id_proyeccion FROM proyecciones WHERE id_cine=? AND id_pelicula=? AND fecha=? AND hora=? AND id_sala=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine, $id_pelicula, $fecha, $hora, $id_sala]);

        if ($sentencia->rowCount() === 0) {
            throw new Exception("No se encontró la proyección");
        }

        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        $id_proyeccion = $fila["id_proyeccion"];

        // Insertar reserva
        $consulta = "INSERT INTO reservas (id_usuario, id_proyeccion, fecha_reserva, cantidad_entradas) VALUES (?, ?, CURDATE(), ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario, $id_proyeccion, count($butacas)]);

        $id_reserva = $conexion->lastInsertId();

        // Preparar sentencias
        $insertar = $conexion->prepare("INSERT INTO reservas_asientos (id_reserva, id_asiento) VALUES (?, ?)");
        $buscar_id_asiento = $conexion->prepare("SELECT id_asiento FROM asientos WHERE id_sala=? AND fila=? AND butaca=?");

        foreach ($butacas as $str_butaca) {
            if (preg_match("/^F(\d+)-B(\d+)$/", $str_butaca, $matches)) {
                $fila_num = $matches[1];
                $butaca_num = $matches[2];

                $buscar_id_asiento->execute([$id_sala, $fila_num, $butaca_num]);

                if ($buscar_id_asiento->rowCount() > 0) {
                    $fila_asiento = $buscar_id_asiento->fetch(PDO::FETCH_ASSOC);
                    $id_asiento = $fila_asiento["id_asiento"];
                    $insertar->execute([$id_reserva, $id_asiento]);
                } else {
                    throw new Exception("No se encontró el asiento $str_butaca en la sala $id_sala");
                }
            } else {
                throw new Exception("Formato de butaca inválido: $str_butaca");
            }
        }

        $respuesta["mensaje"] = "Reserva realizada correctamente";
    } catch (Exception $e) {
        $respuesta["error"] = "Error realizando la reserva: " . $e->getMessage();
    }

    return $respuesta;
}

// Función para obtener reservas de un usuario concreto
function obtener_reservas_usuario($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
        ]);
    } catch (PDOException $e) {
        return ["codigo" => "error", "mensaje" => "Error de conexión: " . $e->getMessage()];
    }

    // Función interna para evitar duplicar código en futuras/historial
    function obtener_reservas($conexion, $id_usuario, $condicion_fecha, $orden)
    {
        $sql = "SELECT r.id_reserva, r.cantidad_entradas, r.fecha_reserva,
                    p.fecha, p.hora, pel.titulo, pel.foto,
                    c.nombre AS cine, s.nombre AS sala,
                    GROUP_CONCAT(CONCAT('F', a.fila, 'B', a.butaca) ORDER BY a.fila, a.butaca SEPARATOR ', ') AS butacas
            FROM reservas r
            JOIN proyecciones p ON r.id_proyeccion = p.id_proyeccion
            JOIN peliculas pel ON p.id_pelicula = pel.id_pelicula
            JOIN cines c ON p.id_cine = c.id_cine
            JOIN salas s ON p.id_sala = s.id_sala
            LEFT JOIN reservas_asientos ra ON r.id_reserva = ra.id_reserva
            LEFT JOIN asientos a ON ra.id_asiento = a.id_asiento
            WHERE r.id_usuario = ? AND $condicion_fecha
            GROUP BY r.id_reserva
            ORDER BY $orden";

        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    try {
        $futuras = obtener_reservas($conexion, $id_usuario, "p.fecha >= CURDATE()", "p.fecha, p.hora");
        $historial = obtener_reservas($conexion, $id_usuario, "p.fecha < CURDATE()", "p.fecha DESC, p.hora DESC");

        return [
            "codigo" => "success",
            "futuras" => $futuras,
            "historial" => $historial
        ];
    } catch (PDOException $e) {
        return ["codigo" => "error", "mensaje" => "Error en la consulta: " . $e->getMessage()];
    }
}

// Función agregar un cine nuevo
function agregar_cine($datos_insert)
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
        $consulta = "INSERT INTO cines (nombre, direccion, ciudad, cp) VALUES (?, ?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos_insert);
    } catch (PDOException $e) {
        return ["error" => "No he podido realizar la consulta: " . $e->getMessage()];
    }

    return ["ult_id" => $conexion->lastInsertId()];
}

// Función eliminar cine
function eliminar_cine($id_cine)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        return ["error" => "No se pudo conectar a la base de datos: " . $e->getMessage()];
    }

    try {
        $consulta = "DELETE FROM cines WHERE id_cine = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine]);

        if ($sentencia->rowCount() === 0) {
            return ["error" => "No se encontró el cine a eliminar"];
        }
    } catch (PDOException $e) {
        return ["error" => "Error al eliminar el cine: " . $e->getMessage()];
    }

    return ["mensaje" => "Cine eliminado con éxito"];
}

// Funcion editar
function editar_cine($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        return ["error" => "Error de conexión: " . $e->getMessage()];
    }

    try {
        $consulta = "UPDATE cines SET nombre=?, direccion=?, ciudad=?, cp=? WHERE id_cine=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        return ["error" => "Error actualizando cine: " . $e->getMessage()];
    }

    return ["success" => "Cine actualizado correctamente"];
}

// Función obtener salas
function obtener_salas_por_cine($id_cine) {
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $consulta = "SELECT id_sala, nombre FROM salas WHERE id_cine = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine]);
        return ["salas" => $sentencia->fetchAll(PDO::FETCH_ASSOC)];
    } catch (PDOException $e) {
        return ["error" => "Error obteniendo salas: " . $e->getMessage()];
    }
}

// Función agregar
function agregar_sala($datos) {
    if (!isset($datos["id_cine"], $datos["nombre"], $datos["aforo"])) {
        return ["error" => "Faltan datos"];
    }

    $id_cine = intval($datos["id_cine"]);
    $nombre = trim($datos["nombre"]);
    $aforo = intval($datos["aforo"]);

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Validación de duplicado
        $consulta = "SELECT COUNT(*) FROM salas WHERE id_cine = ? AND nombre = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine, $nombre]);
        if ($sentencia->fetchColumn() > 0) {
            return ["error" => "Ya existe una sala con ese nombre en este cine"];
        }

        $consulta = "INSERT INTO salas (id_cine, nombre, aforo) VALUES (?, ?, ?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_cine, $nombre, $aforo]);

        return ["ok" => true];

    } catch (PDOException $e) {
        return ["error" => "Error al agregar sala: " . $e->getMessage()];
    }
}

// Eliminar sala
function eliminar_sala($datos) {
    if (!isset($datos["id_sala"])) {
        return ["error" => "Falta el ID de la sala"];
    }

    $id_sala = intval($datos["id_sala"]);

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $consulta = "DELETE FROM salas WHERE id_sala = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_sala]);

        return ["ok" => true];

    } catch (PDOException $e) {
        return ["error" => "Error al eliminar sala: " . $e->getMessage()];
    }
}


// Funcion repetido editando
function repetido_editando($tabla, $columna, $valor, $columna_id, $id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        return ["error" => "Error de conexión: " . $e->getMessage()];
    }

    try {
        $consulta = "SELECT $columna FROM $tabla WHERE $columna = ? AND $columna_id <> ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor, $id]);
    } catch (PDOException $e) {
        return ["error" => "Error ejecutando la consulta: " . $e->getMessage()];
    }

    return ["repetido" => $sentencia->rowCount() > 0];
}

// Función repetido insertando
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
?>