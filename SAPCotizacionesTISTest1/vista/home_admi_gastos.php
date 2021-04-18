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
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="#"><h2>Bienvenido <?php echo $_SESSION['nombreUsuario'];?></h2></a>
    
    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="home_administrador.php">Unidad Administrativa</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="home_admi_gastos.php">Unidad de gastos</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="home_admi_usuario.php">Usuarios</a>
        </li>
    </ul>
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
                            <label for="addDepartamentoNombre">Nombre Unidad:</label>
                            <input type="text" name="addDepartamentoNombre" id="addDepartamentoNombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label for="addDepatamentoFacultad">Selecione Facultad</label>
                                <select name="addDepatamentoFacultad" id="addDepatamentoFacultad" class="form-control">
                                    <option value="defaul">Ninguno</option>
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="addDepatamentoGestion">Selecione Gestion</label>
                                    <input type="text" name="addDepatamentoGestion" class="form-control" id="addDepatamentoGestion" required>
                                </div>
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




</body>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="librerias/tail.select.js"></script>
    <script src="src/home_administrador.js"></script>

</html>