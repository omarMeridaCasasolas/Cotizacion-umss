let tablaUsuario, selectEditUA , selectAddUA, tablaFacultad ;
let listaNombreasUA = new Array();
let listaCorreos = new Array();
function obtenerTablas(){
    listaNombreasUA = new Array();
    let aux = tablaUsuario.column(0).data();
    console.log(aux.length);
    for(let i = 0; i < aux.length ; i++){
        listaNombreasUA.push(aux[i]);
    }  
    console.log(listaNombreasUA);
}

$(document).ready(function () {
    let params = new URLSearchParams(location.search);
    let contract = params.get('action');
    if(contract != null){
        Swal.fire(contract+'!!',"Se ha actualizado los datos del usuario",'success');
    }
    //FACULTADES
    getTablaFacultades();
    listaDeCorreos($("#editCorreo").val().trim());
    $("#formEditDatosPersonales").submit(function (e) { 
        //
        let passRepeat = $("#editRepeatPass").val().trim();
        let pass = $("#editPass").val().trim();
        let correo = $("#editCorreo").val().trim();
        if(listaCorreos.includes(correo)){
            $("#spanEditMyCorreo").html("Correo registrado");
            e.preventDefault();
        }else{
            $("#spanEditMyCorreo").html("");
            if( pass != passRepeat ){
                $("#spanEditPass").html("Deben coincidir");
                e.preventDefault();
            }else{
                $("#spanEditPass").html("");
                // e.preventDefault();
            }
        }
    });

    //FIN DE FACULTADES

    getUnidadesAdministrativa();
    actualizarFacultades();
    // actualizarUsuariosAdministrativos();
    

    $("#tablaUsuario tbody").on('click','button.editUA ',function () {
        $("#editUAFacultad").empty();
        let dataEditUA = tablaUsuario.row( $(this).parents('tr') ).data();
        $("#editUAFacultad").append("<option value='"+dataEditUA.id_facultad+"'>"+dataEditUA.nombre_facultad+"</option>");
        $("#editUAFacultad").val(dataEditUA.id_facultad);
        console.log(dataEditUA);
        //$("#editUAFacultad").empty();
        $("#editUATelef").val(dataEditUA.telefono_ua);
        $("#editUAID").val(dataEditUA.id_uni_admin);
        $('#editUANombre').val(dataEditUA.nombre_ua);
        $('#editUANomAnt').val(dataEditUA.nombre_ua);
        $("#editUAFecha").val(dataEditUA.fecha_ua);
        obtenerFacultadesDisponibles(dataEditUA.id_facultad,dataEditUA.nombre_facultad);
        $("#editDepatamentoResponsable").val(dataEditUA.id_usuario);
        $("#editUAEstado").val(String(dataEditUA.activo_ua));
    });



    $("#tablaUsuario tbody").on('click','button.bajaUA',function () {
        let dataBajaUA = tablaUsuario.row( $(this).parents('tr') ).data();
        $("#bajaUA").val(dataBajaUA.id_uni_admin);
        $("#estadoUACambio").val(!dataBajaUA.activo_ua);
        if(dataBajaUA.activo_ua){
            $("#idTextEstado").html("Desea desactivar la <strong>"+dataBajaUA.nombre_ua+"</strong>, esto permitira desabilitar las funciones de sus usuarios");
        }else{
            $("#idTextEstado").html("Desea activar la <strong>"+dataBajaUA.nombre_ua+"</strong>, esto permitira habilitar las funciones de sus usuarios");
        }
        $('#bajaUANombre').html(dataBajaUA.nombre_ua);
    });

    $("#formEditUnidadAcademica").submit(function (e) { 
        e.preventDefault();
        let idUA = $("#editUAID").val().trim();
        let nombreUA = $("#editUANombre").val().trim();
        let idFacultad = $("#editUAFacultad").val();
        let gestionUA = $("#editUAGestion").val().trim();
        let activoUA = $("#editUAEstado").val();
        let listaResponsables = $("#editDepatamentoResponsable").val();
        if (!listaNombreasUA.includes(nombreUA) || nombreUA ==$('#editUANomAnt').val()){
            $("#spanNomEditDep").html("");
            $.ajax({
                type: "POST",
                url: "../controlador/unidadAdministrativa.php",
                data: {metodo: 'actualizarUA',idUA,nombreUA,idFacultad,gestionUA,activoUA},
                success: function (response) {
                    $('#myModal2').modal('hide');
                    if(!isNaN(response)){
                        $.ajax({
                            type: "POST",
                            url: "../controlador/usuario_ua.php",
                            data: {metodo:'actualizarUsuarioUA',listaResponsables,idUA},
                            success: function (res) {
                                //console.log(res);
                                tablaUsuario.ajax.reload();
                                //tablaUsuario.initComplete();
                                $('#formEditUnidadAcademica')[0].reset();
                                if(!isNaN(res)){
                                    Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                                    obtenerTablas();
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
            $("#spanNomEditDep").html("Ya existe "+nombreUA);
        }
    });

    $("#formBajaUnidadAcademica").submit(function (e) { 
        $('#myModal3').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/unidadAdministrativa.php",
            data: {metodo:'cambioEstadoUA',idUA:$("#bajaUA").val(),cambioUA:$("#estadoUACambio").val()},
            success: function (response) {
                if(!isNaN(response)){
                    //$('#myModal3').modal('hide');
                    //getUnidadesAdministrativa();
                    tablaUsuario.ajax.reload();
                    actualizarFacultades();
                    //Swal.fire('¡Correcto!','Se Dio de baja la unidad, ahora se le puede asignar otra unidad Administrativa'+nombre,'success');  
                }else{
                    //$('#myModal3').modal('hide');  
                    Swal.fire('Problemas',res,'danger');
            }


            }
        });
        e.preventDefault();    
    });

    $("#formAddUnidadAcademica").submit(function (e) {
        e.preventDefault();
        let nombre = $("#addDepartamentoNombre").val().trim();
        let idFacultad = $("#addDepatamentoFacultad").val();
        let fecha = $("#addDepatamentoFecha").val().trim();
        let telefono = $("#addDepatamentoTelef").val().trim();
        let usuario = $('#addDepatamentoResponsable').val();
        if(usuario == "Ninguno"){
            $("#spanAddUA").html("Seleccione un usuario");
        }else{
            $("#spanAddUA").html("");
            if (listaNombreasUA.includes(nombre)) {
                $("#spanNomDep").html("Ya existe "+nombre);
            } else {
                $("#spanNomDep").html("");
                if(idFacultad == "Ninguno"){
                    $("#spanDepFac").html("Selecione una facultad");
                }else{
                    $('#myModal').modal('hide');
                    $("#spanDepFac").html("");
                    $.ajax({
                        type: "POST",
                        url: "../controlador/unidadAdministrativa.php",
                        data: {metodo:"insertarUnidadAdministrativa",nombre, usuario ,idFacultad, fecha, telefono},
                        success: function (response) {
                            tablaUsuario.ajax.reload();
                            if(!isNaN(response)){
                                Swal.fire('¡Exito!','Se ha agregado la unidad administrattiva '+nombre,'success');
                                actualizarFacultades();
                                $('#formAddUnidadAcademica')[0].reset();
                            }else{
                                Swal.fire('Problemas',response,'info');
                            }
                        },
                        error: function (error){
                            console.log(error);
                        }
                    });
                }
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
            let listaFacultades = JSON.parse(response);
            $("#addDepatamentoFacultad").empty();
            $("#editUAFacultad").empty();
            $("#addDepatamentoFacultad").append("<option value='Ninguno'>Ninguno</option>");
            listaFacultades.forEach(element => {
                $("#addDepatamentoFacultad").append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
                $("#editUAFacultad").append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
        },
        error: function (){
            console.log("Error");
        }
    });
}

function getUnidadesAdministrativa(){
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
          data: { metodo: "getUnidadAdministrativa" },
          url: "../controlador/unidadAdministrativa.php",
        },
        columns: [
          { data: "nombre_ua", width: "25%" },
          { data: "nombre_facultad", width: "30%" },
          { data: "fecha_ua", width: "15%" },
          {
            data: "activo_ua", // can be null or undefined
            // "defaultContent": "Sin Asignacion", "width": "15%"},
            render: function (data) {
              if (data == true) {
                return '<h5><span class="badge badge-success">Activo</span></h5>';
              } else {
                return '<h5><span class="badge badge-danger">Baja</span></h5>';
              }
            },
            width: "15%",
          },
          {
            data: null,
            defaultContent:
              "<button type='button' class='editUA btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUA btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
            width: "15%",
          }
        ],
        "initComplete": function(settings, json) {
            obtenerTablas();
          }
    });
}

function actualizarUsuariosAdministrativos(){
    $.ajax({
        type: "POST",
        url: "../controlador/usuario.php",
        data: {metodo:"getUsuariosAdministrativos"},
        success: function (response) {
            // console.log(JSON.parse(response));
            let listaUsuarios = JSON.parse(response);
            $("#addDepatamentoResponsable").empty();
            $("#editDepatamentoResponsable").empty();
            $("#addDepatamentoResponsable").append("<option value='Ninguno'>Ninguno</option>");
            listaUsuarios.forEach(element => {
                $("#addDepatamentoResponsable").append("<option value='"+element.id_usuario+"'>"+element.nombre+"</option>");
                $("#editDepatamentoResponsable").append("<option value='"+element.id_usuario+"'>"+element.nombre+"</option>");
            });
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

function obtenerResponsablesUnidadAdministrariva(){
    $.ajax({
        type: "POST",
        url: "../controlador/usuario.php",
        data: {metodo:getResponsableDisponiblesUA},
        dataType: "dataType",
        success: function (response) {
            
        }
    });
}

function obtenerFacultadesDisponibles(id,nombre){
    $.ajax({
        type: "POST",
        url: "../controlador/facultad.php",
        data: {metodo:"getFacultadeSelect"},
        success: function (response) {
            let listaFacultades = JSON.parse(response);
            listaFacultades.forEach(element => {
                $("#editUAFacultad").append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
        },
        error: function (){
            console.log("Error");
        }
    });
}


// INICIO FUNCIONES FACULTADES
function getTablaFacultades(){
    $('#tablaFacultad').dataTable().fnDestroy();
    tablaFacultad = $("#tablaFacultad").DataTable({
        responsive: true,
        "order": [[ 3, "asc" ]],
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
          data: { metodo: "getFacultades" },
          url: "../controlador/facultad.php",
        },
        columns: [
          { data: "nombre_facultad", width: "30%" },
          { data: "siglas_facutlad", width: "10%" },
          { data: "fecha_facultad", width: "15%" },
          { data: "telefono_facultad", width: "15%" },
          {
            data: "activo_facultad", // can be null or undefined
            // "defaultContent": "Sin Asignacion", "width": "15%"},
            render: function (data) {
              if (data == true) {
                return '<h5><span class="badge badge-success">Activo</span></h5>';
              } else {
                return '<h5><span class="badge badge-danger">Baja</span></h5>';
              }
            },
            width: "15%",
          },
          {
            data: null,
            defaultContent:
              "<button type='button' class='editUA btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUA btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
            width: "15%",
          }
        ],
        "initComplete": function(settings, json) {
            //getNombreFacultades();
          }
    });
}

function getNombreFacultades(){
    listaNombreFacultades = new Array();
    let aux = tablaFacultad.column(0).data();
    for(let i = 0; i < aux.length ; i++){
        listaNombreFacultades.push(aux[i]);
    } 
}

function listaDeCorreos(correo){
    $.ajax({
        type: "POST",
        url: "../controlador/usuario.php",
        data: {metodo:'getCorreoUsuarios',correo},
        success: function (response) {
            let lista = JSON.parse(response);
            if(listaCorreos == "Metodo no existe"){
                Swal.fire('¡Problema!',listaCorreos,'info');
            }else{
                lista.forEach(element => {
                    listaCorreos.push(element.login_usuario);
                });
                console.log(listaCorreos);
            }
        }
    });
}