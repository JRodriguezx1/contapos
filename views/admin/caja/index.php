<div class="box caja">
  <h4 class="text-gray-600 mb-6 border-b-2 pb-2 border-blue-600">Gestion de caja</h4>
  <div class="flex flex-wrap gap-2 mb-6">
    <a class="btn-xs btn-light" href="/admin/caja/cerrarcaja">Cerrar caja</a>
    <button class="btn-xs btn-light" id="btnGastosingresos">Gastos/ingresos</button>
    <a class="btn-xs btn-light" href="/admin/caja/zetadiario">Zeta diario</a>
    <a class="btn-xs btn-light" href="/admin/caja/ultimoscierres">Ultimos cierres</a>
    <button class="btn-xs btn-dark">Abrir cajon</button>
  </div>
  <h5 class="text-gray-600 mb-3">Lista de facturas</h5>
  <table class="display responsive nowrap tabla" width="100%" id="tablaempleados">
      <thead>
          <tr>
              <th>N.</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Factura</th>
              <th>Estado</th>
              <th>Valor Bruto</th>
              <th>Total</th>
              <th class="accionesth">Acciones</th>
          </tr>
      </thead>
      <tbody>
          <?php //foreach($empleados as $index => $value): ?>
          <tr> 
              <td class="">1<?php //echo $index+1;?></td>        
              <td class="">26 Sep 2024, 03:24 PM<?php //echo $value->nombre.' '.$value->apellido;?></td> 
              <td class="" >Fernando Antonio Gutierrez Lopez<div class="text-center"><img style="width: 40px;" src="/build/img/<?php //echo $value->img;?>" alt=""></div></td> 
              <td class="">POS1254<?php // echo $value->movil;?></td>
              <td class="">No pago<?php // echo $value->email;?></td>
              <td class="">$150.450<?php // echo $value->cedula;?></td>
              <td class="">$161.210<?php // echo $value->perfil==1?'Empleado':($value->perfil==2?'Admin':'Propietario');?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php // echo $value->id;?>">
                      <button class="btn-xs btn-turquoise">Ver</button> <button class="btn-xs btn-blueintense">Facturar</button><button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                  </div>
              </td>
          </tr>

          <tr> 
              <td class="">2<?php //echo $index+1;?></td>        
              <td class="">26 Sep 2024, 04:24 PM<?php //echo $value->nombre.' '.$value->apellido;?></td> 
              <td class="" >Mauricio Andres Gutierrez Jaramillo<div class="text-center"><img style="width: 40px;" src="/build/img/<?php //echo $value->img;?>" alt=""></div></td> 
              <td class="">POS1256<?php // echo $value->movil;?></td>
              <td class="">No pago<?php // echo $value->email;?></td>
              <td class="">$2.150.450<?php // echo $value->cedula;?></td>
              <td class="">$2.161.210<?php // echo $value->perfil==1?'Empleado':($value->perfil==2?'Admin':'Propietario');?></td>
              <td class="accionestd"><div class="acciones-btns" id="<?php // echo $value->id;?>">
                      <button class="btn-xs btn-turquoise">Ver</button> <button class="btn-xs btn-blueintense">Facturar</button><button class="btn-xs btn-light"><i class="fa-solid fa-print"></i></button>
                  </div>
              </td>
          </tr>
          <?php //endforeach; ?>
      </tbody>
  </table>

  <dialog class="midialog-sm p-5" id="gastosIngresos">
    <h4 class="font-semibold text-gray-700 mb-4">Gastos e ingresos</h4>
    <div id="divmsjalerta2"></div>
    <form id="formGastosingresos" class="formulario" action="/admin" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="operacion">Operacion</label>
            <select class="formulario__select" name="operacion" id="operacion" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Ingreso a caja</option>
                <option value="2">Gasto de la caja</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="caja">Caja</label>
            <select class="formulario__select" name="caja" id="caja" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Caja principal</option>
                <option value="2">Caja segundaria</option>
            </select>
        </div>
        <div class="formulario__campo tipodegasto" style="display: none;">
            <label class="formulario__label" for="tipodegasto">Tipo de gasto</label>
            <select class="formulario__select" name="tipodegasto" id="tipodegasto" required>
                <option value="" disabled selected>-Seleccionar-</option>
                <option value="1">Reabastecimiento</option>
                <option value="2">Arriendo o alquiler de espacio</option>
                <option value="3">Marketing y publicidad</option>
                <option value="4">Papeleria</option>
                <option value="5">Mantenimiento y/o reparacion</option>
                <option value="6">Alquiler de equipos</option>
                <option value="7">Servicios publicos</option>
                <option value="8">Insumos de aseo</option>
                <option value="9">Logistica distribucion o transporte</option>
                <option value="10">Otros</option>
            </select>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="dinero">Ingresar dinero</label>
            <div class="formulario__dato">
                <input class="formulario__input" type="number" min="1" placeholder="Ingresa el dinero" id="dinero" name="dinero" value="<?php echo $empleado->movil??'';?>" required>
            </div>
        </div>
        <div class="formulario__campo">
            <label class="formulario__label" for="descripcion">Descripcion: </label>
            <textarea class="formulario__textarea" id="descripcion" name="descripcion" rows="4"></textarea>
        </div>
        
        <div class="text-right">
            <button class="btn-md btn-red" type="button" value="cancelar">cancelar</button>
            <input id="btnEnviargastosingresos" class="btn-md btn-blue" type="submit" value="Aplicar">
        </div>
    </form>
</dialog>

</div>