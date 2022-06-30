<script src="<?= base_url('assets/js/chosen.jquery.min.js') ?>"></script>
<script>
function relocate_home()
{
     location.href = "http://tdcmvalparaiso.cl/codiad/workspace/desarrollo/index.php/DiasLibres/admin";
} 
$(function() {
    $(".chosen-select").chosen(
    		{no_results_text: "No se encontro nada compadre."}
    	);
});
</script>

