<?php
    //include("../modelo/model_unidad_de_gastos.php");
    require_once("../modelo/model_unidad_de_gastos.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $unidadDeGastos = new UnidadDeGastos();
        $res ="";
        switch ($metodo) { 
            case 'mostrarUnidadDeGastos':
                //$idUnidadAdministrativa = $_REQUEST['idUA'];
                $res = $unidadDeGastos->consulta();
                break;
            case 'cambioEstadoUG':
                $idUnidadGastos = $_REQUEST['idUG'];
                $cambioUG = $_REQUEST['cambioUG'];
                $res = $unidadDeGastos->cambioEstadoUG($idUnidadGastos,$cambioUG);
                break;
            case 'insertarUnidadAdministrativa':
                $nombre = $_REQUEST['nombreUA']; 
                $idFacultad = $_REQUEST['idFacultadUA'];
                $gestion = $_REQUEST['gestionUA'];
                $res = $unidadAdministrativa->insertarUnidadAdministrativa($nombre,$idFacultad,$gestion);
                break;
            case 'getUnidadAdministrativa':
                $res = $unidadAdministrativa->getUnidadAdministrativa();
                break;
            default:
                # code...
                break;
        }
        $unidadDeGastos->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }