<?php
$new_password = array(
	'name'	=> 'new_password',
	'id'	=> 'new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_new_password = array(
	'name'	=> 'confirm_new_password',
	'id'	=> 'confirm_new_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size' 	=> 30,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
	<p><?php echo form_label('New Password', $new_password['id']); ?><?php echo form_password($new_password); ?></p>
	<?php echo form_error($new_password['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$new_password['name']])?'<div class="alert alert-error">'.$errors[$new_password['name']].'</div>':''; ?>
	<p><?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?><?php echo form_password($confirm_new_password); ?></p>
	<?php echo form_error($confirm_new_password['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$confirm_new_password['name']])?'<div class="alert alert-error">'.$errors[$confirm_new_password['name']].'</div>':''; ?>
	<div class="form-actions"><?php echo form_submit('change', 'Change Password', 'class="btn btn-primary"'); ?>
<?php echo form_close(); ?>