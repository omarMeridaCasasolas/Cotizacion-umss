<?php 
    session_start();
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
        <a class="nav-link" href="home_administrador.php">Unidad Administrativa</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Unidad de gastos</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="home_admi_usuario.php">Usuarios</a>
        </li>
    </ul>
    </nav>
    <main class="container bg-light rounded-lg border p-2">
        <h1 class="text-primary text-center">LIsta de usuarios</h1>
        <div class="m-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Usuario</button>
        </div>
        <table class="display" id="tablaUsuario">
            <thead>
                <tr class="bg-info">
                    <th>Nombre usuario</th>
                    <th>Cargo</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
    </main>

    <!-- modales -->
    <!-- The Modal Agregar departamento-->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Agregar usuario</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="formAddUser">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="addNameUSuario">Nombre(s) Usuario:</label>
                                <input type="text" name="addNameUSuario" id="addNameUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                            <div class="form-group col-6">
                                <label for="addApellUSuario">Apellidos:</label>
                                <input type="text" name="addApellUSuario" id="addApellUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="addCiUSuario">Carnet:</label>
                                <input type="text" name="addCiUSuario" id="addCiUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                            <div class="form-group col-6">
                                <label for="addPassUSuario">Contraseña:</label>
                                <input type="password" name="addPassUSuario" id="addPassUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addCorreoUSuario">Correo de Usuarios</label>
                                <input type="mail" name="addCorreoUSuario" id="addCorreoUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                            <span id="spanCorreoUser" class="text-danger"></span>
                            <div class="form-group col-5">
                                <label for="addTelUSuario">Telefono</label>
                                <input type="text" name="addTelUSuario" id="addTelUSuario" class="form-control" required>
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                        </div>
                        <div class="form-group">
                                <span>Selecione rol Asignado:</span>
                                <select multiple name="addRol" id="addRol" class="mul-select form-control" required style = "width:100%">
                                </select>
                        </div>
                        <span class="text-danger" id="spanAddRol"></span>
                        <div class="move-container"></div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Crear">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA DAR DE BAJA -->
    <div class="modal fade" id="myModal3">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-center">Cambiar estado de Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formBajaUsuarioRol"> 
                        <input type="text" name="idUsuarioRol" id="idUsuarioRol" class="d-none">
                        <input type="text" name="estadoUserRol" id="estadoUserRol" class="d-none">
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

    <!-- MODAL PARA EDITAR -->
    <div class="modal fade" id="myModal2">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Editar Usuarios</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formEditUsuario">
                        <input type="text" name="editIDRol" id="editIDRol" class="d-none">
                        <input type="text" name="editIDUser" id="editIDUser" class="d-none">
                        <input type="text" name="editCopyCorreo" id="editCopyCorreo" class="d-none">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="editCorreoUser">Correo</label>
                                <input type="mail" name="editCorreoUser" id="editCorreoUser" class="form-control" required>
                                <span id="spanCorreoUs" class="text-danger"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="editTelUser">Telefono</label>
                                <input type="text" name="editTelUser" id="editTelUser" class="form-control" required pattern="[0-9]{5,9}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="editUsuarioRol">Seleccione :</label>
                                <div class="spinner-border text-muted" id="loader"></div>
                                <select class="form-control" id="editUsuarioRol" required>
                                    <!-- <option value="" selected disabled>Facultad de Z</option> -->
                                </select>
                                
                            </div>
                            <div class="form-group col-4">
                                <label for="editEstadoUsuario">Estado:</label>
                                <select class="form-control" id="editEstadoUsuario" disabled>
                                    <option value="true">Si</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
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
</body>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_admi_usuario.js"></script>
</html>