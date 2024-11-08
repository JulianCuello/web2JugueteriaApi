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
/*
 <?php

abstract class ApiController{

    protected $view;
    protected $helper;//utilizado para validar seteos de query params
    private $data;


    public function __construct(){
        $this->view = new ApiView();
        $this->helper = new Helper();
        $this->data = file_get_contents("php://input");
    }

    function getData(){
        return json_decode($this->data);
    }
}