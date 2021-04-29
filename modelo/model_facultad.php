<?php
    require_once("conexion.php");
    class Facultad extends Conexion{
        private $sentenceSQL;
        public function Facultad(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        } 

        public function actualizarFacultadBD($nombre,$sigla,$telefono,$correo,$descripcion,$idFacultad){
            $sql = "UPDATE facultad SET nombre_facultad = :nom, siglas_facutlad = :sigla, telefono_facultad = :telef, correo_facultad = :correo,
            descripcion_facultad = :descripcion  WHERE id_facultad = :idFacultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":nom"=>$nombre,":sigla"=>$sigla,":telef"=>$telefono,":correo"=>$correo,":descripcion"=>$descripcion,":idFacultad"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function cambiarEstadoFacultad($idFacultad,$estado){
            $sql = "UPDATE facultad SET activo_facultad = :estado WHERE id_facultad = :idFacultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":estado"=>$estado,":idFacultad"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function insertarFacultad($nombre,$sigla,$gestion,$fecha,$telefono,$correo,$descripcion){
            $sql = "INSERT INTO facultad (nombre_facultad,siglas_facutlad,tipo_facultad,fecha_facultad, telefono_facultad, correo_facultad ,descripcion_facultad, activo_facultad)
            VALUES(:nombre,:sigla,:tipo,:fecha,:telef,:correo,:descripcion,true)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":sigla"=>$sigla,":tipo"=>$gestion,":fecha"=>$fecha,":telef"=>$telefono,":correo"=>$correo,":descripcion"=>$descripcion));
            //$respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            return $res;
        }
        public function getFacultades(){
            $sql = "SELECT * FROM facultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        public function getFacultadeSelect(){
            $sql = "SELECT id_facultad, nombre_facultad FROM facultad WHERE activo_facultad = true AND id_facultad NOT IN
            (SELECT id_facultad FROM unidad_administrativa)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
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

        // public function insertarFacultad($nomFacultad,$facCodigo,$facFechaCrea,$dirFac){
        //     $sql = "INSERT INTO facultades(nombre_facultad,fecha_creacion,codigo_facultad,director_academico) VALUES(:nameFacultad,:fecha,:codigo,:director)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $res = $sentenceSQL->execute(array(":nameFacultad"=>$nomFacultad,":fecha"=>$facFechaCrea,":codigo"=>$facCodigo,":director"=>$dirFac));
        //     //$respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     //$res = json_encode($respuesta);
        //     return $res;
        // }

        // public function AsignarDirectorFacultad($idFacultad,$nomDirector){
            // $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL-> execute(array(":director"=>$nomDirector,":id"=>$idFacultad));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
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