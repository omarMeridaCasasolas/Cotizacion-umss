<?php
    require_once("conexion.php");
    class UnidadDeGastos extends Conexion{
        private $sentenceSQL;
        public function UnidadDeGastos(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        } 

        public function consulta(){
            $sql = "SELECT id_unidad_gastos, nombre_ug, avtivo_ug FROM unidades_de_gastos";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function getUnidadAdministrativa(){
            $sql = "SELECT id_unidad_gastos, nombre_ug, avtivo_ug FROM unidades_de_gastos";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        public function insertarUnidadAdministrativa($nombre,$idFacultad,$gestion){
            $sql = "INSERT INTO unidad_de_gastos (nombre_ug, activo_ua) VALUES(:nombre,:idFacultad,:gestion,true)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":idFacultad"=>$idFacultad,":gestion"=>$gestion));
            //$respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            if($res == 1 || $res == true){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            return $res;
        } 

        public function bajaUA($idUnidadAdministrativa){
            $sql = "UPDATE unidad_administrativa SET activo_ua = false WHERE id_uni_admin = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idUnidadAdministrativa));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
    }