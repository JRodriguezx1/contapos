<div class="box">
    <a class="btn-xs btn-dark" href="/admin/caja">Atras</a>
    <h4 class="text-gray-600 mb-12 mt-4">Zeta diario</h4>

    <div class="flex gap-4 mb-4">
        <button class="btn-command"><span class="material-symbols-outlined">subject</span>Zeta diario de hoy</button>
        <button class="btn-command"><span class="material-symbols-outlined">calendar_month</span>Zeta diario por fecha</button>
    </div>
    
    <div class="">
        <table class="display responsive nowrap tabla" width="100%" id="tablaempleados">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>N. Cierre</th>
                    <th>Caja</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th class="accionesth">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ultimoscierres as $index => $value): ?>
                    <tr> 
                        <td class=""><?php echo $index+1;?></td>        
                        <td class=""><?php echo $value->id;?></td> 
                        <td class="" ><?php echo $value->nombrecaja;?></td> 
                        <td class="" ><?php echo $value->fechainicio;?></td> 
                        <td class=""><?php echo $value->fechacierre;?></td>
                        <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><a class="btn-xs btn-turquoise" href="/admin/caja/zetadiario?id=<?php echo $value->id;?>">Ver</a></div></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>