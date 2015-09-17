(function($) {
	var command = [];
	command.push({'command':[74, 65, 89, 65], 'callback':function() { $('#build_button').show(); }});
	command.push({'command':[70, 85, 67, 75], 'callback':function() { window.top.location.href = '/admin/logout.html'; }});
	
	var stack = [];
	var cleanTimer = null;
	$(window).keydown(function(e) {
		var e = e || window.event;
		stack.push(e.keyCode);
		clearTimeout(cleanTimer);
		cleanTimer = setTimeout(function() { stack = []; }, 600);
		bootstrapCommand(stack);
	});
	
	function bootstrapCommand(stack) {
		for (var i in command) {
			if (command[i].command.toString() == stack.toString()) {
				command[i].callback();
			}
		}
	}
})(jQuery);