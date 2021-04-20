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

        public function cambioEstadoUG($idUnidadGastos,$cambioUG){
            $sql = "UPDATE unidades_de_gastos SET avtivo_ug = :estado WHERE id_unidad_gastos = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idUnidadGastos, ":estado"=>$cambioUG));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }



        public function actualizarUG($idUG,$nombreUG,$avtivoUG){
            $sql = "UPDATE unidades_de_gastos SET nombre_ug = :nombre, avtivo_ug = :activo WHERE id_unidad_gastos = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idUG,":nombre"=>$nombreUG,":activo"=>$avtivoUG));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
    }