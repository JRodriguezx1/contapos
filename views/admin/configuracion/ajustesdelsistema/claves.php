<div class="contenido3 accordion_tab_content bg-white p-6 rounded-lg shadow-md w-full space-y-6 mt-6">
    <div class="flex flex-wrap gap-10">
        <p class="text-indigo-600 font-bold">Claves</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 gap-y-10">
        <div>
            <label for="clave_para_eliminar_factura" class="block mb-2 text-xl font-medium text-gray-900 ">
                Clave para eliminar factura
            </label>
            <input 
                type="password" 
                id="clave_para_eliminar_factura" 
                name="clave_para_eliminar_factura" 
                placeholder="Ingrese la clave eliminar factura"
                value="<?php echo $conflocal['clave_para_eliminar_factura']->valor_final;?>"
                class="keyinput bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <div>
            <label for="clave_para_eliminar_un_gasto/base" class="block mb-2 text-xl font-medium text-gray-900 ">
                Clave para eliminar un gasto/base
            </label>
            <input 
                type="password" 
                id="clave_para_eliminar_un_gasto/base" 
                name="clave_para_eliminar_un_gasto/base" 
                placeholder="Ingrese la clave eliminar gasto/base"
                value="<?php echo $conflocal['clave_para_eliminar_un_gasto/base']->valor_final;?>"
                class="keyinput bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <div>
            <label for="clave_para_agregar_descuento" class="block mb-2 text-xl font-medium text-gray-900 ">
                Clave para agregar descuento
            </label>
            <input 
                type="password" 
                id="clave_para_agregar_descuento" 
                name="clave_para_agregar_descuento" 
                placeholder="Ingrese la clave para descuento"
                value="<?php echo $conflocal['clave_para_agregar_descuento']->valor_final;?>"
                class="keyinput bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <div>
            <label for="clave_para_abrir_cajón_monedero" class="block mb-2 text-xl font-medium text-gray-900 ">
                Clave para abrir cajón monedero
            </label>
            <input 
                type="password" 
                id="clave_para_abrir_cajón_monedero" 
                name="clave_para_abrir_cajón_monedero" 
                placeholder="Ingrese la clave abrir cajón"
                value="<?php echo $conflocal['clave_para_abrir_cajón_monedero']->valor_final;?>"
                class="keyinput bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
        <div>
            <label for="clave_para_ajustar_credito" class="block mb-2 text-xl font-medium text-gray-900 ">
                Clave para ajustar credito
            </label>
            <input 
                type="password" 
                id="clave_para_ajustar_credito" 
                name="clave_para_ajustar_credito" 
                placeholder="Ingrese la clave para ajustar credito"
                value="<?php echo $conflocal['clave_para_ajustar_credito']->valor_final;?>"
                class="keyinput bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:border-indigo-600 block w-full p-2.5     h-14 text-xl focus:outline-none focus:ring-1"
            >
        </div>
    </div> 
</div> <!-- fin claves-->