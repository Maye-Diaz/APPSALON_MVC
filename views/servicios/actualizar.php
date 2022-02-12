<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los valores del formulario</p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form method="POST" class="formulario"> <!-- Para que respete el id en la url -->
    <?php include_once __DIR__ . '/formulario.php'; ?> <!--Se agrega el formulario -->

    <input type="submit" class="boton" value="Actualizar">
</form>    