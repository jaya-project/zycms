/**
 *  依赖jquery
 *  
 */

(function($) {
	$.extend({
		/**
		 *  speed 设置速度, 单位是毫秒
		 *  offset 设置页内偏移
		 */
		scrollToWhere : function(speed, offset) {
			offset = offset || 0;
			speed = speed || 400;
			$('body').animate({scrollTop: offset}, speed);
		}
	});
	
	$.fn.extend({
		/**
		 *  鼠标移上时切换class
		 */
		changeStyle : function(className) {
			if (typeof className == 'undefined') {
				console.log('className can\'t be empty');
				return;
			}
			return	this.hover(function() {
				$(this).addClass(className);
			}, function() {
				$(this).removeClass(className);
			});
		}
	});
})(jQuery);