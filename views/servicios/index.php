<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>

<ul class="servicios">
    <?php  foreach($servicios as $servicio) {?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></apan> </p>
            <p>Precio: <span>$<?php echo $servicio->precio; ?></apan> </p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo 
                $servicio->id; ?>">Actualizar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>"> <!--type esta oculto el id para poderlo leer en le POST controlador -->
                    
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>
