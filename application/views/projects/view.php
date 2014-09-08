<style>
.todo {
	cursor: pointer;
}
.todo.waiting {
	list-style-type: circle;
	color: #ff0000;
}
.todo.inprogress {
	list-style-type: square;
	color: #ff9900;
}	
.todo.done {
	list-style-type: disc;
	text-decoration: line-through;
	color: #00cc00;
}
</style>
<h1><?= $project['title'] ?></h1>
<div><?= parse_markdown($project['description']) ?></div>
<script type="text/javascript">
	$(function() {
		$('body').on('click', '.todo.waiting', function(e) {
			var $this = $(this);
			var idx = $this.index('.todo.waiting');
			collect($this.text(), function(data) {
				$.post(app_url + '/projects/toggle_inprogress', { 'project': <?= $project['id'] ?>, 'index': idx }, function() {
					$this.removeClass('waiting').addClass('inprogress');
				});
			});
			e.preventDefault();			
		});

		$('body').on('click', '.todo.inprogress', function(e) {
			var $this = $(this);
			var idx = $this.index('.todo.inprogress');
			$.post(app_url + '/projects/toggle_done', { 'project': <?= $project['id'] ?>, 'index': idx }, function() {
				$this.removeClass('inprogress').addClass('done');
			});
			e.preventDefault();			
		});

		$('body').on('click', '.todo.done', function(e) {
			var $this = $(this);
			var idx = $this.index('.todo.done');
			$.post(app_url + '/projects/toggle_waiting', { 'project': <?= $project['id'] ?>, 'index': idx }, function() {
				$this.removeClass('done').addClass('waiting');
			});
			e.preventDefault();			
		});
	});
</script>