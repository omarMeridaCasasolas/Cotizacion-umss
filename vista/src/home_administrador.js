let tablaUnidadAdministrativa, selectEditUA;
$(document).ready(function () {
    getUnidadesAdministrativa();
    actualizarFacultades();
    actualizarUsuariosAdministrativos();

    // $("#btnRowAdd").click(function (e) { 
    //     tablaUnidadAdministrativa.row.add({"nombre_ua":'aaa',"gestion_ua":'2020',"nombre_facultad":'bbb','activo_ua':'true'}).draw();
    //     e.preventDefault();
    // });
    $("#tablaUnidadAdministrativa tbody").on('click','button.editUA ',function () {
        let dataEditUA = tablaUnidadAdministrativa.row( $(this).parents('tr') ).data();
        console.log(dataEditUA);
        $("#editUAID").val(dataEditUA.id_uni_admin);
        $('#editUANombre').val(dataEditUA.nombre_ua);
        $("#editUAGestion").val(dataEditUA.gestion_ua);
        $("#editUAFacultad").empty();
        $("#editUAFacultad").append("<option value="+dataEditUA.nombre_facultad.replace(/ /g, "")+" selected disabled>"+dataEditUA.nombre_facultad+"</option>");
        $("#editUAFacultad").val(dataEditUA.nombre_facultad.replace(/ /g, ""));
        $("#editUAEstado").val(String(dataEditUA.activo_ua));
        listaDeUsuariosUA(dataEditUA.id_uni_admin);
    });

    $("#tablaUnidadAdministrativa tbody").on('click','button.bajaUA',function () {
        let dataBajaUA = tablaUnidadAdministrativa.row( $(this).parents('tr') ).data();
        // console.log(dataBajaUA);
        $("#bajaUA").val(dataBajaUA.id_uni_admin);
        //console.log(dataEditDirector);
        $('#bajaUANombre').html(dataBajaUA.nombre_ua);
    });

    $("#formEditUnidadAcademica").submit(function (e) { 
        e.preventDefault();
        let idUA = $("#editUAID").val().trim();
        let nombreUA = $("#editUANombre").val().trim();
        let idFacultad = $("#editUAFacultad").val();
        let gestionUA = $("#editUAGestion").val().trim();
        let activoUA = $("#editUAEstado").val();
        $.ajax({
            type: "POST",
            url: "../controlador/unidadAdministrativa.php",
            data: {metodo: 'actualizarUA',idUA,nombreUA,idFacultad,gestionUA,activoUA},
            success: function (response) {
                console.log(response);
                if(!isNaN(response)){
                    let listaResponsables = $("#editDepatamentoResponsable").val();
                    $.ajax({
                        type: "POST",
                        url: "../controlador/usuario_ua.php",
                        data: {metodo:'actualizarUsuarioUA',listaResponsables,idUA},
                        success: function (res) {
                            $('#formEditUnidadAcademica')[0].reset();
                            console.log(res);
                            $('#myModal2').modal('hide');
                            if(!isNaN(res)){
                                Swal.fire('Exito!!',"Se ha actualizado la unidad Administrativa",'success');
                            }else{
                                Swal.fire('Problemas',res,'danger');
                            }
                            tablaUnidadAdministrativa.ajax.reload();
                        }
                    });
                }else{
                    $('#formEditUnidadAcademica')[0].reset();
                    $('#myModal2').modal('hide');
                    Swal.fire('Problemas',response,'danger');
                }
            }
        });
    });

    $("#formBajaUnidadAcademica").submit(function (e) { 
        $('#myModal3').modal('hide');
        $.ajax({
            type: "POST",
            url: "../controlador/unidadAdministrativa.php",
            data: {metodo:'bajaUA',idUA:$("#bajaUA").val()},
            success: function (response) {
                if(!isNaN(response)){
                    //$('#myModal3').modal('hide');
                    getUnidadesAdministrativa();
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
        $('#myModal').modal('hide');
        let nombre = $("#addDepartamentoNombre").val().trim();
        let idFacultad = $("#addDepatamentoFacultad").val();
        let gestion = $("#addDepatamentoGestion").val().trim();
        let nombreFacultad = $('#addDepatamentoFacultad option:selected').text();
        let listaUsuario = $('#addDepatamentoResponsable').val();
        //alert(listaUsuario);
        //console.log(listaUsuario);
        $.ajax({
            type: "POST",
            url: "../controlador/unidadAdministrativa.php",
            data: {metodo:"insertarUnidadAdministrativa",nombreUA: nombre, idFacultadUA: idFacultad, gestionUA: gestion},
            success: function (response) {
                //console.log(response);
                tablaUnidadAdministrativa.ajax.reload();
                if(!isNaN(response)){
                    $.ajax({
                        type: "POST",
                        url: "../controlador/usuario_ua.php",
                        data: {metodo:"insertarUsuarioUA", listaUsuario, idUA: parseInt(response)},
                        success: function (res) {
                            console.log(res);
                            if(!isNaN(res)){
                                //getUnidadesAdministrativa();
                                //$('#myModal').modal('hide');
                                //tablaUnidadAdministrativa.row.add({"nombre_ua":nombre,"gestion_ua":gestion,"nombre_facultad":nombreFacultad,'activo_ua':'true'}).draw();
                                //tablaUnidadAdministrativa.ajax.reload();
                                Swal.fire('¡Exito!','Se ha agregado la unidad administrattiva '+nombre,'success');
                                actualizarFacultades();
                                $('#formAddUnidadAcademica')[0].reset();
                            }else{
                                Swal.fire('Problemas',res,'danger');
//                      $('#myModal').modal('hide');  
                            }
                            
                        }
                    });
                } 
            },
            error: function (){
                console.log("Error");
            }
        });
    });
});

function actualizarFacultades(){
    $.ajax({
        type: "POST",
        url: "../controlador/facultad.php",
        data: {metodo:"getFacultadeSelect"},
        success: function (response) {
            console.log(JSON.parse(response));
            let listaFacultades = JSON.parse(response);
            //$("#addDepatamentoFacultad").append("<option value='null'>Ninguno</option>");
            $("#addDepatamentoFacultad").empty();
            //$("#editUAFacultad").empty();
            listaFacultades.forEach(element => {
                $("#addDepatamentoFacultad").append("<option value="+element.id_facultad+">"+element.nombre_facultad+"</option>");
                //$("#editUAFacultad").append("<option value="+element.id_facultad+">"+element.nombre_facultad+"</option>");
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
          data: { metodo: "getUnidadAdministrativa" },
          url: "../controlador/unidadAdministrativa.php",
        },
        columns: [
          { data: "nombre_ua", width: "25%" },
          { data: "gestion_ua", width: "15%" },
          { data: "nombre_facultad", width: "30%" },
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
          },
        ],
    });
}

function actualizarUsuariosAdministrativos(){
    $.ajax({
        type: "POST",
        url: "../controlador/usuario.php",
        data: {metodo:"getUsuariosAdministrativos"},
        success: function (response) {
            console.log(JSON.parse(response));
            let listaUsuarios = JSON.parse(response);
            //$("#addDepatamentoFacultad").append("<option value='null'>Ninguno</option>");
            $("#addDepatamentoResponsable").empty();
            $("#editDepatamentoResponsable").empty();
            listaUsuarios.forEach(element => {
                $("#addDepatamentoResponsable").append("<option value="+element.id_usuario+">"+element.nombre+"</option>");
                $("#editDepatamentoResponsable").append("<option value="+element.id_usuario+">"+element.nombre+"</option>");
            });
            tail.select('#editDepatamentoResponsable',{
                locale: "es",
                search: true,
                multiLimit: 5,
                hideSelect: true,
                hideDisabled: true,
                multiContainer: '.move-container2'
            });

            selectEditUA = tail.select('#addDepatamentoResponsable',{
                locale: "es",
                search: true,
                multiLimit: 5,
                hideSelect: true,
                hideDisabled: true,
                multiContainer: '.move-container'
            });

            // $("#editDepatamentoResponsable").empty();
            // listaUsuarios.forEach(element => {
            //     $("#editDepatamentoResponsable").append("<option value="+element.id_usuario+">"+element.nombre+"</option>");
            // });
            // tail.select('#editDepatamentoResponsable',{
            //     locale: "es",
            //     search: true,
            //     multiLimit: 5,
            //     hideSelect: true,
            //     hideDisabled: true,
            //     multiContainer: '.move-container2'
            // });
        },
        error: function (){
            console.log("Error");
        }
    });
}

function listaDeUsuariosUA(idUsuarioUA){
    console.log(idUsuarioUA);
    $.ajax({
        type: "POST",
        url: "../controlador/usuario_ua.php",
        data: {metodo:"listaUsuariosUA",idUA:idUsuarioUA},
        success: function (response) {
            let listaUsuarios = JSON.parse(response);
            //console.log(listaUsuarios);
            listaUsuarios.forEach(element => {
                //$("#editDepatamentoResponsable ul li[data-key="+element.id_usuario+"]").attr('selected','true'); 
                //console.log(selectEditUA);
  //              console.log(element.id_usuario);
                //selectEditUA.options.handle("select", element.id_usuario, '#');
                $("#listaResponsablesAnt").empty();
                $("#listaResponsablesAnt").append('<li>'+element.nombre+'</li>');
            });
            
        },
        error: function (){
            console.log("Error");
        }
    });
}