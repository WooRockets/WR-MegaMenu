/**
 * @version    $Id$
 * @package    WR MegaMenu
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 * Technical Support:  Feedback - http://www.woorockets.com
 */

(function ($){
	/**
	 * Function to attach popover into an object
	 */
	$.wr_popover		= function (button, content_obj, title)
	{
		if (!(button instanceof jQuery)) {
			button	= $(button);
		}
		if (!(content_obj instanceof jQuery)) {
			content_obj	= $(content_obj);
		}
		var _header	= (title !='') ? $('<h3 class="popover-title">' + title + '</h3>') : '',
			_arrow	= $('<div class="arrow"></div>');
		var left_odd	= $('#wpbody').offset().left;
		var top_odd		= $('#wpbody').offset().top;
		var dialog	= $('<div class="popover bottom "></div>');
		var dialog_content	= $('<div class="popover-content"></div>');
		
		dialog.append(_arrow).append(_header);
		button.click (function (){
			dialog_content.append(content_obj);
			dialog.append(dialog_content);
			position	= {};			
			button.after(dialog);
			 
			position.left = button.offset().left - left_odd + button.outerWidth() - $(dialog).outerWidth();
			//position.left = button.offset().left - odd;
	        position.top = button.offset().top - top_odd + button.outerHeight();

	        $(dialog).find(".arrow").css("left", $(dialog).outerWidth() - button.outerWidth()/2);
	        dialog.css(position).click(function (e) {
	            e.stopPropagation();
	        });
	        dialog.show();
	        button.trigger('setting_dialog_open');
		});
		
		$(document).click(function (e) {

			if (e.target == button[0]){
				return false;
			}

            if ($('.colpick').css('display') != 'none') {

                return false;
            }

            if ($('.colpick').children().on('click', function() {
                return false;
            })) ;

	    	if ($(dialog).css('display') != 'none' ) {
	            dialog.hide();                    
	        }               
	    });		
	}
	
})(jQuery);	
