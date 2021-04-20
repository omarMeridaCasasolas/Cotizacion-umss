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
        <h1 class="text-primary text-center">Unidades de Gastos</h1>
        <div class="m-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalUG">+ Unidades de Gastos</button>
        </div>
        <table class="display" id="tablaUnidadDeGastos">
            <thead>
                <tr class="bg-info">
                    <th>Nombre Unidad</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
    </main>



    <!-- modales -->
    <!-- The Modal Agregar departamento-->
    <div class="modal fade" id="modalUG">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Crear Unidad de Gastos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formAddUG">
                        <div class="form-group">
                            <label for="addDepartamentoNombre">Nombre Departamento:</label>
                            <input type="text" name="addDepartamentoNombre" id="addDepartamentoNombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label for="addDepatamentoFacultad">Selecione Sub Unidad</label>
                                <select name="addDepatamentoFacultad" id="addDepatamentoFacultad" class="form-control">
                                    <option value="default">Ninguno</option>
                                </select>
                            </div>
                        <div class="row">
                            <div class="col-8">
                                <!-- <div class="form-group">
                                    <label for="addDepatamentoResponsable">Selecione responsable</label>
                                    <select name="addDepatamentoResponsable" id="addDepatamentoResponsable" class="form-control">
                                        <option value="defaul">Ninguno</option>
                                    </select>
                                </div> -->
                                <label for="addDepatamentoResponsable">Seleccione responsable</label>
                                    <select multiple  id="addDepatamentoResponsable">
                                        <!-- <option value="defaul">Ninguno</option>
                                        <option value="1">Ana Panozo Merida</option>
                                        <option value="2">Isabel Flores Castro</option>
                                        <option value="3">Carla Teran Andrade</option> -->
                                    </select>
                            </div>

                        </div>
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
                    <h4 class="modal-title text-center">Cambiar estado de la Unidad De Gastos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formBajaUnidadAcademica">
                        <input type="text" name="bajaUG" id="bajaUG" class="d-none">
                        <input type="text" name="estadoUGCambio" id="estadoUGCambio" class="d-none">
                        <h5 id="idTextEstado"></h5>
                        <!-- <h5>Desea cambiar el estado de la : <strong id='bajaUGNombre'>UA</strong>, desabilitara/habilara las tareas de los usuarios</h5> -->
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
                    <h4 class="modal-title">Editar Unidad de Gastos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formEditUnidadAcademica">
                        <input type="text" name="editUGID" id="editUGID" class="d-none">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Nombre</label>
                                <input type="text" name="editUGNombre" id="editUGNombre" class="form-control" required>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Nivel:</label>
                                <select class="form-control" id="editUGFacultad">
                                    <!-- <option value="" selected disabled>Facultad de Z</option> -->
                                </select>
                            </div>
                            <!-- <div class="form-group col-4">
                                <label for="">Estado:</label>
                                <select class="form-control" id="editUGEstado" disabled>
                                    <option value="true">Si</option>
                                    <option value="false">No</option>
                                </select>
                            </div> -->
                        </div>
                        <div class="">
                            <h4 class="text-primary">Lista de responsables anteriorres:</h4>
                            <ul id="listaResponsablesAnt">
                            
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="editDepatamentoResponsable">Seleccione responsable</label>
                                <select multiple  id="editDepatamentoResponsable" class="form-control" required>
                                            <!-- <option value="defaul">Ninguno</option>
                                            <option value="1">Ana Panozo Merida</option>
                                            <option value="2">Isabel Flores Castro</option>
                                            <option value="3">Carla Teran Andrade</option> -->
                                </select>
                            </div>
                        <div class="move-container2"></div>
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
    <script src="librerias/tail.select.js"></script>
    <!-- <script src="src/home_administrador.js"></script> -->
    <script src="src/home_admi_gastos.js"></script>
<!-- select2 -->
</html>