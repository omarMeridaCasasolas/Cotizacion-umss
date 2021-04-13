<?php
    require_once("../modelo/model_facultad.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $facultad = new Facultad();
        $res ="";
        switch ($metodo) { 
            case 'getFacultades':
                $res = $facultad->getFacultades();
                break;
            case 'getFacultadeSelect':
                $res = $facultad->getFacultadeSelect();
                break;
            default:
                # code...
                break;
        }
        $facultad->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }