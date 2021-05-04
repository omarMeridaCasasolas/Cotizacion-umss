<?php 
    session_start();
    if(isset($_SESSION["nombreUsuario"])){

    }else{
         header("Location:../index.php");
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home_Administrador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="librerias/tail.select.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="estiasdasf">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="#"><h2>Bienvenido <?php echo $_SESSION['nombreUsuario'];?></h2></a>
    
    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="home_Administrador.php">Unidad Administrativa</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="home_admi_gastos.php">Unidad de gastos</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="home_admi_usuario.php">Usuarios</a>
        </li>
    </ul>
    <div class="float-right py-3">
        <a href="../controlador/formCerrarSession.php" class="btn btn-primary float-right" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
                <br>
        </div>
    </nav>
    <main class="container bg-light rounded-lg border p-2">
        <h1 class="text-primary text-center">Lista de usuarios</h1>
        <div class="m-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Usuario</button>
        </div>
        <table class="table-sm display table-bordered" id="tablaUsuario">
            <thead>
                <tr class="bg-info">
                    <th>Nombre Usuario</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        <!-- MODAL PARA DAR DE BAJA -->
        <div class="modal fade" id="myModal3">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h4 class="modal-title text-center">Cambiar estado de usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="" id="formBajaUsuario">
                            <input type="text" name="id_usuario" id="idUsuario" class="d-none">
                            <input type="text" name="estadoUsuario" id="estadoUsuario" class="d-none">
                            <h5 id="idTextEstado"></h5>
                            <!-- <h5>Desea cambiar el estado de la : <strong id='bajaUANombre'>UA</strong>, desabilitara/habilara las tareas de los usuarios</h5> -->
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary" value="Cambiar">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal Agregar Usuario-->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-success">
                        <h4 class="modal-title">Crear Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="" id="formAddUsuario">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="">Nombre:</label>
                                    <input type="text" name="" id="nombreUsuario" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Apellido:</label>
                                    <input type="text" name="" id="apellidoUsuario" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="">Telefono:</label>
                                    <input type="text" name="" id="telefonoUsuario" class="form-control" required pattern="[0-9]{6,8}" title="Solo números entre 6 a 8 dígitos" autocomplete="off">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Carnet:</label>
                                    <input type="text" name="" id="carnetUsuario" class="form-control" required pattern="[0-9]{6,8}" title="Solo números entre 6 a 8 dígitos" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-7">
                                    <label for="">Correo:</label>
                                    <input type="mail" name="" id="correoUsuario" class="form-control" required autocomplete="off" >
                                </div>
                                <div class="form-group col-5">
                                    <label for="">Password:</label>
                                    <input type="password" name="" id="passUsuario" class="form-control" required pattern="[A-Za-z0-9_-]{4,15}" title="Solo letras y números entre 4 y 15 caracteres" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo:</label>
                                <select name="" id="tipoUsuario" class="form-control" required> 
                                    <option value="2">Unidad administrativa</option>
                                    <option value="3">Unidad de gastos</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-succes" value="Crear">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="" id="formEditUsuario">
                            <input type="text" name="" id="idEditUsuario" class="d-none">
                            <input type="text" name="" id="idEditRolUsuario" class="d-none">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="">Nombre:</label>
                                    <input type="text" name="" id="nombreEditUsuario" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                                </div>
                                <div class="form-group col-6">
                                    <label for="">Apellido:</label>
                                    <input type="text" name="" id="apellidoEditUsuario" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-7">
                                    <label for="">Correo:</label>
                                    <input type="mail" name="" id="correoEditUsuario" class="form-control" required autocomplete="off" >
                                </div>
                                <div class="form-group col-5">
                                    <label for="">Telefono:</label>
                                    <input type="text" name="" id="telefonoEditUsuario" class="form-control" required pattern="[0-9]{6,8}" title="Solo números entre 6 a 8 dígitos" autocomplete="off">
                                </div>
                            </div>
                            <input type="text" name="" id="copiaTipoEditUsuario" class="d-none">
                            <div class="form-group">
                                <label for="">Tipo:</label>
                                <select name="" id="tipoEditUsuario" class="form-control" required> 
                                    <option value="2">Unidad administrativa</option>
                                    <option value="3">Unidad de gastos</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary" value="Actualizar">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_admi_usuario.js"></script>
</html>