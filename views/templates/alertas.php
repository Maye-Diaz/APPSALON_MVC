<?php 
    foreach($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>
    <div class="alerta <?php echo $key; ?>">
        <?php echo $mensaje; ?>     
    </div>
<?php
        endforeach; // para identificar la llave del arreglo y despúes se accede a los mensajes    
    endforeach;    
?>