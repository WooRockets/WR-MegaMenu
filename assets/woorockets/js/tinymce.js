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

// Add Woorockets button to TinyMCE
(function($){
    if (typeof(Wr_Megamenu_Translate) != 'undefined') {
        // creates the plugin
        tinymce.create('tinymce.plugins.wr_mm', {
            // creates control instances based on the control's id.
            // our button's id is "wr_mm_button"
            createControl : function(id, controlManager) {
                if (id == 'wr_mm_button') {
                    // creates the button
                    var button = controlManager.createButton('wr_mm_button', {
                        title : Wr_Megamenu_Translate.wr_shortcode, // title of the button
                        image : Wr_Megamenu_Translate.wr_icon,  // path to the button's image
                        onclick : function() {
                            // triggers the thickbox
                            tb_show( Wr_Megamenu_Translate.wr_shortcode, '#TB_inline?width=' + 100 + '&height=' + 100 + '&inlineId=wr_mm-form' );
                            // custom style
                            $('#TB_window').css({'overflow-y' : 'auto', 'overflow-x' : 'hidden', 'height' : parseInt(jQuery(window).height()*0.9 - 3) + 'px'});
                            $('#TB_ajaxContent').css({'width' : '95%', 'height' : '90%'});
                        }
                    });
                    return button;
                }
                return null;
            }
        });

        // registers the plugin. DON'T MISS THIS STEP!!!
        tinymce.PluginManager.add('wr_mm', tinymce.plugins.wr_mm);

        // executes this when the DOM is ready
        jQuery(function(){
            // creates a form to be displayed everytime the button is clicked
            // you should achieve this using AJAX instead of direct html code like this
            var form = $("<div/>", {
                            "id":"wr_mm-form"
                        }).append(
                            $("<div />").append(window.parent.jQuery.noConflict()('#wr-shortcodes').clone()).html()
                        );
            form.appendTo('body').hide();
            form.find('#wr-shortcodes').fadeIn(500);
        });
    }
})(jQuery)