let tablaUsuario, selectEditUA , selectAddUA ;
let listaCorreos = new Array();

function obtenerCorreos(){
    listaCorreos = new Array();
    let aux = tablaUsuario.column(2).data();
    for(let i = 0; i < aux.length ; i++){
        listaCorreos.push(aux[i]);
    }  
    console.log(listaCorreos);
}

$(document).ready(function () {
    getUsaurios();
    getListaRoles();
    // actualizarUsuariosAdministrativos();
    

    $("#tablaUsuario tbody").on('click','button.editUA ',function () {
        let dataEditUsuario = tablaUsuario.row( $(this).parents('tr') ).data();
        console.log(dataEditUsuario);
        $("#editIDRol").val(dataEditUsuario.id_role_usuario);
        $("#editIDUser").val(dataEditUsuario.id_usuario);

        $("#editUsuarioRol").empty();
        $("#editUsuarioRol").append("<option value='"+dataEditUsuario.role+"'>"+dataEditUsuario.role+"</option>");
        $("#editUsuarioRol").val(dataEditUsuario.role);
        $.ajax({
            type: "POST",
            url: "../controlador/usuario.php",
            data: {metodo:'obtenerRolesAjenos',idUser:dataEditUsuario.id_usuario},
            beforeSend: function() {
                $('#loader').show();
             },
            success: function (response) {
                console.log(response);
                let listaCargosPosibles = JSON.parse(response);
                console.log(listaCargosPosibles);
                listaCargosPosibles.forEach(element => {
                    $("#editUsuarioRol").append("<option value='"+element.role+"'>"+element.role+"</option>");
                });
            },
            complete: function(){
                $('#loader').hide();
             }
        });

        $("#editCorreoUser").val(dataEditUsuario.login_usuario);
        $('#editCopyCorreo').val(dataEditUsuario.login_usuario);

        $('#editTelUser').val(dataEditUsuario.telef_usuario);
        $("#editUAEstado").val(String(dataEditUsuario.rol_activo));
    });

    $("#tablaUsuario tbody").on('click','button.bajaUA',function () {
        let dataBajaUsuario = tablaUsuario.row( $(this).parents('tr') ).data();
        console.log(dataBajaUsuario);
        $("#idUsuarioRol").val(dataBajaUsuario.id_role_usuario);
        $("#estadoUserRol").val(!dataBajaUsuario.rol_activo);
        if(dataBajaUsuario.rol_activo){
            $("#idTextEstado").html("Desea desactivar la <strong>"+dataBajaUsuario.nombre+"</strong>, respecto a <strong>"+dataBajaUsuario.role+"</strong> esto permitira desabilitar las funciones del usuario");
        }else{
            $("#idTextEstado").html("Desea activar la <strong>"+dataBajaUsuario.nombre+"</strong>, respecto a <strong>"+dataBajaUsuario.role+"</strong> esto permitira habilitar las funciones del usuario");
        }
        // $('#bajaUANombre').html(dataBajaUsuario.nombre_ua);
    });

    $("#formEditUsuario").submit(function (e) { 
        e.preventDefault();
        let id = $("#editIDUser").val().trim();
        let idTipo = $("#editIDRol").val().trim();
        let correo = $("#editCorreoUser").val().trim();
        let telefono = $("#editTelUser").val();
        let editUsuarioRol = $("#editUsuarioRol").val();
        $('#myModal2').modal('hide');
        if (!listaCorreos.includes(correo) || correo ==$('#editCopyCorreo').val()){
            $("#spanCorreoUs").html("");
            $.ajax({
                type: "POST",
                url: "../controlador/usuario.php",
                data: {metodo: 'actualizarUsuario',id,correo,telefono},
                success: function (response) {
                    if(!isNaN(response)){
                        $.ajax({
                            type: "POST",
                            url: "../controlador/usuario.php",
                            data: {metodo:'actualizarUsuarioTipo',editUsuarioRol,idTipo},
                            success: function (res) {
                                //console.log(res);
                                tablaUsuario.ajax.reload();
                                //tablaUsuario.initComplete();
                                $('#formEditUsuario')[0].reset();
                                if(!isNaN(res)){
                                    Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                                    obtenerCorreos();
                                }else{
                                    Swal.fire('Problemas',res,'danger');
                                }
                            }
                        });
                    }else{
                        $('#myModal2').modal('hide');
                        Swal.fire('Problemas',response,'danger');
                    }
                }
            });   
        } else {
            $("#spanCorreoUs").html("Ya existe "+nombreUA);
        }
    });

    $("#formBajaUsuarioRol").submit(function (e) {  
        $('#myModal3').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/usuario.php",
            data: {metodo:'cambioEstadoUsuario',idUserRol:$("#idUsuarioRol").val(),cambioUserRol:$("#estadoUserRol").val()},
            success: function (response) {
                if(!isNaN(response)){
                    //$('#myModal3').modal('hide');
                    //getUnidadesAdministrativa();
                    tablaUsuario.ajax.reload();
                    //actualizarFacultades();
                    Swal.fire('¡Correcto!','Se cambio el estado del usuario','success');  
                }else{
                    //$('#myModal3').modal('hide');  
                    Swal.fire('Problemas',res,'info');
            }


            }
        });
        e.preventDefault();    
    });

    $("#formAddUser").submit(function (e) {
        e.preventDefault();
        let nombre = $("#addNameUSuario").val().trim();
        let apellido = $("#addApellUSuario").val().trim();
        let ci = $("#addCiUSuario").val().trim(); 
        let pass = $("#addPassUSuario").val().trim();
        let correo = $("#addCorreoUSuario").val().trim();
        let telefono = $("#addTelUSuario").val().trim();
        let listaRoles = $('#addRol').val();
        if(listaRoles.length == 0){
            $("#spanAddRol").html("Seleccione almenos un rol para el usuario!!");
        }else{
            if (listaCorreos.includes(correo)) {
                $("#spanCorreoUser").html("Ya existe "+correo);
            } else {
                $('#myModal').modal('hide');
                $("#spanCorreoUser").html("");
                $("#spanAddRol").html("");
                $.ajax({
                    type: "POST",
                    url: "../controlador/usuario.php",
                    data: {metodo:"insertarUsuario",nombre,apellido,ci,pass,correo,telefono},
                    success: function (response) {
                        console.log(listaRoles);
                        if(!isNaN(response)){
                            $.ajax({
                                type: "POST",
                                url: "../controlador/usuario.php",
                                data: {metodo:"insertarUsuarioRol", listaRoles, idUsuario: parseInt(response)},
                                success: function (res) {
                                    tablaUsuario.ajax.reload();
                                    console.log(res);
                                    if(!isNaN(res)){
                                        Swal.fire('¡Exito!','Se ha agregado la unidad administrattiva '+nombre,'success');
                                        //actualizarFacultades();
                                        $('#formAddUser')[0].reset();
                                        $("#addRol").val([]);
                                        getListaRoles();
                                    }else{
                                        Swal.fire('Problemas',res,'info');
                                    }
                                }
                            });
                        } 
                    },
                    error: function (){
                        console.log("Error");
                    }
                });
            }
        }
    });
});

function actualizarFacultades(){
    $.ajax({
        type: "POST",
        url: "../controlador/facultad.php",
        data: {metodo:"getFacultadeSelect"},
        success: function (response) {
            // console.log(JSON.parse(response));
            let listaFacultades = JSON.parse(response);
            //$("#addDepatamentoFacultad").append("<option value='null'>Ninguno</option>");
            $("#addDepatamentoFacultad").empty();
            //$("#editUAFacultad").empty();
            listaFacultades.forEach(element => {
                $("#addDepatamentoFacultad").append("<option value="+element.id_facultad+">"+element.nombre_facultad+"</option>");
                //$("#editUAFacultad").append("<option value="+element.id_facultad+">"+element.nombre_facultad+"</option>");
            });
            if($('#addDepatamentoFacultad option').length == 0){
                $("#addDepatamentoFacultad").append("<option value=''>No existen facultades disponibles</option>");
            }
        },
        error: function (){
            console.log("Error");
        }
    });
}

function getUsaurios(){
    $('#tablaUsuario').dataTable().fnDestroy(); 
    tablaUsuario = $("#tablaUsuario").DataTable({
        responsive: true,
        "order": [[ 1, "asc" ]],
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
          data: { metodo: "getUsuaurios" },
          url: "../controlador/usuario.php",
        },
        columns: [
          { data: "nombre", width: "20%" },
          { data: "role", width: "25%" },
          { data: "login_usuario",width: "25%" },
          { data: "telef_usuario",width: "10%" },
          { data: "rol_activo",
            render: function (data) {
              if (data == true) {
                return '<h5><span class="badge badge-success">Activo</span></h5>';
              } else {
                return '<h5><span class="badge badge-danger">Baja</span></h5>';
              }
            },
            width: "10%" 
          },
          { data: null, width: "10%" ,
            defaultContent:
              "<button type='button' class='editUA btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUA btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>"
          }
        ],
        "initComplete": function(settings, json) {
            obtenerCorreos();
          }
    });
}

function getListaRoles(){
    $.ajax({
        type: "POST",
        url: "../controlador/usuario.php",
        data: {metodo:"getListaRoles"},
        success: function (response) {
            let listaUsuarios = JSON.parse(response);
            $("#addRol").empty();
            //$("#editDepatamentoResponsable").empty();
            listaUsuarios.forEach(element => {
                $("#addRol").append("<option value='"+element.role+"'>"+element.role+"</option>");
                //$("#editDepatamentoResponsable").append("<option value="+element.id_usuario+">"+element.nombre+"</option>");
            });
            $('#addRol').select2({
                placeholder: "Selecione a los usuarios",
                tags: true
            });
            // $('#editDepatamentoResponsable').select2({
            //     placeholder: "Selecione a los usuarios",
            //     tags: true
            // });
        },
        error: function (){
            console.log("Error");
        }
    });
}

function listaDeUsuariosUA(idUsuarioUA){
    //console.log(idUsuarioUA);
    $.ajax({
        type: "POST",
        url: "../controlador/usuario_ua.php",
        data: {metodo:"listaUsuariosUA",idUA:idUsuarioUA},
        success: function (response) {
            let listaUsuarios = JSON.parse(response);
            myArregloEdit = new Array();
            listaUsuarios.forEach(element => {
                //console.log(element.id_usuario);
                $("#listaResponsablesAnt").append('<li>'+element.nombre+'</li>');
                myArregloEdit.push(element.id_usuario);
            });
            //selectEditUA.options.selected = Array();
            $("#editDepatamentoResponsable").val(myArregloEdit);
            $('#editDepatamentoResponsable').trigger('change');
        },
        error: function (){
            console.log("Error");
        }
    });
}

