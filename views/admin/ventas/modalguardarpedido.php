<!-- MODAL PARA GUARDAR EL PEDIDO-->
  <dialog id="miDialogoGuardar" class="bg-white rounded-xl shadow-lg p-8 relative z-50">
      <div class="text-center">
          <p class="text-2xl font-semibold text-gray-600 mb-6">Desea guardar el pedido?</p>
          <p class="text-xl text-gray-500">El pedido de venta No: <?php echo $num_orden;?> se guardara en sistema.</p>
      </div>
      <div id="" class="flex justify-around w-full border-t border-gray-300 pt-6">
          <div class="siguardar flex cursor-pointer transition-transform hover:scale-110 text-blue-500 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-1">Si</p></div>
          <div class="noguardar flex cursor-pointer transition-transform hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-1">No</p></div>
      </div>
  </dialog>