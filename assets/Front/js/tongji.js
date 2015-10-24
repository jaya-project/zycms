/**
 *  流量统计工具
 *  @author church
 *  @date 2015-10-21
 */

(function($) {
	var Tj = {
		userAgnet : '',
	};
	
	Tj.GetUserAgent = function() {
		if (navigator.userAgent.indexOf('Chrome') != -1) {
			this.userAgent = '谷歌浏览器';
		} else if(navigator.userAgent.indexOf('Firefox') != -1) {
			this.userAgent = '火狐浏览器';
		} else if(/MSIE\s+\d+\.\d+/.test(navigator.userAgent)) {
			this.userAgent = 'IE浏览器';
		} else if (navigator.userAgent.indexOf('Opera') != -1) {
			this.userAgent = '欧朋浏览器';
		} else if (navigator.userAgent.indexOf('AppleWebKit') != -1) {
			this.userAgent = 'safari浏览器';
		} else {
			this.userAgent = '其它浏览器';
		}
		return this;
	}
	
	Tj.pushData = function() {
		if (navigator.userAgent.indexOf('spider') == -1) {
			$.get('/tongji/index', {userAgent:this.userAgent}, function(result) {
				
			}) 
		}
		
	}
	
	Tj.GetUserAgent().pushData();
	
})(jQuery);