<?php
    session_start();
    if(isset($_SESSION["nombreUsuario"])){
        $nombre = trim($_POST['editNombre']);
        $apellido = trim($_POST['editApellido']);
        $correo = trim($_POST['editCorreo']);
        $telefono = trim($_POST['editTelefono']);
        $password = trim($_POST['editPass']);
        require_once ('../modelo/model_user.php');
        $user = new User();
        $res = $user->actualizarDatosUsuario($_SESSION['idUsuario'],$nombre,$apellido,$correo,$telefono,$password);
        if($res == true){
            $_SESSION['nombreUsuario'] = $nombre;
            $_SESSION['apellidoUsuario'] = $apellido;
            $_SESSION['correoUsuario'] = $correo;
            $_SESSION['telefonoUsuario'] = $telefono;
            $_SESSION['passUsuario'] = $password;
            $data = parse_url($_SERVER['HTTP_REFERER']);
            header("Location:".$data['scheme']."://".$data['host'].$data['path']."?action=Usuario actualizado");
        }else{
            var_dump($res);
        }
    }else{
         header("Location:../index.php?problem=Usuario no identificado");
    }

