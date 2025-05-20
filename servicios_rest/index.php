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

// Traer los articulo
$app->get('/articulo/{id_articulo}', function ($request) {
    $id_articulo = $request->getAttribute("id_articulo");
    echo json_encode(obtener_articulo($id_articulo));
});

// Traer articulo concreto

// Repetido
$app->get('/repetido/{tabla}/{columna}/{valor}', function ($request) {
    $tabla = $request->getAttribute("tabla");
    $columna = $request->getAttribute("columna");
    $valor = $request->getAttribute("valor");

    echo json_encode(repetido_insertando($tabla, $columna, $valor));
});

// Crear usuario nuevo
$app->post('/crearUsuario', function ($request) {
    // Me aseguro de que nada venga vacio
    if (
        !$request->getParam("nombre") ||
        !$request->getParam("apellidos") ||
        !$request->getParam("email") ||
        !$request->getParam("clave")
    ) {
        echo json_encode(["error" => "Faltan datos obligatorios"]);
        return;
    }

    $datos_insert = [
        $request->getParam("nombre"),
        $request->getParam("apellidos"),
        $request->getParam("email"),
        $request->getParam("clave"),
        $request->getParam("suscripcion") == "1" ? 1 : 0
    ];

    echo json_encode(insertar_usuario($datos_insert));
});

// Esta por ver
$app->get('admin/repetido/{tabla}/{columna}/{valor}', function ($request) {
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