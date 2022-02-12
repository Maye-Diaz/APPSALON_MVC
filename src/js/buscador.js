document.addEventListener('DOMContentLoaded', function() {
    iniciarApp(); // se registra todo en una función y apartir de ahí se manda a llamar
});

function iniciarApp() {
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha'); // El elemento que se va a escuchar es por input
    fechaInput.addEventListener('input', function(e) { // function(e) Se ejecuta una vez que suceda ese evento
        const fechaSeleccionada = e.target.value; // e.target.value para leer el valor de la fecha

        window.location = `?fecha=${fechaSeleccionada}`; //para validar en el controlador / se reedirecciona al usuario
        //console.log(fechaSeleccionada);
    });
}