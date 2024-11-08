<?php //['error'][] as ['error'] => ['strin1', 'string2'...]
    foreach($alertas as $key => $alerta){ //$key => [error],   $alerta = ['strin1', 'string2'...]
        foreach($alerta as $mensaje){  //   $mensaje = 'string1'.. 'string2'   
            ?>
            <div class="alerta alerta__<?php echo $key ?>"> <!-- echo $key = clase deacuerdo al tipo de alerta si es un error etc -->
                <?php if($key == 'error'):?><p><i class="fa-solid fa-circle-exclamation"></i><?php echo $mensaje;?></p><?php endif;
                if($key == 'exito'):?><p><i class="fa-solid fa-circle-check"></i><?php echo $mensaje;?></p><?php endif; ?>
            </div>

            <?php

        }
}

?>