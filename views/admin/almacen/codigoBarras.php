<div class=" codigoBarras">
    <h4 class="text-gray-600 mb-8 mt-12">Generar codigo de barras</h4>
    <h2 class="text-xl font-semibold mb-4 text-gray-800 pt-6">Seleccionar producto</h2>
      <div class="flex flex-col md:flex-row gap-2">
        <select id="itemCodeBar" name="" class="w-full md:w-2/4" multiple="multiple">
          <?php foreach($productos as $index => $value):
            if($value->visible == 1&&($value->tipoproducto == '0' || ($value->tipoproducto == '1' && $value->tipoproduccion == '1'))): ?>
            <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
          <?php endif; endforeach; ?> 
        </select>
        <input
            id="codigoBarras"
            type="text" 
            class="w-full md:w-1/2 focus:border-indigo-600 h-14 text-xl focus:outline-none focus:ring-1 border rounded-lg p-2.5 bg-gray-50 border-gray-300 text-gray-900"
            placeholder="Codigo de barras"
            value=""
        />
        <input id="unidadmedida" type="text" class="w-full md:w-1/4 focus:border-indigo-600 h-14 text-xl focus:outline-none focus:ring-1 border rounded-lg p-2.5 bg-gray-50 border-gray-300 text-gray-900" value="">
        <button id="btnGenerarCodigoBarras" class="px-4 h-14 py-2 w-full md:w-1/5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Generar</button>
      </div>
</div>