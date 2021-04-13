<?php
    require_once("../modelo/model_user.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $user = new User();
        $res ="";
        switch ($metodo) {  
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