let tablaUnidadAdministrativa, selectEditUA , selectAddUA, tablaFacultad ;
let listaNombreasUA = new Array();
let listaCorreos = new Array();
let listaNombreFacultades = new Array();
function obtenerTablas(){
    listaNombreasUA = new Array();
    let aux = tablaUnidadAdministrativa.column(0).data();
    // console.log(aux.length);
    for(let i = 0; i < aux.length ; i++){
        listaNombreasUA.push(aux[i]);
    }  
    // console.log(listaNombreasUA);
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

    $("#formAddFacultad").submit(function (e) { 
        e.preventDefault();
        let nombre = $("#addFacultadNombre").val();
        if(listaNombreFacultades.includes(nombre)){
            $("#spanNombreFac").html("Nombre registrado");
        }else{
            let gestion = $("#addGestionFacultad").val();
            $("#spanNombreFac").html("");
            if(gestion == "default"){
                $("#spanGestionFac").html("Selecione tipo de gestion");
            }else{
                $("#spanGestionFac").html("");
                let sigla = $("#addFacultadSigla").val();
                let fecha = $("#addFechaFacultad").val();
                let correo = $("#addFacultadCorreo").val();
                let telefono = $("#addFacultadTelefono").val();
                let descripcion = $("#addFacultadDesc").val();
                $('#myModal4').modal('hide');
                $.ajax({
                    type: "POST",
                    url: "../controlador/facultad.php",
                    data: {metodo:"insertarFacultad",nombre,gestion,sigla,fecha,correo,telefono,descripcion},
                    success: function (response) {
                        let myResp = parseInt(response);
                        if(!isNaN(myResp)){
                            tablaFacultad.ajax.reload();
                            $('#formAddFacultad')[0].reset();
                            Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                            getNombreFacultades();
                        }else{
                            Swal.fire('Problema!!',response,'info');
                        }
                    },
                    error: function(error){
                        console.log(error);
                        Swal.fire('Problema!!',error.status +" "+error.statusText,'info');;
                    }
                });
            }
        }
    });

    $("#formEditFacultad").submit(function (e) { 
        e.preventDefault();
        let descripcion = $("#editFacultadDesc").val();
        let telefono = $("#editFacultadTelefono").val();
        let correo = $("#editFacultadCorreo").val();
        let sigla = $("#editFacultadSigla").val();
        let nombre = $("#editFacultadNombre").val();
        let idFacultad = $("#editIDFacultad").val();
        $('#myModal7').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/facultad.php",
            data: {metodo:"actualizarFacultadBD",descripcion,telefono,correo,sigla,nombre,idFacultad},
            success: function (response) {
                let num = parseInt(response);
                if(!isNaN(num)){
                    tablaFacultad.ajax.reload();
                    Swal.fire('Exito!!','Se ha actualizado la facultad: '+nombre,'success');
                    $('#formEditFacultad')[0].reset();
                }else{
                    Swal.fire('Problema!!', response,'info');
                }
            },
            error: function( val ){
                console.log(val);
            }
        });
    });

    $("#formBajaFacutltad").submit(function (e) { 
        e.preventDefault();
        $('#myModal6').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/facultad.php",
            data: {metodo:"cambiarEstadoFacultad",idFacultad: $("#bajaFacultad").val(), estado: $("#estadoFacultadCambio").val()},
            success: function (response) {
                console.log(response);
                let aux = parseInt(response);
                if(!isNaN(aux)){
                    tablaFacultad.ajax.reload();
                    Swal.fire("Exito!!","Se ha actualizado el cambio de la facultad",'success');
                }else{
                    Swal.fire("Problema",response,'info');
                }
            }
        });
    });

    $("#tablaFacultad tbody").on('click','button.editFacultad ',function () {
        let dataEditFac = tablaFacultad.row( $(this).parents('tr') ).data();
        // console.log(dataEditFac);
        $("#editIDFacultad").val(dataEditFac.id_facultad);
        $("#editFacultadNombre").val(dataEditFac.nombre_facultad);
        $("#editFacultadSigla").val(dataEditFac.siglas_facutlad);
        $("#editFacultadCorreo").val(dataEditFac.correo_facultad);
        $("#editFacultadTelefono").val(dataEditFac.telefono_facultad);
        $("#editFacultadDesc").val(dataEditFac.descripcion_facultad);
    });

    $("#tablaFacultad tbody").on('click','button.bajaFacultad ',function () {
        let dataBajaFacultad = tablaFacultad.row( $(this).parents('tr') ).data();
        $("#bajaFacultad").val(dataBajaFacultad.id_facultad);
        // console.log(dataBajaFacultad);
        $("#estadoFacultadCambio").val(!dataBajaFacultad.activo_facultad);
        if(dataBajaFacultad.activo_facultad){ 
            $("#idTextEstadoFacultdad").html("Desea desactivar la <strong>"+dataBajaFacultad.nombre_facultad+"</strong>, esto permitira desabilitar las funciones de sus usuarios");
        }else{
            $("#idTextEstadoFacultdad").html("Desea activar la <strong>"+dataBajaFacultad.nombre_facultad+"</strong>, esto permitira habilitar las funciones de sus usuarios");
        }
        // $('#bajaFacultadNombre').html(dataBajaFacultad.nombre_facultad);
    });



    //FORMULARIOS Y FUNCIONES DEL SISTEMAS

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
    actualizarUsuariosAdministrativos();
    

    $("#tablaUnidadAdministrativa tbody").on('click','button.editUA ',function () {
        $("#editUAFacultad").empty();
        let dataEditUA = tablaUnidadAdministrativa.row( $(this).parents('tr') ).data();
        $("#editUAFacultad").append("<option value='"+dataEditUA.id_facultad+"'>"+dataEditUA.nombre_facultad+"</option>");
        $("#editUAFacultad").val(dataEditUA.id_facultad);
        // console.log(dataEditUA);
        $("#editUATelef").val(dataEditUA.telefono_ua);
        $("#editUAID").val(dataEditUA.id_unidad_admin);
        $('#editUANombre').val(dataEditUA.nombre_ua);
        $('#editUANomAnt').val(dataEditUA.nombre_ua);
        $("#editUAFecha").val(dataEditUA.fecha_ua);
        obtenerFacultadesDisponibles(dataEditUA.id_facultad,dataEditUA.nombre_facultad);
        $("#editDepatamentoResponsable").append("<option value='"+dataEditUA.id_usuario+"'>"+dataEditUA.nombre+"</option>");
        $("#editDepatamentoResponsable").val(dataEditUA.id_usuario);
        $("#editDepatamentoResponsableAnterior").val(dataEditUA.id_usuario);
        $("#editUAEstado").val(String(dataEditUA.activo_ua));
    });



    $("#tablaUnidadAdministrativa tbody").on('click','button.bajaUA',function () {
        let dataBajaUA = tablaUnidadAdministrativa.row( $(this).parents('tr') ).data();
        $("#bajaUA").val(dataBajaUA.id_unidad_admin);
        console.log(dataBajaUA);
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
        let responsableActual = $("#editDepatamentoResponsable").val();
        let responsableAnterior = $("#editDepatamentoResponsableAnterior").val();
        let telefono = $("#editUATelef").val();
        if (!listaNombreasUA.includes(nombreUA) || nombreUA ==$('#editUANomAnt').val()){
            $("#spanNomEditDep").html("");
            $('#myModal2').modal('hide');
            $.ajax({
                type: "POST",
                url: "../controlador/unidadAdministrativa.php",
                data: {metodo: 'actualizarUA',idUA,nombreUA,idFacultad,telefono},
                success: function (response) {
                    let aux = parseInt(response);
                    console.log(responsableActual+"  "+responsableAnterior);
                    if(!isNaN(aux)){
                        if(responsableActual != responsableAnterior){
                            $.ajax({
                                type: "POST",
                                url: "../controlador/usuario.php",
                                data: {metodo:'actualizarUsuarioUA',responsableActual,responsableAnterior,idUA},
                                success: function (res) {
                                    let aux2 = parseInt(res);
                                    console.log(res);
                                    if(!isNaN(aux2)){
                                        tablaUnidadAdministrativa.ajax.reload();
                                        $('#formEditUnidadAcademica')[0].reset();
                                        Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                                        obtenerTablas();
                                    }else{
                                        Swal.fire('Problemas',res,'info');
                                    }
                                }
                            });
                        }else{
                            tablaUnidadAdministrativa.ajax.reload();
                            $('#formEditUnidadAcademica')[0].reset();
                            Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                            obtenerTablas();
                        }
                    }else{
                        Swal.fire('Problemas',response,'info');
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
                let aux = parseInt(response);
                console.log(aux);
                if(!isNaN(aux)){
                    tablaUnidadAdministrativa.ajax.reload();
                    actualizarFacultades();
                    Swal.fire('¡Correcto!','Se cambio el estado de unidad Administrativa'+nombre,'success');  
                }else{
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
        let correo = $('#addDepatamentoCorreo').val().trim();
        let descripcion = $('#addDepartamentoDesc').val().trim();
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
                        data: {metodo:"insertarUnidadAdministrativa",nombre, usuario ,idFacultad, fecha, telefono, correo, descripcion},
                        success: function (response) {
                            tablaUnidadAdministrativa.ajax.reload();
                            console.log(response);
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
    $('#tablaUnidadAdministrativa').dataTable().fnDestroy();
    tablaUnidadAdministrativa = $("#tablaUnidadAdministrativa").DataTable({
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
          { data: "nombre", width: "20%" },
          { data: "nombre_facultad", width: "25%" },
          { data: "fecha_ua", width: "10%" },
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
            width: "10%",
          },
          {
            data: null,
            defaultContent:
              "<button type='button' class='editUA btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUA btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
            width: "10%",
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
              "<button type='button' class='editFacultad btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal7'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaFacultad btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal6'><i class='fas fa-sync'></i></button>",
            width: "15%",
          }
        ],
        "initComplete": function(settings, json) {
            getNombreFacultades();
          }
    });
}

function getNombreFacultades(){
    listaNombreFacultades = new Array();
    let aux = tablaFacultad.column(0).data();
    for(let i = 0; i < aux.length ; i++){
        listaNombreFacultades.push(aux[i]);
    }
    // console.log(listaNombreFacultades); 
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
                //console.log(listaCorreos);
            }
        }
    });
}