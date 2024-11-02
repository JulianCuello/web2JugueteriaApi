<?php
class Ruta {
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;
    public function __construct($url, $verbo, $controlador, $metodo){
        $this->url = $url;
        $this->verbo = $verb;
        $this->controlador = $controlador;
        $this->metodo = $metodo;
        $this->parametro = [];
    }
    public function coincidirRutas($url, $verbo) {
        if($this->verbo != $verbo) {
            return false;
        }
        $partesURL = explode("/", trim($url, '/'));
        $partesRuta = explode("/", trim($this->url, '/'));
        
        if(count($partesRuta) != count($partesURL)) {
            return false;
        }
        
        foreach ($partesRuta as $clave => $parte) {
            if($parte[0] != ":") {
                if($parte != $partesURL[$clave]) {
                    return false;
                }
            } // es un parámetro
            else {
                $this->parametro[$parte] = $partesURL[$clave];
            }
        }
        
        return true;
    }
    
    public function ejecutar(){
        $controlador = $this->controlador;  
        $metodo = $this->metodo;
        $parametros = $this->parametros;
       
        (new $controlador())->$metodo($parametros);
    }
}

class Router {
    private $tablaDeRuta = [];
    private $rutaPorDefecto;
    public function __construct() {
        $this->rutaPorDefecto = null;
    }
    public function route($url, $verbo) {
       
        foreach ($this->tablaDeRuta as $ruta) {
            if($ruta->coincidirRuta($url, $verbo)){
                $ruta->ejecutar();
                return;
            }
        }
     
        if ($this->rutaPorDefecto != null)
            $this->rutaPorDefecto->ejecutar();
    }
    
    public function agregarRoute ($url, $verbo, $controlador, $metodo) {
        $this->routeTable[] = new Ruta($url, $verbo, $controlador, $metodo);
    }
    public function establecerRutaPorDefecto($controlador, $metodo) {
        $this->rutaPorDefecto = new Ruta("", "", $controlador, $metodo);
    }
 }