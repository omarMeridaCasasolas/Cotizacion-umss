let tablaFacultad, listaNombreFacultades;
$(document).ready(function () {
    getTablaFacultades();
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
                $('#myModal').modal('hide');
                $.ajax({
                    type: "POST",
                    url: "../controlador/facultad.php",
                    data: {metodo:"insertarFacultad",nombre,gestion,sigla,fecha},
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
});

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
          { data: "nombre_facultad", width: "25%" },
          { data: "siglas_facutlad", width: "15%" },
          { data: "fecha_facultad", width: "30%" },
          {
            data: "estado_facultad", // can be null or undefined
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
}