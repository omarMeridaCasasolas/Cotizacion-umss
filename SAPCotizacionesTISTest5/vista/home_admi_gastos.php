<?php
    session_start();
    if(isset($_SESSION["nombreUsuario"])){

    }else{
         header("Location:../index.php?error=usuario no identidicado");
     }
?>
<!DOCTYPE html>
<html lang="es">
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
    <link rel="stylesheet" href="librerias/modalUG.css">
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

        <!--Listar facultad para recien desplegar las unidades de gasto-->
        <div class="row">
            <div>
                <div class="m-3">
                    <label for="">Seleccione Facultad:</label>
                        <select name="seleccionarFacultad" id="seleccionarFacultad" class="form-control">
                            <option value="0">Selecciona Facultad...</option>
                        </select>
                </div>
            </div>

        </div>

        <div class="row">
            <div>
                <div class="m-3">
                    <!-- Boton Agregar Unidad de Gastos-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal_NuevoUG">+ Unidades de Gastos</button>
                    <!-- Boton Agregar USUARIOS para Unidad de Gastos-->
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal_AgregarUsuariosUG">+ Usuarios</button>
                </div>
            </div>
            
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
    <!-- add Julio Crear Unidad de Gastos--> 
    <div class="modal fade" id="modal_NuevoUG">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Cabecera -->
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Nueva Unidad de Gastos</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Cuerpo -->
                <div class="modal-body">
                    <form action="" id="formAddUG">
                        <div class="form-group">
                            <!-- Lista de Facultades -->
                            <label for="">Facultad:</label>
                            <select name="nuevoUG_seleccionarFacultad" id="nuevoUG_seleccionarFacultad" class="form-control" disabled>
                                    <option value="0">Selecciona Facultad...</option>
                            </select>
                            
                            <!-- Nombre de la Nueva Unidad de Gastos -->
                            <label for="">Nombre Unidad de Gastos:</label>
                            <input type="text" placeholder="Escriba nombre de Unidad de Gastos" name="nuevoUG_nombre_ug" id="nuevoUG_nombre_ug" class="form-control" required>

                            <!-- Unidad de Gastos Superior OPCIONAL -->
                            <label for="">Unidad de Gastos Superior:</label>
                            <select name="nuevoUG_selecciona_ug_superior" id="nuevoUG_selecciona_ug_superior" class="form-control">
                                    <option value="0">Seleccione Unidad de Gastos Superior</option>
                            </select>
                            <br>
                            <div class="row">
                                <div class="form-group col-7">
                                    <!-- Gestion -->
                                    <label for="">Gestión:</label>
                                    <select name="nuevoUG_gestion" id="nuevoUG_gestion" class="form-control">
                                            <option value="0">2021</option>
                                    </select>

                                    <!-- Estado -->
                                    <label for="">Estado:</label>
                                    <select class="form-control" id="nuevoUG_estado">
                                        <option value="true">Activo</option>
                                        <option value="false">Inactivo</option>
                                    </select>
                                </div>
                                <div class="form-group col-5">
                                    <!-- Responsable -->
                                    <label for="">Seleccione responsable</label>
                                    <select id="nuevoUG_responsableUG">
                                        <option value="0">Ninguno</option>
                                        <option value="1">Ana Panozo Merida</option>
                                        <option value="2">Isabel Flores Castro</option>
                                        <option value="3">Carla Teran Andrade</option>
                                    </select>
                                </div>

                            </div>

                        </div>
                        <div class="move-container"></div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Crear">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Crear Unidad de Gastos-->


    <!-- add Julio Crear USUARIOS Unidad de gastos SIN USO AUN-->

    <div class="modal fade" id="modal_AgregarUsuariosUG" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
            <!-- Modal Cabecera -->
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title">Nuevo Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Cuerpo -->
                <div class="modal-body">
                    <form action="" id="formAddUsuarioUG">
                    <!--<form action="" id="formAddUG"> -->

                        <!-- ******DATOS DE USUARIO******* -->
                        <div class="form-group">
                            <!-- Nombre de usuario de acceso -->
                            <label for="">nombre de usuario:</label>
                            <input type="text" placeholder="Escriba un nombre de usuario" name="escribe_nombre_usuario" id="formAddUsuarioUG_nombre_usuario" class="form-control" required >

                            <!-- Nombre del usuario -->
                            <label for="">Nombres:</label>
                            <input type="text" placeholder="Escriba su nombre(s)" name="formAddUsuarioUG_nombres" id="formAddUsuarioUG_nombres" class="form-control" required >

                            <!-- Apellidos del usuario -->
                            <label for="">Apellidos:</label>
                            <input type="text" placeholder="Escriba su apellido(s)" name="formAddUsuarioUG_apellidos" id="formAddUsuarioUG_apellidos" class="form-control" required >
                            <div class="row">
                                <div class="form-group col-7">
                                    <!-- Cedula de identidad -->
                                    <label for="">CI:</label>
                                    <input type="text" placeholder="Número de cedula de identidad" name="formAddUsuarioUG_ci" id="formAddUsuarioUG_ci" class="form-control" required >
                                </div>
                                <div class="form-group col-5">
                                    <!-- Complemento  ATERTA:Agregar campo complemento_ci -->
                                    <label for="">Complemento:</label>
                                    <input type="text" placeholder="Complemento" name="formAddUsuarioUG_complemento_ci" id="formAddUsuarioUG_complemento_ci" class="form-control" >
                                </div>
                            </div>

                            <!-- Correo -->
                            <label for="">Correo electronico:</label>
                            <input type="text" placeholder="Escribe tu correo electronico" name="formAddUsuarioUG_email" id="formAddUsuarioUG_email" class="form-control" required >
                        </div>
                        <!-- ************* -->

                        <div class="form-group">
                            <!-- Lista de Facultades para crear Usuario-->
                            <label for="">Facultad:</label>
                            <select name="formAddUsuarioUG_Facultad" id="formAddUsuarioUG_Facultad" class="form-control" disabled>
                                    <option value="default">Selecciona Facultad...</option>
                            </select>

                            <!-- Nombre de la Unidad de Gastos -->
                            <label for="">Unidad de Gastos:</label>
                            <input type="text" placeholder="muestra nombre Unidad de Gastos" name="formAddUsuarioUG_nombre_ug" id="formAddUsuarioUG_nombre_ug" class="form-control" value="Carrera de Informática" required disabled>
                            <br>

                            <div class="row">
                                <div class="form-group col-7">
                                    <!-- Estado -->
                                    <label for="">Estado:</label>
                                    <select class="form-control" id="formAddUsuarioUG_estado">
                                        <option value="true">Activo</option>
                                        <option value="false">Inactivo</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="move-container"></div>
                        <div class="text-center">
                            <input type="submit" class="btn btn-primary" value="Agregar Usuario">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin USUARIOS Unidad de gastos-->






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
    <!-- changed -->
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
                            <!-- <div class="form-group col-8">
                                <label for="">Nivel:</label>
                                <select class="form-control" id="editUGFacultad"> -->

                                    <!-- <option value="" selected disabled>Facultad de Z</option> -->
                                    
                                <!-- </select>
                            </div> -->
                            
                            <!-- <div class="form-group col-4">
                                <label for="">Estado:</label>
                                <select class="form-control" id="editUGEstado" disabled>
                                    <option value="true">Si</option>
                                    <option value="false">No</option>
                                </select>
                            </div> -->
                        </div>
                        <!-- <div class="">
                            <h4 class="text-primary">Lista de responsables anteriorres:</h4>
                            <ul id="listaResponsablesAnt">
                            
                            </ul>
                        </div> -->
                        <div class="form-group">
                            <label for="editDepatamentoResponsable">Seleccione responsable</label>
                                <select multiple  id="editDepatamentoResponsable" class="form-control" required>
                                            <option value="defaul">Ninguno</option>
                                            <option value="1">Ana Panozo Merida</option>
                                            <option value="2">Isabel Flores Castro</option>
                                            <option value="3">Carla Teran Andrade</option>
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