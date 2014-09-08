<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
<?php echo form_open($this->uri->uri_string()); ?>
		<p><?php echo form_label($login_label, $login['id']); ?> <?php echo form_input($login); ?></p>
		<?php echo form_error($login['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$login['name']])?'<div class="alert alert-error">'.$errors[$login['name']].'</div>':''; ?>
		<div class="form-actions"><?php echo form_submit('reset', 'Get a new password', 'class="btn btn-primary"'); ?>
<?php echo form_close(); ?>