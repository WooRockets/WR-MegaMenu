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
 
(function ($) {
	
	var is_mobile_browser = function () {
		if( navigator.userAgent.match(/Android/i)
				|| navigator.userAgent.match(/webOS/i)
				|| navigator.userAgent.match(/iPhone/i)
				|| navigator.userAgent.match(/iPad/i)
				|| navigator.userAgent.match(/iPod/i)
				|| navigator.userAgent.match(/BlackBerry/i)
				|| navigator.userAgent.match(/Windows Phone/i)
		) {
			return true;
		} else {
			return false;
		}
	};

    $(document).ready(function() {
    	
    	if ( is_mobile_browser() ) {
    		$('.wr-megamenu-container').each(function () {
    			var rand_id = Date.now();
    			rand_id     = 'dln_megamenu_' + rand_id;
    			
    			// Insert button responsive-mega
    			if ( ! $(this).attr('data-relate-id') ) {
    				$(this).attr('data-relate-id', rand_id);
    				
    				// Create new button reposinve-mega class
    				var button = $('<button class="it-responsive-mega" id="' + rand_id + '" />');
    				$(this).before(button);
    			}
    		});
    		
    		// Add click action
    		$('.it-responsive-mega').on('click', function (e) {
    			e.preventDefault();

    			// Remove active state
    			$('.it-responsive-mega').removeClass('active');
    			$('.wr-megamenu-container').removeClass('active');
    			
    			var id_relate = $(this).attr('id');
    			if ( $('.wr-megamenu-container[data-relate-id="' + id_relate + '"]').length ) {
    				$(this).addClass('active');
    				$('.wr-megamenu-container[data-relate-id="' + id_relate + '"]').addClass('active');
    			}
    		});
    	}

        $(window).on('load', function() {
            onResizing();
        });

        $(window).on('resize',  function() {

            clearTimeout($.data(this, 'resizeTimer'));
            $.data(this, 'resizeTimer', setTimeout(function() {
                onResizing();
            }, 200));

        });

        function onResizing() {

            var isMobile = window.matchMedia("only screen and (max-width: 768px)");

            if (isMobile.matches) {

                $('.wr-megamenu-fixed .wr-megamenu-inner').css('width', '100%');

            } else {

                $('.wr-megamenu-fixed .wr-megamenu-inner').each(function() {
                    var or_width = $(this).attr('data-container');
                    $(this).css('width', or_width);
                });

            }

        }

        $('.wr-mega-menu .sub-menu-collapse').on('click', function (event) {
            $(this).toggleClass('active');
        });

    });

})(jQuery);