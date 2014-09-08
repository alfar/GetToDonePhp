$(function() {
	$('body').on('click', '.kaizen_state_link', function(e) {
		var val = $(this).attr('data-value');
		var $sel = $('<select id="' + $(this).attr('id') + '" class="input-block-level kaizen_state"><option value="0">New</option><option value="1">Under evaluation</option><option value="2">Accepted</option><option value="3">Rejected</option></select>');
		$(this).replaceWith($sel);
		$sel.val(val);
		$sel.focus();
		$sel.select2({dropdownAutoWidth: true, minimumResultsForSearch: -1});
		e.preventDefault();
	}).on('change', '.kaizen_state', function(e) {
			var $sel = $(this);
			var $tr = $sel.closest('tr');
			$.ajax({
				url: '../update_kaizen',
				method: 'POST',
				dataType: 'json',
				async: true,
				data: {'id': $(this).attr('id').substr(6), 'state': $(this).val()},
				success: function(data) {
					$sel.select2('destroy');
					$sel.replaceWith($('<a href="#" id="' + $sel.attr('id') + '" data-value="' + $sel.val() + '" class="kaizen_state_link">' + $sel.children(':selected').text() + '</a>'));
					$tr.effect('highlight');
				}
			});				
	});
});