<html>
	<head>
		<style rel="stylesheet" type="text/css">
			@media (min-width: 640px){.sm\:col-span-2{grid-column:span 2 / span 2}.sm\:block{display:block}.sm\:grid{display:grid}.sm\:grid-cols-5{grid-template-columns:repeat(5, minmax(0, 1fr))}.sm\:grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.sm\:justify-end{justify-content:flex-end}.sm\:gap-2{gap:0.5rem}.sm\:text-end{text-align:end}}
		</style>
	</head>
	<body style="margin: 0px; line-height: inherit;">
		<div class="min-h-screen flex flex-col" style="display: flex; min-height: 100vh; flex-direction: column;">
			<!-- Contenedor Factura -->
			<div class="flex-1" style="flex: 1 1 0%;">
				<!-- Invoice -->
				<div
					class="max-w-[85rem] px-16 mx-auto my-10"
					style="margin: 2.5rem auto; padding-left: 4rem; padding-right: 4rem;">
					<!-- Grid -->
					<div class="flex justify-between" style="display: flex; justify-content: space-between;">
						<div>
							<div class="grid space-y-3" style="display: grid;">
								<img
									class="w-auto h-24"
									src="https://inliner.kromate.dev/build/img/&lt;?php echo $sucursal-&gt;logo;?&gt;"
									alt="user"
									style="display: block; vertical-align: middle; max-width: 100%; height: 6rem; width: auto;" />
								<dl
									class="flex flex-col gap-y-3 text-sm pt-20"
									style="margin: 0px; display: flex; flex-direction: column; row-gap: 0.75rem; padding-top: 5rem; font-size: 0.875rem; line-height: 1.25rem;">
									<div
										class="font-medium text-gray-800 text-lg leading-normal"
										style="font-size: 1.125rem; line-height: 1.5; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										<span
											class="block font-semibold uppercase"
											style="display: block; font-weight: 600; text-transform: uppercase;">
											Facturado a
										</span>
										<span
											class="not-italic font-normal text-gray-400"
											style="font-weight: 400; font-style: normal; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
											<!--?php echo $cliente--->
											nombre.' '.$cliente-&gt;apellido;?&gt;
										</span>
										<address
											class="not-italic font-normal text-gray-400"
											style="font-weight: 400; font-style: normal; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
											<span class="font-semibold" style="font-weight: 600;">NIT/CC:</span>
											<!--?php echo $cliente--->
											identificacion;?&gt;,
											<br />
											<span
												class="font-semibold uppercase"
												style="font-weight: 600; text-transform: uppercase;">
												Email:
											</span>
											<!--?php echo $cliente--->
											email;?&gt;,
											<br />
											<span
												class="font-semibold uppercase"
												style="font-weight: 600; text-transform: uppercase;">
												Teléfono:
											</span>
											<!--?php echo $cliente--->
											telefono;?&gt;
											<br />
										</address>
									</div>
									<div
										class="font-medium text-gray-800 text-lg leading-normal mt-5"
										style="margin-top: 1.25rem; font-size: 1.125rem; line-height: 1.5; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										<span
											class="block font-semibold uppercase"
											style="display: block; font-weight: 600; text-transform: uppercase;">
											Dirección de entrega
										</span>
										<address
											class="not-italic font-normal text-gray-400"
											style="font-weight: 400; font-style: normal; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
											<!--?php echo $direccion--->
											direccion;?&gt;,
											<br />
											<!--?php echo $direccion--->
											ciudad.' - '.$direccion-&gt;departamento;?&gt;
											<br />
										</address>
									</div>
								</dl>
							</div>
						</div>
						<!-- Col -->

						<div class="text-lg leading-normal" style="font-size: 1.125rem; line-height: 1.5;">
							<div
								class="grid font-medium text-gray-800 text-center text-lg leading-normal"
								style="display: grid; text-align: center; font-size: 1.125rem; line-height: 1.5; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
								<span
									class="block font-semibold text-lg uppercase"
									style="display: block; font-size: 1.125rem; line-height: 1.75rem; font-weight: 600; text-transform: uppercase;">
									<!--?php echo $sucursal--->
									negocio;?&gt;
								</span>
								<address class="not-italic font-light" style="font-weight: 300; font-style: normal;">
									<!--?php echo $sucursal--->
									nombre;?&gt;,
									<br />
									<!--?php echo $sucursal--->
									direccion;?&gt;,
									<br />
									Tel:
									<!--?php echo $sucursal--->
									telefono;?&gt;,
									<br />
									<!--?php echo $sucursal--->
									ciudad.' - '.$sucursal-&gt;departamento;?&gt;,
									<br />
									<!--?php echo $sucursal--->
									email;?&gt;
									<br />
									<!--?php //echo $sucursal--->
									www;?&gt;
									<br />
								</address>
							</div>
						</div>
						<!-- Col -->

						<div>
							<div class="grid space-y-3" style="display: grid;">
								<div class="text-lg leading-normal" style="font-size: 1.125rem; line-height: 1.5;">
									<p
										class="min-w-36 max-w-[200px] text-gray-800 text-lg font-semibold"
										style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; font-weight: 600; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										FACTURA #:
									</p>
									<span
										class="text-gray-500"
										style="--tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity));">
										<!--?php echo $factura--->
										prefijo.''.$factura-&gt;num_orden??'';?&gt;
									</span>
								</div>
								<div class="text-lg leading-normal" style="font-size: 1.125rem; line-height: 1.5;">
									<p
										class="min-w-36 max-w-[200px] text-gray-800 text-lg font-semibold"
										style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; font-weight: 600; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										Vendedor:
									</p>
									<span
										class="text-gray-500"
										style="--tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity));">
										<!--?php echo $vendedor--->
										nombre.' '.($vendedor-&gt;apellido??'');?&gt;
									</span>
								</div>

								<div
									class="flex flex-col gap-x-1 pt-8 text-lg leading-normal"
									style="display: flex; flex-direction: column; column-gap: 0.25rem; padding-top: 2rem; font-size: 1.125rem; line-height: 1.5;">
									<p
										class="font-medium min-w-36 max-w-[200px] text-gray-800"
										style="margin: 0px; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										<span class="uppercase" style="text-transform: uppercase;">
											Fecha y Hora de Factura
										</span>
										<br />
										<span
											class="font-normal text-gray-400"
											style="font-weight: 400; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
											<!--?php echo $factura--->
											fechapago??'';?&gt;
										</span>
									</p>
									<p
										class="font-medium text-gray-800 mt-4"
										style="margin: 1rem 0px 0px; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										<span class="uppercase" style="text-transform: uppercase;">Medio de Pago</span>
										<br />
										<span
											class="font-normal text-gray-400"
											style="font-weight: 400; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
											<!--?php foreach($mediospago as $value): echo $value--->
											mediopago.' '; endforeach; ?&gt;
										</span>
									</p>
								</div>
							</div>
						</div>
						<!-- Col -->
					</div>
					<!-- End Grid -->
					<!--?php if($factura--->
					estado == 'Eliminada'): ?&gt;
					<div>
						<p
							class="block font-semibold uppercase text-center"
							style="margin: 0px; display: block; text-align: center; font-weight: 600; text-transform: uppercase;">
							Factura eliminada.
							<span
								class="font-normal text-gray-400 text-base normal-case"
								style="font-size: 1rem; line-height: 1.5rem; font-weight: 400; text-transform: none; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
								Documento no valido
							</span>
						</p>
					</div>
					<!--?php endif; ?-->
					<!-- Table -->
					<div
						class="mt-6 border border-gray-200 p-4 rounded-lg space-y-4 text-lg leading-normal"
						style="margin-top: 1.5rem; border-radius: 0.5rem; border-width: 1px; --tw-border-opacity: 1; border-color: rgb(229 231 235 / var(--tw-border-opacity)); padding: 1rem; font-size: 1.125rem; line-height: 1.5;">
						<div class="hidden sm:grid sm:grid-cols-5" style="display: none;">
							<div
								class="sm:col-span-2 text-base font-nomal text-gray-400 uppercase"
								style="font-size: 1rem; line-height: 1.5rem; text-transform: uppercase; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
								Item
							</div>
							<div
								class="text-start text-base font-nomal text-gray-400 uppercase"
								style="text-align: start; font-size: 1rem; line-height: 1.5rem; text-transform: uppercase; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
								Cantidad
							</div>
							<div
								class="text-start text-base font-nomal text-gray-400 uppercase"
								style="text-align: start; font-size: 1rem; line-height: 1.5rem; text-transform: uppercase; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
								Vr. Unitario
							</div>
							<div
								class="text-end text-base font-nomal text-gray-400 uppercase"
								style="text-align: end; font-size: 1rem; line-height: 1.5rem; text-transform: uppercase; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
								Vr. Total
							</div>
						</div>
						<div
							class="hidden sm:block border-b border-gray-200"
							style="display: none; border-bottom-width: 1px; --tw-border-opacity: 1; border-color: rgb(229 231 235 / var(--tw-border-opacity));"></div>

						<!--?php foreach($productos as $index=-->
						$value): ?&gt;
						<div
							class="grid grid-cols-3 sm:grid-cols-5 gap-2"
							style="display: grid; grid-template-columns: repeat(3, minmax(0px, 1fr)); gap: 0.5rem;">
							<div class="col-span-full sm:col-span-2" style="grid-column: 1 / -1;">
								<p
									class="text-lg font-medium text-gray-800"
									style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
									<!--?php echo $value--->
									nombreproducto??'';?&gt;
								</p>
							</div>
							<div>
								<p
									class="text-lg text-gray-800"
									style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
									<!--?php echo $value--->
									cantidad??'';?&gt;
								</p>
							</div>
							<div>
								<p
									class="text-lg text-gray-800"
									style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
									<!--?php echo number_format($value--->
									valorunidad??'', '0', ',', '.');?&gt;
								</p>
							</div>
							<div>
								<p
									class="text-lg sm:text-end text-gray-800"
									style="margin: 0px; font-size: 1.125rem; line-height: 1.75rem; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
									$
									<!--?php echo number_format($value--->
									total??'', '0', ',', '.');?&gt;
								</p>
							</div>
						</div>
						<!--?php endforeach; ?-->
					</div>
					<!-- End Table -->

					<!-- Totales -->
					<div class="mt-8 flex sm:justify-end" style="margin-top: 2rem; display: flex;">
						<div class="w-full max-w-2xl sm:text-end space-y-2" style="width: 100%; max-width: 42rem;">
							<div
								class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2"
								style="display: grid; grid-template-columns: repeat(2, minmax(0px, 1fr)); gap: 0.75rem;">
								<dl
									class="grid sm:grid-cols-5 gap-x-3 text-sm"
									style="margin: 0px; display: grid; column-gap: 0.75rem; font-size: 0.875rem; line-height: 1.25rem;">
									<dt
										class="col-span-3 text-gray-400"
										style="grid-column: span 3 / span 3; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
										Subotal:
									</dt>
									<dd
										class="col-span-2 font-medium text-gray-800"
										style="margin: 0px; grid-column: span 2 / span 2; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										$
										<!--?php echo number_format($factura--->
										subtotal??'', '0', ',', '.');?&gt;
									</dd>
								</dl>

								<dl
									class="grid sm:grid-cols-5 gap-x-3 text-sm"
									style="margin: 0px; display: grid; column-gap: 0.75rem; font-size: 0.875rem; line-height: 1.25rem;">
									<dt
										class="col-span-3 text-gray-400"
										style="grid-column: span 3 / span 3; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
										Descuento:
									</dt>
									<dd
										class="col-span-2 font-medium text-gray-800"
										style="margin: 0px; grid-column: span 2 / span 2; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										$
										<!--?php echo number_format($factura--->
										descuento??'', '0', ',', '.');?&gt;
									</dd>
								</dl>

								<dl
									class="grid sm:grid-cols-5 gap-x-3 text-sm"
									style="margin: 0px; display: grid; column-gap: 0.75rem; font-size: 0.875rem; line-height: 1.25rem;">
									<dt
										class="col-span-3 text-gray-400"
										style="grid-column: span 3 / span 3; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
										Impuesto:
									</dt>
									<dd
										class="col-span-2 font-medium text-gray-800"
										style="margin: 0px; grid-column: span 2 / span 2; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										$
										<!--?php echo number_format($factura--->
										valorimpuestototal??'', '0', ',', '.');?&gt;
									</dd>
								</dl>

								<dl
									class="grid sm:grid-cols-5 gap-x-3 text-sm"
									style="margin: 0px; display: grid; column-gap: 0.75rem; font-size: 0.875rem; line-height: 1.25rem;">
									<dt
										class="col-span-3 text-gray-400"
										style="grid-column: span 3 / span 3; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
										Total:
									</dt>
									<dd
										class="col-span-2 font-medium text-gray-800"
										style="margin: 0px; grid-column: span 2 / span 2; font-weight: 500; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
										$
										<!--?php echo number_format($factura--->
										total??'','0', ',', '.');?&gt;
									</dd>
								</dl>
							</div>
						</div>
					</div>
					<!-- End Totales -->

					<!-- Observaciones -->
					<div class="mt-8" style="margin-top: 2rem;">
						<div
							class="border border-gray-200 p-4 rounded-lg space-y-2 text-lg leading-normal"
							style="border-radius: 0.5rem; border-width: 1px; --tw-border-opacity: 1; border-color: rgb(229 231 235 / var(--tw-border-opacity)); padding: 1rem; font-size: 1.125rem; line-height: 1.5;">
							<span
								class="block font-semibold uppercase text-gray-800"
								style="display: block; font-weight: 600; text-transform: uppercase; --tw-text-opacity: 1; color: rgb(31 41 55 / var(--tw-text-opacity));">
								Observaciones
							</span>
							<p
								class="text-gray-500"
								style="margin: 0px; --tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity));">
								<!--?php echo $factura--->
								observaciones ?? 'Ninguna'; ?&gt;
							</p>
						</div>
					</div>
					<!-- End Observaciones -->
				</div>
				<!-- End Invoice -->
			</div>

			<!-- Footer -->
			<footer
				class="border-t border-gray-200 py-5 text-center text-sm text-gray-500 leading-snug"
				style="border-top-width: 1px; --tw-border-opacity: 1; border-color: rgb(229 231 235 / var(--tw-border-opacity)); padding-top: 1.25rem; padding-bottom: 1.25rem; text-align: center; font-size: 0.875rem; line-height: 1.375; --tw-text-opacity: 1; color: rgb(107 114 128 / var(--tw-text-opacity));">
				<p class="mb-1.5" style="margin: 0px;">
					Esta factura es un documento válido generado electrónicamente por
					<span
						class="font-semibold text-gray-700"
						style="font-weight: 600; --tw-text-opacity: 1; color: rgb(55 65 81 / var(--tw-text-opacity));">
						<!--?php echo $sucursal--->
						negocio;?&gt;
					</span>
					- NIT
					<!--?php echo $sucursal--->
					nit;?&gt;.
				</p>
				<p class="mb-1" style="margin: 0px 0px 0.25rem;">Gracias por su compra.</p>
				<p class="mb-1" style="margin: 0px 0px 0.25rem;">
					Contáctanos:
					<a
						href="mailto:correo@empresa.com"
						class="text-indigo-600 hover:underline"
						style="color: rgb(79 70 229 / var(--tw-text-opacity)); text-decoration: inherit; --tw-text-opacity: 1;">
						<!--?php echo $sucursal--->
						email??'';?&gt;
					</a>
					| Tel:
					<!--?php echo $sucursal--->
					telefono??'';?&gt;
				</p>
				<p class="mb-1" style="margin: 0px 0px 0.25rem;">
					Dirección:
					<!--?php echo $sucursal--->
					direccion??'';?&gt;,
					<!--?php echo $sucursal--->
					ciudad??'';?&gt; -
					<!--?php echo $sucursal--->
					departamento??'';?&gt;
				</p>
				<p
					class="mt-3 text-xs text-gray-400"
					style="margin: 0.75rem 0px 0px; font-size: 0.75rem; line-height: 1rem; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
					©
					<!--?php echo date("Y"); ?-->
					<!--?php echo $sucursal--->
					negocio;?&gt;. Todos los derechos reservados.
				</p>
				<p
					class="mt-1 text-xs text-gray-400"
					style="margin: 0.25rem 0px 0px; font-size: 0.75rem; line-height: 1rem; --tw-text-opacity: 1; color: rgb(156 163 175 / var(--tw-text-opacity));">
					Generado con
					<span
						class="text-indigo-500 font-semibold"
						style="font-weight: 600; --tw-text-opacity: 1; color: rgb(99 102 241 / var(--tw-text-opacity));">
						J2 Software POS Multisucursal
					</span>
				</p>
			</footer>
			<!-- End Footer -->
		</div>
	</body>
</html>
