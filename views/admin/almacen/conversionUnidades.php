<div class="box conversionUnidades !pb-20">
    <a href="/admin/almacen" class="text-white bg-indigo-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-4 text-center inline-flex items-center me-2   ">
        <svg class="w-6 h-6 rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <span class="sr-only">Atrás</span>
    </a>
    <h4 class="text-gray-600 mb-12 mt-12 ">Conversion de unidades</h4>
    
    
    <table id="tablaSubProductos" class="display responsive nowrap tabla" width="100%">
      <thead>
          <tr>
              <th>Nº</th>
              <th>ID</th>
              <th>Nombre</th>
              <th>Unidad base</th>
              <th>Codigo</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php foreach($subproductos as $index => $value): ?>
          <tr> 
              <td class=""><?php echo $index+1;?></td>
              <td class=""><?php echo $value->id;?></td>
              <td class=""><?php echo $value->nombre;?></td>
              <td class=""><?php echo $value->unidadmedida;?></td>
              <td class=""><?php echo $value->sku;?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php echo $value->id;?>" data-unidadmedida="<?php echo $value->unidadmedida;?>">
                <button class="btn-md btn-turquoise editarUnidadMedida" title="Actualizar unidad de medida"><i class="fa-solid fa-pen-to-square"></i></button>
              </td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>


    <dialog id="miDialogoConversionUnidad" class="w-[95%] max-w-xl p-8 rounded-2xl border border-slate-200 bg-white shadow-xl">
        <div class="text-center">
            <div class="w-16 h-16 mx-auto rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                <i class="fa-solid fa-ruler-combined text-indigo-600 text-2xl"></i>
            </div>

            <h4 id="modalConversionUnidad" class="text-4xl font-bold text-slate-700">
                Conversion de unidades de medida
            </h4>

            <p class="text-slate-500 text-xl mt-2">
                Agregue una nueva unidad de medida equivalente.
            </p>
        </div>

        <hr class="my-6 border-slate-200">

        <div id="divmsjalerta1"></div>
        
        
    </dialog><!--fin editar conversion unidad-->
</div>