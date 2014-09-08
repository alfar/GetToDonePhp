<div class="list-group">
<?php foreach ($projects as $project): ?>
	<?= anchor('/projects/view/' . $project['id'], $project['title'], 'class="list-group-item context"') ?>
<?php endforeach; ?>
</div>
