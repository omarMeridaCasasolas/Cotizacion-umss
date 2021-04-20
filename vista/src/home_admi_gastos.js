let tablaUnidadDeGastos, selectEditUG;
$(document).ready(function () {
  mostrarUnidadDeGastos();
  //getUnidadesDeGastos();
  //mostrarInfo();
  mostrarInfo2();

  $("#tablaUnidadDeGastos tbody").on("click", "button.editUG ", function () {
    let dataEditUG = tablaUnidadDeGastos.row($(this).parents("tr")).data();
    //console.log(dataEditUG);
    $("#listaResponsablesAnt").empty();
    listaDeUsuariosUG(dataEditUG.id_unidad_gastos);
    $("#editUGID").val(dataEditUG.id_unidad_gastos);
    $("#editUGNombre").val(dataEditUG.nombre_ug);
    $("#editUGFacultad").empty();
    $("#editUGFacultad").append(
      "<option value=" +
        dataEditUG.nombre_facultad.replace(/ /g, "") +
        " selected disabled>" +
        dataEditUG.nombre_facultad +
        "</option>"
    );
    $("#editUGFacultad").val(dataEditUG.nombre_facultad.replace(/ /g, ""));
    $("#editUGEstado").val(String(dataEditUG.avtivo_ug));
  });

  $("#tablaUnidadDeGastos tbody").on("click", "button.bajaUG", function () {
    let dataBajaUG = tablaUnidadDeGastos.row($(this).parents("tr")).data();
    console.log(dataBajaUG);
    $("#bajaUG").val(dataBajaUG.id_unidad_gastos);
    $("#estadoUGCambio").val(!dataBajaUG.avtivo_ug);
    if (dataBajaUG.avtivo_ug) {
      $("#idTextEstado").html(
        "Desea desactivar la <strong>" +
          dataBajaUG.nombre_ug +
          "</strong>, esto permitira desabilitar las funciones de sus usuarios"
      );
    } else {
      $("#idTextEstado").html(
        "Desea activar la <strong>" +
          dataBajaUG.nombre_ug +
          "</strong>, esto permitira habilitar las funciones de sus usuarios"
      );
    }
    //console.log(dataEditDirector);
    $("#bajaUGNombre").html(dataBajaUG.nombre_ug);
  });

  $("#formEditUnidadAcademica").submit(function (e) {
    e.preventDefault();
    let idUA = $("#editUGID").val().trim();
    let nombreUA = $("#editUGNombre").val().trim();
    let idFacultad = $("#editUGFacultad").val();
    let activoUA = $("#editUGEstado").val();
    $.ajax({
      type: "POST",
      url: "../controlador/unidadAdministrativa.php",
      data: {
        metodo: "actualizarUA",
        idUA,
        nombreUA,
        idFacultad,
        gestionUA,
        activoUA,
      },
      success: function (response) {
        console.log(response);
        if (!isNaN(response)) {
          let listaResponsables = $("#editDepatamentoResponsable").val();
          $.ajax({
            type: "POST",
            url: "../controlador/usuario_ua.php",
            data: { metodo: "actualizarUsuarioUA", listaResponsables, idUA },
            success: function (res) {
              console.log(res);
              $("#myModal2").modal("hide");
              if (!isNaN(res)) {
                Swal.fire(
                  "Exito!!",
                  "Se ha actualizado la unidad Administrativa",
                  "success"
                );
              } else {
                Swal.fire("Problemas", res, "danger");
              }
              tablaUnidadDeGastos.ajax.reload();
            },
          });
        } else {
          $("#myModal2").modal("hide");
          Swal.fire("Problemas", response, "danger");
        }
      },
    });

    $("#formEditUnidadAcademica")[0].reset();
  });

  $("#formBajaUnidadAcademica").submit(function (e) {
    $("#myModal3").modal("hide");
    $.ajax({
      type: "POST",
      url: "../controlador/unidadDeGastos.php",
      data: {
        metodo: "cambioEstadoUG",
        idUG: $("#bajaUG").val(),
        cambioUG: $("#estadoUGCambio").val(),
      },
      success: function (response) {
        if (!isNaN(response)) {
          //$('#myModal3').modal('hide');
          //getUnidadesAdministrativa();
          tablaUnidadDeGastos.ajax.reload();
          actualizarFacultades();
          //Swal.fire('¡Correcto!','Se Dio de baja la unidad, ahora se le puede asignar otra unidad Administrativa'+nombre,'success');
        } else {
          //$('#myModal3').modal('hide');
          //Swal.fire("Problemas", res, "danger");
        }
      },
    });
    e.preventDefault();
  });

  $("#formAddUG").submit(function (e) {
    let nombre = $("#addDepartamentoNombre").val().trim();
    let idFacultad = $("#addDepatamentoFacultad").val();
    let gestion = $("#addDepatamentoGestion").val().trim();
    let nombreFacultad = $("#addDepatamentoFacultad option:selected").text();
    let listaUsuario = $("#addDepatamentoResponsable").val();
    if (listaUsuario.length == 0) {
      $("#spanAddUA").html("Seleccione almenos un usuario!!");
    } else {
      $("#spanAddUA").html("");
      $("#myModal").modal("hide");
      $.ajax({
        type: "POST",
        url: "../controlador/unidadAdministrativa.php",
        data: {
          metodo: "insertarUnidadAdministrativa",
          nombreUA: nombre,
          idFacultadUA: idFacultad,
          gestionUA: gestion,
        },
        success: function (response) {
          //console.log(response);
          tablaUnidadDeGastos.ajax.reload();
          if (!isNaN(response)) {
            $.ajax({
              type: "POST",
              url: "../controlador/usuario_ua.php",
              data: {
                metodo: "insertarUsuarioUA",
                listaUsuario,
                idUA: parseInt(response),
              },
              success: function (res) {
                console.log(res);
                if (!isNaN(res)) {
                  //getUnidadesAdministrativa();
                  //$('#myModal').modal('hide');
                  //tablaUnidadDeGastos.row.add({"nombre_ug":nombre,"gestion_ua":gestion,"nombre_facultad":nombreFacultad,'avtivo_ug':'true'}).draw();
                  //tablaUnidadDeGastos.ajax.reload();
                  Swal.fire(
                    "¡Exito!",
                    "Se ha agregado la unidad administrattiva " + nombre,
                    "success"
                  );
                  actualizarFacultades();
                  $("#formAddUG")[0].reset();
                } else {
                  Swal.fire("Problemas", res, "danger");
                }
              },
            });
          }
        },
        error: function () {
          console.log("Error");
        },
      });
    }
    e.preventDefault();
  });
});

function actualizarFacultades() {
  $.ajax({
    type: "POST",
    url: "../controlador/facultad.php",
    data: { metodo: "getFacultadeSelect" },
    success: function (response) {
      // console.log(JSON.parse(response));
      let listaFacultades = JSON.parse(response);
      //$("#addDepatamentoFacultad").append("<option value='null'>Ninguno</option>");
      $("#addDepatamentoFacultad").empty();
      //$("#editUGFacultad").empty();
      listaFacultades.forEach((element) => {
        $("#addDepatamentoFacultad").append(
          "<option value=" +
            element.id_facultad +
            ">" +
            element.nombre_facultad +
            "</option>"
        );
        //$("#editUGFacultad").append("<option value="+element.id_facultad+">"+element.nombre_facultad+"</option>");
      });
      if ($("#addDepatamentoFacultad option").length == 0) {
        $("#addDepatamentoFacultad").append(
          "<option value=''>No existen facultades disponibles</option>"
        );
      }
    },
    error: function () {
      console.log("Error");
    },
  });
}

// function getUnidadesDeGastos() {
//   $("#tablaUnidadDeGastos").dataTable().fnDestroy();
//   tablaUnidadDeGastos = $("#tablaUnidadDeGastos").DataTable({
//     responsive: true,
//     order: [[3, "asc"]],
//     language: {
//       sProcessing: "Procesando...",
//       sLengthMenu: "Mostrar _MENU_ registros",
//       sZeroRecords: "No se encontraron resultados",
//       sEmptyTable: "Ningún dato disponible en esta tabla",
//       sInfo:
//         "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//       sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
//       sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
//       sInfoPostFix: "",
//       sSearch: "Buscar:",
//       sUrl: "",
//       sInfoThousands: ",",
//       sLoadingRecords: "Cargando...",
//       oPaginate: {
//         sFirst: "Primero",
//         sLast: "Último",
//         sNext: "Siguiente",
//         sPrevious: "Anterior",
//       },
//       oAria: {
//         sSortAscending:
//           ": Activar para ordenar la columna de manera ascendente",
//         sSortDescending:
//           ": Activar para ordenar la columna de manera descendente",
//       },
//       buttons: {
//         copy: "Copiar",
//         colvis: "Visibilidad",
//       },
//     },
//     ajax: {
//       method: "POST",
//       data: { metodo: "mostrarUnidadDeGastos" },
//       url: "../controlador/unidadDeGastos.php",
//     },
//     columns: [
//       { data: "nombre_ug", width: "25%" },
//       {
//         data: "avtivo_ug", // can be null or undefined
//         // "defaultContent": "Sin Asignacion", "width": "15%"},
//         render: function (data) {
//           if (data == true) {
//             return '<h5><span class="badge badge-success">Activo</span></h5>';
//           } else {
//             return '<h5><span class="badge badge-danger">Baja</span></h5>';
//           }
//         },
//         //width: "15%",
//       },
//       {
//         data: null,
//         defaultContent:
//           "<button type='button' class='editUG btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUG btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
//         //width: "15%",
//       },
//     ],
//   });
// }

function actualizarUsuariosAdministrativos() {
  $.ajax({
    type: "POST",
    url: "../controlador/usuario.php",
    data: { metodo: "getUsuariosAdministrativos" },
    success: function (response) {
      // console.log(JSON.parse(response));
      let listaUsuarios = JSON.parse(response);
      //$("#addDepatamentoFacultad").append("<option value='null'>Ninguno</option>");
      $("#addDepatamentoResponsable").empty();
      $("#editDepatamentoResponsable").empty();
      listaUsuarios.forEach((element) => {
        $("#addDepatamentoResponsable").append(
          "<option value=" +
            element.id_usuario +
            ">" +
            element.nombre +
            "</option>"
        );
        $("#editDepatamentoResponsable").append(
          "<option value=" +
            element.id_usuario +
            ">" +
            element.nombre +
            "</option>"
        );
      });
      tail.select("#editDepatamentoResponsable", {
        locale: "es",
        search: true,
        multiLimit: 5,
        hideSelect: true,
        hideDisabled: true,
        multiContainer: ".move-container2",
      });

      selectEditUG = tail.select("#addDepatamentoResponsable", {
        locale: "es",
        search: true,
        multiLimit: 5,
        hideSelect: true,
        hideDisabled: true,
        multiContainer: ".move-container",
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
    error: function () {
      console.log("Error");
    },
  });
}

function listaDeUsuariosUG(idUsuarioUA) {
  console.log(idUsuarioUA);
  $.ajax({
    type: "POST",
    url: "../controlador/usuario_ua.php",
    data: { metodo: "listaUsuariosUA", idUA: idUsuarioUA },
    success: function (response) {
      let listaUsuarios = JSON.parse(response);
      //console.log(listaUsuarios);
      listaUsuarios.forEach((element) => {
        //$("#editDepatamentoResponsable ul li[data-key="+element.id_usuario+"]").attr('selected','true');
        //console.log(selectEditUG);
        //              console.log(element.id_usuario);
        //selectEditUG.options.handle("select", element.id_usuario, '#');
        $("#listaResponsablesAnt").append("<li>" + element.nombre + "</li>");
      });
    },
    error: function () {
      console.log("Error");
    },
  });
}

//let tablaUnidadDeGastos2;
function mostrarUnidadDeGastos() {
  $("#tablaUnidadDeGastos").dataTable().fnDestroy();
  tablaUnidadDeGastos = $("#tablaUnidadDeGastos").DataTable({
    responsive: true,
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
      data: { metodo: "mostrarUnidadDeGastos" },
      url: "../controlador/unidadDeGastos.php",
    },
    columns: [
      { data: "nombre_ug" },
      {
        data: "avtivo_ug", // can be null or undefined
        // "defaultContent": "Sin Asignacion", "width": "15%"},
        render: function (data) {
          if (data == true) {
            return '<h5><span class="badge badge-success">Activo</span></h5>';
          } else {
            return '<h5><span class="badge badge-danger">Baja</span></h5>';
          }
        },
        //width: "15%",
      },
      {
        data: null,
        defaultContent:
          "<button type='button' class='editUG btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='fas fa-edit'></i></button>	<button type='button' class='bajaUG btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-sync'></i></button>",
      },
    ],
  });
  //tablaUnidadDeGastos = $("#tablaUnidadDeGastos").DataTable
  //console.log(tablaUnidadDeGastos);
}

function mostrarInfo() {
  $("#tablaUnidadDeGastos").dataTable().fnDestroy();
  tablaUnidadDeGastos2 = $("#tablaUnidadDeGastos").DataTable;
  //tablaUnidadDeGastos2 = $("#tablaUnidadDeGastos").DataTable
  console.log(tablaUnidadDeGastos2);
}

function mostrarInfo2() {
  $.ajax({
    type: "POST",
    url: "../controlador/unidadDeGastos.php",
    data: { metodo: "mostrarUnidadDeGastos" },
    success: function (response) {
      console.log(JSON.parse(response));
    },
    error: function () {
      console.log("Error");
    },
  });
}
