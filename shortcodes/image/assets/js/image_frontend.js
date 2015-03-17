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

	$(document).ready(function () {
		if ( typeof($.fn.lazyload) == "function" ) {
			$(".image-scroll-fade").lazyload({
				effect       : "fadeIn"
			});
		}
		if (typeof($.fancybox) == "function") {
			$(".mm-image-fancy").fancybox({
				"autoScale"	: true,
				"transitionIn"	: "elastic",
				"transitionOut"	: "elastic",
				"type"		: "iframe",
				"width"		: "75%",
				"height"	: "75%"
			});
		}
	});

})(jQuery);