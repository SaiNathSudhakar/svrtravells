//Preload Images
(function($){
	 $.fn.extend({
		preload: function(options) {
			var defaults = { };
			var options = $.extend(defaults, options);
			return this.each(function() {
				var o = options;
				var obj = $(this);
				var imageArr = [];
				$('img', obj).each(function(index) { 
					imageArr[i] = new Image();
					imageArr[i].src = $(this).attr('src');
				});
			});
		}
	 });
})(jQuery);