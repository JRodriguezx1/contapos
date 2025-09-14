<div class="box">
    <a href="/admin/caja" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 mb-12 mt-4">Zeta diarios</h4>

    <div class="flex gap-4 mb-4">
        <a title="zeta diario de las cajas abiertas" class="btn-command btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/fechazetadiario?id=<?php echo $idultimocierreabierto; ?>"><span class="material-symbols-outlined">subject</span>Zeta diario de hoy</a>
        <a id="zcalendario" href="/admin/caja/fechazetadiario?id=0" class="btn-command text-center"><span class="material-symbols-outlined">calendar_month</span>Zeta diario por fecha</a>
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
                        <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>"><a class="btn-xs btn-turquoise" href="/admin/caja/fechazetadiario?id=<?php echo $value->id;?>">Ver</a></div></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>