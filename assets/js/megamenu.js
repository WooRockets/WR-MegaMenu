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

        var megamenu_container = $('#wr-megamenu-builder');
        var location_obj = $('#locations', megamenu_container);
        var megamenu_type = $('#megamenu_type', megamenu_container);
        var overlay = $('.jsn-modal-overlay, .jsn-modal-indicator');
        var profile_id = $('#profile_id', megamenu_container).val();
        var layout = null;

        init_mega_menu();

        get_menu_items(profile_id, location_obj.val());
        location_obj.unbind('change').bind('change', function () {
            var location = $(this).val();
            $('#top-level-menu-container', megamenu_container).html('');
            get_menu_items(profile_id, location);
        });

        /**
         * Get all submenu items
         */
        function get_menu_items(profile_id, location) {

            var data = 'action=wr_megamenu_get_menu_items';
            data += '&location=' + location;
            data += '&profile_id=' + profile_id;
            get_overlay().show();
            $.ajax({
               type    : "POST",
               dataType: "json",
               url     : Wr_Megamenu_Ajax.ajaxurl,
               data    : data,
               success : function (data) {

                   $('#selected_menu_type').val(data.menu_type);
                   $('#top-level-menu-container', megamenu_container).html(data.html);
                   var button_title = $('.top-level-item button.btn-menu-title', megamenu_container);
                   if (button_title.size() > 0) {
                       $('#setting-container').show();
                   } else {
                       $('#setting-container').hide();
                   }
                   
                   $('#btn-submenu-styling').addClass('disabled');
                   $('#page-custom-css').addClass('disabled');
                   if ( button_title.length ) {
                	   $('#btn-submenu-styling').removeClass('disabled');
                	   $('#page-custom-css').removeClass('disabled');
                   }
                   
                   button_title.unbind('click').bind('click', function (e) {
                       e.preventDefault();
                       
                       if ($(this).hasClass('btn-primary')) {
                        return;
                       }
                       
                       var is_mega = $('#is-mega', megamenu_container);
                       var id = $(this).attr('id');
                       var buttons = $('.top-level-item button.btn-menu-title', megamenu_container);
                       id = id.replace('menu-item-', '');

                       // Auto save menu item settings when clicking on another menu item
                       if (save_settings()) {

                           $('#selected_menu_id').val(id);

                           if ($('#is-mega-' + id).val() == 'true') {
                               is_mega.val('true');
                           } else {
                               is_mega.val('false');
                           }

                           buttons.removeClass('btn-primary').parent().parent().removeClass('selected');
                           $(this).addClass('btn-primary').parent().parent().addClass('selected');
                           var lis = $(this).closest('#top-level-menu');
                           var btn_menu_item = lis.find('.top-level-item .btn-menu-setting-popover');
                           btn_menu_item.addClass('hidden');

                           $('.top-level-item .popover').hide();
                           var menu_setting_popover = $(this).next('.btn.btn-menu-setting-popover').first();
                           var setting_menu_item = menu_setting_popover.next('.setting-menu-item').first();

                           //  load on/off mega menu
                           setting_menu_item.unbind('wr-mm-switch').bind('wr-mm-switch', function () {

                               var content = setting_menu_item.find('.popover-content');

                               if (!$('.btn-toggle .btn.on.active', setting_menu_item).size() > 0) {
                                   is_mega.val('false');
                                   content.find('.mg-menu-setting-desc').remove();
                                   content.prepend($("<div/>", {"class": "mg-menu-setting-desc"}).append(Wr_Megamenu_Translate.dismega_this_menu));
                                   content.find('.setting-content').addClass('hidden');
                               } else {
                                   is_mega.val('true');

                                   content.find('.mg-menu-setting-desc').remove();
                                   content.find('.setting-content').removeClass('hidden');
                               }

                               if (is_mega.val() == 'true') {
                                   $('#turn-off-msg').addClass('hidden');
                                   $('#form-mm-design-content').removeClass('hidden');
                               } else {
                                   $('#turn-off-msg').removeClass('hidden');
                                   $('#form-mm-design-content').addClass('hidden');
                               }

                               $(document).trigger('resize');
                           });

                           setting_menu_item.trigger('wr-mm-switch');

                           $('.btn-toggle', setting_menu_item).unbind('click').bind('click', function (e) {

                               e.preventDefault();
                               $(this).find('.btn').toggleClass('active');
                               $(this).find('.btn.off').toggleClass('btn-danger');
                               $(this).find('.btn.on').toggleClass('btn-success');
                               $(this).find('.btn').toggleClass('btn-default');

                               setting_menu_item.trigger('wr-mm-switch');

                           });


                           menu_setting_popover.removeClass('hidden');
                           menu_setting_popover.unbind('click').bind('click', function (e) {
                               e.preventDefault();
                               var $this = $(this);
                               setting_menu_item.first().toggle(5, function() {
                                   $(this).on('click' ,function(e) {
                                       e.stopPropagation();
                                   });

                                   $('body').bind('click', function (e) {
                                       var el = $(e.target);
                                       if (el.hasClass('glyphicon') || el.hasClass('btn-menu-setting-popover')) {

                                       } else {
                                           setting_menu_item.hide();
                                       }
                                   });
                               });

                           });


                           $('#turn-on-mega').unbind('click').bind('click', function (e) {
                               e.preventDefault();
                               $('.btn-toggle', setting_menu_item).trigger('click');
                           })

                           init_layout_builder(profile_id, id);
                           init_menu_item_setting($(this).siblings('.setting-menu-item'));
                       }


                   });


                   get_overlay().hide();
                   $('.top-level-item button', megamenu_container).first().click();

               }
           });
        }


        /**
         * Initializes the settings of menu item
         * @param container
         */
        function init_menu_item_setting(container) {

            var full_width = $('#full_width', container),
                container_width_obj = $('#container_width', container),
                form_design_content = $('#form-mm-design-content'),
                full_width_value = $('#full_width_value', container);

            container_width_obj.bind('change', function () {

                if ($(this).val() == '' || $(this).val() == 0) {
                    form_design_content.css('width', '100%');
                } else {
                    form_design_content.css('width', $(this).val());
                }

                $(document).trigger('resize');
            });

            form_design_content.removeAttr('style', '');

            if (full_width_value.val() == '1') {
                container_width_obj.parent().parent().addClass('hidden');
                form_design_content.css('width', '100%');
                form_design_content.removeAttr('class');
                $(document).trigger('resize');
            } else {
                container_width_obj.parent().parent().removeClass('hidden');
                if (container_width_obj.val() != '') {
                    form_design_content.css('width', container_width_obj.val());
                    $(document).trigger('resize');
                }
            }


            $('#container_group', container).unbind('click').bind('click', function (e) {

                e.preventDefault();
                var full_width_value = $('#full_width_value', container);
                var container_width = container_width_obj.parent().parent();
                $(this).find('.btn').toggleClass('active');

                if ($(this).find('#full_width').hasClass('active')) {
                    container_width_obj.attr('disabled', true);
                    form_design_content.css('width', '100%');
                    container_width.addClass('hidden');
                    $(document).trigger('resize');
                    full_width_value.val(1);
                } else {
                    container_width.removeClass('hidden');
                    container_width_obj.attr('disabled', false);
                    container_width_obj.trigger('change');
                    full_width_value.val(0);
                }

            });

        }

        /**
         * Initializes layout builder for loading the layout of each top menu item
         * @param profile_id
         * @param menu
         * @param location
         * @param menu_id
         */
        function init_layout_builder(profile_id, menu_id) {

            // get layout of menu parent

            if (layout == null) {
                layout = new JSNLayoutCustomizer();
                layout.init($(".wr-mm-form-container.jsn-layout .jsn-row-container"));
            }
            // disable WP Update button
            $('#publishing-action #publish').attr('disabled', true);

            var data = 'action=wr_megamenu_get_menu_layout';
            data += '&menu_id=' + menu_id;
            data += '&profile_id=' + profile_id;
            get_overlay().show();
            $.ajax({
               type   : "POST",
               url    : Wr_Megamenu_Ajax.ajaxurl,
               data   : data,
               success: function (html) {

                   var html_temp = (html != '') ? html : $("#tmpl-wr_megamenu_row").html();

                   if (html_temp != '') {

                       load_layout_data(html_temp, function () {
                           layout.fnReset(layout, true);
                           layout.moveItemDisable(layout.wrapper);
                       });

                   }
                   get_overlay().hide();

               }
           });

            function load_layout_data(data, call) {
                // remove current content of WR MegaMenu
                $("#jsn-add-container").prevAll().remove();
                // insert placeholder text to &lt; and &gt; before prepend, then replace it
                data = wr_mm_add_placeholder(data, '&lt;', 'wrapper_append', '&{0}lt;');
                data = wr_mm_add_placeholder(data, '&gt;', 'wrapper_append', '&{0}gt;');
                $(".wr-mm-form-container").prepend(data);
                $(".wr-mm-form-container").html(wr_mm_remove_placeholder($(".wr-mm-form-container").html(), 'wrapper_append', ''));

                if (call != null) {
                    call();
                }
                $(".wr-mm-form-container").animate({
                                                       'opacity': 1
                                                   }, 200, 'easeOutCubic');

                // active WP Update button
                $('#publishing-action #publish').removeAttr('disabled');
            }

        }

        function get_overlay() {
            if (!$('.jsn-modal-overlay').length) {
                overlay.appendTo('body');
            }

            return $('.jsn-modal-overlay, .jsn-modal-indicator');
        }

        function init_mega_menu() {

            $.HandleSetting.select2();
            init_styling_popover(megamenu_container);

            $("#publish").bind('click', function (e) {

                var selected = $('.top-level-item.selected').first();
                var data = get_selected_options(selected);
                $('#theme_style_options').val(data.theme_options);
                delete data.theme_options;
                $('#menu_options').val(JSON.stringify(data));

            });

        }


        function init_styling_popover(container) {

            var theme_style = $('#theme_style');

            init_styling_modal();

            ini_theme_style(theme_style);

            init_resize_styling_columns();

            init_button_group(theme_style);

            load_dependency('.wr_has_depend');

            init_color_picker('.color-selector');


            $('.font-type').each(function () {
                init_font_face($(this));
            });
            $('.font-type').bind('change', function () {
                init_font_face($(this));
            });

            $.HandleElement.initTooltip('[data-toggle="tooltip"]');

        }

        function init_button_group(theme_style) {

            // init for button group, group radio
            $('.wr-btn-group .btn,  .wr-btn-radio .radio-inline').click(function(e) {
                e.preventDefault();
                $(this).parent().find('input').attr('checked', false);

                $(this).children('input').attr('checked', true);

                set_theme_options(theme_style.val(), false);

                theme_style.trigger('change');

            });
        }

        function init_styling_modal() {

            var btn_styling = $('#btn-submenu-styling');
            var theme_style = $('#theme_style');
            var modal;
            var box = $('#menu-styling');

            $('body').on('keydown', function(e) {
                if (e.keyCode === $.ui.keyCode.ENTER) {
                    return false;
                }
            });

            btn_styling.click(function (e){
                e.preventDefault();
                modal = new $.WRModal({
                      iframe: false,
                      closeOnEscape: false,
                      modal_content: box,
                      dialogClass: 'wr-dialog jsn-bootstrap3',
                      jParent    : window.parent.jQuery.noConflict(),
                      title      : 'Styling',
                      buttons    : [

                          {
                              'text' : Wr_Megamenu_Ajax.cancel,
                              'id'   : 'btn-cancel',
                              'class': 'btn btn-default',
                              'click': function (e) {
                                  e.preventDefault();
                                  get_overlay().hide();
                                  box.hide();
                                  $(this).dialog('destroy');
                              }
                          },
                          {
                              'text' : 'Reset',
                              'id'   : 'btn-reset-default',
                              'class': 'btn btn-default',
                              'click': function (e) {

                                  var reset_modal = $('#reset-modal');

                                  reset_modal.modal({ keyboard: false });


                                  $('#action-reset').on('click', function() {

                                      var data_json = $('#reset-default').val();

                                      get_theme_options( theme_style.val(), data_json);
                                      reset_modal.modal('hide');

                                      return false;

                                  });

                                  $('#action-cancel').on('click', function() {
                                      reset_modal.modal('hide');
                                      return false;
                                  });

                              }
                          },
                          {
                              'text' : Wr_Megamenu_Ajax.save,
                              'id'   : 'btn-save',
                              'class': 'btn btn-primary',
                              'click': function (e) {
                                  e.preventDefault();
                                  var _this = $(this);
                                  var jParent = window.parent.jQuery.noConflict();
                                  save_settings(function() {
                                      get_overlay().hide();
                                      box.hide();
                                      modal.close();
                                  });

                              }
                          }
                      ],
                      loaded     : function (obj, iframe) {
                          box.show();
                      },
                      fadeIn     : 200,
                      scrollable : true,
                      width      : $.HandleElement.resetModalSize(0, 'w'),
                      height     : $(window.parent).height() * 0.9
                  });

                modal.show(function() {
                    $(window).resize(function() {
                        $.HandleElement.resizeDialog(null, $.HandleElement.resetModalSize(0, 'w'), $(window.parent).height() * 0.9);
                    });
                });

            });


        }
        function ini_theme_style(theme_style) {

            get_theme_options(theme_style.val());

            theme_style.bind('change', function () {
                get_theme_options($(this).val());
            });

            $("#menu-styling .tab-content input,#menu-styling .tab-content select").bind('change', function () {
                set_theme_options(theme_style.val(), false);
                theme_style.trigger('change');
            });

        }

        function get_theme_options(theme_style, reset_default) {


            var theme = $('#style-' + theme_style);

            var options = {};

            if (reset_default != null) {
                options = JSON.parse(reset_default);
                $('#style-' + theme_style).val(reset_default);
            } else {
                options = JSON.parse(theme.val());
            }

            $.each(options, function (key, val) {

                var el = $('#param-' + key);
                if (el.is('select')) {

                    el.select2('val', val);
                    el.attr('data-selected', val);

                } else {
                    if (!el.is(':radio'))
                        el.val(val);
                    else {

                        el.parent().parent().children().removeClass('active');

                        $('input[name^="param-'+key+'"]').each(function() {

                            var _this = $(this);
                            if (_this.val() == val) {
                                _this.parent().addClass('active');
                                _this.attr('checked', true);
                            }

                        });

                    }
                    var color = $('#color-picker-param-' + key);
                    if (color.length > 0) {
                        color.children('input').first().css('background-color', '#' + val);
                        color.find('.input-group-btn a.btn-default').first().css('background-color', '#' + val);
                    }

                }

            });

            $( '#menu-styling .wr_has_depend').each(function() {
                if (($(this).is(":radio") || $(this).is(":checkbox")) && !$(this).is(":checked")) {
                    return;
                }

                var this_id  = $(this).attr('id'), this_val  = $(this).val();

                $.HandleSetting.toggleDependency(this_id, this_val);
            });

            preview_styling(theme_style);
        }


        function init_font_face(el) {


            var parent = $(el).parents('.controls');
            var fontType = $(el).val();

            var dataOptions = '';
            $(parent).find("select.font-face").html("");
            switch (fontType) {
                case 'Standard Font':
                    dataOptions = getStandardOptions();
                    break;
                case 'Google Font':
                    dataOptions = getGoogleOptions();
                    break;
                default:
                    dataOptions = getStandardOptions();
                    break;
            }
            ;

            $.each(dataOptions, function (i, val) {

                $(parent).find("select.font-face").append(
                    $("<option/>", {"value":i, "text":val})
                )

                if (i == $(parent).find("select.font-face").attr("data-selected")) {
                    $(parent).find("select.font-face").select2('val', i);
                }

            });

        }

        function getStandardOptions() {

            var listFonts = {
                "Verdana"     : "Verdana",
                "Georgia"     : "Georgia",
                "Courier New" : "Courier New",
                "Arial"       : "Arial",
                "Tahoma"      : "Tahoma",
                "Trebuchet MS": "Trebuchet MS"
            };
            return listFonts;

        }

        function getGoogleOptions() {

            var listFonts = {
                "Open Sans"        : "Open Sans", "Oswald": "Oswald", "Droid Sans": "Droid Sans", "Lato": "Lato", "Open Sans Condensed": "Open Sans Condensed", "PT Sans": "PT Sans", "Ubuntu": "Ubuntu", "PT Sans Narrow": "PT Sans Narrow",
                "Yanone Kaffeesatz": "Yanone Kaffeesatz", "Roboto Condensed": "Roboto Condensed", "Source Sans Pro": "Source Sans Pro", "Nunito": "Nunito", "Francois One": "Francois One", "Roboto": "Roboto", "Raleway": "Raleway", "Arimo": "Arimo",
                "Cuprum"           : "Cuprum", "Play": "Play", "Dosis": "Dosis", "Abel": "Abel", "Droid Serif": "Droid Serif", "Arvo": "Arvo", "Lora": "Lora", "Rokkitt": "Rokkitt", "PT Serif": "PT Serif", "Bitter": "Bitter", "Merriweather": "Merriweather", "Vollkorn": "Vollkorn",
                "Cantata One"      : "Cantata One", "Kreon": "Kreon", "Josefin Slab": "Josefin Slab", "Playfair Display": "Playfair Display", "Bree Serif": "Bree Serif", "Crimson Text": "Crimson Text", "Old Standard TT": "Old Standard TT", "Sanchez": "Sanchez",
                "Crete Round"      : "Crete Round", "Cardo": "Cardo", "Noticia Text": "Noticia Text", "Judson": "Judson", "Lobster": "Lobster", "Unkempt": "Unkempt", "Changa One": "Changa One", "Special Elite": "Special Elite",
                "Chewy"            : "Chewy", "Comfortaa": "Comfortaa", "Boogaloo": "Boogaloo", "Fredoka One": "Fredoka One", "Luckiest Guy": "Luckiest Guy", "Cherry Cream Soda": "Cherry Cream Soda",
                "Lobster Two"      : "Lobster Two", "Righteous": "Righteous", "Squada One": "Squada One", "Black Ops One": "Black Ops One", "Happy Monkey": "Happy Monkey", "Passion One": "Passion One", "Nova Square": "Nova Square", "Metamorphous": "Metamorphous", "Poiret One": "Poiret One", "Bevan": "Bevan", "Shadows Into Light": "Shadows Into Light", "The Girl Next Door": "The Girl Next Door", "Coming Soon": "Coming Soon",
                "Dancing Script"   : "Dancing Script", "Pacifico": "Pacifico", "Crafty Girls": "Crafty Girls", "Calligraffitti": "Calligraffitti", "Rock Salt": "Rock Salt", "Amatic SC": "Amatic SC", "Leckerli One": "Leckerli One", "Tangerine": "Tangerine", "Reenie Beanie": "Reenie Beanie", "Satisfy": "Satisfy", "Gloria Hallelujah": "Gloria Hallelujah", "Permanent Marker": "Permanent Marker", "Covered By Your Grace": "Covered By Your Grace", "Walter Turncoat": "Walter Turncoat", "Patrick Hand": "Patrick Hand", "Schoolbell": "Schoolbell", "Indie Flower": "Indie Flower"
            };
            return listFonts;

        }

        function set_theme_options(theme_style, get_options) {

            var styling_options = {};

            styling_options['menu-bar-bg_value'] = $('#param-menu-bar-bg_value').val();
            styling_options['menu-bar-bg'] = $('#param-menu-bar-bg').val();
            styling_options['menu-bar-font'] = $('#param-menu-bar-font').val();
            styling_options['menu-bar-font_type'] = $('#param-menu-bar-font_type').val();
            styling_options['menu-bar-font_face'] = $('#param-menu-bar-font_face').val();
            styling_options['menu-bar-font_size'] = $('#param-menu-bar-font_size').val();
            styling_options['menu-bar-font_weight'] = $('#param-menu-bar-font_weight').val();
            styling_options['menu-bar-menu_color'] = $('#param-menu-bar-menu_color').val();
            styling_options['menu-bar-menu_layout'] = $('input[name^="param-menu-bar-menu_layout"]:checked').val();
            styling_options['menu-bar-stick_menu'] = $('input[name^="param-menu-bar-stick_menu"]:checked').val();
            styling_options['menu-bar-on_hover'] = $('#param-menu-bar-on_hover').val();
            styling_options['menu-bar-icon_display_mode'] = $('input[name^="param-menu-bar-icon_display_mode"]:checked').val();
            styling_options['menu-bar-icon_position'] = $('input[name^="param-menu-bar-icon_position"]:checked').val();
            styling_options['menu-bar-icon_size'] = $('#param-menu-bar-icon_size').val();

            // Submenu panel
            styling_options['heading-text-font'] = $('#param-heading-text-font').val();
            styling_options['heading-text-font_type'] = $('#param-heading-text-font_type').val();
            styling_options['heading-text-font_face'] = $('#param-heading-text-font_face').val();
            styling_options['heading-text-font_size'] = $('#param-heading-text-font_size').val();
            styling_options['heading-text-font_weight'] = $('#param-heading-text-font_weight').val();
            styling_options['heading-text-menu_color'] = $('#param-heading-text-menu_color').val();

            styling_options['normal-text-font'] = $('#param-normal-text-font').val();
            styling_options['normal-text-font_type'] = $('#param-normal-text-font_type').val();
            styling_options['normal-text-font_face'] = $('#param-normal-text-font_face').val();
            styling_options['normal-text-font_size'] = $('#param-normal-text-font_size').val();
            styling_options['normal-text-font_weight'] = $('#param-normal-text-font_weight').val();
            styling_options['normal-text-menu_color'] = $('#param-normal-text-menu_color').val();

            styling_options['submenu-panel-bullet_icon'] = $('input[name^="param-submenu-panel-bullet_icon"]:checked').val();

            if (get_options == true) {
                return styling_options;
            } else {
                $('#style-' + theme_style).val(JSON.stringify(styling_options));
            }

        }

        function preview_styling(theme_style) {

            var preview_menu_bar = $('#style-menu_bar');
            var preview_submenu_panel = $('#style-submenu_panel');
            var styling_options = set_theme_options(theme_style, true);

            var menu_bar_style = '';
            menu_bar_style += '.menubar-preview { float:left; margin:0; padding:0; }';
            menu_bar_style += '.menubar-preview {background-color:'+styling_options['menu-bar-bg']+'}';
            menu_bar_style += '.menu-item { height: auto; position: relative; margin-bottom: 0; }';
            menu_bar_style += '.menu-item a { padding:10px 25px; display: block; color:#fff !important; }';
            menu_bar_style += '.menu-item .glyphicon { margin-right: 7px; }';

            if (styling_options['menu-bar-menu_layout'] == 'vertical') {
                menu_bar_style += '.menu-item {display: block;}';
            } else if (styling_options['menu-bar-menu_layout'] == 'horizontal') {
                menu_bar_style += '.menu-item {display: inline-block;}';
            }
            menu_bar_style += '.menu-item:hover a, .menu-item:focus a { background-color: '+styling_options['menu-bar-on_hover']+'; text-decoration:none !important; }';

            if (styling_options['menu-bar-icon_display_mode'] !="text_only") {

                if (styling_options['menu-bar-icon_position'] == 'top') {
                    menu_bar_style += '.menu-item .glyphicon {display:block !important; text-align:center;}';
                }
                menu_bar_style += '.menu-item .glyphicon {font-size: '+styling_options['menu-bar-icon_size']+'px;}';

            }
            if (styling_options['menu-bar-font'] == 'custom') {
                menu_bar_style += '.menu-item a {';
                menu_bar_style += 'font-family: ' + styling_options['menu-bar-font_face'] + ' !important;';
                menu_bar_style += 'font-size: ' + styling_options['menu-bar-font_size'] + 'px;';
                menu_bar_style += 'font-weight: ' + styling_options['menu-bar-font_weight'] + ';';
                menu_bar_style += 'color: ' + styling_options['menu-bar-menu_color'] + ' !important;';
                menu_bar_style += '}';

            } else {
                menu_bar_style += '.menu-item a {';
                menu_bar_style += 'font-family: inherit;';
                menu_bar_style += 'font-size: inherit;';
                menu_bar_style += 'font-weight: inherit;';
                menu_bar_style += 'color: inherit;';
                menu_bar_style += '}';

            }

            if (styling_options['menu-bar-icon_display_mode'] == 'icon_text') {

            } else if (styling_options['menu-bar-icon_display_mode'] == 'icon_only') {
                menu_bar_style += '.menu-item a > .menu_text {display:none !important;}';
            } else if (styling_options['menu-bar-icon_display_mode'] == 'text_only') {
                menu_bar_style += '.menu-item a .glyphicon {display:none;}';
            }

            preview_menu_bar.html(menu_bar_style);

            var submenu_panel_style = '';
            submenu_panel_style += '.submenu-panel-preview { float:left; margin:0; padding: 0; width: 300px; }';
            submenu_panel_style += '.submenu-item i { font-size: 11px; margin-left:10px;}';

            if (styling_options['submenu-panel-bullet_icon'] == 'no') {
                submenu_panel_style += '.submenu-item i {display:none !important;}';
            }

            if (styling_options['heading-text-font'] == 'custom') {
                submenu_panel_style+= '.submenu-panel-preview > li.caption > a {';
                submenu_panel_style+= 'font-family: ' + styling_options['heading-text-font_face'] + ';';
                submenu_panel_style+= 'font-size: ' + styling_options['heading-text-font_size'] + 'px;';
                submenu_panel_style+= 'font-weight: ' + styling_options['heading-text-font_weight'] + ';';
                submenu_panel_style+= 'color: ' + styling_options['heading-text-menu_color'] + ';';
                submenu_panel_style+= '}';
            }

            if (styling_options['normal-text-font'] == 'custom') {
                submenu_panel_style += '.submenu-panel-child li > a {';
                submenu_panel_style += 'font-family: ' + styling_options['normal-text-font_face'] + ';';
                submenu_panel_style += 'font-size: ' + styling_options['normal-text-font_size'] + 'px;';
                submenu_panel_style += 'font-weight: ' + styling_options['normal-text-font_weight'] + ';';
                submenu_panel_style += 'color: ' + styling_options['normal-text-menu_color'] + ';';
                submenu_panel_style += '}';
            }

            preview_submenu_panel.html(submenu_panel_style);
        }

        function load_dependency(dp_selector) {

            if (!dp_selector) {
                return false;
            }

            $('#menu-styling').delegate(dp_selector, 'change', function () {
                var this_id = $(this).attr('id'), this_val = $(this).val();
                $.HandleSetting.toggleDependency(this_id, this_val);
            });

        };

        // Function to handling resize modal styling
        function init_resize_styling_columns() {


                $('.styling-options-resize').resizable({
                   handles: 'e',
                   minWidth: 400,
                   start: $.proxy(function (event, ui) {

                   }, this),
                   resize: $.proxy(function (event, ui) {

                       var resize_handle_width =  ui.element.find('.ui-resizable-e').first().width();
                       var thisWidth           = ui.element.width() + resize_handle_width;

                       var remain_width        = ui.element.parent().width() - thisWidth - 15;

                       ui.element.next('.preview-styling-resize').first().css('width', remain_width + 'px');

                   }, this),
                   stop: $.proxy(function (event, ui) {

                   })
               });

//
//            $('.jsn-modal').on('resize', function () {
////               todo
//            });

        }


        function init_color_picker(selector) {
            if (!selector) {
                return false;
            }
            var theme_style = $('#theme_style');

            $( selector + " > input").each(function(i, e) {
                // Handle manual color input
                $(e).keypress(function() {
                    if ($(e).val().substr(0, 1) != "#") {
                        return;
                    }

                    if ($(e).val().length == 7) {
                        $(e).next().find("a.btn").css(
                            {
                              "background-color": $(e).val(),
                              "color": $(e).val()
                            }).colpickSetColor($(e).val().substr(1));
                    }
                });
            });

            $(selector + " > .input-group-btn > a.btn").each(function(i, e) {
                // Set button color
                $(e).css(
                    {
                         "background-image": "none",
                         "text-shadow": "none",
                         "background-color": $(e).parent().prev().val(),
                         "color": $(e).parent().prev().val()
                     }).colpick({
                        submit: false,
                        color: $(e).parent().prev().val().substr(1),
                        colorScheme: "dark",
                        onShow: function(color_picker) {
                            $(color_picker).fadeIn(500);

                            return false;
                        },
                        onHide: function(color_picker) {
                            $(color_picker).fadeOut(500);
                            get_theme_options(theme_style.val());
                            return false;
                        },
                        onChange: function(hsb, hex, rgb) {
                            $(e).parent().prev().val("#" + hex).trigger("change");
                            $(e).css({
                                         "background-color": "#" + hex,
                                         "color": "#" + hex
                                     });

                            set_theme_options(theme_style.val(), false);
                        }
                    });
            });


        };


        /**
         * Build a collection setting for mega menu
         * @param object - Save button
         */
        function save_settings(callback) {

            var selected = $('.top-level-item.selected').first();

            if (selected.size() > 0) {
                var data = get_selected_options(selected);
                data.action = 'wr_megamenu_save_megamenu_data';
                $.ajax({
                   type   : "POST",
                   url    : Wr_Megamenu_Ajax.ajaxurl,
                   data   : data,
                   success: function (html) {
                        if (callback != null) {
                            callback();
                        }
                   }
                });

            }

            return true;
        }

        function get_selected_options(selected) {

            var settings_menu_item = $('input', selected).serialize();
            var menu_type = $('#selected_menu_type').val();
            var location = $('#locations').val();
            var theme_style = $('#theme_style').val();
            var menu_id = $('#selected_menu_id').val();
            var is_mega = $('#is-mega').val();
            var profile_id = $('#profile_id').val();
            var shortcode_content = '';

            // get shortcode content
            $('[name="shortcode_content[]"]').each(function () {
                shortcode_content += $(this).val();
            });


            var data = {};

            data.menu_type = menu_type;
            data.location = location;
            data.theme_style = theme_style;

            data.menu_id = menu_id;
            data.is_mega = is_mega;
            data.profile_id = profile_id;
            data.setting_menu = settings_menu_item;
            data.shortcode_content = encodeURIComponent(shortcode_content);

            var theme_object = {};

            $('#menu-styling [name="theme_options[]"]').each(function () {
                var $this = $(this);
                theme_object[$this.attr('id').replace('style-', '')] = $this.val();
            });
            if (theme_object) {
                data.theme_options = JSON.stringify(theme_object);
            }

            return data;
        }

        function debug(string) {
            console.log(string);
        }
    });

})(jQuery);
