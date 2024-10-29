(function($) {
	$.fn.alwp = function() {
		return this.each(function() {
			var box_id = $(this).attr('id');
			var main_img = $('.main_img',this);
			var thumbs = $('.nav li a',this);
			var main_img_title, main_img__alt, full_url, loader, new_url;
			var main_title = $(this).find('.img_caption');
			thumbs.click(function(e) {
				thumbs.each(function() {
					$(this).parent().removeClass('current');
					$(this).parent().addClass('reg');
				});
				$(this).parent().removeClass('reg');
				$(this).parent().addClass('current');
				var path = get_scriptPath ();
				loader = path + 'images/ajax-loader.gif';
				new_url = $(this).attr('href');
				full_url = $(this).attr('title');
				main_img_title = $(this).find('img').attr('title');
				main_img_alt = $(this).find('img').attr('alt');
				main_img.fadeOut(500, function() {
					main_img.css({'display':'none','position':'relative','top':'50%','marginTop':'-25px'});
					main_img.attr('src',loader).fadeIn(500,function () {
						new_img = new Image();
						new_img.src = new_url;
						new_img.onload = function(){
							main_img.fadeOut(500, function() {
								main_img.css({'position':'static','marginTop':'0'});
								main_img.attr('src',new_url);
								main_img.parent().attr('href',full_url);
								main_img.attr('title',main_img_title);
								main_img.attr('alt',main_img_alt);
								main_img.fadeIn(500);
								main_title.html(main_img_title);
							});
						};
					});
				});
	            return false;
	        });
			var prev = $('.prev', this);
			var next = $('.next', this);
			prev.css('visibility','hidden');
			var nav = $('.nav', this);
			var nav_holder = nav.parent();
			var container_width = nav_holder.width();
			var nav_width = nav.width();
			var step = nav_width/thumbs.length;
			next.click(function(e) {
				if ($(':animated').length) {
			        return false;
			    }
				prev.css('visibility','visible');
				var delta = nav_width - container_width; 
				if (!nav.css('left')) {
			 		current_position = 0;
			 	}
				else {
					current_position = nav.css('left').replace(/px/i,'')*1;
				}
				new_position = current_position - step;
				if (Math.abs(current_position) < delta) {
					nav.animate({left: new_position},{duration: 500});
				}
				if (Math.abs(new_position) >= delta) {
					next.css('visibility','hidden');
				}
			});
			prev.click(function(e) {
				if ($(':animated').length) {
			        return false;
			    }
				next.css('visibility','visible');
				if (!nav.css('left')) {
			 		current_position = 0;
			 	}
				else {
					current_position = nav.css('left').replace(/px/i,'')*1;
				}
				new_position = current_position + step;
				if (current_position < 0) {
					nav.animate({left: new_position},{duration: 500});
				}
				if (new_position >= 0) {
					prev.css('visibility','hidden');
				}
			});
		});
	};
})(jQuery);


function get_scriptPath () {
    var scripts = document.getElementsByTagName('SCRIPT');
    var path = '';
    if(scripts && scripts.length>0) {
        for(var i in scripts) {
            if(scripts[i].src && scripts[i].src.match(/alwp\.js/)) {
                path = scripts[i].src.replace(/(.*)alwp\.js.*$/, '$1');
            }
        }
    }
    return path;
}

jQuery(document).ready(function(){
	jQuery('.alwp_galleryHolder').alwp();
});
