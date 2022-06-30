<script src="<?= base_url('assets/js/select2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#codigo_centro').select2({
            placeholder: 'Seleccione un centro'
        });
    });
</script>

<script>
    function emailFunction(){ 
        if (document.getElementById('same').checked){ 
            document.getElementById('email').value=document.getElementById('identity').value +'@cmvalparaiso.cl' ; 
        }else{ 
            document.getElementById('email').value=""; 
        } 
    } 
</script> 

<script>
    $('input[class^="grupo-checkbox"]').click(function() {
        var $this = $(this);
        if ($this.is(".grupo-checkbox-1")) {
            if ($(".grupo-checkbox-1:checked").length > 0) {
                $(".grupo-checkbox").prop({ disabled: true, checked: false });
                $(".grupo-checkbox-2").prop({ disabled: true, checked: false });
                $(".grupo-checkbox-3").prop({ disabled: true, checked: false });
                $(".grupo-checkbox-4").prop({ disabled: true, checked: false });
                $(".grupo-checkbox-5").prop({ disabled: true, checked: false });
                $(".grupo-checkbox-extra").prop({ disabled: true, checked: false });
       	    } else {
    	        $(".grupo-checkbox").prop("disabled", false);
                $(".grupo-checkbox-2").prop("disabled", false);
                $(".grupo-checkbox-4").prop("disabled", false);
                $(".grupo-checkbox-5").prop("disabled", false);
                $(".grupo-checkbox-extra").prop("disabled", false);
       	    }
        } else if ($this.is(".grupo-checkbox-2")) {
            if ($(".grupo-checkbox-2:checked").length > 0) {
                $(".grupo-checkbox-3").not($this).prop({ disabled: false, checked: false });
            } else {
                $(".grupo-checkbox-3").not($this).prop({ disabled: true, checked: false });
            }
        } else if ($this.is(".grupo-checkbox-4")){
            if ($this.is(":checked")) {
                $(".grupo-checkbox-4").not($this).prop({ disabled: true, checked: false });
            } else {
                $(".grupo-checkbox-4").prop("disabled", false);
            }
        }
    });
</script>

<script>
    $('[data-rel=popover]').popover({container:'body'});
</script>

<script src='<?= base_url('assets/js/chosen.jquery.min.js') ?>'></script>

<script type="text/javascript">
    jQuery(function($) {
        if(!ace.vars['touch']) {
            $('.chosen-select').chosen({allow_single_deselect:true}); 
      
            $(window).off('resize.chosen').on('resize.chosen', function() {
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            }).trigger('resize.chosen');
            $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                if(event_name != 'sidebar_collapsed') return;
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({'width': $this.parent().width()});
                })
            });
      
            $('#chosen-multiple-style .btn').on('click', function(e){
                var target = $(this).find('input[type=radio]');
                var which = parseInt(target.val());
                if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                else $('#form-field-select-4').removeClass('tag-input-style');
            });
        }
    });
</script>