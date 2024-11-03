<?php
require_once './app/controladores/api.controlador.php';
require_once './app/modelos/juguete.modelo.php';
require_once './app/modelos/marca.modelo.php';

class JugueteApiControlador extends ApiControlador{
    
    private $modelo;
    public function __construct(){
        parent::__construct();
        $this->modelo = new jugueteModelo();
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

        public function eliminarJuguete ($parametro=[]){
            if (!empty($parametro)){
                $id=$parametro[':Id'];
                $juguete=$this->modelo->borrarJuguete($id);
                if($juguete){
                    $this->vista->response ("registro Id N°:$id eliminado.",200);
                }
                else {
                    $this->vista->response ("el registro no existe", 404);
                }
                else{
                    $this->vista->responde("error", 404);
                }
            }
        }

       
         public function agregarJuguete(){
        
        $juguete=$this->getData();//desarma el json y genera un objeto

        $nombreProducto=$juguete->nombreProducto;
        $precio=$juguete->precio;
        $material=$juguete->material;
        $id_marca=$juguete->id_marca;
        $codigo=$juguete->codigo;
        $img=$juguete->img;

        $id=$this->modelo->insertarJuguete($nombreProducto,$precio,$material,$id_marca,$codigo,$img);
        if($id){
            $this->view->response("Item ingresado con exito id N°: $id",201);
        }else{
            $this->view->response("el item no pudo ser ingresado",404);
        }
    
    }
    public function modificarJuguete($parametro=[]){
        $id=$parametro[':Id'];
        $jugueteId=$this->modelo->obtenerJuguetePorId($id);
        if($jugueteId){
        $juguete=$this->getData();

        $id_juguete=$juguete->$id_juguete;
        $nombreProducto=$juguete->nombreProducto;
        $precio=$juguete->precio;
        $material=$juguete->material;
        $id_marca=$juguete->id_marca;
        $codigo=$juguete->codigo;
        $img=$juguete->img;

        $jugueteModificado= $this->modelo->editarJuguete($id_juguete, $nombreProducto, $precio, $material, $id_marca, $codigo, $img);
        if ($jugueteModificado){
            $this->vista->response("juguete modificado con exito",200);
        }else{
            $this->vista->response("no se pudo modificar juguete",404);
        }    
        }else{
            $this->vista->response("no existe juguete con Id:$id",404);
        }
    }
}
  