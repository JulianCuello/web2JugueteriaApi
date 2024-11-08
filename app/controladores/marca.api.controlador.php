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
        } else {
            $id = $parametro[":id"];
            $marca = $this->modelo->obtenerMarcaId($id);
            if ($marca) {
                $this->vista->response($marca, 200);
            } else {
                $this->vista->response('No existe marca', 404);
            }
        }
    }

    public function eliminarMarca($parametro = []){
        if (empty($parametro)) {
            $this->vista->response("Error, no encontrado", 404);
            return;
        }
        $id = $parametro['Id'];
        try {
            $marca = $this->modelo->borrarMarca($id);
            if ($marca) {
                $this->vista->response('Marca eliminada', 200);
            } else {
                $this->vista->response("Error al intentar eliminar", 404);
            }
        } catch (PDOException $e) {
            $this->vista->response("La marca que intenta eliminar tiene asociado un conjunto de items. Para poder eliminar correctamente, deberá eliminar los registros de los juguetes asociados.", 404);
        }
    }

    public function modificarMarca(){
        Autorizacion::verificacion(); // Verificación de autorización.
        
        try {
            if ($_POST && Validacion::verificacionFormulario($_POST)) {
                $id_marca = htmlspecialchars($_POST['id_marca']);
                $origen = htmlspecialchars($_POST['origen']);
                $caracteristica = htmlspecialchars($_POST['caracteristica']);
                $nombreMarca = htmlspecialchars($_POST['nombreMarca']);
                $imgMarca = htmlspecialchars($_POST['imgMarca']);

                $marcaModificada = $this->modelo->modificarMarca($id_marca, $origen, $caracteristica, $nombreMarca, $imgMarca);
                
                if ($marcaModificada > 0) {
                    header('Location: ' . BASE_URL . "marca");
                } else {
                    $this->alertaVista->mostrarError("No se pudo actualizar la marca.");
                }
            }
        } catch (Exception $e) {
            $this->vista->response("Error al modificar marca: " . $e->getMessage(), 500);
        }
    }

} 
