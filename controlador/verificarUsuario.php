<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['pass'])){
        include_once("../modelo/model_user.php");
        $user = new User();
        $respuesta = $user->obtenerUsuario($_POST['user'],$_POST['pass']);
        $user->cerrarConexion();
        if(sizeof($respuesta)){
            $_SESSION['nombreUsuario'] = $respuesta['nombre_usuario'];
            $_SESSION['idUsuario'] = $respuesta['id_usuario'];
            include_once("../modelo/model_rol.php");
            $rol = new Rol();
            $res = $rol->getRolUsuario($respuesta['id_usuario']);
            var_dump($res);
            $rol->cerrarConexion();
            $_SESSION['rolUsuario'] = $res['role'];
            switch ($_SESSION['rolUsuario']) {
                case 'Administrador':
                    header("Location:../vista/home_Administrador.php");
                    break;
                case 'unidadAdministrativa':
                    //header("Location:../vista/home_usuario.php");
                    break;
                case 'unidadDeGastos':
                    //header("Location:../vista/home_usuario.php");
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            header("Location:../index.php?error=autentificacion");
        }
    }else{
        header("Location:../index.php");
    }