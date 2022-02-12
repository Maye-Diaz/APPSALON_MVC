let paso = 1; // Se crea esta variable
const pasoInicial = 1; // A este paso inicial y final se realiza un calculo de divición 
const pasoFinal = 3; // de ese calculo se saca un promedio que en este caso es el número 3, es un paginador de e páginas

const cita = { // es un objeto de cita global
    id: '', // string vacio
    nombre: '',
    fecha: '',
    hora: '',
    servicios: [] // [] un arreglo
}

document.addEventListener('DOMContentLoaded', function() { // Inicializar el documento
    iniciarApp(); // Se crea esta funcion 
}); 

function iniciarApp() { // se van agregando  en la funcion algunas otras funciones.
    mostrarSeccion(); //Función que Muestra y oculta las secciones - carga automáticamente servicios.
    tabs(); // Cambia la sessión cuando se presionen los tabs
    botonesPaginador(); // Registrar función / Agrega o quita los botones del paginador.
    paginaSiguiente(); //Registrando
    paginaAnterior(); //Registrando 

    consultarAPI(); // Crear una nueva función consulta la API en el backend de PHP.
    
    idCliente();
    nombreCliente(); // Función que añade el nombre del cliente al objeto de cita
    seleccionarFecha(); // Añade la fecha del cliente en el objeto
    seleccionarHora(); // Añade la hora de la cita en el objeto

    mostrarResumen(); // Muestra el resumen de la cita
}

function mostrarSeccion() { // Se esta llamando todo el tiempo

    // Ocultar la sección que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar'); // El punto es solamente cuando es el selector. Este código selecciona la clase mostrar
    if(seccionAnterior) { // Este es una comprovación para que ejecuete la linea de remove.
        seccionAnterior.classList.remove('mostrar'); // Remueve la clase que no esta selecionada es decir la oculta solo muestra la que esytamos selecionando.
    }
    
    //Seleccionar la sección con el paso...
    const pasoSelector = `#paso-${paso}`; // #paso- es de el selector y el ${paso} es la variable inyectada. De esa forma va atraer el selector
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar'); //console.log('Mostrando Sesion...');
    
    // Quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior) { // si existe el tabAnterior, entoces se remove
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab o botón actual
    const tab = document.querySelector(`[data-paso="${paso}"]`); // `` string [] selector atributo, el paso va cambiando según vaya dando click en los tabs.
    tab.classList.add('actual');
}

function tabs() { // Se marca o se manda llamar una sola vez

    // Agrega y cambia la variable de paso según el tab seleccionado
    const botones = document.querySelectorAll('.tabs button'); // querySelectorAll selecciona todas las considencias
    botones.forEach( boton => {
        boton.addEventListener('click', function(e) { // Se ve mucha informacíon en la console del navegador, el target.
            e.preventDefault();
            
            paso = parseInt( e.target.dataset.paso ); // dataset puede acceder a los atributos que estoy creando, parserInt para pasar un entero.
            mostrarSeccion(); // Se manda a llamar

            botonesPaginador(); // Se manda a llamar
        });
    });
}

function botonesPaginador() {

    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1) {
        paginaAnterior.classList.add('ocultar'); // la que se agrego en paginación / oculta el boton de anterior
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');

        mostrarResumen(); // para que  en el tab de abajo aparezca también.
    } else { // Para que en el paso número 2 se muestren ambos botones anterior y siguente, se muestran de forma condicional
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion(); // Es importante es el que cambia de sessión cada vez que doy clic
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function() {

        if(paso <= pasoInicial) return; // No deja pasar menos del 1 es la lógica <=
        paso--; // Es -- menos menos para que vaya en uno en uno

        botonesPaginador(); // Se manda llamar el mostrar o ocultar a los pasos
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function() {

        if(paso >= pasoFinal) return; // No deja pasar menos del 1 es la lógica  >=
        paso++; // Es ++ hacia arriba para que vaya en uno en uno

        botonesPaginador(); // Se manda llamar el mostrar o ocultar a los pasos
    })
}

async function consultarAPI() { // async se ejecuta esa función y pueden arrancar otras funciones, con async nuestra aolicación va a tener un mejor performance.

    try { // intenta realizar ejecutar y si hay algún error entonces ejecuta el catch
        const url = 'http://localhost:3000/api/servicios'; // Se consulta la DB
        const resultado = await fetch(url); // fetch función que permite consumir el servicio url de arriba, el await tiene acceso  al async, TODA LA LÍNEA SE CONSULTA LA API.
        const servicios = await resultado.json();// Obtener resultados como json
        mostrarServicios(servicios);

    } catch (error) { // Se ejecuta e  caso de que en el try haya algún error.
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach( servicio => { // Se itera sobre los array
        const { id, nombre, precio } = servicio; // extrae el valor y crea la variable al mismo tiempo

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio'); // De esa forma se le puede dar stilo con SASS.
        nombreServicio.textContent = nombre;
        
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV'); // Crear el contenedor el div que contenga cada servicio.
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio);
        }
        
        servicioDiv.appendChild(nombreServicio); // div con parrafo 
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv); // Para mostrar en pantalla es decir en citas servicios.
    });
}   

function seleccionarServicio(servicio) {
    const { id } = servicio; // Se estrae
    const { servicios } = cita; // Se estrae el servicio del objeto de cita

    // Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`); // Se agrega una clase

    // Comprobar si un servicio ya fue agregado
    if( servicios.some( agregado => agregado.id === id ) ) { //  servicios.some E irera y verifica sobre todo el arreglo retorna true o false; ES UN PUNTO ZOM.
        // Eliminarlo
        cita.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove('seleccionado'); // Se agrega la clase de seleccionado
    } else {
       // Agregarlo
       cita.servicios = [...servicios, servicio]; // ... quiere decir toma una copia de los servicios
       divServicio.classList.add('seleccionado'); // Se agrega la clase de seleccionado
    }
}

function idCliente() {
    cita.id = document.querySelector('#id').value;
}

function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
    }

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e) {

        const dia = new Date(e.target.value).getUTCDay();
        
        if( [6, 0].includes(dia) ) { // Se controla que día se puede agendar citas
            e.target.value = ''; // no permite asignar esa fecha
            mostrarAlerta('Fines de semana no permitidos', 'error', '.formulario'); // una función
        } else {
            cita.fecha = e.target.value;        
        }
    });
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e) {


        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0]; // split es la forma de separar un string.
        if(hora < 10 || hora > 18) {
            e.target.value = ''; // No agrega la hora seleccionada en el campo correspondiente cuando no es hora valida
            mostrarAlerta('Hora No Válida', 'error', '.formulario');
        } else {
            cita.hora = e.target.value; // lo guarda correctamente
        }
    })
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    // Previene que se generen más de 1 alerta
    const alertaPrevia = document.querySelector('.alerta'); // Para que No cree más de una alerta en caso de dar varias veces click
    if(alertaPrevia) { // alertaPrevia se manda a llamar la función
        alertaPrevia.remove();
    }

    // Scripting para crear la alerta
    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje; // toma el mensaje desde la función que se esta mandando llamar
    alerta.classList.add('alerta'); // clase de alerta
    alerta.classList.add(tipo); // tipo de alerta

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta); 
    
    if(desaparece) {
        // Eliminar la alerta
        setTimeout( () => { // Time de aparecer el error en pantalla de haber seleccionado fecha que no trabajan
            alerta.remove();
        }, 3000); // 3000 segundos
    }
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');
    
    // Limpiar el Contenido de Resumen
    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0 ) {
       mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen',
       false);

       return;
    } 
    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita; // Todo esto se estrae de cita

    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => { //Mostrar los servicios en resumen
        const { id, precio, nombre, } = servicio; //Aplica destruchion
        const contenedorServicio = document.createElement('DIV'); // Cada servicio va en un DIV
        contenedorServicio.classList.add('contenedor-servicio'); // Clase contenedor-servicio para agregar stilo

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre; // //Aplica destruchion

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`; // $$ es para inyectar la variable

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);    
    });

    // Heading para Cita en Resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en español
    const fechaObj = new Date(fecha); // Instanciar la nueva fecha
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date( Date.UTC(year, mes, dia));
    
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' } // Es un objeto weekday: 'long' weeday es día de la semana, long es nombre largo
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES', opciones); // tolocaleDateString me regresa una fecha más formateada en un idioma especifico
    
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora:</span> ${hora} Horas`;

    // Boton para Crear una cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton'); // Para crear la clase
    botonReservar.textContent = 'Reservar Cita'; // text
    botonReservar.onclick = reservarCita; // ejecuta una función cuando lleva onclick no se le puede colocar () los parentixis manda llamar la función.

    resumen.appendChild(nombreCliente); // De esta forma se muestran los datos en resumen
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    resumen.appendChild(botonReservar); // Para que se vea en pantalla
} 

async function reservarCita() {
    
    const { nombre, fecha, hora, servicios, id } = cita; // Estraer objeto en este caso es cita
    const idServicios = servicios.map( servicio => servicio.id ); // diferencia entre map y foreach, foreach solamente itera y el map las coincidencias las coloca en la variable idServicios.
    //console.log(idServicios);
   
    const datos = new FormData();
    
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id); // con append se agregan los datos
    datos.append('servicios', idServicios);
    //console.log([...datos]);

    try {
         // Petición hacia la API
        const url = 'http://localhost:3000/api/citas'
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos // Es el cuerpo de la petición que se va a enviar, la estancia son los datos
        });

        const resultado = await respuesta.json();
        console.log("resultadijson",resultado.resultadocitasservicios1.resultado.resultado);

        if(resultado.resultadocitasservicios1.resultado.resultado) { // .resultado es para que solo aparezca el true en los resultados
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu cita fue creada correctamente',
                button: 'OK' // Propiedad button que se agrega
            }).then( () => { // evita que los usuarios dupliquen las entradas
                setTimeout( () => {
                    window.location.reload(); // reload para recargar la página
                }, 3000); // tres segundos
            })
        }
    }catch (error) { // a prueba de errores
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
          })
    }
   
   
    //console.log([...datos]); // [...datos] lo que hace es que toma una copia y lo formatea.
}