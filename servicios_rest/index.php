<?php


require __DIR__ . '/Slim/autoload.php';
require "src/funciones_CTES_servicios.php";


$app = new \Slim\App;

// Control logueado
$app->get('/logueado', function () {
    $test = validateToken();
    if (is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

// Loguear
$app->post('/login', function ($request) {
    $correo = $request->getParam("correo");
    $clave = $request->getParam("clave");
    echo json_encode(login($correo, $clave));

});

// Traer peliculas
$app->get('/peliculas', function ($request) {
    $id_cine = $_GET["id_cine"] ?? null;
    echo json_encode(obtener_peliculas($id_cine));
});

// Traer proximos lanzamientos
$app->get('/proximos-lanzamientos', function ($request) {
    $id_cine = $_GET["id_cine"] ?? null;
    echo json_encode(obtener_lanzamientos($id_cine));
});

// Traer una pelicula concreta
$app->get('/pelicula/{codigo}', function ($request) {
    $cod = $request->getAttribute("codigo");
    echo json_encode(obtener_pelicula($cod));
});

// Traer los cines donde proyecta una pelicula en concreto
$app->get('/proyecciones/cines/{id_pelicula}', function ($request) {
    $id_pelicula = $request->getAttribute("id_pelicula");
    echo json_encode(obtener_cines_con_proyeccion_pelicula($id_pelicula));
});

// Obtener sesiones
$app->get('/sesiones/{id_cine}/{id_pelicula}', function ($request) {
    $id_cine = $request->getAttribute("id_cine");
    $id_pelicula = $request->getAttribute("id_pelicula");
    echo json_encode(obtener_sesiones($id_cine, $id_pelicula));
});

// Traer cines donde esta disponible la pelicula
$app->get('/cine_pelicula/{id_pelicula}', function ($request) {
    $cod = $request->getAttribute("id_pelicula");
    echo json_encode(obtener_cines_disponibles_pelicula($cod));
});

// Traer cines
$app->get('/cines', function ($request) {
    echo json_encode(obtener_cines());
});

// Traer los articulos
$app->get('/articulos', function ($request) {
    echo json_encode(obtener_articulos());
});

// Traer articulo concreto
$app->get('/articulo/{id_articulo}', function ($request) {
    $id_articulo = $request->getAttribute("id_articulo");
    echo json_encode(obtener_articulo($id_articulo));
});

// Traer los asientos de la proyeccion
$app->get('/butacas/{id_cine}/{id_pelicula}/{fecha}/{hora}', function ($request) {
    $id_cine = $request->getAttribute("id_cine");
    $id_pelicula = $request->getAttribute("id_pelicula");
    $fecha = $request->getAttribute("fecha");
    $hora = $request->getAttribute("hora");

    echo json_encode(obtener_butacas($id_cine, $id_pelicula, $fecha, $hora));
});

// Realizar reserva
$app->post('/reservar', function ($request) {
    $datos = json_decode($request->getBody(), true);

    try {
        echo json_encode(reservar($datos));
    } catch (Throwable $e) {
        echo json_encode(["error" => "Error interno", "detalle" => $e->getMessage()]);
    }
});

// Obtener reservas del usuario
$app->get('/reservas', function () {
    $auth = validateToken();

    if (!is_array($auth) || !isset($auth["usuario"]["id_usuario"])) {
        echo json_encode(["no_auth" => "No tienes permisos para usar este servicio"]);
        return;
    }

    $id_usuario = $auth["usuario"]["id_usuario"];
    echo json_encode(obtener_reservas_usuario($id_usuario));
});

// Repetido
$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {
    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");

    echo json_encode(repetido_insertando($tabla, $columna, $valor));
});

// Crear usuario nuevo
$app->post('/crearUsuario', function ($request) {
    $nombre = $request->getParam("nombre");
    $direccion = $request->getParam("direccion");
    $ciudad = $request->getParam("ciudad");
    $cp = $request->getParam("cp");

    if (!$nombre || !$direccion || !$ciudad || !$cp) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        return;
    }

    $datos_insert = [$nombre, $direccion, $ciudad, $cp];

    echo json_encode(insertar_usuario($datos_insert));
});

// Agregar un cine nuevo
$app->post('/agregarCine', function ($request) {
    // Verificamos token y tipo de usuario
    $test = validateToken();
    if (!is_array($test) || !isset($test["usuario"]) || $test["usuario"]["tipo"] !== "admin") {
        echo json_encode(["no_auth" => "No tienes permisos para usar este servicio"]);
        return;
    }

    $params = json_decode($request->getBody(), true);

    $nombre = $params["nombre"] ?? null;
    $direccion = $params["direccion"] ?? null;
    $ciudad = $params["ciudad"] ?? null;
    $cp = $params["cp"] ?? null;

    // Validar campos obligatorios
    if (!$nombre || !$direccion || !$ciudad || !$cp) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        return;
    }

    // Verificar si ya existe un cine con ese nombre
    $repetido = repetido_insertando("cines", "nombre", $nombre);
    if (isset($repetido["error"])) {
        echo json_encode(["error" => $repetido["error"]]);
        return;
    }

    if ($repetido["repetido"]) {
        echo json_encode(["error" => "Ya existe un cine con ese nombre"]);
        return;
    }

    // Insertar cine
    $datos_insert = [$nombre, $direccion, $ciudad, $cp];
    echo json_encode(agregar_cine($datos_insert));
});

// Eliminar un cine
$app->delete('/eliminarCine', function ($request, $response, $args) {
    $id =  $request->getParam("id");

    if (!is_numeric($id)) {
        echo json_encode(["error" => "ID inválido"]);
        return;
    }

    echo json_encode(eliminar_cine($id));
});

// Editar cine
$app->put('/editarCine', function ($request) {
    $test = validateToken();
    if (is_array($test) && isset($test["usuario"]) && $test["usuario"]["tipo"] === "admin") {
        $datos = json_decode($request->getBody(), true);

        if (
            !isset($datos["id"], $datos["nombre"], $datos["direccion"], $datos["ciudad"], $datos["cp"]) ||
            empty(trim($datos["nombre"])) ||
            empty(trim($datos["direccion"])) ||
            empty(trim($datos["ciudad"])) ||
            empty(trim($datos["cp"]))
        ) {
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            return;
        }

        // Verificar si el nombre ya existe en otro cine
        $check = repetido_editando("cines", "nombre", $datos["nombre"], "id_cine", $datos["id"]);
        if (isset($check["error"])) {
            echo json_encode($check);
            return;
        }

        if ($check["repetido"]) {
            echo json_encode(["error" => "Ya existe un cine con ese nombre"]);
            return;
        }

        echo json_encode(editar_cine([
            $datos["nombre"],
            $datos["direccion"],
            $datos["ciudad"],
            $datos["cp"],
            $datos["id"]
        ]));
    } else {
        echo json_encode(["no_auth" => "No tienes permisos para usar este servicio"]);
    }
});

// traer salas de un cine
$app->get('/salas/{id_cine}', function ($request) {
    $test = validateToken();
    if (is_array($test) && isset($test["usuario"]) && $test["usuario"]["tipo"] === "admin") {
        $id_cine = $request->getAttribute("id_cine");
        echo json_encode(obtener_salas_por_cine($id_cine));
    } else {
        echo json_encode(["no_auth" => "No tienes permisos para usar este servicio"]);
    }
});


// Repetido editando
$app->get('/admin/repetido/{tabla}/{columna}/{valor}', function ($request) {
    $test = validateToken();
    if (is_array($test))
        if (isset($test["usuario"]))
            if ($test["usuario"]["tipo"] == "admin") {
                $tabla = $request->getAttribute("tabla");
                $columna = $request->getAttribute("columna");
                $valor = $request->getAttribute("valor");
                echo json_encode(repetido_insertando($tabla, $columna, $valor));
            } else
                echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));
});

$app->run();
?>