<div class="box detalleinvoice">

    <div class="flex flex-wrap gap-2 mt-4 mb-4 pb-4">
        <button id="btnModalNotaCredito" class="btn-command text-center"><span class="material-symbols-outlined">other_admission</span>Crear nota credito</button>
    </div>


    <dialog id="miDialogoNC" class="midialog-sm p-12">
        <h4 class="font-semibold text-gray-700 mb-4">Generar nota credito</h4>
        <div id="divmsjalertaNC"></div>
        <input id="idfe" type="text" class="hidden" value="<?php echo $idfe;?>">
        <form id="formNC" class="formulario" method="POST">
            <div class="formulario__campo">
                <label class="formulario__label" for="selectSetConsecutivo">Seleccionar consecutivo</label>
                <select id="selectSetConsecutivo" class="formulario__select bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" name="selectSetConsecutivo" required>
                    <option value="" disabled selected>-Seleccionar-</option>
                    <option value="0">Siguiente consecutivo</option>
                    <option value="1">Consecutivo personalizado</option>
                </select>
            </div>
            <div class="formulario__campo habilitaconsecutivo" style="display: none;">
                <label class="formulario__label" for="consecutivoPersonalizado">Consecutivo personalizado</label>
                <input id="consecutivoPersonalizado" class="formulario__input bg-gray-50 border border-gray-300 text-gray-900 !rounded-lg focus:border-indigo-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white h-14 text-xl focus:outline-none focus:ring-1" type="text" placeholder="Digite numero del consecutivo" name="consecutivoPersonalizado" value="" required>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4 !px-6 !w-[136px]" type="button" value="Cancelar">Cancelar</button>
                <input id="btnEnviarNotaCredito" class="btn-md btn-indigo !mb-4 !py-4 px-6 !w-[136px]" type="submit" value="Generar">
            </div>
        </form>
    </dialog><!--fin set pruebas-->

</div>