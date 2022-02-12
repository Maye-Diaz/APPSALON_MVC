<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php'; // Es para el admin
?>

<div id="app">
        <nav class="tabs">
            <button class="actual" type="button" data-paso="1">Servicios</button>  <!--Mapea los pasos el 1,2 0 3  según donde vaya dando clic -->
            <button type="button" data-paso="2">Información Cita</button>
            <button type="button" data-paso="3">Resumen</button>
        </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div> <!-- Se queda vacio porque con JavaScrip se consusulta en la base de datos se exporta a jason-->
    </div>
    <div id="paso-2" class="seccion">
            <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">  
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input
                    id="nombre"
                    type="text"
                    placeholder="Tu Nombre"
                    value="<?php echo $nombre; ?>"
                    disabled 
                /> 
            </div> 

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input
                    id="fecha"
                    type="date"
                    min="<?php echo date('Y-m-d', strtotime('+1 day') ); ?>"
                />
            </div>
            
            <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time"
                />
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>"> <!--hidden quiere decir que esta oculto no se puede ver, solomante se ve si se inspecciona el código-->

        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button 
            id="anterior"
            class="boton"
        >&laquo; Anterior</button> <!-- &laquo es una entidad lo que hace es que añade las flechas en el boton hacia atrás -->

        <button 
            id="siguiente"
            class="boton"
        >Siguiente &raquo;</button> <!-- &raquo; es una entidad lo que hace es colocar las flechas en el botón hacia adelante -->
    </div>
</div>

<?php 
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script> 
    ";
?>