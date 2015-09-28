(function($){
	$.fn.extend({
		replaceClass: function(options){
			var defaults = {
				event_type:"hover",
				element_affected:"",
				old_class:"",
				new_class:""
			}
			var options = $.extend(defaults, options);
			return this.each(function(){
				var o = options;
				var obj = $(this);
				if (o.old_class == "" || o.new_class == "") return false;
				if (o.element_affected == "") o.element_affected = obj;
				if (o.event_type == "hover"){
					$(obj).hover(
						function(){
							$(o.element_affected).removeClass(o.old_class);
							$(o.element_affected).addClass(o.new_class);
						},
						function(){
							$(o.element_affected).removeClass(o.new_class);
							$(o.element_affected).addClass(o.old_class);
						}
					);
				}
				if (o.event_type == "click"){
					$(obj).click(function(event){
						event.preventDefault();
						if ($(o.element_affected).hasClass(o.old_class)){
							$(o.element_affected).removeClass(o.old_class);
							$(o.element_affected).addClass(o.new_class);
						}
						else{
							$(o.element_affected).removeClass(o.new_class);
							$(o.element_affected).addClass(o.old_class);
						}
					});
				}
			});
		}
	});
})(jQuery); 