(function($) {
	var command = [];
	command.push({'command':[74, 65, 89, 65], 'callback':function() { $('#build_button').show(); }});
	
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