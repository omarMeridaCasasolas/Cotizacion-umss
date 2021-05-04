<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Inicio de session</title>
    <?php 
        if(isset($_GET['error'])){
            echo "<script>alert('Usuario no autorizado');</script>";
        }
    ?>
</head>
<body class="bg-secondary my-5">
    <main class="container bg-light rounded p-3">
        <form action="controlador/verificarUsuario.php" method="POST" class="container">
            <h1 class="text-center">Validar Usuario</h1>
            <div class="form-group mx-5">
                <label for="user">Correo Electronicio</label>
                <input type="mail" name="user" class="form-control" id="user" required>
            </div>
            <div class="form-group mx-5">
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" class="form-control" id="pass" required>
            </div>
            <div class="text-center my-3">
                <input type="submit" value="Ingresar" class="btn btn-primary">
            </div>
        </form>
        <a href="">¿Te olvidaste tu contraseña?</a>
    </main>
</body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="vista/src/index.js"></script>
</html>