<?php
    require_once("../modelo/model_facultad.php");
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $facultad = new Facultad();
        $res ="metodo no funcionando";
        switch ($metodo) { 
            case 'getObtenerFAcultades':
                $res = $facultad->getObtenerFAcultades();
                break;
            case 'actualizarFacultadBD':
                $idFacultad = $_REQUEST['idFacultad'];
                $nombre = $_REQUEST['nombre'];
                $sigla = $_REQUEST['sigla'];
                $telefono = $_REQUEST['telefono'];
                $correo = $_REQUEST['correo'];
                $descripcion = $_REQUEST['descripcion'];
                $res = $facultad->actualizarFacultadBD($nombre,$sigla,$telefono,$correo,$descripcion,$idFacultad);
                break;
            case 'cambiarEstadoFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $estado = $_REQUEST['estado'];
                $res = $facultad->cambiarEstadoFacultad($idFacultad,$estado);
                break;
            case 'insertarFacultad':
                $nombre = $_REQUEST['nombre'];
                $sigla = $_REQUEST['sigla'];
                $gestion = $_REQUEST['gestion'];
                $fecha = $_REQUEST['fecha'];
                $telefono = $_REQUEST['telefono'];
                $correo = $_REQUEST['correo'];
                $descripcion = $_REQUEST['descripcion'];
                $res = $facultad->insertarFacultad($nombre,$sigla,$gestion,$fecha,$telefono,$correo,$descripcion);
                break;
            case 'getFacultades':
                $res = $facultad->getFacultades();
                break;
            case 'getFacultadeSelect':
                $res = $facultad->getFacultadeSelect();
                break;
            case 'getListaFacultades':
                $res = $facultad->getListaFacultades();
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