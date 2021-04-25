<?php 
    session_start();
    // if(isset($_SESSION["nombreUsuario"])){
    // }else{
    //      header("Location:../index.php");
    //  }
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
        <h1 class="text-primary text-center">Facultades</h1>
        <div class="m-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#myModal">+ Facultad</button>
        </div>
        <table class="display" id="tablaFacultad">
            <thead>
                <tr class="bg-info">
                    <th>Nombre Facultad</th>
                    <th>Sigla</th>
                    <th>Fecha</th>
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
                    <h4 class="modal-title">Crear Facultad</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formAddFacultad">
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="addFacultadNombre">Nombre facultad:</label>
                                <input type="text" id="addFacultadNombre" class="form-control" required>
                                <span class="text-danger" id="spanNombreFac"></span>
                            </div>
                            <div class="form-group col-4">
                                <label for="addFacultadSigla">Sigla:</label>
                                <input type="text" id="addFacultadSigla" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addGestionFacultad">Tipo Gestion</label>
                                <select name="addGestionFacultad" id="addGestionFacultad" class="form-control" required>
                                    <option value="default">Ninguno</option>
                                    <option value="Semestral">Semestral</option>
                                    <option value="Anual">Anual</option>
                                </select>
                                <span class="text-danger" id="spanGestionFac"></span>
                            </div>
                            <div class="form-group col-5">
                                <label for="addFechaFacultad">fecha:</label>
                                <input type="date" id="addFechaFacultad" class="form-control" required value="<?php echo date("Y-m-d");?>" disabled>                            
                                <span class="text-danger" id="spanNomDep"></span>
                            </div>
                        </div>
                        <span class="text-danger" id="spanAddUA"></span>
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
                                <label for="">Gestion</label>
                                <input type="text" name="editUAGestion" id="editUAGestion" class="form-control" required pattern="[0-9]{4}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-8">
                                <label for="">Facultad:</label>
                                <select class="form-control" id="editUAFacultad">
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
                        <div class="">
                            <h4 class="text-primary">Lista de responsables anteriorres:</h4>
                            <ul id="listaResponsablesAnt">
                            
                            </ul>
                        </div>
                        <div class="form-group">
                            <h6>Lista de usuarios:</h65>
                            <select multiple  id="editDepatamentoResponsable" required class="mul-select form-control" style = "width:100%">
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
    <script src="src/home_facultades.js"></script>
</html>