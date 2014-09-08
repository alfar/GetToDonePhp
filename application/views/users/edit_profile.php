<h1><img src="<?= $user['image'] ?>" style="vertical-align: top; margin: 5px;" /><?= $user['name'] ?></=?></h1>
<?= validation_errors('<div class="alert alert-error">', '</div>'); ?>
<?= form_open('users/edit_profile'); ?>
	<?= form_fieldset('Edit profile') ?>
		<p><label for="name">Name:</label><?= form_input(array('name' => 'name', 'class' => 'input-block-level'), set_value('name', $user['name'])) ?></p>
		<p><label for="bio">Bio:</label><?= tiny_editor(array('name' => 'bio', 'class' => 'tiny input-block-level'), set_value('bio', $user['bio'])) ?></p>
		<p><input type="submit" name="btnSubmit" value="Save" /></p>
	</fieldset>
</form>
<?= tiny_mce() ?>
