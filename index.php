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
    <title>Hola Mundo</title>
</head>
<body >
    <main class="container">
            <form action="controlador/verificarUsuario.php" method="POST">
            <h1>Validar Usuario</h1>
            <div class="form-group">
                <label for="user"></label>
                <input type="text" name="user" class="form-control" id="user">
            </div>
            <div class="form-group">
                <label for="pass"></label>
                <input type="password" name="pass" class="form-control" id="pass">
            </div>
            <div class="text-center">
                <input type="submit" value="Ingresar" class="btn btn-primary">
            </div>
        </form>
    </main>
</body>
</html>