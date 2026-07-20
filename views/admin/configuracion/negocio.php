<div class="config-business">
    <div class="config-business__heading">
        <div>
            <p class="config-business__eyebrow">Datos del negocio</p>
            <h2>Informaci&oacute;n del negocio</h2>
            <p>Actualiza la informaci&oacute;n que aparece en facturas, recibos y documentos impresos.</p>
        </div>
        <div class="config-business__logo-preview">
            <?php if(!empty($negocio->logo)): ?>
                <img src="/build/img/<?php echo $negocio->logo; ?>" alt="Logo del negocio">
            <?php else: ?>
                <span class="material-symbols-outlined">storefront</span>
            <?php endif; ?>
        </div>
    </div>

    <form class="formulario config-business-form" action="/admin/configuracion/editarnegocio" enctype="multipart/form-data" method="POST">
        <section class="config-business-card">
            <div class="config-business-card__header">
                <span class="material-symbols-outlined">badge</span>
                <div>
                    <h3>Identificaci&oacute;n</h3>
                    <p>Nombre comercial, sede y datos tributarios.</p>
                </div>
            </div>

            <div class="config-business-grid">
                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="nombreEmpresa">Empresa</label>
                    <input id="nombreEmpresa" class="formulario__input config-business-input" type="text" placeholder="Nombre de la empresa" name="negocio" value="<?php echo $negocio->negocio??''; ?>" required>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="nombreSucursal">Nombre de la sucursal</label>
                    <input id="nombreSucursal" class="formulario__input config-business-input" type="text" placeholder="Nombre de la sucursal" name="nombre" value="<?php echo $negocio->nombre??''; ?>" required>
                </div>

                <div class="formulario__campo config-business-field config-business-field--full">
                    <label class="formulario__label" for="datosencabezados">Datos del RUT</label>
                    <textarea id="datosencabezados" class="formulario__textarea config-business-input config-business-textarea" name="datosencabezados" placeholder="Datos de encabezado de la factura" rows="4"><?php echo $negocio->datosencabezados ?? '';?></textarea>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="nitEmpresa">NIT</label>
                    <input id="nitEmpresa" class="formulario__input config-business-input" type="text" placeholder="NIT del negocio" name="nit" value="<?php echo $negocio->nit ?? '';?>" required>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="host">HOST</label>
                    <input id="host" class="formulario__input config-business-input" type="text" placeholder="Prefijo o subdominio de la cuenta" name="host" value="<?php echo $negocio->host??'';?>">
                </div>
            </div>
        </section>

        <section class="config-business-card">
            <div class="config-business-card__header">
                <span class="material-symbols-outlined">location_on</span>
                <div>
                    <h3>Ubicaci&oacute;n y contacto</h3>
                    <p>Datos de atenci&oacute;n visibles para clientes y reportes.</p>
                </div>
            </div>

            <div class="config-business-grid">
                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="ciudadSucursal">Ciudad</label>
                    <input id="ciudadSucursal" class="formulario__input config-business-input" type="text" placeholder="Ciudad del negocio" name="ciudad" value="<?php echo $negocio->ciudad ?? '';?>" required>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="direccionSucursal">Direcci&oacute;n</label>
                    <input id="direccionSucursal" class="formulario__input config-business-input" type="text" placeholder="Direcci&oacute;n del negocio" name="direccion" value="<?php echo $negocio->direccion ?? '';?>" required>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="telefonoSucursal">Tel&eacute;fono</label>
                    <input id="telefonoSucursal" class="formulario__input config-business-input" type="number" placeholder="Tel&eacute;fono fijo de contacto" name="telefono" value="<?php echo $negocio->telefono ?? '';?>">
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="celularSucursal">Celular</label>
                    <input id="celularSucursal" class="formulario__input config-business-input" type="number" min="3000000000" max="3777777777" placeholder="M&oacute;vil de contacto" name="movil" value="<?php echo $negocio->movil ?? '';?>" required>
                </div>

                <div class="formulario__campo config-business-field config-business-field--full">
                    <label class="formulario__label" for="emailSucursal">Correo electr&oacute;nico</label>
                    <input id="emailSucursal" class="formulario__input config-business-input" type="email" placeholder="Correo electr&oacute;nico" name="email" value="<?php echo $negocio->email ?? '';?>" required>
                </div>
            </div>
        </section>

        <section class="config-business-card">
            <div class="config-business-card__header">
                <span class="material-symbols-outlined">share</span>
                <div>
                    <h3>Presencia digital</h3>
                    <p>Canales sociales, QR alternativo y logo del negocio.</p>
                </div>
            </div>

            <div class="config-business-grid">
                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="QREmpresa">www / QR alternativo</label>
                    <input id="QREmpresa" class="formulario__input config-business-input" type="text" placeholder="Texto o link a imprimir en QR" name="www" value="<?php echo $negocio->www??'';?>">
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="wsNegocio">Whatsapp</label>
                    <div class="config-business-social">
                        <span class="config-business-social__icon config-business-social__icon--whatsapp"><i class="fa-brands fa-whatsapp"></i></span>
                        <input id="wsNegocio" class="config-business-input" type="number" min="3000000000" max="3777777777" name="ws" placeholder="Whatsapp" value="<?php echo $negocio->ws ?? '';?>">
                    </div>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="facebookNegocio">Facebook</label>
                    <div class="config-business-social">
                        <span class="config-business-social__icon config-business-social__icon--facebook"><i class="fa-brands fa-facebook"></i></span>
                        <input id="facebookNegocio" class="config-business-input" type="text" name="facebook" placeholder="Facebook" value="<?php echo $negocio->facebook ?? ''; ?>">
                    </div>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="instagramNegocio">Instagram</label>
                    <div class="config-business-social">
                        <span class="config-business-social__icon config-business-social__icon--instagram"><i class="fa-brands fa-instagram"></i></span>
                        <input id="instagramNegocio" class="config-business-input" type="text" name="instagram" placeholder="Instagram" value="<?php echo $negocio->instagram ?? ''; ?>">
                    </div>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="youtubeNegocio">YouTube</label>
                    <div class="config-business-social">
                        <span class="config-business-social__icon config-business-social__icon--youtube"><i class="fa-brands fa-youtube"></i></span>
                        <input id="youtubeNegocio" class="config-business-input" type="text" name="youtube" placeholder="Youtube" value="<?php echo $negocio->youtube ?? ''; ?>">
                    </div>
                </div>

                <div class="formulario__campo config-business-field">
                    <label class="formulario__label" for="logo">Logo</label>
                    <input id="logo" class="formulario__input config-business-input config-business-file" type="file" accept="image/*" name="logo">
                    <?php if(!empty($negocio->logo)): ?>
                        <small class="config-business-help"><?php echo $negocio->logo;?></small>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <div class="config-business-actions">
            <button class="config-business-submit" type="submit">
                <i class="fa-solid fa-floppy-disk"></i>
                Actualizar
            </button>
        </div>
    </form>
</div>
