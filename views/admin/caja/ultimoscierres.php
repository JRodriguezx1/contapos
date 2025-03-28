<div class="box">
    <a class="btn-xs btn-dark" href="/admin/caja">Atras</a>
    <h4 class="text-gray-600 mb-12 mt-4">Ultimos cierres</h4>

    <div class="">
        <table class="display responsive nowrap tabla" width="100%" id="">
            <thead>
                <tr>
                    <th>N. Cierre</th>
                    <th>Caja</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Total Ventas</th>
                    <th>Usuario</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ultimoscierres as $index => $value): ?>
                <tr> 
                    <td class=""><?php echo $index+1;?></td>        
                    <td class=""><?php echo $value->idcaja??'Caja eliminada';?></td> 
                    <td class="" ><?php echo $value->fechainicio;?></td> 
                    <td class=""><?php echo $value->fechacierre;?></td>
                    <td class="">$<?php echo number_format($value->ingresoventas, "0", ",", ".");?></td>
                    <td class=""><?php echo $value->id_usuario;?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><a class="btn-xs btn-turquoise" href="/admin/caja/detallecierrecaja?id=<?php echo $value->id;?>">Ver</a></div></td>
                </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>