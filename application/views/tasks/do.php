<div class="row">
	<div class="col-md-3">
		<div class="list-group">
		<?php foreach ($contexts as $context): ?>
			<a href="#" data-id="<?= $context['id'] ?>" class="list-group-item context <?= $context['active'] == 1 ? ' active' : '' ?>"><?= $context['name'] ?></a>
		<?php endforeach; ?>
		</div>
	</div>
	<div class="col-md-9">
		<div class="list-group">
		<?php foreach ($tasks as $task): ?>
			<div data-id="<?= $task['id'] ?>" data-context="<?= $task['contextId'] ?>" class="list-group-item"<?= $task['active'] ? '' : ' style="display: none;"' ?>><?= $task['title'] ?><span class="pull-right"><a href="#" class="doItButton"><i class="glyphicon glyphicon-ok"></i></a> <a href="#" class="reprocessButton"><i class="glyphicon glyphicon-refresh"></i></a> <a href="#" class="deleteButton"><i class="glyphicon glyphicon-remove"></i></a></span></div>
		<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.deleteButton').click(function(e) {
			var $this = $(this);
			$.post(app_url + '/tasks/process_delete', { 'task': $this.parent().parent().data('id') }, function() {
				$this.parent().parent().fadeOut();
			});
			e.preventDefault();			
		});
		$('.doItButton').click(function(e) {
			var $this = $(this);
			$.post(app_url + '/tasks/process_finish', { 'task': $this.parent().parent().data('id') }, function() {
				$this.parent().parent().fadeOut();
			});
			$('body').trigger('taskFinished', $this.parent().parent().text());
			e.preventDefault();
		});
		$('.reprocessButton').click(function(e) {
			var $this = $(this);
			$.post(app_url + '/tasks/reprocess', { 'task': $this.parent().parent().data('id') }, function() {
				$this.parent().parent().fadeOut();
			});			
			e.preventDefault();
		});
		$('.context').click(function(e) {
			var $this = $(this);
			$.post(app_url + '/contexts/toggle', { 'context': $this.data('id') }, function() {			
				$this.toggleClass('active');
				$('div[data-context="' + $this.data('id') + '"]').fadeToggle();
			});
		});
	});
</script>