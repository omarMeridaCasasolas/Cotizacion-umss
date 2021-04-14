<?php
    require_once("../modelo/model_unidad_administrativa.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $unidadAdministrativa = new UnidadAdministrativa();
        $res ="";
        switch ($metodo) { 
            case 'actualizarUA':
                $idUA = $_REQUEST['idUA'];
                $nombreUA = $_REQUEST['nombreUA'];
                $gestionUA = $_REQUEST['gestionUA'];
                $activoUA  = $_REQUEST['activoUA'];
                $res = $unidadAdministrativa->actualizarUA($idUA,$nombreUA,$gestionUA,$activoUA);
                break;
            case 'cambioEstadoUA':
                $idUnidadAdministrativa = $_REQUEST['idUA'];
                $cambioUA = $_REQUEST['cambioUA'];
                $res = $unidadAdministrativa->cambioEstadoUA($idUnidadAdministrativa,$cambioUA);
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
        $unidadAdministrativa->cerrarConexion();
        echo $res;
    }else{
        echo "Error al obtener metodo";
    }