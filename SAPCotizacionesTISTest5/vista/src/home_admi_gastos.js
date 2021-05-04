let tablaUnidadDeGastos, selectEditUG;
let selectedID_Facultad; //add Julio

let listaNombreUG;

$(document).ready(function () {
  getlistaFacultades(); //add julio
  mostrarUnidadDeGastos();

  //getUnidadesDeGastos();
  //mostrarInfo();
  mostrarInfo2();

  $("#tablaUnidadDeGastos tbody").on("click", "button.editUG", function () {
    let dataEditUG = tablaUnidadDeGastos.row($(this).parents("tr")).data();
    //console.log(dataEditUG);
    $("#listaResponsablesAnt").empty();
    //listaDeUsuariosUG(dataEditUG.id_ug);
    $("#editUGID").val(dataEditUG.id_ug);
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
    $("#editUGEstado").val(String(dataEditUG.estado_ug));
  });

  $("#tablaUnidadDeGastos tbody").on("click", "button.bajaUG", function () {
    let dataBajaUG = tablaUnidadDeGastos.row($(this).parents("tr")).data();
    console.log(dataBajaUG);
    $("#bajaUG").val(dataBajaUG.id_ug);
    $("#estadoUGCambio").val(!dataBajaUG.estado_ug);
    if (dataBajaUG.estado_ug) {
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

  //changed
  $("#formEditUnidadAcademica").submit(function (e) {
    $("#myModal2").modal("hide");
    e.preventDefault();
    let idUG = $("#editUGID").val().trim();
    let nombreUG = $("#editUGNombre").val().trim();
    let idFacultad = $("#editUGFacultad").val();
    let activoUA = $("#editUGEstado").val();
    $.ajax({
      type: "POST",
      url: "../controlador/unidadDeGastos.php",
      data: {
        metodo: "actualizarUG",
        idUG,
        nombreUG,
      },
      success: function (response) {
        if (!isNaN(response)) {
          //$('#myModal3').modal('hide');
          //getUnidadesAdministrativa();
          tablaUnidadDeGastos.ajax.reload();

          //actualizarFacultades();
          //revertir

          //Swal.fire('¡Correcto!','Se Dio de baja la unidad, ahora se le puede asignar otra unidad Administrativa'+nombre,'success');
          //Swal.fire("¡Correcto!");
        } else {
          //$('#myModal3').modal('hide');
          //Swal.fire("Problemas", res, "danger");
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

          //actualizarFacultades();
          //revertir

          //Swal.fire('¡Correcto!','Se Dio de baja la unidad, ahora se le puede asignar otra unidad Administrativa'+nombre,'success');
          //Swal.fire("¡Correcto!");
        } else {
          //$('#myModal3').modal('hide');
          //Swal.fire("Problemas", res, "danger");
        }
      },
    });
    e.preventDefault();
  });

  /** add Julio
   * Evento al seleccionar una Facultad que muestra las unidades de gasto de una facultad
   */
  $("#seleccionarFacultad").change(function () {
    selectedID_Facultad = $(this).children("option:selected").val();

    if (selectedID_Facultad == "0") {
      mostrarUnidadDeGastos();
    } else {
      mostrarUnidadDeGastosPorFacultad(selectedID_Facultad);

      //Selecciona de la lista la facultad elegida al principio
      $("#nuevoUG_seleccionarFacultad")
        .val(selectedID_Facultad)
        .prop("selected", true);
    }
  });

  //
  /** add Julio
   * crear Nueva Unidad de Gastos
   */
  $("#formAddUG").submit(function (e) {
    let idFacultad_ug = $("#nuevoUG_seleccionarFacultad option:selected").val();
    let padre_id_ug = $("#nuevoUG_selecciona_ug_superior").val();
    let nombre_ug = $("#nuevoUG_nombre_ug").val();
    let gestion_ug = $("#nuevoUG_gestion").text().trim();
    let estado_ug = $("#nuevoUG_estado").val();
    console.log(idFacultad_ug);
    console.log(padre_id_ug);
    console.log(nombre_ug);
    console.log(gestion_ug);
    console.log(estado_ug);

    e.preventDefault();

    if (idFacultad_ug == 0) {
      Swal.fire("Debe elegir una facultad!!", "", "warning");
      $("#modal_NuevoUG").modal("hide");
    } else {
      if (listaNombreUG.includes(nombre_ug)) {
        Swal.fire(
          "La Unidad de Gastos ya existe!!",
          "Escribe otro nombre",
          "warning"
        );
        $("#modal_NuevoUG").modal("hide");
      } else {
        $("#modal_NuevoUG").modal("hide");
        $.ajax({
          type: "POST",
          url: "../controlador/unidadDeGastos.php",
          data: {
            metodo: "insertarNuevaUnidadDeGastosEnFacultad",
            idFacultad_ug,
            padre_id_ug,
            nombre_ug,
            gestion_ug,
            estado_ug,
          },
          success: function (response) {
            let myResp = parseInt(response);
            if (!isNaN(myResp)) {
              tablaUnidadDeGastos.ajax.reload();
              $("#formAddUG")[0].reset();
              Swal.fire(
                "Exito!!",
                "Se ha actualizado la unidad Administrativa",
                "success"
              );
              mostrarUnidadDeGastosPorFacultad(idFacultad_ug);
            } else {
              Swal.fire("Problema!!", response, "info");
            }
          },
          error: function (error) {
            console.log(error);
            Swal.fire(
              "Problema!!",
              error.status + " " + error.statusText,
              "info"
            );
          },
        });
      }
    }
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
//         data: "estado_ug", // can be null or undefined
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
    data: { metodo: "listaUsuariosUA", idUG: idUsuarioUA },
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

// Mostrar las Unidades de Gasto
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
        data: "estado_ug", // can be null or undefined
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
    initComplete: function (settings, json) {
      getListaNombreUG();
    },
  });
  //tablaUnidadDeGastos = $("#tablaUnidadDeGastos").DataTable
  //console.log(tablaUnidadDeGastos);
  //getListaNombreUG();
}

/// Mostrar UG por facultad  add Julio
function mostrarUnidadDeGastosPorFacultad(id_Facultad) {
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
      url: "../controlador/unidadDeGastos.php",
      data: { metodo: "mostrarUnidadDeGastosPorFacultad", id_Facultad },
    },
    columns: [
      { data: "nombre_ug" },
      {
        data: "estado_ug", // can be null or undefined
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
  getlistaUG(id_Facultad);
}

/// Fin Mostrar UG por facultad

function mostrarInfo() {
  $("#tablaUnidadDeGastos").dataTable().fnDestroy();
  tablaUnidadDeGastos2 = $("#tablaUnidadDeGastos").DataTable;
  //tablaUnidadDeGastos2 = $("#tablaUnidadDeGastos").DataTable
  //console.log(tablaUnidadDeGastos2);
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

//Funcion add Julio
//Obtener Lista de facultades y añadirlo a lista SeleccioneFacultad de home_admin_gastps.php
function getlistaFacultades() {
  $.ajax({
    type: "POST",
    url: "../controlador/facultad.php",
    data: { metodo: "getListaFacultades" },
    success: function (response) {
      //console.log("Mensaje entro aquí");
      //console.log(response);
      let listaFacultades = JSON.parse(response);
      listaFacultades.forEach((element) => {
        $("#seleccionarFacultad").append(
          "<option value='" +
            element.id_facultad +
            "'>" +
            element.nombre_facultad +
            "</option>"
        );
        $("#nuevoUG_seleccionarFacultad").append(
          "<option value='" +
            element.id_facultad +
            "'>" +
            element.nombre_facultad +
            "</option>"
        );
      });
    },
  });
}

/**add Julio
 * Obtiene la lista de unidades de gastos como path y los asigna en en select ID:#nuevoUG_selecciona_ug_superio al CREAR  UNIDAD de GASTOS
 */
function getlistaUG(id_Facultad) {
  $("#nuevoUG_selecciona_ug_superior").empty();
  $("#nuevoUG_seleccionarFacultad")
    .val(selectedID_Facultad)
    .prop("selected", true);
  $("#nuevoUG_selecciona_ug_superior").append(
    "<option value = 0>Ninguno</option>"
  );
  $.ajax({
    type: "POST",
    url: "../controlador/unidadDeGastos.php",
    data: { metodo: "getListaUnidadDeGastosDeFacultad", id_Facultad },
    success: function (response) {
      console.log("Mensaje entro aquí");
      console.log(response);
      let listaUG_Superior = JSON.parse(response);
      listaUG_Superior.forEach((element) => {
        $("#nuevoUG_selecciona_ug_superior").append(
          "<option value='" +
            element.id_ug +
            "'>" +
            element.path_ug +
            "</option>"
        );
      });
    },
  });
}

//add Julio
function getListaNombreUG() {
  listaNombreUG = new Array();
  let aux = tablaUnidadDeGastos.column(0).data();
  for (let i = 0; i < aux.length; i++) {
    listaNombreUG.push(aux[i]);
  }
}
