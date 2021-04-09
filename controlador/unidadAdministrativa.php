<?php
    require_once("../modelo/model_unidad_administrativa.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $unidadAdministrativa = new UnidadAdministrativa();
        $res ="";
        switch ($metodo) { 
            case 'bajaUA':
                $idUnidadAdministrativa = $_REQUEST['idUA'];
                $res = $unidadAdministrativa->bajaUA($idUnidadAdministrativa);
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