<?php
    require_once("conexion.php");
    class UnidadAdministrativa extends Conexion{
        private $sentenceSQL;
        public function UnidadAdministrativa(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        } 
        public function getUnidadAdministrativa(){
            $sql = "SELECT id_uni_admin, nombre_ua, gestion_ua, nombre_facultad, activo_ua FROM 
            unidad_administrativa INNER JOIN facultad ON facultad.id_facultad = unidad_administrativa.id_facultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        public function insertarUnidadAdministrativa($nombre,$idFacultad,$gestion){
            $sql = "INSERT INTO unidad_administrativa (nombre_ua, id_facultad, gestion_ua, activo_ua) VALUES(:nombre,:idFacultad,:gestion,true)";
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


        // public function EliminarFacultad($idFacultad){
        //     $sql = "DELETE FROM facultades WHERE id_facultad = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL-> execute(array(":id"=>$idFacultad));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }
        // public function LeerFacultades(){
        //     $sql = "SELECT * FROM facultades WHERE UPPER(codigo_facultad) <> UPPER('Ninguno') ";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     //$res = json_encode($respuesta);
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        //     //return $res;
        // }

        // public function facultadesDisponibles(){
        //     $sql = "SELECT * FROM facultades WHERE (director_academico IS NULL or director_academico = 'Ninguno') AND id_facultad <> 666";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     return $res;
        // }




        // public function cambiarDirectorNinguno($idFacultad,$director){
        //     $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL-> execute(array(":director"=>$director,":id"=>$idFacultad));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }

        // public function cambiarDirectorAcedemicoFacultad($idFacultad,$nomDirector){
        //     $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :idFacultad";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL-> execute(array(":director"=>$nomDirector,":idFacultad"=>$idFacultad));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }

        // public function obtenerCodigoFacultad($id_facultad){
        //     $sql = "SELECT codigo_facultad FROM facultades WHERE id_facultad=:id_fac";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id_fac"=>$id_facultad));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     //echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        //     return $res;
        // }

        // public function mostrarFacultades(){
        //     $sql = "SELECT * FROM facultades WHERE director_academico <> 'Ninguno'";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     //$res = json_encode($respuesta);
        //     return json_encode($respuesta);
        // }

        // //EN USO
        // public function obtenerFacultadDocente($id_docente){
        //     $sql = "SELECT facultades.id_facultad, facultades.nombre_facultad from facultades, departamento, departamento_docente where facultades.id_facultad = departamento.id_facultad and departamento.id_departamento = departamento_docente.id_departamento and departamento_docente.id_docente =:id_doc";
        //     $this->sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $this->sentenceSQL->execute(array(":id_doc"=>$id_docente));
        //     $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $this->sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     return $res;
        // }

        // //EN USO
        // public function obtenerFacultadAuxiliarDocente($id_aux_docente){
        //     $sql = "SELECT facultades.id_facultad, facultades.nombre_facultad from facultades, departamento, departamento_auxiliar_docente where facultades.id_facultad = departamento.id_facultad and departamento.id_departamento = departamento_auxiliar_docente.id_departamento and departamento_auxiliar_docente.id_auxiliar_docente =:id_aux_doc";
        //     $this->sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $this->sentenceSQL->execute(array(":id_aux_doc"=>$id_aux_docente));
        //     $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $this->sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     return $res;
        // }
    } 