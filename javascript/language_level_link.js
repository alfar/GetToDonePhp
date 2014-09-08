$(function() {
	$('body').on('click', '.language_level_link', function(e) {
		var val = $(this).attr('data-value');
		var $sel = $('<select id="' + $(this).attr('id') + '" class="input-block-level language_level"><option value="1">Tarzan at a party</option><option value="2">Getting to the party</option><option value="3">What happened at the party?</option><option value="4">What if parties were illegal?</option></select>');
		$(this).replaceWith($sel);
		$sel.val(val);
		$sel.focus();
		$sel.select2({dropdownAutoWidth: true, minimumResultsForSearch: -1});
		e.preventDefault();
	}).on('change', '.language_level', function(e) {
			var $sel = $(this);
			var $li = $sel.closest('li');
			$.ajax({
				url: 'update_language',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: {'type': ($(this).closest('div').attr('id') == 'offering' ? 1 : 2), 'language': $(this).attr('id').substr(6), 'level': $(this).val()},
				success: function(data) {
					$sel.select2('destroy');
					$sel.replaceWith($('<a href="#" id="' + $sel.attr('id') + '" data-value="' + $sel.val() + '" class="language_level_link">' + $sel.children(':selected').text() + '</a>'));
					$li.effect('highlight');
				}
			});				
	});
});