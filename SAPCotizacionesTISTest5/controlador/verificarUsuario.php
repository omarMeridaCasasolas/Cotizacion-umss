<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['pass'])){
        include_once("../modelo/model_user.php");
        $user = new User();
        $respuesta = $user->obtenerUsuario($_POST['user'],$_POST['pass']);
        $user->cerrarConexion();
        if(sizeof($respuesta)){
            $_SESSION['nombreUsuario'] = $respuesta['nombre_usuario'];
            $_SESSION['apellidoUsuario'] = $respuesta['apellido_usuario'];
            $_SESSION['correoUsuario'] = $respuesta['login_usuario'];
            $_SESSION['telefonoUsuario'] = $respuesta['telef_usuario'];
            $_SESSION['passUsuario'] = $respuesta['pass_usuario'];
            $_SESSION['idUsuario'] = $respuesta['id_usuario'];
            include_once("../modelo/model_rol.php");
            $rol = new Rol();
            $res = $rol->getRolUsuario($respuesta['id_usuario']);
            var_dump($res);
            $rol->cerrarConexion();
            $_SESSION['rolUsuario'] = $res['nombre_rol'];
            switch ($_SESSION['rolUsuario']) {
                case 'Administrador':
                    header("Location:../vista/home_Administrador.php");
                    break;
                case 'Unidad Administrativa':
                    $_SESSION['idUA'] = $res['id_uni_admin'];
                    header("Location:../vista/sub_unidadUA.php");
                    break;
                case 'unidadDeGastos':
                    //header("Location:../vista/home_usuario.php");
                    break;
                default:
                    header("Location:../index.php?problem=".$_SESSION['rolUsuario']);
                    break;
            }
        }else{
            header("Location:../index.php?error=autentificacion");
        }
    }else{
        header("Location:../index.php");
    }