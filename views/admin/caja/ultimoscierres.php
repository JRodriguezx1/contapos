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
                <?php //foreach($empleados as $index => $value): ?>
                <tr> 
                    <td class="">1<?php //echo $index+1;?></td>        
                    <td class="">Caja Principal<?php //echo $value->nombre.' '.$value->apellido;?></td> 
                    <td class="" >26 Sep 2024, 06:24 AM</td> 
                    <td class="">27 Sep 2024, 03:24 PM<?php // echo $value->movil;?></td>
                    <td class="">$8.985.000<?php // echo $value->email;?></td>
                    <td class="">sami<?php // echo $value->cedula;?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php // echo $value->id;?>"><button class="btn-xs btn-turquoise">Ver</button></div></td>
                </tr>

                <tr> 
                    <td class="">2<?php //echo $index+1;?></td>        
                    <td class="">Caja Principal<?php //echo $value->nombre.' '.$value->apellido;?></td> 
                    <td class="" >29 Sep 2024, 03:24 PM</td> 
                    <td class="">5 Oct 2024, 08:24 PM<?php // echo $value->movil;?></td>
                    <td class="">$18.485.004<?php // echo $value->email;?></td>
                    <td class="">sami<?php // echo $value->cedula;?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php // echo $value->id;?>"><button class="btn-xs btn-turquoise">Ver</button></div></td>
                </tr>
                <?php //endforeach; ?>
            </tbody>
        </table>
    </div>

</div>