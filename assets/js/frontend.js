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

    $(document).ready(function() {

        $('.wr-megamenu-container').each(function (key, value) {

            var rand_id = Date.now();
            rand_id     = 'dln_megamenu_' + rand_id + key;
            
            // Insert button responsive-mega
            if ( ! $(this).attr('data-relate-id') ) {
                $(this).attr('data-relate-id', rand_id);
                
                // Create new button reposinve-mega class
                var button = $('<div class="it-responsive-mega" id="' + rand_id + '" ></div>'); 
                $(this).before(button);
            }

            //Add arrow down if has children
            var list_item = $(this).find('ul.wr-mega-menu > li.menu-item');

            $(list_item).each(function (key_item, value_item) {
                var count_children = $(value_item).children().length;
                if(count_children > 1){
                    $(value_item).children('a.menu-item-link').after('<span class="wr-menu-down"></span>');
                }
            });

            // Subitem
            $(this).find('ul.wr-mega-menu > li.menu-item > .sub-menu .menu-item-has-children > a').after('<span class="wr-menu-down"></span>');
        });
        
        // Add click action
        $('.it-responsive-mega').on('click', function (e) {
            e.preventDefault();
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).next('.wr-megamenu-container').removeClass('active');
            } else{
                $(this).addClass('active');
                $(this).next('.wr-megamenu-container').addClass('active');
            }
        });



        // Add click action
        $('.wr-menu-down').on('click', function (e) {
            e.preventDefault();
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).next().removeClass('active');
            } else{
                $(this).addClass('active');
                $(this).next().addClass('active');
            }
        });


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