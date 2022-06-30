<h1><?php echo lang('eliminar_heading');?></h1>
<p><?php echo sprintf(lang('eliminar_subheading'), $user->username);?></p>

<?php echo form_open("auth/eliminar_user/".$user->id);?>

  <p>
	<input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo lang('deactivate_confirm_y_label', 'confirm');?>
  </p>
  <p>
    <input type="radio" name="confirm" value="no" />
    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', lang('eliminar_submit_btn'));?></p>

<?php echo form_close();?>