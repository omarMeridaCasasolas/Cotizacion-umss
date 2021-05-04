<?php
    //include("../modelo/model_unidad_de_gastos.php");
    require_once("../modelo/model_unidad_de_gastos.php");
    
    if(isset($_REQUEST['metodo'])){
        $metodo = $_REQUEST['metodo'];
        $unidadDeGastos = new UnidadDeGastos();
        $res ="metodo no funcionando";
        
        switch ($metodo) { 
            case 'mostrarUnidadDeGastos':
                $res = $unidadDeGastos->consulta();
                break;
            case 'mostrarUnidadDeGastosPorFacultad':
                //bloque case add Julio $idUnidadAdministrativa = $_REQUEST['idUA']; Ya estaba comentado
                $idFacultad = $_REQUEST['id_Facultad'];//add Julio
                $res = $unidadDeGastos->consulta_ug_por_facultad($idFacultad);
                break;
            case 'getListaUnidadDeGastosDeFacultad':
                //bloque case add Julio
                $idFacultad = $_REQUEST['id_Facultad'];//add Julio
                $res = $unidadDeGastos->consulta_getListaUnidadDeGastosDeFacultad($idFacultad);
                break;
            case 'insertarNuevaUnidadDeGastosEnFacultad':
                //bloque case add Julio
                $facultad = $_REQUEST['idFacultad_ug'];
                $padre = $_REQUEST['padre_id_ug'];
                $nombre = $_REQUEST['nombre_ug'];
                $gestion = $_REQUEST['gestion_ug'];
                $estado = $_REQUEST['estado_ug'];
                
                $res = $unidadDeGastos->insertarNuevaUnidadDeGastosEnFacultad($facultad,$padre,$nombre,$gestion,$estado);
                break;
            case 'cambioEstadoUG':
                $idUnidadGastos = $_REQUEST['idUG'];
                $cambioUG = $_REQUEST['cambioUG'];
                $res = $unidadDeGastos->cambioEstadoUG($idUnidadGastos,$cambioUG);
                break;
            case 'actualizarUG':
                $idUG=$_REQUEST['idUG'];
                $nombreUG=$_REQUEST['nombreUG'];
                $res = $unidadDeGastos->actualizarUG($idUG,$nombreUG);
                break;
            case 'getListaFacultades':
                $res = $facultad->getListaFacultades();
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