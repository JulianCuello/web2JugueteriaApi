<?php
require_once './app/modelos/modelo.php';

class marcaModelo extends Modelo {
    
   function obtenerMarcas(){
    
        $query = $this->db->prepare('SELECT * FROM `marca`');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);       
    }
    
        public function obtenerMarcaId($id){
            $query = $this->db->prepare('SELECT * FROM `marca` WHERE id_marca=?');
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ); 
    }
    function insertarMarca($origen, $caracteristica, $nombreMarca, $imgMarca){
        $query = $this->db->prepare('INSERT INTO marca (origen, caracteristica, nombreMarca, imgMarca) VALUES(?,?,?,?)');
        $query->execute([$origen, $caracteristica, $nombreMarca, $imgMarca]);
        return $this->db->lastInsertId();
    }
    function borrarMarca($id){
        $query = $this->db->prepare('DELETE FROM marca WHERE id_marca = ?');
        $query->execute([$id]);
        return $query->rowCount();
    }
    function modificarMarca($id_marca, $origen, $caracteristica,$nombreMarca, $imgMarca){
        $query = $this->db->prepare('UPDATE marca SET origen=?,caracteristica=?,nombreMarca=?,imgMarca=? WHERE id_marca=?');
        $query->execute([$origen, $caracteristica, $nombreMarca, $imgMarca]);
        return $query->rowCount();
    }
    //consulta para mostrar las categorias disponibles cuando se quiere modificar un producto o categoria
    function obtenerIdMarca(){ 
        $query = $this->db->prepare('SELECT * FROM `marca` WHERE id_marca=?');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}

    
