<?php
    require_once("../modelo/model_user.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $user = new User();
        $res ="Metodo no existe";
        switch ($metodo) {  
            case 'actualizarUsuarioUA':
                $responsableAnterior = $_REQUEST['responsableAnterior'];
                $res = $user->eliminarUsuarioUA($responsableAnterior);
                echo $res." mientras que el idIA ".$_REQUEST['idUA'];
                $idUA = $_REQUEST['idUA'];
                $responsableActual = $_REQUEST['responsableActual'];
                $res = $user->agregarUsuarioUA($responsableActual,$idUA);
                // if(is_numeric($res)){
                //     $idUA = $_REQUEST['idUA'];
                //     $responsableActual = $_REQUEST['responsableActual'];
                //     $res = $user->agregarUsuarioUA($responsableActual,$idUA);
                // }
                break;
            case 'getCorreoUsuarios': 
                $correo = $_REQUEST['correo'];
                $res = $user->getCorreoUsuarios($correo);
                break;
            case 'getResponsableDisponiblesUA':
                $res = $user->getResponsableDisponiblesUA();
                break;
            case 'actualizarUsuarioTipo':
                $idTipo=$_REQUEST['idTipo'];
                $editUsuarioRol=$_REQUEST['editUsuarioRol'];
                $res = $user->actualizarUsuarioTipo($idTipo,$editUsuarioRol);
                break;
            case 'actualizarUsuario':
                $id=$_REQUEST['id'];
                $correo=$_REQUEST['correo'];
                $telefono=$_REQUEST['telefono'];
                $res = $user->actualizarUsuario($id,$correo,$telefono);
                break;
            case 'obtenerRolesAjenos':
                $idUser=$_REQUEST['idUser'];
                $res = $user->obtenerRolesAjenos($idUser);
                break;
            case 'cambioEstadoUsuario':
                $idUserRol=$_REQUEST['idUserRol'];
                $cambioUserRol=$_REQUEST['cambioUserRol'];
                $res = $user->cambioEstadoUsuario($idUserRol,$cambioUserRol);
                break;
            case 'insertarUsuarioRol':
                $idUsuario = $_REQUEST['idUsuario'];
                $listaRoles = $_REQUEST['listaRoles'];
                foreach ($listaRoles as $rol) {
                    $res = $user->insertarUsuarioRol($idUsuario,$rol);
                    if($res != 1){
                        break;
                    }
                }
                break;  
            case 'insertarUsuario':
                $nombre=$_REQUEST['nombre'];
                $apellido=$_REQUEST['apellido'];
                $ci=$_REQUEST['ci'];
                $pass=$_REQUEST['pass'];
                $correo=$_REQUEST['correo'];
                $telefono=$_REQUEST['telefono'];
                $res = $user->insertarUsuario($nombre,$apellido,$ci,$pass,$correo,$telefono);
                break;
            case 'getListaRoles':
                $res = $user->getListaRoles();
                break;
            case 'getUsuaurios':
                $res = $user->getUsuaurios();
                break;
            case 'getUsuariosAdministrativos':
                $res = $user->getUsuariosAdministrativos();
                break;
            case 'getFacultadeSelect':
                $res = $user->getFacultadeSelect();
                break;
            default:
                # code...
                break;
        }
        $user->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }