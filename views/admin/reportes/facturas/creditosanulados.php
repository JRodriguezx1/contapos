<div class="box creditosAnulados">

  <a href="/admin/creditos" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2   ">
    <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
    </svg>
    <span class="sr-only">Atrás</span>
  </a>
  <h4 class="text-gray-600 mb-8 mt-4">Creditos anulados</h4>

  <div class=" overflow-x-auto">   
        <table id="tablaCreditosAnulados" class="display responsive nowrap tabla" width="100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Credito</th>
                    <th>Interes</th>
                    <th>Total Credito</th>
                    <th>Abono total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($creditosAnulados as $index => $value): ?>
                <tr>
                    <td class=""><?php echo $value->ID; ?></td>
                    <td class=""><?php echo $value->fechainicio; ?></td>
                    <td class=""><?php echo $value->idtipofinanciacion==1?'Credito':'Separado'; ?></td>
                    <td class=""><?php echo $value->nombre.' '.$value->apellido; ?></td>         
                    <td class="">$<?php echo number_format($value->capital,'2', ',', '.'); ?></td>
                    <td class="">$<?php echo number_format($value->valorinterestotal,'2', ',', '.'); ?></td>
                    <td class="">$<?php echo number_format($value->montototal,'2', ',', '.'); ?></td>
                    <td class="">$<?php echo number_format($value->montototal-$value->saldopendiente,'2', ',', '.'); ?></td>
                    <td class="">
                                <a class="btn-xs btn-light" href="/admin/creditos/detallecredito?id=<?php echo $value->ID;?>" target="_blank">Abrir</a>
                                <button class="btn-xs <?php echo $value->idestadocreditos==1?'btn-lima':($value->idestadocreditos==2?'Abierto':'btn-red'); ?>">
                                    <?php echo $value->idestadocreditos==1?'Finalizado':($value->idestadocreditos==2?'Abierto':'Anulado'); ?>
                                </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>