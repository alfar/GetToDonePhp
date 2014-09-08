(function($) {
    $.fn.drags = function(opt) {

        opt = $.extend({handle:"",within:"",cursor:"move"}, opt);

        if(opt.handle === "") {
            var $el = this;
        } else {
            var $el = this.find(opt.handle);
        }
        
        if(opt.within === '') {
        	var $within = $('body');
        } else {
        	var $within = $(opt.within);
        }
        return $el.css('cursor', opt.cursor).on("mousedown", function(e) {
            if(opt.handle === "") {
                var $drag = $(this).addClass('draggable');
            } else {
                var $drag = $(this).addClass('active-handle').parent().addClass('draggable');
            }
            var z_idx = $drag.css('z-index'),
                drg_h = $drag.outerHeight(),
                drg_w = $drag.outerWidth(),
                orig = $drag.offset();
                pos_y = orig.top + drg_h - e.pageY,
                pos_x = orig.left + drg_w - e.pageX,
		  	        min_x = $within.offset().left,
		            min_y = $within.offset().top,
		            max_x = $within.offset().left + $within.outerWidth(),
		            max_y = $within.offset().top + $within.outerHeight();
		            
            $drag.css('z-index', 1000).parents().on("mousemove", function(e) {
		            new_x = e.pageX + pos_x - drg_w;
		            new_y = e.pageY + pos_y - drg_h;
		            
		            new_x = Math.min(Math.max(min_x, new_x), max_x);
		            new_y = Math.min(Math.max(min_y, new_y), max_y);

                $('.draggable').offset({
                    top:new_y,
                    left:new_x
                });
            });
            $(document).on("mouseup", function(e) {
            	$(this).off('mouseup');
	            new_x = $drag.offset().left;
	            new_y = $drag.offset().top;
	            
            	if ((new_x != orig.left) || (new_y != orig.top)) {
            		var eventData = jQuery.Event("dropped");
            		eventData.offset = {x: drg_w - pos_x, y: drg_h - pos_y};
              	$drag.trigger(eventData);
            	}
              $drag.removeClass('draggable').css('z-index', z_idx);
            });
            e.preventDefault(); // disable selection
        }).on("mouseup", function() {
            if(opt.handle === "") {
                $(this).removeClass('draggable');
            } else {
                $(this).removeClass('active-handle').parent().removeClass('draggable');
            }
        });

    }
})(jQuery);