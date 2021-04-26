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
    <a class="navbar-brand" href="#"><h2 data-toggle="modal" data-target="#myModalX">Bienvenido <?php echo $_SESSION['nombreUsuario'];?></h2></a>
    <!-- <button class="btn btn-default btn-lg text-white "><?php echo 'Bienvenid@: '.$_SESSION['nombreUsuario'];?></button> -->
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
        <div id="accordion">
            <div class="card">
                <div class="card-header">
                    <h3><a class="card-link" data-toggle="collapse" href="#collapseOne">Facultades</a></h3>
                </div>
                <div id="collapseOne" class="collapse show" >
                    <div class="card-body">
                        <div class="m-3">
                        <button class="btn btn-success" data-toggle="modal" data-target="#myModal4">+ Facultad</button>
                        </div>
                        <table class="table display" id="tablaFacultad">
                            <thead>
                                <tr class="bg-info">
                                <th>Nombre Facultad</th>
                                <th>Sigla</th>
                                <th>Fecha</th>
                                <th>Telefono</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3><a class="card-link" data-toggle="collapse" href="#collapseDos">Unidades Administrativas</a></h3>
                </div>
                <div id="collapseDos" class="collapse show" >
                    <div class="card-body">
                        <div class="m-3">
                        <button class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Unidad Administrativa</button>
                        </div>
                        <table class="display" id="tablaUsuario">
                            <thead>
                                <tr class="bg-info">
                                    <th>Nombre Unidad</th>
                                    <th>Facultad</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="d-none">
            <h1 class="text-primary text-center">Unidades Administrativas</h1>
            <div class="m-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Unidad Administrativa</button>
            </div>
            <table class="display" id="tablaUsuario">
                <thead>
                    <tr class="bg-info">
                        <th>Nombre Unidad</th>
                        <th>Facultad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </main>

    <!-- modales -->
    <!-- The Modal Agregar departamento-->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Crear Unidad Administrativa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formAddUnidadAcademica">
                        <div class="form-group">
                            <label for="addDepartamentoNombre">Nombre Unidad Administrativa:</label>
                            <input type="text" name="addDepartamentoNombre" id="addDepartamentoNombre" class="form-control" required>
                            <span class="text-danger" id="spanNomDep"></span>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="addDepatamentoFacultad">Seleccione Facultad:</label>
                                <select name="addDepatamentoFacultad" id="addDepatamentoFacultad" class="form-control" required>
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                                <span class="text-danger" id="spanDepFac"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="addDepatamentoTelef">Telefono:</label>
                                <input type="text" name="" id="addDepatamentoTelef" class="form-control" required>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-8">
                                <label for="addDepatamentoCorreo">Correo:</label>
                                <input type="text" name="" id="addDepatamentoCorreo" class="form-control">
                                <span class="text-danger" id="spanAddUA"></span>                               
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="addDepatamentoEstado">Estado:</label>
                                    <select name="" id="addDepatamentoEstado" class="form-control">
                                        <option value="true">Si</option>
                                        <option value="false">No</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-7">
                                <label for="addDepatamentoResponsable">Seleccione responsable:</label>
                                    <select id="addDepatamentoResponsable" class="form-control" required>
                                    </select> 
                                <span class="text-danger" id="spanAddUA"></span>                               
                            </div>
                            <div class="col-5">
                                <label for="addDepatamentoCorreo">Correo:</label>
                                <input type="text" name="" id="addDepatamentoCorreo" class="form-control">
                                <span class="text-danger" id="spanAddUA"></span>                               
                            </div>
                            <!-- <div class="col-4">
                                <div class="form-group">
                                    <label for="addDepatamentoFecha">Fecha:</label>
                                    <input type="date" class="form-control" id="addDepatamentoFecha" required value="<?php echo date("Y-m-d");?>" disabled>
                                </div>
                            </div> -->
                        </div>
                        <br>
                        <h5>Descripcion de la unidad Academica</h5>
                        <textarea name="" id="" cols="30" rows="4" class="form-control m-2"></textarea>
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
                    <h4 class="modal-title text-center">Cambiar estado de la Unidad Administrativa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formBajaUnidadAcademica">
                        <input type="text" name="bajaUA" id="bajaUA" class="d-none">
                        <input type="text" name="estadoUACambio" id="estadoUACambio" class="d-none">
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
                    <h4 class="modal-title">Editar Unidad Administrativa</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formEditUnidadAcademica">
                        <input type="text" name="editUAID" id="editUAID" class="d-none">
                        <input type="text" name="editUANomAnt" id="editUANomAnt" class="d-none">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Nombre</label>
                                <input type="text" name="editUANombre" id="editUANombre" class="form-control" required>
                                <span id="spanNomEditDep" class="text-danger"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="editUAFecha">Fecha:</label>
                                <input type="text"  id="editUAFecha" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Facultad:</label>
                                <select class="form-control" id="editUAFacultad" required>
                                    <!-- <option value="" selected disabled>Facultad de Z</option> -->
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="">Estado:</label>
                                <select class="form-control" id="editUAEstado" disabled>
                                    <option value="true">Si</option>
                                    <option value="false">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Responsable:</label>
                                <select  id="editDepatamentoResponsable" required class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="editUATelef">Telefono:</label>
                                <input type="text"  id="editUATelef" class="form-control">
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

    <!-- MODAL PARA EDITAR DATOS PERSONASLES -->
    <div class="modal fade" id="myModalX">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Editar Datos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="../controlador/cambiarDatosPersonales.php" id="formEditDatosPersonales" method="POST">
                        <!-- <input type="text" name="idEditUsuario" id="idEditUsuario" value="<?php echo $_SESSION['nombreUsuario'];?>"> -->
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="editNombre">Nombre(s):</label>
                                <input type="text" name="editNombre" id="editNombre" class="form-control" value="<?php echo $_SESSION['nombreUsuario'];?>" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                            </div>
                            <div class="form-group col-6">
                                <label for="editApellido">Apellido(s):</label>
                                <input type="text" name="editApellido" id="editApellido" class="form-control" value="<?php echo $_SESSION['apellidoUsuario'];?>" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off" title="Solo letras y vocales">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="editCorreo">Correo:</label>
                                <input type="mail" name="editCorreo" id="editCorreo" class="form-control" required value="<?php echo $_SESSION['correoUsuario'];?>">
                            </div>
                            <div class="form-group col-4">
                                <label for="editTelefono">Telefono:</label>
                                <input type="tel" name="editTelefono" id="editTelefono" class="form-control" required pattern="[0-9]{6,8}" title="Solo números entre 6 a 8 dígitos" value="<?php echo $_SESSION['telefonoUsuario'];?>">
                            </div>
                        </div>
                        <span id="spanEditMyCorreo" class="text-danger"></span>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="editPass">Contraseña:</label>
                                <input type="password" name="editPass" id="editPass" class="form-control" required value="<?php echo $_SESSION['passUsuario'];?>" pattern="[A-Za-z0-9_-]{4,15}" title="Solo letras y números entre 4 y 15 caracteres">
                            </div>
                            <div class="form-group col-6">
                                <label for="editRepeatPass">Repet contraseña:</label>
                                <input type="password" name="editRepeatPass" id="editRepeatPass" class="form-control" required value="<?php echo $_SESSION['passUsuario'];?>" pattern="[A-Za-z0-9_-]{4,15}" title="Solo letras y números entre 4 y 15 caracteres">
                            </div>
                        </div>
                        <span id="spanEditPass" class="text-danger"></span>
                        <div class="text-center">
                            <input type="submit" value="Actualiza" class="btn btn-primary">
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
    <script src="src/home_administrador.js"></script>
</html>