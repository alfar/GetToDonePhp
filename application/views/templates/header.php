<!DOCTYPE html>
<html>
	<head>
		<title>GetToDone</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
		<script type="text/javascript" src="<?= base_url() ?>javascript/jquery-1.10.1.js"></script>
		<script type="text/javascript">
			var app_url = '<?= base_url() ?>index.php';
		</script>
		<script type="text/javascript" src="<?= base_url() ?>javascript/collect.js"></script>
	</head>
	<body>
    <div class="container">
			<div class="navbar navbar-default">
	      <div class="container-fluid">
	      	<div class="navbar-header">
	      		<a href="<?= site_url('/') ?>" class="navbar-brand">GetToDone</a>
	      	</div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	          	<li><?= anchor('/tasks/process', 'Process <span class="badge" id="for_processing">' . $for_processing . '</span>') ?></li>
	          	<li><?= anchor('/tasks', 'Do') ?></li>
	          	<li><?= anchor('/projects', 'Projects') ?></li>
	          </ul>
					<?php if ($userid !== FALSE) : ?>
	          <ul class="nav navbar-nav navbar-right">
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $this->session->userdata('name'); ?><b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?= anchor('/users/profile/' . $userid, 'View profile') ?></li>
									<li><?= anchor('/users/edit_profile', 'Edit profile') ?></li>
									<li><?= anchor('/auth/logout', 'Log out'); ?></li>
								</ul>
							</li>
						</ul>							
						<form class="navbar-form navbar-right" role="search">
						  <div class="form-group">
							  <div class="input-group" style="width: 250px;">
							    <input type="text" class="form-control" placeholder="Collect" id="collectInput" />
							    <span class="input-group-btn">
							  		<button type="submit" class="btn btn-default collectSubmit"><i class="glyphicon glyphicon-inbox"></i></button>
							  	</span>
							  </div>
						  </div>
						</form>
					<?php else: ?>
	          <ul class="nav navbar-nav navbar-right">
							<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?= anchor('/auth/login', 'E-mail'); ?></li>
									<li><?= anchor('/auth/session/google', 'Google'); ?></li>
									<li><?= anchor('/auth/session/facebook', 'Facebook'); ?></li>
								</ul>
							</li>
						</ul>
					<?php endif; ?>
	        </div><!--/.nav-collapse -->
				</div>			
			</div>
	<?php if (isset($tabs)): ?>
			<ul class="nav nav-tabs">
			<?php foreach($tabs as $tab): ?>
					<li<?= $tab['active'] ? ' class="active"' : '' ?>><?= anchor($tab['url'], $tab['text']) ?></li>
			<?php endforeach; ?>
			</ul>
	<?php endif; ?>	
	<?php if (isset($submenu)): ?>
			<div class="navbar navbar-default">
	      <div class="container-fluid">
					<div class="nav-collapse">
						<ul class="nav navbar-nav">
						<?php foreach($submenu as $url => $text): ?>
								<li><?= anchor($url, $text) ?></li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
	<?php endif; ?>
			<div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Done!</h4>
			      </div>
			      <div class="modal-body">
			      	<h4 id="finishedTitle"></h4>
			        <p>Do you have anything to collect related to this task?</p>
						  <div class="input-group" style="width: 250px;">
						    <input type="text" class="form-control" placeholder="Collect" id="finishCollectInput" required autofocus />
						    <span class="input-group-btn">
						  		<button type="submit" id="finishCollectButton" class="btn btn-default collectSubmit"><i class="glyphicon glyphicon-inbox"></i></button>
						  	</span>
						  </div>        
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">I'm done</button>
			      </div>
			    </div>
			  </div>
			</div>
		