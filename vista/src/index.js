$(document).ready(function () {
    let URLActual = location.href;
    console.log(URLActual);
    let listaValores = URLActual.split("?");
    if(listaValores.length >=2 ){
        let categoriaUna = listaValores[1].split("=");
        let propiedadUno = categoriaUna[0];
        if(propiedadUno == 'error'){
            console.log(categoriaUna[1]);
            if(categoriaUna[1] == 'autentificacion'){
                Swal.fire('Problema!!!','No se ha encontrado usuario registrado','warning');
            }
        }
    }
});