<div class="box">
    <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
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
                    <td class=""><?php echo $value->idcaja?$value->nombrecaja:'Caja eliminada';?></td> 
                    <td class="" ><?php echo $value->fechainicio;?></td> 
                    <td class=""><?php echo $value->fechacierre;?></td>
                    <td class="">$<?php echo number_format($value->ingresoventas, "0", ",", ".");?></td>
                    <td class=""><?php echo $value->nombreusuario;?></td>
                    <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><a class="btn-xs btn-turquoise" href="/admin/caja/detallecierrecaja?id=<?php echo $value->id;?>">Ver</a></div></td>
                </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>