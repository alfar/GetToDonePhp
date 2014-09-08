<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'class' => 'form-control',
	'type' => 'email',
	'placeholder' => 'Email address',
	'required' => 'required',
	'autofocus' => 'autofocus'
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
	'class' => 'form-control',
	'placeholder' => 'Password',
	'required' => 'required'
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>
<?php echo form_open($this->uri->uri_string()); ?>
<h2 class="form-signin-heading">Please sign in</h2>
<?php echo form_input($login); ?>
<?php echo form_error($login['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$login['name']])?'<div class="alert alert-error">'.$errors[$login['name']].'</div>':''; ?>
<?php echo form_password($password); ?>
<?php echo form_error($password['name'], '<div class="alert alert-error">', '</div>'); ?><?php echo isset($errors[$password['name']])?'<div class="alert alert-error">'.$errors[$password['name']].'</div>':''; ?>
<?php echo form_label(form_checkbox($remember, 'class="checkbox inline"') . ' Remember me', $remember['id']); ?>
<?php echo form_submit('submit', 'Let me in', 'class="btn btn-lg btn-block btn-primary"'); ?>
<?php echo anchor('/auth/forgot_password/', 'Forgot password', 'class="btn btn-link"'); ?> <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('/auth/register/', 'Register', 'class="btn btn-link"'); ?>
<?php echo form_close(); ?>