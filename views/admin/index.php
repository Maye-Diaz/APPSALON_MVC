<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once __DIR__ . '/../templates/barra.php'; // Es para el admin
?>

<h2>Buscar Citas</h2>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha; ?>"
            />
        </div>
    </form>
</div>

<?php
    if(count($citas) === 0) {
        echo "<h2>No hay Citas en esta fecha</h2>"; //En caso de una fecha seleccionada no haya citas
    }
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
            $idCita = 0; // para definirlo  
            foreach( $citas as $key => $cita )  { // el foreach es especialmente diseñado para un arreglo / Es una comparación

                
                if($idCita !== $cita->id) { // Aqui es para que aperezca la información de la cita una sola vez.
                    $total = 0; // Es muy inportante este total ya que define e imprime el precio correcto
        ?>
        <li> 
                <p>ID: <span><?php echo $cita->id; ?></span></p>
                <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                <p>Email: <span><?php echo $cita->email; ?></span></p>
                <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                    
                <h3>Servicios</h3>
        <?php 
            $idCita = $cita->id; // Siempre va a tener el último id
        } // Fin de If y es la parque que no se repite 
            $total += $cita->precio; // Va a sumar todos los servicios
        ?>
                <p class="servicio"><?php echo $cita->servicio . " " . $cita->precio; ?></p> 
                
                <?php 
                    $actual = $cita->id; // Actual retorna el id de donde nos encontramos
                    $proximo = $citas[$key + 1]->id ?? 0; // proximo es el indice en el arreglo de la base de datos, identifica cual es el último registro la variable inicia en 0

                    if(esUltimo($actual, $proximo)) { ?>
                        <p class="total">Total: <span></span>$ <?php echo $total; ?></p>

                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>
                <?php } 
            }// Fin de Foreach ?> 
        </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>