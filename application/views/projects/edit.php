<h1>Edit project</h1>
<?= validation_errors('<div class="alert alert-error">', '</div>'); ?>
<?= form_open('projects/edit/' . $project['id']); ?>
	<p><label for="name">Title:</label><?= form_input(array('name' => 'title', 'class' => 'input-block-level'), set_value('title', $project['title'])) ?></p>
	<p><label for="description">Description:</label><?= form_textarea(array('name' => 'description', 'class' => 'tiny input-block-level'), set_value('description', $project['description'])) ?></p>
	<p><input type="submit" name="btnSubmit" value="Save" /></p>
</form>
