<?php 
    require_once './app/vista/api.vista.php';
    
    abstract class ApiControlador{
        
        protected $vista;
        private $datos;
        public function __construct() {
        $this->vista = new ApiVista();
        $this->datos = file_get_contents("php://input"); 
    }
    function obtenerDatos(){ 
        return json_decode($this->datos); 
    } 
    }