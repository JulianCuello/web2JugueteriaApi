<?php 
    require_once './app/vista/api.vista.php';
    require_once './ayuda.php';
    
    abstract class ApiControlador{
        
        protected $vista;
        private $datos;
        protected $ayuda;

        public function __construct() {
            
        $this->vista = new ApiVista();
        $this->datos = file_get_contents("php://input"); 
        $this->ayuda = new ayuda();

    }
    function obtenerDatos(){ 
        return json_decode($this->datos); 
    } 
 }
