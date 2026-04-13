<dialog id="miDialogoEnviarEmailCliente" class="midialog-xs p-8 rounded-lg shadow-lg">
        <h4 id="modalEnviarEmail" class="font-semibold text-gray-700 mb-4 mt-4">Enviar orden por email</h4>
        <div id="divmsjalertaEnviarEmail"></div>
        <form id="formEnviarEmailCliente" class="formulario" method="POST">
            <h5 class="my-2 text-lg text-gray-500">Enviar detalle de la orden por correo electronico</h5>
            <div class="formulario__campo">
                <div class="formulario__dato focus-within:!border-indigo-600 border border-gray-300 rounded-lg flex items-center h-14 overflow-hidden">
                    <input id="inputEmail" class="formulario__input !border-0" type="email" placeholder="Email"  required>
                </div>
            </div>
            <div class="text-right">
                <button class="btn-md btn-turquoise !py-4  !w-[100px]" type="button" value="Salir">Salir</button>
                <input id="btnEnviarEmailCliente" class="btn-md btn-indigo !py-4  !w-[100px]" type="submit" value="Enviar">
            </div>
        </form>
    </dialog><!--fin enviar email a cliente-->