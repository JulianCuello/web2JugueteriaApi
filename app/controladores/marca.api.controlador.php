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
        if (empty($parametro=[])){
            $marc=$this->modelo->obtenerMarcas();
            $this->vista->response($marc,200);
        } else if (!empty($parametro)){
            $id=$parametro[":id"];
            $marca=$this->modelo->obtenerMarcaId($id);
            if ($marca){
                $this->vista->response($marca, 200);
            }else{
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

    /*
     
    //enviar datos de modificacion 
    public function updateCategory(){
        AuthHelper::verify();
        try {//verifico permisos, parametros validos y posible acceso sin previo acceso al form modificacion.
            if ($_POST && ValidationHelper::verifyForm($_POST)) {
                $idCategoria =htmlspecialchars($_POST['idCategoria']);
                $material =htmlspecialchars($_POST['material']);
                $origen =htmlspecialchars($_POST['origen']);
                $motor =htmlspecialchars($_POST['motor']);
                $imagenCategoria =htmlspecialchars($_POST['imagenCategoria']);
                $categoriaModificada = $this->model->updateItem($idCategoria, $material, $origen, $motor, $imagenCategoria);
                if ($categoriaModificada > 0) {
                    header('Location: ' . BASE_URL . "category");
                } else {
                    $this->alertView->renderError("No se pudo actualizar categoria");
                }
            } else {
                $this->alertView->renderError("Error-El formulario no pudo ser procesado, asegurate de que hayas completado todos los campos");
            }
        } catch (PDOException $error) {
            $this->alertView->renderError("Error en la consulta a la base de datos/$error");
        }
    }
    public function insertCategory(){
                $categoria =htmlspecialchars($_POST['categoria']);
                $material =htmlspecialchars($_POST['material']);
                $origen =htmlspecialchars($_POST['origen']);
                $motor =htmlspecialchars($_POST['motor']);
                $imagenCategoria =htmlspecialchars($_POST['imagenCategoria']);
                $id = $this->model->insertCategory($categoria, $material, $origen, $motor, $imagenCategoria);
                if ($id) {
                    $this->view->response('categoria creada',200);
                } else {
                    $this->view->response("Error al crear la categoria",404);
                }    
        
    }
}