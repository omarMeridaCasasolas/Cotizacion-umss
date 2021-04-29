$(document).ready(function () {
    consultaFacultades();
});

function consultaFacultades(){
    $.ajax({
        type: "POST",
        url: "../controlador/facultad.php",
        data: {metodo:'getObtenerFAcultades'},
        success: function (response) {
            let listaFAcultades = JSON.parse(response);
            $("#idSelect").empty();
            // listaFAcultades.forEach(element => {
            //     $("#idSelect").append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            // });
        }
    });
}