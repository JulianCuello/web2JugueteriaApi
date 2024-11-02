<?php
require_once './app/controladores/api.controlador.php';
require_once './app/modelos/juguete.modelo.php';
require_once './app/modelos/marca.modelo.php';

class JugueteApiControlador extends ApiControlador{
    
    private $modelo;
    public function __construct(){
        parent::__construct();
        $this->modelo = new jugueteModel();
    }

    //lista completa
    public function listaJuguetes($parametro = []){
    
        if (empty($parametro)) {
            $juguetes = $this->modelo->obtenerJuguetes();
            $this->vista->response($juguete,200);
        } else if(!empty($parametro)){
            $id=$parametro[':Id'];
            $jugueteLista=$this->modelo->obtenerJuguetePorId($id);
            if($jugueteLista)
                $this->vista->response($jugueteLista,200);
            else{
                $this->vista->response('no se encontro juguete',404);
            }
         }else{
            $this->vista->response('error not found',404);
         }
        }