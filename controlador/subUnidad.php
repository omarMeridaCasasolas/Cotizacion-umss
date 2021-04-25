<?php
    require_once("../modelo/model_subUnidad.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $subUnidad = new SubUnidad();
        $res ="Metodo no econtrado";
        switch ($metodo) { 
            case 'getSubUnidad':
                $idUA = $_REQUEST['idUA'];
                $res = $subUnidad->getSubUnidad($idUA);
                break;
            case 'getFacultadeSelect':
                $res = $subUnidad->getFacultadeSelect();
                break;
            default:
                # code...
                break;
        }
        $subUnidad->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }