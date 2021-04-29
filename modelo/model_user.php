<?php
    require_once("conexion.php");
    class User extends Conexion{
        private $sentenceSQL;
        public function User(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        } 

        public function agregarUsuarioUA($responsableActual,$idUA){
            $sql = "UPDATE usuario SET id_unidad_admin = :idUA  WHERE id_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":idUA"=>$idUA,":id"=>$responsableActual));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function eliminarUsuarioUA($responsableAnterior){
            $sql = "UPDATE usuario SET id_unidad_admin = NULL  WHERE id_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":id"=>$responsableAnterior));
            $sentenceSQL->closeCursor();
            return $res;
        }
        public function getCorreoUsuarios($correo){
            $sql = "SELECT DISTINCT(login_usuario) FROM usuario WHERE login_usuario <> :correo";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute(array(':correo'=>$correo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function actualizarDatosUsuario($id,$nombre,$apellido,$correo,$telefono,$password){
            $sql = "UPDATE usuario SET nombre_usuario = :nombre, apellido_usuario = :apellido, pass_usuario = :pass, login_usuario = :correo, telef_usuario = :telef WHERE id_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":apellido"=>$apellido,":pass"=>$password,":correo"=>$correo,":telef"=>$telefono,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarUsuarioTipo($idTipo,$editUsuarioRol){
            $sql = "UPDATE usuario_tipo SET  role = :rol WHERE id_role_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":rol"=>$editUsuarioRol,":id"=>$idTipo));
            $sentenceSQL->closeCursor();
            return $res;
        }
        public function asignarUnidadAdministrativa($idUA,$usuario){
            $sql = "UPDATE usuario SET id_unidad_admin =:idUA WHERE id_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":idUA"=>$idUA,":id"=>$usuario));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function actualizarUsuario($id,$correo,$telefono){
            $sql = "UPDATE usuario SET login_usuario = :correo, telef_usuario = :telef WHERE id_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":correo"=>$correo,":telef"=>$telefono,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $res;
        }
        public function obtenerRolesAjenos($idUser){
            $sql = "SELECT DISTINCT(role) FROM usuario_tipo WHERE role <> 'Administrador' AND role NOT IN 
            (SELECT DISTINCT (role) FROM usuario_tipo WHERE id_usuario = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idUser));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function cambioEstadoUsuario($idUserRol,$cambioUserRol){
            $sql = "UPDATE usuario_tipo SET rol_activo = :cambio WHERE id_role_usuario = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":cambio"=>$cambioUserRol,":id"=>$idUserRol));
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function insertarUsuarioRol($idUsuario,$rol){
            $sql = "INSERT INTO usuario_tipo (id_usuario, role, rol_activo) VALUES(:idUsuario,:rol,true)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":idUsuario"=>$idUsuario,":rol"=>$rol));
            //$respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            return $res;
        }

        public function insertarUsuario($nombre,$apellido,$ci,$pass,$correo,$telefono){
            $sql = "INSERT INTO usuario(nombre_usuario, apellido_usuario,ci_usuario,pass_usuario,login_usuario,telef_usuario)
            VALUES(:nombre,:apellido,:ci,:pass,:correo,:telef)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nombre"=>$nombre,":apellido"=>$apellido,":ci"=>$ci,":pass"=>$pass,":correo"=>$correo,":telef"=>$telefono));
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
        public function getListaRoles(){ 
            $sql = "SELECT DISTINCT(role) FROM usuario_tipo WHERE role<>'Administrador'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }
        public function getUsuaurios(){
            $sql = "SELECT id_role_usuario, usuario_tipo.role, usuario.id_usuario, login_usuario, (nombre_usuario || ' ' || apellido_usuario) AS nombre, telef_usuario, rol_activo
            FROM usuario INNER JOIN usuario_tipo ON usuario.id_usuario = usuario_tipo.id_usuario  WHERE usuario.id_usuario 
            IN (SELECT id_usuario FROM usuario_tipo WHERE role <>'Administrador'); ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        public function obtenerUsuario($user,$pass){
            $sql = "SELECT * FROM usuario WHERE UPPER(login_usuario) = UPPER(:user) AND pass_usuario = :pass";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL-> execute(array(":user"=>$user,":pass"=>$pass));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }
        public function getUsuariosAdministrativos(){
            $sql = "SELECT id_usuario, (nombre_usuario || ' ' || apellido_usuario) AS nombre FROM usuario WHERE activo_usuario = true AND id_unidad_admin IS NULL AND id_usuario IN(
                (SELECT id_usuario FROM usuario_rol WHERE id_rol IN (SELECT id_rol FROM ROL WHERE UPPER(nombre_rol) = UPPER('Unidad Administrativa'))))";
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
        //     $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :id";
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