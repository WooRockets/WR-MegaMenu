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

        // Return if it's not inside customcss modal.
        if (!document.getElementById('wr-mm-custom-css-box')) {
            return;
        }
        // Transform custom CSS textarea to codeMirror editor
        var editor = CodeMirror.fromTextArea(document.getElementById('custom-css'), {
            mode: "text/css",
            styleActiveLine: true,
            lineNumbers: true,
            lineWrapping: true
        });

        editor.on('change',function (){
            $('#custom-css').html(editor.getValue());
        });

        // Set editor's height to fullfill the modal
        $(window).resize(function() {
            editor.setSize('98%' , $(window).height() - 250);
        });
        /**
         * Action inside Modal
         */
        var parent = $('#wr-mm-custom-css-box');
        var css_files = parent.find('.jsn-items-list');

        // sort the CSS files list
        css_files.sortable();

        parent.find('#items-list-edit, #items-list-save').click(function(e){
            e.preventDefault();

            $(this).toggleClass('hidden');
            $(this).parent().find('.btn').not(this).toggleClass('hidden');

            css_files.toggleClass('hidden');
            parent.find('.items-list-edit-content').toggleClass('hidden');

            // get current css files, add to textarea value
            if( $(this).is('#items-list-edit') ) {
                var files = '';
                css_files.find('input').each(function(){
                    files += $(this).val() + '\n';
                });
                var textarea = parent.find('.items-list-edit-content').find('textarea');
                textarea.val(files);
                textarea.focus();
            }
        });

        // Save Css files
        parent.find('#items-list-save').click(function(e){

            e.preventDefault();

            /**
             * Add file to CSS files list
             */
            // store exist urls
            var exist_urls = new Array();

            // store valid urls
            var valid_urls = new Array();

            // get HTML template of an item in CSS files list
            var custom_css_item_html = $('#tmpl-wr-custom-css-item').html();
            // get list of files url
            var files	= parent.find('.items-list-edit-content').find('textarea').val();
            files = files.split("\n");

            css_files.empty();
            $.each(files, function(i, file){
                var regex = /^[^\s]+\.[^\s]+/i;

                // check if input is something like abc.xyz
                if (regex.test(file))
                {
                    css_files.append(custom_css_item_html.replace(/VALUE/g, file).replace(/CHECKED/g, ''));
                    valid_urls[i] = file;
                }
            });

            // add loading icon
            css_files.find('li.jsn-item').each(function(){
                var file = $(this).find('input').val();

                // if file is not checked whether exists or not, add loading icon
                if( $.inArray( file, exist_urls ) < 0 ) {
                    $(this).append('<i class="jsn-icon16 jsn-icon-loading"></i>');
                }
            });

            var hide_file = function(css_files, file) {
                var item = css_files.find('input[value="'+file+'"]');

                item.attr('disabled', 'disabled');
                item.parents('li').attr('data-title', Wr_Megamenu_Translate.custom_css.file_not_found);

                // remove loading icon
                item.parents('li.jsn-item').find('.jsn-icon-loading').remove();
            }

            // check if file exists
            $.each(valid_urls, function(i, file){
                if (!file) {
                    return;
                }

                var file_ = file;

                // check if is relative path
                var regex = /^(?:(?:https?|ftp):\/\/)/i;
                if (!regex.test(file))
                {
                    // add WP root path to url to check
                    file_ = Wr_Megamenu_Translate.site_url + '/' + file;
                }

                // check if file exists or not
                $.ajax({
                    url: file_,
                    statusCode: {
                        404: function () {
                            hide_file(css_files, file);
                        }
                    },
                    success: function () {
                        exist_urls[i] = file;

                        var item = css_files.find('input[value="'+file+'"]');
                        // check the checbox
                        item.attr('checked', 'checked');

                        // remove loading icon
                        item.parents('li.jsn-item').find('.jsn-icon-loading').remove();
                    },
                    error: function () {
                        hide_file(css_files, file);
                    }
                });
            });
        });

    });

})(jQuery)
