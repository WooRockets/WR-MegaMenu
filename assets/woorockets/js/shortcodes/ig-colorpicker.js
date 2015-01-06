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
    "use strict";

    $.WRColorPicker = function (selector) {
        this.init(selector);
    };

    $.WRColorPicker.prototype = {
        init: function (selector) {
            if ( ! selector )
                selector = '#modalOptions .color-selector';

            $( selector ).each(function () {
                var self	= $(this);
                var colorInput = self.siblings('input').last();
                var inputId 	= colorInput.attr('id');
                var inputValue 	= inputId.replace(/_color/i, '') + '_value';
                if ($('#' + inputValue).length){
                    $('#' + inputValue).val($(colorInput).val());
                }

                self.ColorPicker({
                    color: $(colorInput).val(),
                    onShow: function (colpkr) {
                        $(colpkr).fadeIn(500);
                        return false;
                    },
                    onHide: function (colpkr) {
                        $(colpkr).fadeOut(500);
                        $.HandleSetting.shortcodePreview();
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        $(colorInput).val('#' + hex);

                        if ($('#' + inputValue).length){
                            $('#' + inputValue).val('#' + hex);
                        }
                        self.children().css('background-color', '#' + hex);
                    }
                });
            });
        }
    }

})(jQuery);