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
	var insert_wrapper = function ( parent_elm ) {
		if ( ! parent_elm )
			return false;
		
		var html_elm = '<div class="jsn-bootstrap3 description-wide wr-text-center wr-icon wr-icon-wrapper"><div class="jsn-icon16 jsn-icon-loading"></div></div>';
		
		$(parent_elm).find('.item-delete').before(html_elm);
	};
	
	var add_collapse = function () {
		 var collapse = $('.collapse'),
         btn_toggle = collapse.prev('.panel-heading').find('[data-toggle="collapse"]');

		 if ( ! collapse.hasClass('wr-added') ){
		     collapse.on('shown.bs.collapse', function () {
		         btn_toggle.addClass('dropup');
		     });

	     	collapse.on('hidden.bs.collapse', function () {
	         	btn_toggle.removeClass('dropup');
	         });
	     	collapse.addClass('wr-added');
		 }
	};
	
	window.wr_ajax_insert_icon = function ( item_id ) {

		var arr_locations = [];
		$('.menu-theme-locations input[type="checkbox"]:checked').each(function(){
			var location = $(this).attr('id').replace( 'locations-', '' );
			arr_locations.push( location );
		});

		if( arr_locations ) {

			var location_string = arr_locations.join(',');

			if ( ! item_id ) {
				// Get all item ids
				var arr_ids = [];
				$('li.menu-item').each(function () {
					var id = $(this).attr('id');
					id     = id.replace('menu-item-', '');
					id     = parseInt( id );
					if ( typeof( id ) != 'NaN') {
						arr_ids.push( id );
					}
				});
			}
			
			if ( arr_ids ) {
				var item_ids = arr_ids.join(',');
				// Send request ajax for get icons collapse accordion html
				$.ajax({
					type   : "POST",
					url    : Wr_Megamenu_Ajax.ajaxurl,
					data   : {
						action         : 'wr_megamenu_get_menu_icons',
						item_ids       : item_ids,
						wr_nonce_check : Wr_Megamenu_Ajax._nonce,
						locations	   : location_string
					},
					success: function (data) {
						if( data == 'not_show' ){
							$( ".wr-icon-wrapper" ).remove();
						} else {
							data = ( data ) ? JSON.parse( data ) : '';
							if ( data ) {
								for( var i = 0; i < data.length; i++ ) {
									if ( data[i].id ) {
										var element = $( '#menu-item-' + data[i].id + ' .jsn-bootstrap3' );
										element.removeClass('wr-icon-wrapper');
										element.removeClass('wr-text-center');
										element.html( data[i].html );
									}
								}
							}
							
							$('body').trigger('init_jsn_icon_selector');
						}
	               }
	           });
			}
		} else {
			$( ".wr-icon-wrapper" ).remove();
		}
	};
	
	var parse_str = function( query_str ) {
	    var params = {}, queries, temp, i, l;
	 
	    // Split into key/value pairs
	    queries = query_str.split("&");
	 
	    // Convert the array of strings into an object
	    for ( i = 0, l = queries.length; i < l; i++ ) {
	        temp = queries[i].split('=');
	        params[temp[0]] = temp[1];
	    }
	 
	    return params;
	};
	
    $(document).ready(function() {
    	// Insert jsn-bootstrap3 wrapper first
    	$('.menu-item-actions').each(function () {
    		insert_wrapper( this );
    	});
    	add_collapse();
    	window.wr_ajax_insert_icon();
    	
    	$( document ).ajaxComplete(function(event, xhr, settings) {
    		var data = parse_str( settings.data );
    		if ( data.action == 'add-menu-item' ) {
    			$('#menu-to-edit > li').each(function (index) {
    				if ( $(this).find('.jsn-bootstrap3').length <= 0 ) {
    					insert_wrapper( $(this) );
    				}
    			});
    			
    			add_collapse();
    	    	window.wr_ajax_insert_icon();
    		}
		});
    	
    	// Bind event when select jsn-item icons
    	$('body').bind('end_jsn_icon_selector', function () {
    		$('.wr-added .jsn-item .icons-item').on('click', function () {
    			var icon_class = $(this).find('i').attr('class');
    			if ( ! icon_class ) {
    				icon_class = 'icon-wand';
    			}
    			
    			var title = $(this).closest('.jsn-bootstrap3').find('.panel-title i');
    			if ( icon_class && title.length ) {
    				$(title).attr('class', icon_class);
    			}
    		});
    	});
    });

})(jQuery)
