/*
 * Victor J. <victor.maximo@mtlc.com.mx>
 * date 18/03/2024
 * update 18/03/2024
 * desc Custom JavaScript
 */

function handlerVerEjemplo(el){
    const img = el.getAttribute("data-img");
    const title = el.getAttribute("data-tile");
    const text = el.getAttribute("data-text");

    Swal.fire({
        title: title,
        text: text,
        imageUrl: img,
        imageWidth: 460,
        imageHeight: 240,
        imageAlt: "Custom image"
    });
}

function fnHandlerFormFields(){
    // get values for each input
    const archivoExcel = $('#archivo-excel')[0].files[0];
    const validarColumnas = $('#validar-columnas').prop('checked');

    // check validate values for `archivo-excel` input
    if(!archivoExcel)
    {
        $('#archivo-excel').addClass('is-invalid');
    } else {
        $('#archivo-excel').removeClass('is-invalid');
        $('#archivo-excel').addClass('is-valid');
    }

    // check validate values for `validar-columnas` input
    if(!validarColumnas)
    {
        $('#validar-columnas').addClass('is-invalid');
    } else {
        $('#validar-columnas').removeClass('is-invalid');
        $('#validar-columnas').addClass('is-valid');
    }

    if(archivoExcel){
        if (!archivoExcel.type.toLowerCase().includes('sheet') ||
            !archivoExcel.name.toLowerCase().endsWith('.xlsx') &&
            !archivoExcel.name.toLowerCase().endsWith('.xls') )
        {
            $('#archivo-excel').removeClass('is-valid');
            $('#archivo-excel').addClass('is-invalid');
            return false;
        }
    }

    return (!validarColumnas || !archivoExcel) ? false : true;
}
