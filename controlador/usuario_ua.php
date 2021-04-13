<?php
    require_once("../modelo/model_usuario_ua.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $userUA = new UserUA();
        $res ="";
        switch ($metodo) { 
            case 'actualizarUsuarioUA':
                $idUA = $_REQUEST['idUA'];
                $tmp = $userUA->eliminarUsuariosUA($idUA);
                if($tmp == 1){ 
                    $listaResponsables = $_REQUEST['listaResponsables'];
                    foreach ($listaResponsables as $usuario) {
                        $res = $userUA->insertarUsuarioUA($usuario,$idUA);
                        if($res != 1){
                            break;
                        }
                    }
                }
                break;
            case 'listaUsuariosUA':
                $idUA = $_REQUEST['idUA'];
                $res = $userUA->listaUsuariosUA($idUA);
                break;
            case 'insertarUsuarioUA':
                $idUA = $_REQUEST['idUA'];
                $listaUsuarios = $_REQUEST['listaUsuario'];
                //$res = $listaUsuarios; 
                foreach ($listaUsuarios as $usuario) {
                    $res = $userUA->insertarUsuarioUA($usuario,$idUA);
                    if($res != 1){
                        break;
                    }
                }
                break;
            default:
                # code...
                break;
        }
        $userUA->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }