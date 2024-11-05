<?php
require_once './app/controladores/api.controlador.php';
require_once './app/modelos/marca.modelo.php';
require_once './app/modelos/marca.modelo.php';

class marcaControlador extends ApiControlador{
    private $modelo;
    private $modeloJuguete;
    public function __construct()
    {
        //se instancian los dos modelos para no delegar mal, y que cada modelo acceda a su tabla correspondiente.
        $this->modelo = new MarcaModelo();
        $this->modeloJuguete = new JugueteModelo();
        
    }
    public function listaMarcas ($parametro=[]){
        if (empty($parametro)) {
            $marc = $this->modelo->obtenerMarcas();
            $this->vista->response($marc, 200);
        } else {
            $id = $parametro[":id"];
            $marca = $this->modelo->obtenerMarcaId($id);
            if ($marca) {
                $this->vista->response($marca, 200);
            } else {
                $this->vista->response('no existe marca', 404);
            }
        }
    }
    
    public function eliminarMarca ($parametro=[]){
        if(empty($parametro)){
            $this->vista->response("error not found", 404);
            return;
        }
        $id=$parametro['Id'];
        try{
            $marca=$this->modelo->borrarMarca($id);
            if($marca){
                $this->vista->responde('marca eliminada', 200);
            }else{
                $this->vista->response("error al intentar eliminar", 404);
            }
        }catch (PDOException){
            $this->vista->response("la marca que intenta eliminar, tiene asociado un conjunto de items.
                                            Para poder eliminar correctamente,
                                            debera eliminar los registros de los juguetes asociados/
                                            ",404);
        }
    }

    public function modificarMarca(){
        Autorizacion::verificacion();
        try{
            if ($_POST && Validacion::verificacionFormulario($_POST)) {
                $id_marca =htmlspecialchars($_POST['id_marca']);
                $origen =htmlspecialchars($_POST['origen']);
                $caracteristica =htmlspecialchars($_POST['caracteristica']);
                $nombreMarca =htmlspecialchars($_POST['nombreMarca']);
                $imgMarca =htmlspecialchars($_POST['imgMarca']);

                $marcaModificada= $this->modelo->modificarJuguete($id_marca, $origen, $caracteristica, $nombreMarca, $imgMarca);
                if ($marcaModificada > 0) {
                    header('Location: ' . BASE_URL . "marca");
                } else {
                    $this->alertaVista->mostrarError("No se pudo actualizar marca");
                }
        }
    }
 
    
     