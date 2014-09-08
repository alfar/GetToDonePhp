<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$displayname = array(
	'name'	=> 'displayname',
	'id'	=> 'displayname',
	'value' => set_value('displayname'),
	'maxlength'	=> 200,
	'size'	=> 30,
	'class' => 'input-block-level',
);
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'input-block-level',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'input-block-level',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'input-block-level',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
	<p><?php echo form_label('Display name', $displayname['id']); ?><?php echo form_input($displayname); ?></p>
	<?php echo form_error($displayname['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$displayname['name']])?'<div class="alert alert-error">'.$errors[$displayname['name']].'</div>':''; ?>
	<p><?php echo form_label('Email Address', $email['id']); ?><?php echo form_input($email); ?></p>
	<?php echo form_error($email['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$email['name']])?'<div class="alert alert-error">'.$errors[$email['name']].'</div>':''; ?>
	<p><?php echo form_label('Password', $password['id']); ?><?php echo form_password($password); ?></p>
	<?php echo form_error($password['name'], '<div class="alert alert-error">', '</div>'); ?>
	<p><?php echo form_label('Confirm Password', $confirm_password['id']); ?><?php echo form_password($confirm_password); ?></p>
	<?php echo form_error($confirm_password['name'], '<div class="alert alert-error">', '</div>'); ?>	
	<div class="form-actions"><?php echo form_submit('register', 'Register', 'class="btn btn-primary"'); ?></div> 
<?php echo form_close(); ?>