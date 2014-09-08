<style>
	.workflow {
		border-collapse: separate;
	}
	.question {
		text-align: center;
		max-width: 110px;
	}
	.goal {
		text-align: center;
	}
	.answer {
		text-align: center;
		font-size: 8pt;
		color: #ccc;
	}
	.answer.up, .answer.down {
		padding: 10px 2px;
	}
	.answer.right {
		padding: 0px 10px;
	}
</style>

			<div class="modal fade" id="doItModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">Do it!</h4>
			      </div>
			      <div class="modal-body">
			      	<h4 id="doItTitle"></h4>
			      	<p>You have 2 minutes!</p>
			      	<h1 id="doItTimer">0:00</h1>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">I give up</button>
			        <button type="button" class="btn btn-primary" data-dismiss="modal" id="doItDoneButton">I'm done</button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal fade" id="createContextModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myModalLabel">New context</h4>
			      </div>
			      <div class="modal-body">
					    <input type="text" class="form-control" placeholder="Context name" id="createContextInput" required autofocus />
					    
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			        <button type="button" class="btn btn-primary" data-dismiss="modal" id="createContextButton">Create</button>
			      </div>
			    </div>
			  </div>
			</div>

<div id="nothing_to_process"<?php if (isset($task['id'])) { echo(' style="display: none;"'); } ?>>
	<h1>You have nothing to process! Congratulations!</h1>
</div>
<div id="processing"<?php if (!isset($task['id'])) { echo(' style="display: none;"'); } ?>>
<h1>What is: <span id="taskTitle"></span>?</h1>

<table class="workflow" border="0" width="100%">
	<tr>
		<td colspan="11"></td>
		<td rowspan="6" class="goal">
			<div class="list-group" style="margin-bottom: 0px;">
				<?php foreach($contexts as $context): ?>
					<a href="#" class="context list-group-item" data-id="<?= $context['id'] ?>"><?= $context['name'] ?></a>
				<?php endforeach; ?>
					<a href="#" class="list-group-item list-group-item-success" id="createContextLink">New context</a>
			</div>
		</td>
	</tr>
	<tr>
		<td class="goal">
			<a href="#" id="somedayButton" class="btn btn-warning">Some day/Maybe</a>
		</td>
		<td rowspan="2"></td>
		<td class="goal">
			<a href="#" id="doItButton" class="btn btn-success">Do it</a>
		</td>
		<td rowspan="2"></td>
		<td class="goal">
			<a href="#" id="delegateButton" class="btn btn-primary">Delegate</a>
		</td>
		<td rowspan="2" colspan="4"></td>
		<td rowspan="2"></td>
	</tr>
	<tr>
		<td class="answer up">Kind of</td>
		<td class="answer up">&lt; 2 min.</td>
		<td class="answer up">No</td>
	</tr>

	<tr>
		<td class="question alert alert-info">Is it actionable?</td>
		<td class="answer right">Yes</td>
		<td class="question alert alert-info">What size is it?</td>
		<td class="answer right">Good</td>
		<td class="question alert alert-info">Are you the best person to do it?</td>
		<td class="answer right">Yes</td>
		<td class="question alert alert-info">Is timing important?</td>
		<td class="answer right">No</td>
		<td class="question alert alert-info">Where can you do it?</td>
		<td class="answer right">Here:</td>
	</tr>
	<tr>
		<td class="answer down">No</td>
		<td></td>
		<td class="answer down">Too big</td>
		<td colspan="3" rowspan="2"></td>
		<td class="answer down">Yes</td>
		<td colspan="2" rowspan="2"></td>
	</tr>

	<tr>
		<td class="goal">
			<a href="#" id="deleteButton" onclick="return confirm(&#39;Are you sure this should go away forever?&#39;);" class="btn btn-danger">Trash</a>
		</td>
		<td></td>
		<td class="goal">
			<a href="#" id="projectButton" class="btn btn-info">Project</a>
		</td>
		<td class="goal">
			<a href="#" id="calendarButton" class="btn btn-primary">Calendar</a>
		</td>
	</tr>
</table>
</div>
<script type="text/javascript">
	var task = null;
	var doItTime = 120;
	var doItInterval = null;
	
	$(function() {
		<?php if (isset($task['id'])): ?>
		setupTask(<?= json_encode($task) ?>);
		<?php else: ?>
		nothingToProcess();
		<?php endif; ?>
		$('.context').click(function(e) {
			$.post(app_url + '/tasks/process_context', { 'task': task.id, 'context': $(this).data('id') }, processTask);		
			e.preventDefault();
		});
		$('body').on('collected', function() {
			if (!task)
			{
				$.get(app_url + '/tasks/process_next', setupTask);
			}
		});
		$('#deleteButton').click(function(e) {
			$.post(app_url + '/tasks/process_delete', { 'task': task.id }, processTask);		
			e.preventDefault();			
		});
		$('#doItButton').click(function(e) {
			doItTime = (new Date()).getTime();
			$('#doItTitle').text($('#taskTitle').text());
			doItInterval = setInterval(function() { var now = (new Date()).getTime(); var diff = Math.floor((now - doItTime) / 1000); $('#doItTimer').text( Math.floor(diff / 60) + ':' + ('0' + (diff % 60)).slice(-2) ); }, 500);
			$('#doItModal').modal();
			e.preventDefault();
		});
		
		$('body').on('hide.bs.modal', function(e) {
			if (doItInterval) clearInterval(doItInterval);
			doItInterval = null;
		});
		$('#doItDoneButton').click(function(e) {
			$.post(app_url + '/tasks/process_finish', { 'task': task.id }, processTask);					
			$('body').trigger('taskFinished', $('#doItTitle').text());
		});
		$('#projectButton').click(function(e) {
			$.post(app_url + '/tasks/process_project', { 'task': task.id }, processTask);		
			e.preventDefault();			
		});
		$('#somedayButton').click(function(e) {
			$.post(app_url + '/tasks/process_someday', { 'task': task.id }, processTask);		
			e.preventDefault();			
		});
		$('#createContextLink').click(function(e) {
			$('#createContextModal').modal();
			e.preventDefault();			
		});
		$('#createContextButton').click(function(e) {
			$.post(app_url + '/tasks/process_new_context', { 'task': task.id, 'name': $('#createContextInput').val() }, processTask);
		});
	});
	
	function processTask(data)
	{
		$('body').trigger('processed');
		setupTask(data);
	}
	
	function setupTask(data)
	{
		if ('title' in data) 
		{
			task = data;
			$('#taskTitle').text(task.title);
			if (!$('#processing').is(':visible')) {
				$('#processing').slideDown();
				$('#nothing_to_process').slideUp();
			}
		}
		else
		{
			task = null;
			nothingToProcess();
		}
	}
	
	function nothingToProcess()
	{
		if ($('#processing').is(':visible')) {
			$('#processing').slideUp();
			$('#nothing_to_process').slideDown();
		}
	}
</script>