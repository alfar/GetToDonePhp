<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.whee.dk';
$config['smtp_user'] = 'arne@whee.dk';
$config['smtp_pass'] = 'bogomips';
$config['smtp_port'] = '587';

/* End of file email.php */
/* Location: ./application/config/email.php */