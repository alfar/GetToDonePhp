function collect(task, callback) {
	$.post(app_url + '/tasks/collect', { 'task': task }, function(data) { if (callback) { callback(data); }; $("body").trigger('collected'); });
}

$(function() {
	$(".collectSubmit").click(function (e) {
		var $this = $(this);
		collect($this.parent().prev().val(), function(data) { $this.parent().prev().val(''); });
		e.preventDefault();
		return false;
	});
	
	$('body').on('collected', function(e) {
		var count = parseInt($('#for_processing').text(), 10); 
		count++;
		
		$('#for_processing').text(count);		
	});
	
	$('body').on('processed', function(e) {
		var count = parseInt($('#for_processing').text(), 10); 
		count--;
		
		$('#for_processing').text(count);				
	});
	
	$('#finishCollectInput').keypress(function(e) {
		if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
			$('#finishCollectButton').click();
			e.preventDefault();
		}
	});
	$('body').on('taskFinished', function(e, title) {
		$('#finishedTitle').text(title);
		$('#finishModal').modal();
		$('#finishCollectInput').val(title.trim());
	});
	
	$('#finishModal').on('shown.bs.modal', function(e) {
		$('#finishCollectInput').focus();
	});
});

