
    <div class="max-w-4xl mx-auto text-center">

        <h4 class="font-extrabold leading-9 text-gray-900">Ingresar orden de produccion</h4>

    

        <div class="mt-10 mb-8 text-start">
            <label for="itemAproducir" class="block text-2xl font-medium text-gray-600">Producto/Insumo</label>
            <div class="mt-2 grid grid-cols-1">
                <select id="itemAproducir" name="itemAproducir" autocomplete="itemAproducir-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-2xl text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" multiple="multiple" required>
                    <?php foreach($productos as $value): ?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->nombre;?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg flex flex-wrap gap-4 mb-4 p-8">
            <button class="btn-command"><span class="material-symbols-outlined">assignment_add</span>Ingresar Cantidad</button>
            <button class="btn-command"><span class="material-symbols-outlined">playlist_remove</span>Descontar Cantidad</button>
        </div>

    </div>
    
