<?php


require __DIR__ . '/Slim/autoload.php';
require "src/funciones_CTES_servicios.php";


$app= new \Slim\App;


$app->get('/logueado',function(){
    $test=validateToken();
    if(is_array($test))
        echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
});

$app->post('/login',function($request){
  
    $correo=$request->getParam("correo");
    $clave=$request->getParam("clave");
    echo json_encode(login($correo,$clave));
    
});


$app->get('/peliculas',function(){
    echo json_encode(obtener_peliculas());
});
  

$app->get('/pelicula/{codigo}',function($request){
        $cod=$request->getAttribute("codigo");
        echo json_encode(obtener_pelicula($cod));
});

$app->get('/cine_pelicula/{id_pelicula}',function($request){
    $cod=$request->getAttribute("id_pelicula");
    echo json_encode(obtener_cines_disponibles_pelicula($cod));
});


$app->get('/repetido/{tabla}/{columna}/{valor}',function($request){
    $test=validateToken();
    if(is_array($test))
        if(isset($test["usuario"]))
            if($test["usuario"]["tipo"]=="admin")
            {
                $tabla=$request->getAttribute("tabla");
                $columna=$request->getAttribute("columna");
                $valor=$request->getAttribute("valor");
                echo json_encode(repetido_insertando($tabla, $columna,$valor));
            }
            else
                echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));
        else
            echo json_encode($test);
    else
        echo json_encode(array("no_auth"=>"No tienes permisos para usar este servicio"));    
});



$app->run();
?>
