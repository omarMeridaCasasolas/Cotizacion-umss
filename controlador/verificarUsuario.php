<?php
    session_start();
    if(isset($_POST['user']) && isset($_POST['pass'])){
        include_once("../modelo/model_user.php");
        $user = new User();
        $respuesta = $user->obtenerUsuario($_POST['user'],$_POST['pass']);
        $user->cerrarConexion();
        $_SESSION['nombreUsuario'] = $respuesta['nombre_usuario'];
        header("Location:../vista/home_usuario.php");
    }else{
        header("Location:../index.php");
    }