<?php

require_once './librerias/router.php';
require_once './app/controladores/juguete.api.controlador.php';


$router= new Router();


$router->agregarRuta('lista','GET','JugueteApiControlador','listaJuguetes');
$router->agregarRuta('lista', 'POST', 'JugueteApiControlador', 'insertarJuguete');
$router->agregarRuta('lista/:Id', 'PUT','JugueteApiControlador', 'modificarJugete');
$router->agregarRuta('lista/:Id', 'GET','JugueteApiControlador', 'obtenerJuguetes');
$router->agregarRuta('lista/:Id', 'DELETE', 'JugueteApiControlador', 'eliminarJuguete');
$router->agregarRuta('marca', 'GET', 'JugueteApiControlador', 'obtenerMarcaLista');
$router->agregarRuta('marca/:Id', 'POST', 'JugueteApiControlador', 'insertarMarca');
$router->agregarRuta('marca/:Id', 'PUT', 'JugueteApiControlador', 'modificarMarca');
$router->agregarRuta('marca/:Id', 'GET', 'JugueteApiControlador', 'obtenerMarcaLista');
$router->agregarRuta('marca/:Id', 'DELETE', 'JugueteApiControlador', 'borrarMarca');

// rutea
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);