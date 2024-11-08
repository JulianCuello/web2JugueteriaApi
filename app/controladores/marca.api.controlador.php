<?php
require_once './app/controladores/api.controlador.php';
require_once './app/modelos/marca.modelo.php';
require_once './app/modelos/juguete.modelo.php'; 

class marcaControlador extends ApiControlador{
    private $modelo;
    private $modeloJuguete;

    public function __construct(){
       
        $this->modelo = new MarcaModelo();
        $this->modeloJuguete = new JugueteModelo();
    }

    public function listaMarcas($parametro = []){
        if (empty($parametro)) {
            $marc = $this->modelo->obtenerMarcas();
            $this->vista->response($marc, 200);
        } else if(isset($parametro[':Id'])&&is_numeric($parametro[':Id'])){
            $id = $parametro[":id"];
            $marca = $this->modelo->obtenerMarcaId($id);
            if ($marca) {
                $this->vista->response($marca, 200);
            } else {
                $this->vista->response('No existe marca', 404);
            }
        }else{
            $this->vista->response('error not found',404);
        }
    }

    public function eliminarMarca($parametro = []){
        if (!empty($paramamtro)&&is_numeric($parametro[':Id'])) {
            $id= $parametro[':Id'];
            try {
                $marca = $this->modelo->borrarMarca($id);
                if ($marca) {
                    $this->vista->response("categoria Id N°:$marca eliminada.", 200);
                } else {
                    $this->vista->response("la marca no existe", 404);
                }
            } catch (PDOException $e) {
                $this->vista->response("no se puede eliminar marca, tiene items asociados,$e", 400);
            }
        }else{
            $this->vista->response("Error not Found", 404);
            return;
        }
    }
    public function insertarMarca(){
       
        $id_marca = htmlspecialchars($_POST['id_marca']);
        $origen = htmlspecialchars($_POST['origen']);
        $caracteristica = htmlspecialchars($_POST['caracteristica']);
        $nombreMarca = htmlspecialchars($_POST['nombreMarca']);
        $imgMarca = htmlspecialchars($_POST['imgMarca']);

        $id = $this->modelo->insertarMarca($id_marca, $origen, $caracteristica, $nombreMarca, $imgMarca);
        $nuevaMarca=$this->modelo->obtenerMarcaId($id);
        if ($nuevaMarca) {
            $this->vista->response($nuevaMarca, 200);
        } else {
            $this->vista->response("Error al crear la marca", 404);
        }
    }

        public function modificarMarca(){
        
        
        if (!empty($params) && is_numeric($params[':Id'])){
         $id = $parametro[':Id'];
        $MarcaId= $this->modelo->obtenerMarcaId($id);
            if ($marcaId) {
            $marca = $this->getDatos();
                    if (
                        empty($marca->id_marca) || empty($marca->origen) || empty($marca->caracteristica) || empty($marca->nombreMarca)
                        || empty($marca->imgMarca)){
                        $this->vista->response('faltan completar campos', 404);
                        return;
                    }
                    $id_marca = htmlspecialchars($_POST['id_marca']);
                    $origen = htmlspecialchars($_POST['origen']);
                    $caracteristica = htmlspecialchars($_POST['caracteristica']);
                    $nombreMarca = htmlspecialchars($_POST['nombreMarca']);
                    $imgMarca = htmlspecialchars($_POST['imgMarca']);
                    try {
                        $marcaModificada = $this->modelo->editarMarca($id_marca, $origen, $caracteristica, $nombreMarca, $imgMarca);
                        if ($marcaModificada) {
                            $this->vista->response('marca modificada', 200);
                        } else {
                            $this->vista->response("No se pudo actualizar marca", 404);
                        }
                    } catch (PDOException $error) {
                        $this->vista->response("Error en la consulta a la base de datos/$error", 404);
                    }
                }
             } else {
                    $this->vista->response('id invalido', 404);
                }
            }
            
        }

