<div class="clearfix  center menu-ctrz col-lg-12">

    <a class="<?php
        if(1 === $menu_procesos[0]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[0]){
                echo 'btn btn-success';
            } else {
                echo 'btn btn-warning';
            }
        }?>">
        <i class="<?php
            if(1 === $menu_procesos[0]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[0]){
                    echo 'ace-icon fa fa-refresh bigger-110';
                } else {
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }?>">
        </i> Denuncia 
    </a>

    <a class="<?php
        if(1 === $menu_procesos[1]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[1]){
                echo 'btn btn-success';
            } else {
                echo 'btn btn-warning';
            }
        }?>">
        <i class="<?php
            if(1 === $menu_procesos[1]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[1]){
                    echo 'ace-icon fa fa-clock-o bigger-110';
                } else {
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }
        ?>">
        </i> Apertura 
    </a>

    <a class="<?php
        if(1 === $menu_procesos[2]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[2]){
                echo 'btn btn-success';
            }else{
                echo 'btn btn-warning';
            }
        }?>">
        <i class="<?php
            if(1 === $menu_procesos[2]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[2]){
                    echo 'ace-icon fa fa-refresh bigger-110';
                }else{
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }
        ?>">
        </i> Formulación de cargo 
    </a>

    <a class="<?php
        if(1 === $menu_procesos[3]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[3]){
                echo 'btn btn-success';
            } else {
                echo 'btn btn-warning';
            }
        }?>">
        <i class="<?php
            if(1 === $menu_procesos[3]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[3]){
                    echo 'ace-icon fa fa-refresh bigger-110';
                } else {
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }
        ?>">        
        </i> Dictamen
    </a>
    
    <a class="<?php
        if(1 === $menu_procesos[4]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[4]){
                echo 'btn btn-success';
            } else {
                echo 'btn btn-warning';
            }
        }
        ?>">
        <i class="<?php
            if(1 === $menu_procesos[4]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[4]){
                    echo 'ace-icon fa fa-refresh bigger-110';
                } else {
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }
        ?>">
        </i> Impugnación
    </a>

    <a class="<?php
        if(1 === $menu_procesos[5]){
            echo 'btn btn-info';
        } else {
            if(2 === $menu_procesos[5]){
                echo 'btn btn-success';
            } else {
                echo 'btn btn-warning';
            }
        }
        ?>">
        <i class="<?php
            if(1 === $menu_procesos[5]){
                echo 'ace-icon fa fa-check bigger-110';
            } else {
                if(2 === $menu_procesos[5]){
                    echo 'ace-icon fa fa-refresh bigger-110';
                } else {
                    echo 'ace-icon fa fa-pause bigger-110';
                }
            }
        ?>">
        </i> Resolución
    </a>
</div>