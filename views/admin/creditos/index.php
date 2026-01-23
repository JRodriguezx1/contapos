<div class="box creditos">
  <?php include __DIR__. "/../../templates/alertas.php"; ?>
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de creditos</h4>
  <div class="flex flex-wrap gap-4 mb-6">
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/creditos/separado"><span class="material-symbols-outlined">add_2</span>Crear Separado</a>
    <!--<button class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="btnGastosingresos"><span class="material-symbols-outlined">paid</span>Gastos</br>Ingresos</button>
    <button class="btn-command"><span class="material-symbols-outlined">lock_open</span>Abrir Cajon</button>
    <a class="btn-command !text-white bg-gradient-to-br from-indigo-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" href="/admin/caja/pedidosguardados"><span class="material-symbols-outlined">folder_check_2</span>Cotizaciones</a>
    -->
  </div>
  <div id="divmsjalerta"></div>
  <table class="display responsive nowrap tabla" width="100%" id="tablaCreditos">
    <thead>
        <tr class="text-xl">
            <th>id</th>
            <th>Tipo</th>
            <th>Cliente</th>
            <th>Credito</th>
            <th>Abono Inicial</th>
            <th>Credito Financiado</th>
            <th>Interes</th>
            <th>Total Credito</th>
            <th>Cuota</th>
            <th>Abono total</th>
            <th>Estado</th>
            <th class="accionesth">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($creditos as $value): ?>
            <tr class="text-xl"> 
                <td class=""><?php echo $value->ID; ?></td>
                <td class=""><?php echo $value->idtipofinanciacion==1?'Credito':'Separado'; ?></td>
                <td class=""><?php echo $value->nombre.' '.$value->apellido; ?></td>         
                <td class="">$<?php echo number_format($value->capital,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->abonoinicial,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->capital-$value->abonoinicial,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->valorinterestotal,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->montototal,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->montocuota,'2', ',', '.'); ?></td>
                <td class="">$<?php echo number_format($value->montototal-$value->saldopendiente,'2', ',', '.'); ?></td>
                <td class=""><button class="btn-xs <?php echo $value->idestadocreditos==1?'btn-lima':($value->idestadocreditos==2?'Abierto':'btn-red'); ?>">
                                <?php echo $value->idestadocreditos==1?'Finalizado':($value->idestadocreditos==2?'Abierto':'Anulado'); ?>
                            </button>
                </td>     
                <td class="accionestd">
                    <div class="acciones-btns" id="<?php echo $value->ID;?>">
                        <a class="btn-xs btn-bluedark" href="/admin/creditos/detallecredito?id=<?php echo $value->ID;?>" title="Ver detalle del credito"><i class="fa-solid fa-chart-simple"></i></a>
                        <?php if($value->idtipofinanciacion==2&&$value->idestadocreditos==2): ?>
                        <button class="btn-xs btn-red anularCredito" title="Eliminar el credito"><i class="fa-solid fa-trash-can"></i></button>
                        <?php endif; ?>
                        <span id="<?php echo $value->ID;?>" class="printPOSSeparado material-symbols-outlined cursor-pointer">print</span>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
  </table>

</div>