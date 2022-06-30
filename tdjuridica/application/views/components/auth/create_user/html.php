<head>
    <link rel="stylesheet" href="<?= base_url('assets/css/chosen.min.css') ?>" />
</head>
<body>
    <h1><?php echo lang('create_user_heading');?></h1>
    <p><?php echo lang('create_user_subheading');?></p>

    <div id="infoMessage"><?php echo $message;?></div>

    <?php echo form_open("auth/create_user");?>

    <div class="row">
        <div class="column">
            <p>
            <?php echo lang('create_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name);?>
            </p>
            <p>
            <?php echo lang('create_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name);?>
            <br>
            </p>
        </div>
        <div class="column">
            <?php
            if($identity_column!=='email') {
                echo '<p>';
                echo lang('create_user_identity_label', 'identity');
                echo '<br />';
                echo form_error('identity');
                echo form_input($identity);
                echo '</p>';
                }
            ?>
            <p>
            <?php echo lang('create_user_email_label', 'email');?> <br />    
            <?php echo form_input($email);?><br>
                <input type="checkbox" id="same" name="same" onchange= "emailFunction()"/>              
                <label for = "same">autogenerar correo</label><br />
            </p>
        </div>
    </div>
    <div class="row">
        <div class="column">      
            <p>
            <?php echo lang('create_user_company_label', 'company');?> <br />
            <?php echo form_input($company);?>
            </p>    
        </div>
        <div class="column">      
            <p>
            <?php echo lang('create_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone);?>
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h3>Asignar centros <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Puede seleccionar más de un centro." >?</span></h3>
            <select multiple="" name="centros[]" class="chosen-select form-control" id="form-field-select-4" data-placeholder="Elegir centros">
                <?php foreach ($centros as $centro):?>
                <?php if($centro['codigo'] != null):?>
                <option value="<?php echo $centro['codigo'];?>">
                <?php echo htmlspecialchars($centro['nombre'],ENT_QUOTES,'UTF-8');?></option>
                <?php endif?>
                <?php endforeach?>
            </select>
        </div>
    </div>
    <div>
        <h3><?php echo lang('edit_user_groups_heading');?></h3>
        <h4>Grupos con permisos de administrador:</h4>
        <?php foreach ($groups as $k => $group):?>
            <?php if($groups[$k]['id'] == 1):?>
                <input class="grupo-checkbox-1" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php 
                	echo htmlspecialchars('Administrador',ENT_QUOTES,'UTF-8');
                ?>
                <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Al activar esta opción, no se podrán agregar más permisos a este usuario." >?</span>
            <?php endif?>
        <?php endforeach?>
        <h4>Grupos con permisos de Buscador Process:</h4>
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 3 || $groups[$k]['id'] == 9 || $groups[$k]['id'] == 10):?>
                <input class="grupo-checkbox-2" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php 
                    if($groups[$k]['id'] == 3){
                        echo htmlspecialchars('Buscador Process (Personal Educación general)',ENT_QUOTES,'UTF-8');
                    }else if($groups[$k]['id'] == 9){
                        echo htmlspecialchars('Buscador Process (Personal Salud general)',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 10){
                        echo htmlspecialchars('Buscador Process (Compras Salud general)',ENT_QUOTES,'UTF-8');
                    }
                ?>
                <br>
            <?php endif?>
        <?php endforeach?>
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 11):?>
                <input disabled="disabled" class="grupo-checkbox-3" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php echo htmlspecialchars('Buscador Process (filtro por centro(s) para el área seleccionada previamente)',ENT_QUOTES,'UTF-8');?>
                <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="esta opción requiere que al menos un filtro de buscador process este activado." >?</span>
                <br>
            <?php endif?>
        <?php endforeach?>
        <h4>Grupos con permisos de Licencias médicas: <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Solo se puede seleccionar un tipo de esta categoría" >?</span></h4> 
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 4 || $groups[$k]['id'] == 8 || $groups[$k]['id'] == 13):?>
                <input class="grupo-checkbox-4" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php 
                    if($groups[$k]['id'] == 4){
                        echo htmlspecialchars('Licencia médica (filtro por centro(s))',ENT_QUOTES,'UTF-8');
                    }else if($groups[$k]['id'] == 8){
                        echo htmlspecialchars('Licencia médica (ingreso y búsqueda general)',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 13){
                        echo htmlspecialchars('Licencia médica (búsqueda general)',ENT_QUOTES,'UTF-8');
                    }
                ?>
                <br>
            <?php endif?>
        <?php endforeach?>
        <h4>Grupo con permiso de salud incompatible con el cargo:</h4>
		<?php foreach ($groups as $k => $group):?>
            <?php if($groups[$k]['id'] == 19):?>
                <input class="grupo-checkbox-extra" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php echo htmlspecialchars('Visualizar personas con salud incompatible con el cargo',ENT_QUOTES,'UTF-8');?>
                <br>
            <?php endif?>
        <?php endforeach?>
        <h4>Grupos con permisos de Días libres:</h4>
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 14):?>
                <input class="grupo-checkbox" checked="checked" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php echo htmlspecialchars('Días libres (Búsqueda general)',ENT_QUOTES,'UTF-8');?>
                <br>
            <?php endif?>
        <?php endforeach?>
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 15 || $groups[$k]['id'] == 16 || $groups[$k]['id'] == 17 || $groups[$k]['id'] == 18):?>
                <input class="grupo-checkbox" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php 
                    if($groups[$k]['id'] == 15){
                        echo htmlspecialchars('Días libres (filtro por centro(s))',ENT_QUOTES,'UTF-8');
                    }else if($groups[$k]['id'] == 16){
                        echo htmlspecialchars('Días libres (Ingreso y búsqueda general)',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 17){
                        echo htmlspecialchars('Días libres (notificar días libres)',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 18){
                        echo htmlspecialchars('Validador de días libres (valida permisos de días libres)',ENT_QUOTES,'UTF-8');
                    }
                ?>
                <br>
            <?php endif?>
        <?php endforeach?>
        <h4>Otros grupos:</h4>
        <?php foreach ($groups as $k => $group):?>
            <?php if ($groups[$k]['id'] == 12 || $groups[$k]['id'] == 6 || $groups[$k]['id'] == 20 || $groups[$k]['id'] == 21 || $groups[$k]['id'] == 22 || $groups[$k]['id'] == 23):?>
                <input class="grupo-checkbox-5" type="checkbox" name="groups[]" value="<?php echo $group['id'];?>">
                <?php 
                    if($groups[$k]['id'] == 12){
                        echo htmlspecialchars('Process Educación: KPI',ENT_QUOTES,'UTF-8');
                    }else if($groups[$k]['id'] == 6){
                        echo htmlspecialchars('Developed',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 20){
                        echo htmlspecialchars('Funcionarios: Perfil basico',ENT_QUOTES,'UTF-8');
                    }else if( $groups[$k]['id'] == 21){
                        echo htmlspecialchars('Pedidos Drogueria',ENT_QUOTES,'UTF-8');
                    }else if ($groups[$k]['id']==22){
                        echo htmlspecialchars('Jurídica Gestión',ENT_QUOTES,'UTF-8');
                    }else if ($groups[$k]['id']==23){
                        echo htmlspecialchars('Jurídica Abogados',ENT_QUOTES,'UTF-8');
                    }
                ?>
                <br>
            <?php endif?>
        <?php endforeach?>
    </div>
    <br>
    <div class="row">
        <div class="column">      
            <p>
            <?php echo lang('create_user_password_label', 'password');?> <br />
            <?php echo form_input($password);?>
            </p>
        </div>
        <div class="column">
            <p>
            <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
            </p>
        </div>
    </div>

    <p><?php echo form_submit('submit', lang('create_user_submit_btn'));?></p>

    <?php echo form_close();?>
</body>