<div class="box">
  <a class="btn-xs btn-dark" href="/admin/reportes">Atras</a>
  <h4 class="text-gray-600 mb-8 mt-4">Ventas por transaccion</h4>
  <div class="">
    <button class="btn-xs btn-light">Anual</button>
    <button class="btn-xs btn-light">Mensual</button>
    <button class="btn-xs btn-light">Semanal</button>
    <button class="btn-xs btn-light">Diario</button>
    <input type="text" name="daterange" class="border border-gray-500 rounded-lg text-lg leading-4 px-3 py-1 outline-cyan-500" id="fechapersonalizada" placeholder="Fecha Personalizada" />
  
    <button class="btn-xs btn-light">Hoy</button>
    <button class="btn-xs btn-light">Ayer</button>
    <button class="btn-xs btn-light">Esta semana</button>
    <button class="btn-xs btn-light">Este mes</button>
    <button class="btn-xs btn-light">Mes anterior</button>
    <button class="btn-xs btn-light">Fecha personalizada</button>
  </div>

  <div class="mt-4">
    <p class="text-gray-500 text-xl">Septiembre 2024</p>
    <table class="display responsive nowrap tabla" width="100%" id="tablaempleados">
        <thead>
            <tr>
                <th>Nº</th>
                <th>Fecha</th>
                <th>Total Venta</th>
                <th>Numero de Transacciones</th>
                <th>Promedio por Transacción</th>
                <th>Transacción mas alta</th>
                <th>Transacción mas baja</th>
            </tr>
        </thead>
        <tbody>
            <?php //foreach($empleados as $index => $value): ?>
            <tr> 
                <td class="">1<?php //echo $index+1;?></td>
                <td class="">26 Sep 2024</td>
                <td class="">$11.810.540</td>
                <td class="">45</td>
                <td class="">$700.500<?php //echo $index+1;?></td>
                <td class="">$810.540</td>
                <td class="">$10.540</td>
            </tr>
            <tr> 
                <td class="">2<?php //echo $index+1;?></td>
                <td class="">27 Sep 2024</td>
                <td class="">$10.000.540</td>
                <td class="">23</td>
                <td class="">$141.040<?php //echo $index+1;?></td>
                <td class="">$410.540</td>
                <td class="">$18.540</td>
            </tr>
            <tr> 
                <td class="">3<?php //echo $index+1;?></td>
                <td class="">28 Sep 2024</td>
                <td class="">$1.410.140</td>
                <td class="">78</td>
                <td class="">$110.040<?php //echo $index+1;?></td>
                <td class="">$730.540</td>
                <td class="">$11.540</td>
            </tr>
            <tr> 
                <td class="">4<?php //echo $index+1;?></td>
                <td class="">29 Sep 2024</td>
                <td class="">$21.870.440</td>
                <td class="">65</td>
                <td class="">$740.500<?php //echo $index+1;?></td>
                <td class="">$890.030</td>
                <td class="">$9.617</td>
            </tr>
            <?php //endforeach; ?>
        </tbody>
    </table>
  </div>
</div>