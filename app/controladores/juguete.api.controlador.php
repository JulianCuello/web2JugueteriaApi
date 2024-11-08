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
    
        $columnas = $this->modelo->obtenerColumnas();
        //verificaciones al helper
        $filtro = $this->ayuda->esFiltro($_GET, $columnas);
        $valor = $this->ayuda->esValor($_GET);
        $operacion = $this->ayuda->isOperacion($_GET);
        $tipo = $this->ayuda->esTipo($_GET, $columns);
        $orden = $this->ayuda->esOrden($_GET);
        $limite = $this->ayuda->isLimit($_GET);
        $compensar= $this->ayuda->estaCompensado($_GET);

        $opciones = [ //$options almacena las variables true y se envian a la consulta donde se arma la query segun seteos
            'filtro' => $filtro ? $_GET['filtro'] : null,
            'valor' => $valor ? $_GET['valor'] : null,
            'operacion' => $operacion ? $_GET['operacion'] : null,
            'tipo' => $tipo ? $_GET['tipo'] : null,
            'orden' => $orden ? $_GET['orden'] : null,
            'limite' => $limite ? $_GET['limite'] : null,
            'compensar' => $compensar ? $_GET['compensar'] : null
        ];

           try {
            $lista = $this->modelo->mostrarJuguetes($opciones);
            if ($lista) {
                $this->vista->response($lista, 200);
            } else
                $this->vista->response('Bad Request', 400);
        } catch (PDOException) {
            $this->vista->response('Bad Request', 400);
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
                    $this->vista->response ("El registro Id N°:$id no existe", 404);
                }
                else{
                    $this->vista->responde("Error not found", 404);
                }
            }
        }

         public function agregarJuguete(){
        
        $juguete=$this->obtenerDatos();//obtengo el objeto

        if (empty($item->idCodigoProducto) || empty($juguete->nombreProducto) || empty($juguete->precio) || empty($$juguete->material)
            || empty($juguete->id_marca)  || empty($juguete->codigo) || empty($juguete->img) ) {//valido datos de campos recibidos
            $this->vista->response('Faltan completar campos', 404);
            return;
        }

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
        $nombreProducto=$juguete->nombreProducto;
        $precio=$juguete->precio;
        $material=$juguete->material;
        $id_marca=$juguete->id_marca;
        $codigo=$juguete->codigo;
        $img=$juguete->img;
        try{
            $id = $this->modelo->insertarJuguete($nombreProducto,$precio,$material,$id_marca,$codigo,$img);
            $nuevoJuguete=$this->model->getListById($id);
            if ($nuevoJuguete) {
                $this->vista->response($nuevoJuguete, 201);
            } else {
                $this->vista->response("El juguete no pudo ser ingresado", 404);
            }
        }catch(PDOException $e){//si el id de la categoria no existe o es invalido capturo error, entre otros.
            $this->vista->response("Error al intentar ingresar el registro-$e",404);
        }
    
    }

    public function modificarJuguete($parametro=[]){
        $id=$parametro[':Id'];
        if (!empty($parametro) && is_numeric($parametro[':Id'])) {
            $id = $parametro[':Id'];
        $jugueteId=$this->modelo->obtenerJuguetePorId($id);
        if($jugueteId){
        $juguete=$this->obtenerDatos();

        $jugueteId = $this->modelo->obtenerJuguetePorId($id);
            if ($jugueteId) {

        $id_juguete=$juguete->$id_juguete;
        $nombreProducto=$juguete->nombreProducto;
        $precio=$juguete->precio;
        $material=$juguete->material;
        $id_marca=$juguete->id_marca;
        $codigo=$juguete->codigo;
        $img=$juguete->img;

        $juguete=$this->obtenerDatos();
        if(
            empty($juguete->id_juguete) || empty($juguete->nombreProducto) || empty($juguete->precio) || empty($item->material) || empty($juguete->id_marca)
            || empty($juguete->codigo) || empty($juguete->img)
            ) {
                $this->vista->response('faltan completar campos', 404);
                return;
            }

        $jugueteModificado= $this->modelo->editarJuguete($id_juguete, $nombreProducto, $precio, $material, $id_marca, $codigo, $img);
        if ($jugueteModificado){
            $this->vista->response("juguete modificado con exito",200);
        }else{
            $this->vista->response("no se pudo modificar juguete",404);
        }    
        }else{
            $this->vista->response("no existe juguete con Id:$id",404);
            $id_juguete=$juguete->$id_juguete;
            $nombreProducto=$juguete->nombreProducto;
            $precio=$juguete->precio;
            $material=$juguete->material;
            $id_marca=$juguete->id_marca;
            $codigo=$juguete->codigo;
            $img=$juguete->img;

            try {
                $jugueteModificado= $this->modelo->editarJuguete($id_juguete, $nombreProducto, $precio, $material, $id_marca, $codigo, $img);
                if ($jugueteModificado){
                    $this->vista->response("juguete modificado con exito",200);
                }else{
                    $this->vista->response("no se pudo modificar juguete",404);
                }    
                }else{
        $this->vista->response('Error Not Found', 404);
            }
        }
    }
 }
    
