<div class="box cerrarcaja">
  <a class="btn-xs btn-dark" href="/admin/caja">Atras</a>
  <h4 class="text-gray-600 mb-12 mt-4">Cierre de caja</h4>
  <div class="flex gap-4">
    <div>
      <p class="m-0 text-slate-500 text-xl font-semibold">Caja: </p>
      <p class="m-0 text-slate-500 text-xl font-semibold">Fecha: </p>
      <p class="m-0 text-slate-500 text-xl font-semibold">Cajero: </p>
    </div>
    <div>
      <p class="m-0 text-slate-500 text-xl">Caja principal</p>
      <p class="m-0 text-slate-500 text-xl">28-07-2025 10:04 am</p>
      <p class="m-0 text-slate-500 text-xl">Roberto Francisco Suarez Jaramillo</p>
    </div>
  </div>
  <div class="flex flex-col tlg:flex-row gap-4 mt-4">
    <div class="basis-1/3 border border-gray-300 p-4">
      <div class="formulario__campo">
          <label class="formulario__label" for="nombre">Efectivo en caja</label>
          <div class="formulario__dato">
              <input class="formulario__input" type="text" placeholder="Dinero en caja" id="nombre" name="nombre" value="<?php echo $empleado->nombre??'';?>" required>
              <button class="btn-xs btn-blue" id="btnArqueocaja">Arqueo de caja</button>
          </div>
      </div>
      <div class="formulario__campo">
          <label class="formulario__label" for="apellido">Datafono</label>
          <input class="formulario__input" type="text" placeholder="Dinero en datafono" id="apellido" name="apellido" value="<?php echo $empleado->apellido??'';?>" required>
      </div>
      <div class="formulario__campo">
          <label class="formulario__label" for="movil">Davivienda</label>
          <input class="formulario__input" type="number" min="3000000000" max="3777777777" placeholder="Dinero en Davivienda" id="movil" name="movil" value="<?php echo $empleado->movil??'';?>" required>
      </div>
    </div> <!-- Fin col 1 -->
    <div class="basis-2/3 border-b border-gray-300 p-4 flex items-start gap-8 xxs:gap-20">
        <div class="flex gap-4">
          <div class="text-start">
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Base en caja:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Gastos:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Domicilios:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-semibold">Ventas Total:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Nº Facturas:</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">Cotizaciones:</p>
          </div>
          <div>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$184.500</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$14.500</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">$45.000</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-semibold">$1.172.374</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">19</p>
            <p class="m-0 mb-2 text-slate-600 text-2xl font-normal">7</p>
          </div>
        </div>
        <div class="flex flex-wrap gap-4 max-w-96">
            <button class="btn-command" id="btnCerrarcaja"><span class="material-symbols-outlined">keyboard_lock</span>Cerrar caja</button>
            <button class="btn-command"><span class="material-symbols-outlined">print</span>Imprimir cierre</button>
            <button class="btn-command"><span class="material-symbols-outlined">change_circle</span>Cambiar caja</button>
        </div>
    </div> <!-- Fin col 2 -->
  </div>

  <div class="accordion">
      <input type="checkbox" id="first">
      <label class="text-gray-500" for="first">Resumen</label>
      <div class="wrapper">
          <div class="wrapper-content">
            <div class="content">

                <div class="flex flex-col tlg:flex-row gap-12 mb-8">
                    <div class="tlg:basis-1/2">
                        <table class="tabla2" width="100%" id="">
                            <thead>
                                <tr>
                                    <th>Cuadre de caja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>        
                                    <td class="">Base + ingresos de caja</td> 
                                    <td class="">+ $320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Ventas en efectivo</td> 
                                    <td class="">+ $320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Gastos de la caja</td> 
                                    <td class="">- $4.320.000</td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-400 font-medium">Dinero en caja</td> 
                                    <td class="text-blue-400 font-medium">= $4.320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Domicilios</td> 
                                    <td class="">- $320.000</td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-600 font-medium">Real en caja</td> 
                                    <td class="text-blue-600 font-medium">= $4.320.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tlg:basis-1/2">
                        <table class="tabla2 mb-12" width="100%" id="">
                            <thead>
                                <tr>
                                    <th>Medios de pago</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>        
                                    <td class="">Efectivo</td> 
                                    <td class="">$320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Datafono</td> 
                                    <td class="">$320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Daviplata</td> 
                                    <td class="">$4.320.000</td>
                                </tr>
                            </tbody>
                        </table>

                        
                        <table class="tabla2" width="100%" id="">
                            <thead>
                                <tr>
                                    <th>Datos de venta</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>        
                                    <td class="">Ingreso de ventas</td> 
                                    <td class=""> + $320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Total descuentos</td> 
                                    <td class=""> - $320.000</td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-400 font-medium">Real de ventas</td> 
                                    <td class="text-blue-400 font-medium"> = $4.320.000</td>
                                </tr>
                                <tr>        
                                    <td class="">Impuesto</td> 
                                    <td class=""> - $120.000</td>
                                </tr>
                                <tr>        
                                    <td class="text-blue-600 font-medium">Total bruto</td> 
                                    <td class="text-blue-600 font-medium"> = $3.320.000</td>
                                </tr>
                            </tbody>
                        </table>
                    
                    </div>
                </div>

                <h5 class="text-gray-500 border border-gray-300 px-4 py-3 mb-4">Ventas del dia</h5>
                <!-- Facturas del dia -->
                <table class="display responsive nowrap tabla" width="100%" id="">
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
                
            </div> <!--fin content -->
          </div> <!--fin wrpper-content-->
      </div> <!--fin wrapper -->
      
  </div> <!-- fin accordion-->

  <!-- Ventana Modal Arqueo de caja -->
  <dialog class="midialog-sm p-5" id="modalArqueocaja">
    <h4 class="font-semibold text-gray-700 mb-4">Arqueo de caja</h4>
    <div id="divmsjalerta2"></div>
    <form id="formArqueocaja" class="formulario" action="/admin" method="POST">
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
            <input id="btnAPlicararqueocaja" class="btn-md btn-blue" type="submit" value="Aplicar">
        </div>
    </form>
  </dialog>
  
  <!-- MODAL ventana para cerrar caja-->
  <dialog class="midialog-xs p-5" id="Modalcerrarcaja">
    <div>
        <h4 class="font-semibold text-gray-700 mb-4">Caja principal</h4>
        <p class="text-gray-600">Desea cerrar la caja? Ya no se podra modificar.</p>
    </div>
    <div id="" class="cerrarcaja flex justify-around border-t border-gray-300 pt-4">
        <div class="finCerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-blue-600 font-semibold"><i class="fa-regular fa-pen-to-square"></i><p class="m-0 ml-4">Confirmar</p></div>
        <div class="salircerrarcaja flex cursor-pointer transition-transform duration-300 hover:scale-110 text-red-500 font-semibold"><i class="fa-regular fa-trash-can"></i><p class="m-0 ml-4">Salir</p></div>
    </div>
  </dialog>

  <div> <!-- resumen --><p class="text-gray-500 text-center">Innovatech</p></div> <!-- fin resumen -->

</div>