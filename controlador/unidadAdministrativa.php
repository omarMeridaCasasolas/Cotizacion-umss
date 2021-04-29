<?php
    require_once("../modelo/model_unidad_administrativa.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $unidadAdministrativa = new UnidadAdministrativa();
        $res ="Metodo no encontrado";
        switch ($metodo) { 
            case 'actualizarUA':
                $idUA = $_REQUEST['idUA'];
                $nombreUA = $_REQUEST['nombreUA'];
                $id_facultad = $_REQUEST['idFacultad'];
                $telefono  = $_REQUEST['telefono'];
                $res = $unidadAdministrativa->actualizarUA($idUA,$nombreUA,$id_facultad,$telefono);
                break;
            case 'cambioEstadoUA':
                $idUnidadAdministrativa = $_REQUEST['idUA'];
                $cambioUA = $_REQUEST['cambioUA'];
                $res = $unidadAdministrativa->cambioEstadoUA($idUnidadAdministrativa,$cambioUA);
                break;
            case 'insertarUnidadAdministrativa':
                $nombre = $_REQUEST['nombre']; 
                $idFacultad = $_REQUEST['idFacultad'];
                $fecha = $_REQUEST['fecha'];
                $usuario  = $_REQUEST['usuario'];
                $telefono  = $_REQUEST['telefono'];
                $correo = $_REQUEST['correo'];
                $descripcion = $_REQUEST['descripcion'];
                $res = $unidadAdministrativa->insertarUnidadAdministrativa($nombre,$idFacultad,$fecha,$usuario,$telefono,$correo,$descripcion);
                if(is_numeric($res)){
                    require_once("../modelo/model_rol.php");
                    $rol = new Rol();
                    $response = $rol->insertarUsuarioRolUA($usuario);
                    if(is_numeric($res)){
                        require_once('../modelo/model_user.php');
                        $user = new User();
                        $response = $user->asignarUnidadAdministrativa($res,$usuario);
                        $res = $response;
                    }
                }
                break;
            case 'getUnidadAdministrativa':
                $res = $unidadAdministrativa->getUnidadAdministrativa();
                break;
            default:
                # code...
                break;
        }
        $unidadAdministrativa->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }