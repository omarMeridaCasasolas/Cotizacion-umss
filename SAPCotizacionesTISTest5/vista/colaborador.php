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
    <a class="navbar-brand" href="sub_unidadUA.php"><h2>Bienvenido <?php echo $_SESSION['nombreUsuario'];?></h2></a>
    <input type="text" name="" id="identUA" class="d-none" value="<?php echo $_SESSION['idUA'];?>" >
    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="sub_ua.php">Sub unidades</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="colaborador.php">Colababoradores</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="sub_usuario.php">Usuarios</a>
        </li>
    </ul>
    <div class="float-right py-3">
        <a href="../controlador/formCerrarSession.php" class="btn btn-primary float-right" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
                <br>
        </div>
    </nav>



    <main class="container bg-light rounded-lg border p-2">
        <h1 class="text-primary text-center">Colaborador</h1>
        <div class="m-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalUG">Sub unidades</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalFunciones">Sub unidades</button>
        </div>
        <table id="tablaAyudantes" class="hover display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>Secretaria</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
        
            <tr>
                <td>Jennifer Acosta</td>
                <td>Administrador</td>
                <td>Edinburgh</td>
                <td>43</td>
                <td>2013/02/01</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Cara Stevens</td>
                <td>responsable de cotizacion</td>
                <td>New York</td>
                <td>46</td>
                <td>2011/12/06</td>
                <td> <button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Hermione Butler</td>
                <td>Regional Director</td>
                <td>London</td>
                <td>47</td>
                <td>2011/03/21</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Lael Greer</td>
                <td>Systems Administrator</td>
                <td>London</td>
                <td>21</td>
                <td>2009/02/27</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Jonas Alexander</td>
                <td>Developer</td>
                <td>San Francisco</td>
                <td>30</td>
                <td>2010/07/14</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Shad Decker</td>
                <td>Regional Director</td>
                <td>Edinburgh</td>
                <td>51</td>
                <td>2008/11/13</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Michael Bruce</td>
                <td>Javascript Developer</td>
                <td>Singapore</td>
                <td>29</td>
                <td>2011/06/27</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
            <tr>
                <td>Donna Snider</td>
                <td>Customer Support</td>
                <td>New York</td>
                <td>27</td>
                <td>2011/01/25</td>
                <td><button class="btn">Editar</button> <button class="btn btn-danger">Eliminar</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
    </main>



    <!-- modales -->
    <!-- The Modal Agregar departamento-->
    <div class="modal fade" id="modalUG">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Header -->
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Crear Unidad - Departamento</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="" id="formAddUG">
                        <div class="form-group">
                            <label for="addNombreSubUnidad">Nombre Departamento:</label>
                            <input type="text" id="addNombreSubUnidad" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addResponsableSubUnidad">Responsable:</label>
                                <select name="" id="addResponsableSubUnidad" class="form-control"></select>
                            </div>
                            <div class="form-group col-5">
                                <label for="addFechaSubUnidad">Fecha:</label>
                                <input type="date" id="addFechaSubUnidad" value="<?php echo date("Y-m-d");?>" disabled>
                            </div>
                        </div>
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
        <div class="modal fade" id="modalFunciones">
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
                        <div class="form-group">
                            <label for="">Seleccione Cargo:</label>
                            <select name="" id="" class="form-control">
                                <option value="">Secretaria</option>
                                <option value="">Administrador</option>
                                <option value="">Cotizacion</option>
                                <option value="">Empleado I</option>
                                <option value="">Empleado I</option>
                            </select>
                        </div>
                        <input type="submit" value="Obtner funciones">
                    </form>
                    <form action="">
                        <h2 class="text-center">Lista de Tareas</h2>
                        <input type="checkbox" name="vehicle1" value="Bike">
                        <label for="vehicle1"> Tarea</label><br>
                        <input type="checkbox" name="vehicle2" value="Car">
                        <label for="vehicle2"> Tarea 1</label><br>
                        <input type="checkbox" name="vehicle3" value="Boat" checked>
                        <label for="vehicle3"> Tarea 2 </label><br><br>
                        <label for="vehicle3"> Tarea 2 </label><br><br>
                        <input type="checkbox" name="vehicle3" value="Boat" checked>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>



</body>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/colaborador.js"></script>
    <!-- <script src="src/home_admi_gastos.js"></script> -->
<!-- select2 -->
</html>