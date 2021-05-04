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

        // public function consulta(){
        //     $sql = "SELECT id_unidad_gastos, nombre_ug, avtivo_ug FROM unidades_de_gastos";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL-> execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

        public function consulta(){
            $sql = "SELECT id_ug, nombre_ug, estado_ug FROM unidades_de_gastos";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        //add Julio
        public function consulta_ug_por_facultad($idFacultad){
            $sql = "SELECT * FROM unidades_de_gastos where id_facultad = :idfacultad AND estado_ug = true";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute(array(":idfacultad"=>$idFacultad));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        /*
        public function getUnidadAdministrativa(){
            $sql = "SELECT id_unidad_gastos, nombre_ug, avtivo_ug FROM unidades_de_gastos";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }*/
        /*
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
        }*/
        
        public function consulta_getListaUnidadDeGastosDeFacultad($idFacultad){
            $sql = "SELECT id_ug, path_ug FROM view_ug_con_padre WHERE id_facultad = :idfacultad  AND estado_ug = true";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute(array(":idfacultad"=>$idFacultad));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }


        /****
         * //add Julio
         * Insertar Nueva Unidad de Gastos
         */
        //INSERT INTO public.unidades_de_gastos (id_facultad,  padre_id_ug, nombre_ug, gestion_ug, estado_ug, fecha_creacion_ug) VALUES ('1', null, 'Laboratorio de batereología', '2021', true, current_timestamp);
        public function insertarNuevaUnidadDeGastosEnFacultad($id_Facultad,$padre_id_ug, $nombre_ug, $gestion_ug, $estado_ug){
            
            if($padre_id_ug == 0){
                $sql = "INSERT INTO unidades_de_gastos (id_facultad, nombre_ug, gestion_ug, estado_ug, fecha_creacion_ug) VALUES (:id_facultad,:nombre_ug,:gestion_ug,:estado_ug, current_timestamp)";

                $sentenceSQL = $this->connexion_bd->prepare($sql);
                $res = $sentenceSQL->execute(array(":id_facultad"=>$id_Facultad,":nombre_ug"=>$nombre_ug,":gestion_ug"=>$gestion_ug,":estado_ug"=>$estado_ug));
            }else{
                $sql = "INSERT INTO unidades_de_gastos (id_facultad, padre_id_ug, nombre_ug, gestion_ug, estado_ug, fecha_creacion_ug) VALUES (:id_facultad, :padre_id_ug,:nombre_ug,:gestion_ug,:estado_ug,current_timestamp)";

                $sentenceSQL = $this->connexion_bd->prepare($sql);
                $res = $sentenceSQL->execute(array(":id_facultad"=>$id_Facultad,":padre_id_ug"=>$padre_id_ug,":nombre_ug"=>$nombre_ug,":gestion_ug"=>$gestion_ug,":estado_ug"=>$estado_ug));
            }

            $sentenceSQL->closeCursor();

            return $res;
        }
         /*fin Insertar Nueva Unidad de gastos */

        public function cambioEstadoUG($idUnidadGastos,$cambioUG){
            $sql = "UPDATE unidades_de_gastos SET estado_ug = :estado WHERE id_ug = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idUnidadGastos, ":estado"=>$cambioUG));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }




        public function actualizarUG($idUG,$nombreUG){
            $sql = "UPDATE unidades_de_gastos SET nombre_ug = :nombre WHERE id_ug = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idUG,":nombre"=>$nombreUG));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
    }