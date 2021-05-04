let tablaUsuario;
$(document).ready(function () {
    listarUsuario();
    $("#tablaUsuario tbody").on('click','button.editUsuario ',function () {
        let dataEditUsuario = tablaUsuario.row( $(this).parents('tr') ).data();
        console.log(dataEditUsuario);
        $("#idEditUsuario").val(dataEditUsuario.id_usuario);
        $("#nombreEditUsuario").val(dataEditUsuario.nombre_usuario);
        $("#apellidoEditUsuario").val(dataEditUsuario.apellido_usuario);
        $("#correoEditUsuario").val(dataEditUsuario.login_usuario);
        $("#telefonoEditUsuario").val(dataEditUsuario.telef_usuario);
        $("#tipoEditUsuario").val(dataEditUsuario.id_rol);
        $("#copiaTipoEditUsuario").val(dataEditUsuario.id_rol);
        $("#idEditRolUsuario").val(dataEditUsuario.id_rol_usuario);
        // $('#bajaFacultadNombre').html(dataBajaUsuario.nombre_facultad);
    });

    $("#tablaUsuario tbody").on('click','button.bajaUsuario ',function () {
        let dataBajaUsuario = tablaUsuario.row( $(this).parents('tr') ).data();
        console.log(dataBajaUsuario);
        $("#idUsuario").val(dataBajaUsuario.id_usuario);
        $("#estadoUsuario").val(!dataBajaUsuario.activo_usuario);
        if(dataBajaUsuario.activo_usuario){ 
            $("#idTextEstado").html("Desea desactivar la <strong>"+dataBajaUsuario.nombre+"</strong>, esto permitira desabilitar las funciones de sus usuarios");
        }else{
            $("#idTextEstado").html("Desea activar la <strong>"+dataBajaUsuario.nombre+"</strong>, esto permitira habilitar las funciones de sus usuarios");
        }
        // $('#bajaFacultadNombre').html(dataBajaUsuario.nombre_facultad);
    });

    $("#formBajaUsuario").submit(function (e) { 
        e.preventDefault();
        $('#myModal3').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/usuario.php",
            data: {metodo:'cambiarEstadoUsuario',idUsuario: $('#idUsuario').val(),estado: $('#estadoUsuario').val()},
            success: function (response) {
                let num1 = parseInt(response);
                if(!isNaN(num1)){
                    tablaUsuario.ajax.reload();
                    $('#formBajaUsuario')[0].reset();
                    Swal.fire('Exito!!',"Se ha actualizado al usuario",'success');
                    //obtenerTablas();
                }else{
                    Swal.fire('Problema!!',response,'info');
                }
            }
        });
    });

    $("#formEditUsuario").submit(function (e) { 
        e.preventDefault();
        $('#myModal2').modal('hide');
        let nombre =$("#nombreEditUsuario").val();
        let apellido = $("#apellidoEditUsuario").val();
        let correo = $("#correoEditUsuario").val();
        let telefono = $("#telefonoEditUsuario").val();
        let tipo = $("#tipoEditUsuario").val();
        let copia = $("#copiaTipoEditUsuario").val();
        let id = $("#idEditUsuario").val();
        $.ajax({
            type: "POST",
            url: "../controlador/usuario.php",
            data: {metodo:'actualizarUsuario',id,nombre,apellido,correo,telefono},
            success: function (response) {
                let num1 = parseInt(response);
                if(!isNaN(num1)){
                  if(tipo === copia){
                    tablaUsuario.ajax.reload();
                    $('#formEditUsuario')[0].reset();
                    Swal.fire('Exito!!',"Se ha actualizado los datos del  usuario",'success');
                  }else{
                    $.ajax({
                      type: "POST",
                      url: "../controlador/usuario.php",
                      data: {metodo:'actualizarTipoUsuario',idRolUsuario: $("#idEditRolUsuario").val(),tipo},
                      success: function (res) {
                        let num2 = parseInt(res);
                        if(!isNaN(num2)){
                          tablaUsuario.ajax.reload();
                          $('#formEditUsuario')[0].reset();
                          Swal.fire('Exito!!',"Se ha actualizado los datos del  usuario",'success');
                        }else{
                          Swal.fire('Problema!!',res,'info');
                        }
                      }
                    });
                  }
                }else{
                  Swal.fire('Problema!!',response,'info');
                }
            }
        });
    });

    $("#formAddUsuario").submit(function (e) { 
        e.preventDefault();
        $('#myModal').modal('hide');
        let nombre = $("#nombreUsuario").val();
        let apellido = $("#apellidoUsuario").val();
        let correo = $("#correoUsuario").val();
        let pass = $("#passUsuario").val();
        let telefono = $("#telefonoUsuario").val();
        let carnet = $("#carnetUsuario").val();
        let tipo = $("#tipoUsuario").val();
        $.ajax({
            type: "POST",
            url: "../controlador/usuario.php",
            data: {metodo:'agregarUsuario',nombre,apellido,correo,pass,telefono,carnet,tipo},
            success: function (response) {
                let num1 = parseInt(response);
                if(!isNaN(num1)){
                    $('#formAddUsuario')[0].reset();
                    tablaUsuario.ajax.reload();
                    Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                    //obtenerTablas();
                }else{
                    Swal.fire('Problema!!',response,'info');
                }
            }
        });
    });

});

function listarUsuario(){
    $('#tablaUsuario').dataTable().fnDestroy();
    tablaUsuario = $("#tablaUsuario").DataTable({
        responsive: true,
        "order": [[ 2, "asc" ]],
        language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningún dato disponible en esta tabla",
          sInfo:
            "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
            sFirst: "Primero",
            sLast: "Último",
            sNext: "Siguiente",
            sPrevious: "Anterior",
          },
          oAria: {
            sSortAscending:
              ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
              ": Activar para ordenar la columna de manera descendente",
          },
          buttons: {
            copy: "Copiar",
            colvis: "Visibilidad",
          },
        },
        ajax: {
          method: "POST",
          data: { metodo: "getListaUsuario" },
          url: "../controlador/usuario.php",
        },
        columns: [
          { data: "nombre", width: "25%" },
          { data: "login_usuario", width: "25%" },
          { data: "telef_usuario", width: "10%" },
          { data: "nombre_rol", width: "20%" },
          {
            data: "activo_usuario", // can be null or undefined
            // "defaultContent": "Sin Asignacion", "width": "15%"},
            render: function (data) {
              if (data == true) {
                return '<h5><span class="badge badge-success">Activo</span></h5>';
              } else {
                return '<h5><span class="badge badge-danger">Baja</span></h5>';
              }
            },
            width: "10%",
          },
          {
            data: null,
            defaultContent:
              "<button type='button' class='editUsuario btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUsuario btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
            width: "10%",
          }
        ],
        "initComplete": function(settings, json) {
            // obtenerTablas();
          }
    });
}