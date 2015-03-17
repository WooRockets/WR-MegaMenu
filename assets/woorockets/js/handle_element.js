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

(function($) {
	"use strict";
	$.WRModal = $.WRModal || {};
	$.HandleElement = $.HandleElement || {};
	$.PbDoing = $.PbDoing || {};
	$.HandleSetting = $.HandleSetting || {};

	$.options = {
		min_column_span : 2,
		layout_span : 12,
		new_sub_element : false,
		curr_iframe_ : null,
		clicked_column : null,
		if_childmodal : 0,
		modal_settings : {
			modalId: 'jsn_view_modal',
			sub_modalId: 'jsn_view_modal_sub',
			sub_modalChildId: 'jsn_view_modal_sub_child'
		},
		effect: 'easeOutCubic'
	}

	var clk_title_el , append_title_el;
	var el_type; // save type of editing shortcode: element/widget
	var input_enter;

	/**
	 * 1. Common
	 * 2. Resizable
	 * 3. MegaMenu
	 * 4. Modal
	 */

	/***************************************************************************
	 * 1. Common
	 **************************************************************************/

	// alias for jQuery
	$.HandleElement.selector = function(curr_iframe, element) {
		var $selector = (curr_iframe != null && curr_iframe.contents() != null) ? curr_iframe.contents().find(element) : window.parent.jQuery.noConflict()(element);
		return $selector;
	},

	// Capitalize first character of whole string
	$.HandleElement.capitalize = function(text) {
		return text.charAt(0).toUpperCase()
		+ text.slice(1).toLowerCase();
	},

	// Capitalize first character of each word
	$.HandleElement.ucwords = function(text) {
		return (text + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
			return $1.toUpperCase();
		});
	},

	// Remove underscore character from string
	$.HandleElement.remove_underscore_ucwords = function(text) {
		var arr = text.split('_');
		return $.HandleElement.ucwords( arr.join(' ') ).replace(/^(Wp)\s+/g, '');
	},

	// Strip HTML tag from string
	$.HandleElement.strip_tags = function(input, allowed) {
		// Make sure the allowed argument is a string containing only tags in lowercase (<a><b><c>)
		allowed = (((allowed || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');

		var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi, commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;

		return input.replace(commentsAndPhpTags, '').replace(tags, function($0, $1) {
			return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
		});
	},

	// Get n first words of string
	$.HandleElement.sliceContent = function(text, limit) {
		text = unescape(text);
		text = text.replace(/\+/g, ' ');
		text = $.HandleElement.strip_tags(text);

		var arr = text.split(' ');
			arr = arr.slice(0, limit ? limit : 10);
		return arr.join(' ');
	},

	// Get cookie value by key
	$.HandleElement.getCookie = function ( c_name ) {
		if ( ! c_name )
			return null;
		c_name = c_name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(c_name) == 0) return c.substring(c_name.length,c.length);
		}
		return null;
	},

	// Store cookie data
	$.HandleElement.setCookie = function ( c_name, c_value ) {
		c_value = c_value + ";max-age=" + 60 * 3 + ";path=/";
		document.cookie	= c_name + "=" + c_value;
	},

	// Remove cookie
	$.HandleElement.removeCookie = function ( c_name ) {
		if ( ! c_name )
			return null;
		document.cookie = c_name + "=;max-age=0;path=/";
	}
	/**
	 * Show tooltip
	 */
	$.HandleElement.initTooltip = function ( selector, gravity ) {
		if ( ! selector ) {
			return false;
		}

		// Init tooltip
		$(selector).tooltip({
			placement: gravity ? gravity : 'right',
			html: true,
		});

		return true;
	};

	/*******************************************************************
	 * 3. MegaMenu
	 ******************************************************************/

	/**
	 * add Element to WR MegaMenu when click on an element in Add Elements Popover
	 */
	$.HandleElement.addElement = function() {
		$("body").delegate(".wr-add-element .shortcode-item","click",function(e) {
			self_(e, this);
		});
		$("#wr-add-element").delegate(".shortcode-item","click",function(e) {
			self_(e, this);
		});

		function self_(e, this_){
			e.preventDefault();

			if($.PbDoing.addElement)
				return;
			$.PbDoing.addElement = 1;

					// check if adding shortcode from button in Classic Editor
			if($(this_).parents('#wr-shortcodes').length)
				top.addInClassic = 1;

			// Check if user is adding raw shortcode
			if ($(this_).attr('data-shortcode') == 'raw') {
				return $.HandleElement.appendToHolder(this_, null, 'raw');
			}

            $("#wr-add-element").hide();
            $.HandleElement.removeModal();

			$.HandleElement.showLoading();

			// get title of clicked element
			clk_title_el = $.trim($(this_).html().replace(/<i\sclass.*><\/i>/, ''));
			clk_title_el = clk_title_el.replace(/<p.*class=.*?.*>.*<\/p>/gi, '');
			// Append element to MegaMenu
			var $shortcode = $(this_).attr('data-shortcode');
			var $type = $(this_).parent().attr('data-type');
			$.HandleElement.appendToHolder($shortcode, null, $type);
		}
	},

	/**
	 * Add sub Item on Modal setting of an element (Accordion, Tab, Carousel...)
	 */
	$.HandleElement.addItem = function() {
		$(".wr-mm-form-container").delegate(".wr-more-element","click",function(e) {
			e.preventDefault();

			$.options.clicked_column = $(this).parent('.item-container').find('.item-container-content');
			// add item in Accordion/ List ...
			if ($(this).attr('data-shortcode-item') != null) {
				$.HandleElement.showLoading();

				$.options.new_sub_element = true;
				var $count = $.options.clicked_column.find(".jsn-item").length;
				var $replaces = {};
				$replaces['index'] = parseInt($count) + 1;
				$.HandleElement.appendToHolder($(this).attr('data-shortcode-item'), $replaces);
			}
		});
	},

	/**
	 * delete an element (a row OR a column OR an shortcode item)
	 */
	$.HandleElement.deleteElement = function() {
		$(".wr-mm-form-container").delegate(".element-delete","click",function(){
			var msg,is_column;
			if($(this).hasClass('row') || $(this).attr("data-target") == "row_table"){
				msg = Wr_Megamenu_Translate.delete_row;
			}else if($(this).hasClass('column') || $(this).attr("data-target") == "column_table"){
				msg = Wr_Megamenu_Translate.delete_column;
				is_column = 1;
			}else{
				msg = Wr_Megamenu_Translate.delete_element;
			}

			var confirm_ = confirm(msg);
			if(confirm_){
				var $column = $(this).parent('.jsn-iconbar').parent('.shortcode-container');
				if(is_column == 1)
				{
					// Delete a Column in Table element
					if($(this).attr("data-target") == "column_table")
					{
						var table = new $.WRTable();
						table.deleteColRow($(this), 'column', Wr_Megamenu_Translate);
						$.HandleSetting.shortcodePreview();
					}
					else{
						var $row = $column.parent('.row-content').parent('.row-region');
						// if is last column of row, remove parent row
						if($column.parent('.row-content').find('.column-region').length == 1){
							$.HandleElement.removeElement($row);
						}else{
							$.HandleElement.removeElement($column);
						}
					}
				}
				else{
					// Delete a Row in Table element
					if($(this).attr("data-target") == "row_table"){
						table = new $.WRTable();
						table.deleteColRow($(this), 'row', Wr_Megamenu_Translate);
						$.HandleSetting.shortcodePreview();
					}else{
						$.HandleElement.removeElement($column);
					}
				}
			}
		});
	},
	// request to get html template of shortcode
	$.HandleElement.getShortcodeTpl = function($shortcode, $type, callback){
		$.post(
			Wr_Megamenu_Ajax.ajaxurl,
			{
				action 		: 'wr_megamenu_get_shortcode_tpl',
				shortcode   : $shortcode,
				type   : $type,
				wr_nonce_check : Wr_Megamenu_Ajax._nonce
			},
			function( data ) {
				callback(data);
			})
	},

	/**
	 * Add an element to Parent Holder (a column [in MegaMenu], a
	 * group list[in Modal of Accordion, Tab...])
	 */
	$.HandleElement.appendToHolder = function($shortcode, $replaces, $type, sc_html, elem_title) {
		var append_to_div = $("#form-mm-design-content .wr-mm-form-container");
		if(!$(this).hasClass('layout-element') && $.options.clicked_column != null){
			append_to_div = $.options.clicked_column;
		}

		// get HTML template of shortcode
		var html;
		if ( sc_html ) {
			$.HandleElement.appendToHolderFinish($shortcode, sc_html, $replaces, append_to_div, null, elem_title);
		} else {
			if($("#tmpl-"+$shortcode).length == 0){
				// request to get html template of shortcode
				$type = ($type != null) ? $type : 'element';
				$.HandleElement.getShortcodeTpl($shortcode, $type, function(data){
					$('body').append(data);
					html = $("#tmpl-"+$shortcode).html();
					$.HandleElement.appendToHolderFinish($shortcode, html, $replaces, append_to_div, $type, elem_title);
				});
			}
			else{
				html = $("#tmpl-"+$shortcode).html();
				$.HandleElement.appendToHolderFinish($shortcode, html, $replaces, append_to_div, null, elem_title);
			}
		}
	},
	$.HandleElement.elTitle = function($shortcode, clk_title_el, exclude_this){

        if(typeof(clk_title_el) == 'undefined' || clk_title_el == '')
            return '';
        var count_element = $(".wr-mm-form-container").find("a.element-edit[data-shortcode='"+$shortcode+"']").length;
        exclude_this = (exclude_this != null) ? exclude_this : 0;
        clk_title_el = $.trim(clk_title_el.replace(/<p\sclass.*>(.*)<\/p>/, ''));
        return clk_title_el + ' ' + parseInt(count_element + 1 - exclude_this);

	},


	$.HandleElement.appendToHolderFinish = function($shortcode, html, $replaces, append_to_div, $type, elem_title) {
		// hide popover
		$("#wr-add-element").hide();
		// count existing elements which has same type
		append_title_el = $.HandleElement.elTitle($shortcode, clk_title_el);
		if ( append_title_el.indexOf('undefined') >= 0 ) {
			append_title_el = ''
		}
		if ( elem_title ) {
			append_title_el = elem_title;
		}

		if($type != null && $type == 'widget'){
			html = wr_mm_remove_placeholder(html, 'widget_title', 'title='+append_title_el);
		}else{
			html = html.replace(/el_title=\"\"/, 'el_title="'+append_title_el+'"');
		}
		$(".active-shortcode").removeClass('active-shortcode');
		$(".wr-selected-element").removeClass('wr-selected-element');
		html = wr_mm_remove_placeholder(html, 'extra_class', 'wr-selected-element');
		if($replaces != null){
			html = wr_mm_remove_placeholder(html, 'index', $replaces['index']);
		}
		else{
			var idx = 0;
			html = wr_mm_remove_placeholder(html, 'index', function(match, number){
				return ++idx;
			});
		}
		// animation
		append_to_div.append(wr_mm_remove_placeholder(html, 'custom_style', 'style="display:none"'));
		var new_el = append_to_div.find('.jsn-element').last();
		var height_ = new_el.height();
		$.HandleElement.appendElementAnimate(new_el, height_);

		// Show loading image
		if ( $(append_to_div).find('.jsn-item').length ) {
			$(append_to_div).find('.jsn-item').last().append('<i class="jsn-icon16 jsn-icon-loading"></i>');
		}

		// open Setting Modal box right after add new element
		$(".wr-selected-element .element-edit").trigger('click');
	}

	// animation when add new element to container
	$.HandleElement.appendElementAnimate = function(new_el, height_, callback, finished){
		var obj_return = {
			obj_element:new_el
		};
		$('body').trigger('on_clone_element_item', [obj_return]);
		new_el = obj_return.obj_element;
		new_el.css({
			'min-height' : 0,
			'height' : 0,
			'opacity' : 0
		});
		new_el.addClass('padTB0');
		if(callback)callback();
		new_el.show();
		new_el.animate({
			height: height_
		},500,$.options.effect, function(){
			$(this).animate({
				opacity:1
			},300,$.options.effect,function(){
				new_el.removeClass('padTB0');
				new_el.css('height', 'auto');
				$('body').trigger('on_update_attr_label_common');
				$('.wr-mm-form-container').trigger('wr-megamenu-layout-changed');
				if(finished)finished();
			});
		});
	}

	/**
	 * Remove an element in WR MegaMenu / In Modal
	 */
	$.HandleElement.removeElement = function(element) {
		element.css({
			'min-height' : 0,
			'overflow' : 'hidden'
		});
		element.animate({
			opacity:0
		},300,$.options.effect,function(){
			element.animate({
				height:0,
				'padding-top' : 0,
				'padding-bottom' : 0
			},300,$.options.effect,function(){
				element.remove();
				$('body').trigger('on_after_delete_element');
				// for shortcode which has sub-shortcode
				if ($("#modalOptions").find('.has_submodal').length > 0){
					$.HandleElement.rescanShortcode();
				}
				$('.wr-mm-form-container').trigger('wr-megamenu-layout-changed');
			});
		});
	},


	// Clone an Element
	$.HandleElement.cloneElement = function() {
		$(".wr-mm-form-container").delegate(".element-clone","click",function(){
			if($.PbDoing.cloneElement)
				return;
			$.PbDoing.cloneElement = 1;

			var parent_item = $(this).parent('.jsn-iconbar').parent('.jsn-item');
			var height_ = parent_item.height();
			var clone_item = parent_item.clone(true);

			var item_class = $('#modalOptions').length ? '.jsn-item-content' : '.wr-mm-element';
			// update title for clone element
			var html = clone_item.html();
			if(item_class == '.jsn-item-content')
				append_title_el = parent_item.find(item_class).html();
			else
				append_title_el = parent_item.find(item_class).find('span').html();
			if (append_title_el) {
				var regexp = new RegExp(append_title_el, "g");
				html = html.replace(regexp, append_title_el + ' ' + Wr_Megamenu_Translate.copy);
			}
			clone_item.html(html);

			// add animation before insert
			$.HandleElement.appendElementAnimate(clone_item, height_, function(){
				clone_item.insertAfter(parent_item);
				if($('.wr-mm-form-container').hasClass('fullmode')){
					// active iframe preview for cloned element
					$(clone_item[0]).find('form.shortcode-preview-form').remove();
					$(clone_item[0]).find('iframe').remove();
					$.HandleElement.turnOnShortcodePreview(clone_item[0]);
				}

				$.HandleElement.rescanShortcode();
			}, function(){
				$.PbDoing.cloneElement = 0;
			});
		});
	},

	// Deactivate an Element
	$.HandleElement.deactivateElement = function() {
		$(".wr-mm-form-container").delegate(".element-deactivate","click",function(){
			var parent_item = $(this).parents('.jsn-item');
			var textarea	= parent_item.find("[data-sc-info^='shortcode_content']").first();
			var textarea_text = textarea.text();

			var child_i = $(this).find('i');
			if(child_i.hasClass('icon-checkbox-partial')){
				textarea_text = textarea_text.replace('disabled_el="yes"', 'disabled_el="no"');
				// update icon
				child_i.removeClass('icon-checkbox-partial').addClass('icon-checkbox-unchecked');
				// update title
				$(this).attr('title', Wr_Megamenu_Translate.disabled.deactivate);
			} else {
				if ( textarea_text.indexOf('disabled_el="no"') > 0 ) {
					textarea_text = textarea_text.replace('disabled_el="no"', 'disabled_el="yes"');
				} else {
					textarea_text = textarea_text.replace(']', ' disabled_el="yes" ]');
				}
				// update icon
				child_i.removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-partial');
				// update title
				$(this).attr('title', Wr_Megamenu_Translate.disabled.reactivate);
			}
			parent_item.toggleClass('disabled');
			// replace shortcode content
			textarea.text(textarea_text);
			$('.wr-mm-form-container').trigger('wr-megamenu-layout-changed');
		});
	},

	// Edit an Element in WR MegaMenu / in Modal
	$.HandleElement.editElement = function() {


        $('body').on('click', '.item-container-content .jsn-element', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ( $(e.target).closest('.jsn-iconbar').length || $(e.target).hasClass('drag-element-icon') ) {
                return false;
            }
            $(this).find('.jsn-iconbar .element-edit').trigger('click');
        });


		$(".wr-mm-form-container").delegate(".element-edit","click",function(e, restart_edit){

            e.preventDefault();
            if($(this).attr('data-custom-action'))
				return;

			$.HandleElement.showLoading();

			if($.PbDoing.editElement && restart_edit == null)
				return;

			$.PbDoing.editElement = 1;

			$(".wr-selected-element").removeClass('wr-selected-element');
			$(".wr-mm-form-container .active-shortcode").removeClass('active-shortcode');
			var parent_item, shortcode = $(this).attr("data-shortcode"), el_title = '';

			// Set temporary flag to sign current editted element
			var cur_shortcode    = $(this).parents('.jsn-item').find('textarea.shortcode-content:first');
			var editted_flag_str = '#_EDITTED';
			if (cur_shortcode.length > 0) {
				cur_shortcode.html(cur_shortcode.val().replace('[' + shortcode, '[' + shortcode + ' ' + editted_flag_str + ' ' ));
			}

			if($(this).hasClass('row')){
				parent_item = $(this).parent('.jsn-iconbar').parent('.jsn-row-container');
				el_type		= 'element';
			}
			else{
				parent_item = $(this).parent('.jsn-iconbar').parent('.jsn-item');
				el_type		= parent_item.attr('data-el-type');
			}
			parent_item.addClass('active-shortcode');

			$.HandleElement.removeModal();

			if(el_type == 'widget'){
				el_title = $.HandleElement.elTitle(shortcode, clk_title_el, 1);
			}

			if (!el_title) {
				el_title = Wr_Megamenu_Translate.no_title;
			}

			var params		= parent_item.find("[data-sc-info^='shortcode_content']").first().text();

			var title = $.HandleElement.getModalTitle(shortcode, parent_item.attr('data-modal-title'));
			var frameId = $.options.modal_settings.modalId;
			var has_submodal = 0;
			if( $(this).parents('.has_submodal').length > 0 ){
				has_submodal = 1;
				frameId = $.options.modal_settings.sub_modalId;
			}

			if( $(this).parents('.has_childsubmodal').length > 0 ){
				has_submodal = 1;
				frameId = $.options.modal_settings.sub_modalChildId;
			}

			var frame_url = Wr_Megamenu_Ajax.wr_modal_url + '&wr_modal_type=' + shortcode;

			var form = $("<form/>").attr({
				method: "post",
				style: "display:none",
				action: frame_url
			});
			form.append($("<input/>").attr( {name : "shortcode", value : shortcode} ) );
			form.append($("<textarea/>").attr( {name : "params", value : params} ) );
			form.append($("<input/>").attr( {name : "el_type", value : el_type} ) );
			form.append($("<input/>").attr( {name : "el_title", value : el_title} ) );
			form.append($("<input/>").attr( {name : "submodal", value : has_submodal} ) );
            // add these code for submenu element

           if (shortcode== 'wr_submenu') {
                form.append($("<input/>").attr( {name : "menu_type", value : $('#selected_menu_type').val()} ) );
                form.append($("<input/>").attr( {name : "menu_id", value : $('#selected_menu_id').val()} ) );
            }

			// Check if this element require iframe for editing
			var parent_shortcode = shortcode.replace('_item', '');
            		var iframe_required = !parseInt($('button.shortcode-item[data-shortcode="' + parent_shortcode + '"]').attr('data-use-ajax'));
            iframe_required = 0; // fix for editing row

			var modal = new $.WRModal({
				iframe: iframe_required,
				frameId: frameId,
				dialogClass: 'wr-dialog jsn-bootstrap3',
				jParent : window.parent.jQuery.noConflict(),
				title: $.HandleElement.remove_underscore_ucwords(title),
				///url: Wr_Megamenu_Ajax.wr_modal_url + '&wr_modal_type=' + shortcode,
				buttons: [{
					'text'  : Wr_Megamenu_Ajax.delete,
					'id'    : 'delete_element',
					'class' : 'btn btn-danger pull-right',
					'click' : function() {

						var current_element = '';
						if ( $('.active-shortcode').length == 1 )
							current_element = $('.active-shortcode');
						if ( $('.wr-selected-element').length ==1 )
							current_element = $('.wr-selected-element');

						if ( current_element && $.HandleCommon.removeConfirmMsg( current_element, 'element' ) ) {
							$.HandleElement.closeModal(iframe_required ? window.parent.jQuery.noConflict()( '#' + frameId ) : modal.container);
						}
					}
				}, {
					'text'	: Wr_Megamenu_Ajax.cancel,
					'id'	: 'close',
					'class' : 'btn btn-default ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
					'click'	: function() {

                       // $.HandleElement.closeModal(iframe_required ? window.parent.jQuery.noConflict()( '#' + frameId ) : modal.container);
						$('body').trigger('add_exclude_jsn_item_class');

						var curr_iframe = iframe_required ? window.parent.jQuery.noConflict()('#' + frameId) : modal.container;
						var is_submodal = (iframe_required ? curr_iframe.contents() : curr_iframe).find('.submodal_frame').length;

						$.HandleElement.finalize(is_submodal);

						// Update Element Title to Active element (only for not child element)
						if (!$.options.new_sub_element && append_title_el) {
							var active_title = $(".wr-mm-form-container .active-shortcode").find('.wr-mm-element').first();

							if (active_title.length) {
								active_title.html(active_title.html().split(':')[0] + ": " + '<span>' + Wr_Megamenu_Translate.no_title + '</span>');
							}

							append_title_el = '';
						}

						// remove loading image from active child element
						$(".wr-mm-form-container .active-shortcode").find('.jsn-icon-loading').remove();

						$(".wr-mm-form-container .active-shortcode").removeClass('active-shortcode');

						$('body').trigger('on_update_shortcode_widget', 'is_cancel');
						// Remove editted flag
						var cur_shortcode   = $(".wr-mm-form-container .active-shortcode").find('textarea.shortcode-content:first');
						if (cur_shortcode.length > 0) {
							cur_shortcode.html(cur_shortcode.html().replace(new RegExp(editted_flag_str, 'g'), ''));
						}
					}
				},
                {
                    'text'	: Wr_Megamenu_Ajax.save,
                    'id'	: 'selected',
                    'class' : 'btn btn-primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only',
                    'click'	: function() {

                        $(this).attr('disabled', 'disabled');
                        $('body').trigger('add_exclude_jsn_item_class');
                        $.HandleElement.closeModal(iframe_required ? window.parent.jQuery.noConflict()( '#' + frameId ) : modal.container);
                        var cur_shortcode   = $(".wr-mm-form-container .active-shortcode").find('textarea.shortcode-content:first');
                        if (cur_shortcode.length > 0) {
                            cur_shortcode.html(cur_shortcode.html().replace(new RegExp(editted_flag_str, 'g'), ''));
                        }
                    }
                }
                ],
				loaded: function (obj, iframe) {
					$('body').trigger('wr_submodal_load',[iframe]);
					// Remove editted flag in shortcode content
					var shortcode_content   = $(iframe).contents().find('#shortcode_content');
					shortcode_content.html(shortcode_content.length ? shortcode_content.html().replace(new RegExp(editted_flag_str, 'g'), '') : '');

					// remove title of un-titled element
					var title = $(iframe).contents().find('[data-role="title"]').val();
					var index = wr_mm_get_placeholder( 'index' );
					if ( title != null && title.indexOf(index) >= 0 ) {
						$(iframe).contents().find('[data-role="title"]').val('');
					}
				},
				fadeIn:200,
				scrollable: true,
				width: $.HandleElement.resetModalSize(has_submodal, 'w'),
				height: $.HandleElement.resetModalSize(has_submodal, 'h')
			});

			modal.show(function(modal){

                $(window).resize(function() {
                    $.HandleElement.resizeDialog(null, $.HandleElement.resetModalSize(has_submodal, 'w'), $.HandleElement.resetModalSize(has_submodal, 'h'))
                });

				if (iframe_required) {
					// Append form to document body so it can be submitted
					$("body").append(form);

					// Set name for iframe
					window.parent.document.getElementById(frameId).name = frameId;
					window.parent.document.getElementById(frameId).src = 'about:blank';

					// Set form target
					form.attr('target', frameId);

					// Submit form data to iframe
					form.submit();

					// Remove form
					setTimeout(function(){form.remove();}, 200);
				} else {
					// Request server for necessary data
					$.ajax({
						url: frame_url + '&form_only=1',
						data: form.serializeArray(),
						type: 'POST',
						dataType: 'html',
						complete: function(data, status) {
							if (status == 'success') {

                                if ( $('#' + $.options.modal_settings.modalId).length == 0 ) {
                                    modal.container.attr('id', $.options.modal_settings.modalId);
                                }

								modal.container.html(data.responseText);
								setTimeout(function (){
									modal.container.dialog('open').dialog('moveToTop');
								}, 500);

                                // Only fire preview when open main modal
                                if ( $('.jsn-modal').last().attr('id') == $.options.modal_settings.modalId ) {
                                    var time_out = setTimeout( function() {
                                        $.HandleSetting.shortcodePreview();
                                        clearTimeout(time_out);
                                    }, 300 );
                                }
                                // Setting trigger preview for elements
                                $.HandleElement.bindShortcodePreviewElements();

                                if ( $('.jsn-modal').last().attr('id') != $.options.modal_settings.modalId ) {
                                    $('body').trigger('wr_submodal_load',[modal.container]);
                                }

                            }
						}
					});
				}



			});

			setTimeout(function(){
				if($('.wr-dialog').length < 1 && $('.jsn-modal-overlay').is(':visible')){
					$.HandleElement.hideLoading();
				}
			}, 3000);

		});
	},

    // Bind event show shortcode preview
    $.HandleElement.bindShortcodePreviewElements = function () {
        // for icon-selector only in main modal
        if ( ( $('.jsn-modal').last().attr('id') == $.options.modal_settings.modalId ) && $('#modalOptions #icon_selector .jsn-items-list').length ) {
            var cache_icon_active = $('#modalOptions #icon_selector .jsn-items-list .active i').attr('class');

            $('#modalOptions #icon_selector .jsn-items-list').on('click', function () {
                var current_active_class = $(this).find('.active i').attr('class');
                if ( current_active_class != cache_icon_active ) {
                    var time_out = setTimeout( function() {
                        $.HandleSetting.shortcodePreview();
                        clearTimeout(time_out);
                    }, 300 );
                    cache_icon_active = current_active_class;
                }
            });
        }
    }

    // Remove select2 active
    $.HandleElement.removeSelect2Active = function () {
        $('.select2-drop-active').remove();
    }

    // Disable page scroll
    $.HandleElement.disablePageScroll = function() {
        if ( $('body').hasClass('wp-admin') ) {
            $('body').addClass('wr-overflow-hidden');
        }
    }

    // resize dialog
    $.HandleElement.resizeDialog = function (container, w, h) {

        if (container == null) {
            container = $('.jsn-modal:last');
        }

        if ((container.find('#menu-styling').length > 0) && !(container.find('#menu-styling').is(":visible"))) {
            return;
        }

        if (container.length > 0) {
            container.dialog('option', 'width', w);
            container.dialog('option', 'height', h);
            container.dialog('option', 'position', 'center');
        }

    }

    // Enable page scroll
    $.HandleElement.enablePageScroll = function() {
        if ( $('body').hasClass('wp-admin') ) {
            $('body').removeClass('wr-overflow-hidden');
        }
    }

	// fix error of TinyMCE on Modal setting iframe
	$.HandleElement.fixTinyMceError = function(){
		$('#content-html').trigger('click');
	},

	/*******************************************************************
	 * 4. Modal
	 ******************************************************************/

	/**
	 * Generate Title for Modal
	 */
	$.HandleElement.getModalTitle = function(shortcode, modal_title) {
		var title = Wr_Megamenu_Translate.page_modal;
		if (shortcode != '') {
			if(modal_title)
				title = modal_title;
			else{
				shortcode = shortcode.replace('wr_','').replace('_',' ');
				title = $.HandleElement.capitalize(shortcode);
			}
		}
		return title + ' ' + Wr_Megamenu_Translate.settings;
	},

	/**
	 * Remove Modal, Show Loading, Hide Loading
	 */
	$.HandleElement.removeModal = function() {

        if ($('.jsn-modal > #menu-styling').length > 0) {

        } else {
            $('.jsn-modal').remove();
        }

	},

	// Show Overlay & Loading of Modal
	$.HandleElement.showLoading = function(container) {
		container	= container ? container : 'body'
		var $selector = $;//window.parent.jQuery.noConflict();

		var $overlay = $selector('.jsn-modal-overlay');
		if ($overlay.size() == 0) {
			$overlay = $('<div/>', {
				'class': 'jsn-modal-overlay'
			});
		}

		var $indicator = $selector('.jsn-modal-indicator');
		if ($indicator.size() == 0) {
			$indicator = $('<div/>', {
				'class': 'jsn-modal-indicator'
			});
		}


		$selector(container)
		.append($overlay)
		.append($indicator);
		$overlay.css({
			'z-index': 100
		}).show();
		$indicator.show();

		return $indicator;
	},

	// Hide Overlay of Modal
	$.HandleElement.hideLoading = function(container) {
		container = container ? $(container) : $('body');
		var $selector = $;//window.parent.jQuery.noConflict()
		$selector('.jsn-modal-overlay', container).hide();
		$selector('.jsn-modal-indicator', container).hide();
	},

	/**
	 * Extract shortcode params of sub-shortcodes, then update merged
	 * data to a #div
	 */
	$.HandleElement.extractParam = function(shortcode_, param_,
		updateTo_) {
		var sub_data = [];
		$("#modalOptions #group_elements .jsn-item").each(function() {
			sub_data.push($(this).find('textarea').text());
		});
		$.post(Wr_Megamenu_Ajax.ajaxurl, {
			action : 'shortcode_extract_param',
			param : param_,
			shortcode : shortcode_,
			data : sub_data.join(""),
			wr_nonce_check : Wr_Megamenu_Ajax._nonce
		}, function(data) {
			$(updateTo_).text(data);
		});
	},

	/**
	 * For Parent Shortcode: Rescan sub-shortcodes content, call preview
	 * function to regenerate preview
	 */
	$.HandleElement.rescanShortcode = function(curr_iframe, callback) {
		try {
			$.HandleSetting.shortcodePreview(null, null, curr_iframe, callback);
		} catch (err) {
			// Do nothing
		}
	},

	/**
	 * save shortcode data before close Modal
	 */
	$.HandleElement.closeModal = function(curr_iframe) {
		$.options.curr_iframe_ = curr_iframe;

		var	contents = curr_iframe.contents ? curr_iframe.contents() : curr_iframe,
            submodal = contents.find('.has_submodal'),
            submodal2 = curr_iframe.contents().find('.submodal_frame_2');

        if(submodal2.length > 0) {

            $.options.if_childmodal = 1;
            // call Preview to get content of params + tinymce. Finally, update #shortcode_content, Close Modal, call Preview of parents shortcode
            // for sub modal child
            $.HandleElement.rescanShortcode(curr_iframe, function(){
                $.HandleElement.updateBeforeClose(null, window.parent.jQuery.noConflict()('#'+$.options.modal_settings.modalId));
            });
        }
		else if( submodal.length > 0 ) {

			// Advance shortcodes like Tabs, Accordion
			$.HandleElement.updateBeforeClose();
		} else {

			if (contents.find('.submodal_frame').length) {

				$.options.if_childmodal = 1;

				// Call Preview to get content of params + tinymce. Finally, update #shortcode_content, Close Modal, call Preview of parents shortcode
				$.HandleElement.rescanShortcode(curr_iframe, function() {
					if (window.parent) {
						$.HandleElement.finishCloseModal(curr_iframe, window.parent.jQuery.noConflict()('#' + $.options.modal_settings.modalId));
					} else {
						$.HandleElement.finishCloseModal(curr_iframe, $('#' + $.options.modal_settings.modalId));
					}
				});
            } else {
				$.HandleElement.finishCloseModal(curr_iframe);
			}
		}
	},

	/**
	 * Parent shortcode like Tab, Accordion: Collect sub shortcodes
	 * content and update to #shortecode_content before close
	 */
	$.HandleElement.updateBeforeClose = function(action_data, update_iframe) {

		if(action_data != null){
			$.options.curr_iframe_ = window.parent.jQuery.noConflict()( '#' + $.options.modal_settings.modalId);
		}
		// get sub-shorcodes content
		var sub_items_content = [];
		$.options.curr_iframe_.contents().find( "#modalOptions [name^='shortcode_content']" ).each(function() {
			sub_items_content.push($(this).text());
		})
		sub_items_content = sub_items_content.join('');

		// update parent shortcode
		var shortcode_content = $.options.curr_iframe_.contents().find( '#shortcode_content' ).text();

		var arr = shortcode_content.split('][');
		if(arr.length >= 2){
			var data = arr[0] + ']' + sub_items_content + '[' + arr[arr.length - 1];
			$.options.curr_iframe_.contents().find( '#shortcode_content' ).text(data);
			$.HandleElement.finishCloseModal($.options.curr_iframe_, update_iframe, action_data);
		} else {
			$.HandleElement.finishCloseModal($.options.curr_iframe_, update_iframe, action_data);
		}
	},

	/**
	 * update shortcode-content & close Modal & call preview (shortcode
	 * has sub-shortcode) action_data: null (Save button) OR { 'convert' :
	 * 'tab_to_accordion'}
	 */
	$.HandleElement.finishCloseModal = function(curr_iframe, update_iframe, action_data) {
		var	contents = curr_iframe.contents ? curr_iframe.contents() : curr_iframe,
			shortcode_content = contents.find( '#shortcode_content' ).text();

		// Trigger update shortcode for WR MegaMenu widget element
		$('body').trigger('on_update_shortcode_widget', [shortcode_content]);

		var in_sub_modal = window.parent && window.parent.jQuery.noConflict()('#jsn_view_modal_sub').length;

		if (!top.addInClassic || in_sub_modal) {
			var item_title = "", title_prepend, title_prepend_val = "";

			if (contents.find('[data-role="title"]').length) {
				title_prepend = contents.find('[data-role="title_prepend"]');
				title_prepend_val = '';

				if (title_prepend.length) {
					title_prepend = title_prepend.first();

					var title_prepend_type = title_prepend.attr("data-title-prepend");

					title_prepend_val = title_prepend.val();

					if (typeof(title_prepend_val) != "undefined" && Wr_Megamenu_Js_Html[title_prepend_type]) {
						if(title_prepend.val() == '' && title_prepend_type == 'icon') {
							title_prepend_val = '';
						} else {
							title_prepend_val = wr_mm_remove_placeholder(Wr_Megamenu_Js_Html[title_prepend_type], 'standard_value', title_prepend.val());
						}
					}
				}

				item_title = title_prepend_val + contents.find('[data-role="title"]').first().val();
			}

			if (contents.find('#wr-widget-form').length) {
				title_prepend = contents.find('#wr-widget-form').find("input:text[name$='[title]']");
				item_title = title_prepend.val();
			}

			item_title = item_title.replace(/\[/g,"").replace(/\]/g,"");

			if ( !item_title ) {
				item_title = Wr_Megamenu_Translate.no_title;
			}

			$.HandleElement.updateActiveElement(update_iframe, shortcode_content, item_title, action_data);
		}

		if (top.addInClassic || ! in_sub_modal) {
			// update to textarea of Classdic Editor

			// inserts the shortcode into the active editor
			if (typeof tinymce != 'undefined' && tinymce.activeEditor) {
				tinymce.activeEditor.execCommand('mceInsertContent', 0, shortcode_content);
			}

			// closes Thickbox
//			tb_remove(); testing
		}

		if ($.options.if_childmodal) {
			// Update Tags of sub-element in Accordion
			if ($("#modalOptions #shortcode_name").val() == "wr_accordion") {
				$.HandleElement.extractParam("wr_accordion", "tag", "#wr_share_data");
			}

			// Rescan sub-element shortcode of Parent element (Accordion, Tab...)
			$.HandleElement.rescanShortcode();
		}

		$.HandleElement.finalize($.options.if_childmodal);
	},

	/**
	 * Update to active element
	 */
	$.HandleElement.updateActiveElement = function(update_iframe, shortcode_content, item_title, action_data) {
		var active_shortcode = $.HandleElement.selector(update_iframe,".wr-mm-form-container .active-shortcode");
		var editted_flag_str = '#_EDITTED';
		if(active_shortcode.hasClass('jsn-row-container'))
			shortcode_content = shortcode_content.replace('[/wr_megamenu_row]','');
		active_shortcode.find("[data-sc-info^='shortcode_content']").first().text(shortcode_content);

		// update content to current active sub-element in group elements (Accordions, Tabs...)
		var item_class = ($.options.if_childmodal) ? ".jsn-item-content" : ".wr-mm-element";
		// if sub modal, use item_title as title. If in megamenu, show like this (Element Type : item_title)
		if(!$.options.if_childmodal && active_shortcode.find(item_class).first().length){
			if(item_title != '')
				item_title = active_shortcode.find(item_class).first().html().split(':')[0] + ": " + '<span>'+item_title+'</span>';
			else
				item_title = active_shortcode.find(item_class).first().html().split(':')[0];
		}

		if ( ! item_title || item_title == "<i class=''></i>" )
			item_title = Wr_Megamenu_Translate.no_title;
		active_shortcode.find(item_class).first().html(item_title);
		// update content to current active Cell in Table
		if(window.parent.jQuery.noConflict()( '#jsn_view_modal_sub').contents().find('#shortcode_name').val() == "wr_item_table"){
			var table = new $.WRTable();
			table.init(active_shortcode);
		}

		var element_html = active_shortcode.html();
		var action_;
		if(action_data != null){
			$.each(action_data, function(action, data){
				action_ = action;
				if(action == "convert")
				{
					var arr = data.split('_');
					if(arr.length == 3)
					{
						var regexp = new RegExp("wr_"+arr[0], "g");
						element_html = element_html.replace(regexp, "wr_"+arr[2]);

						regexp = new RegExp("wr_item_"+arr[0], "g");
						element_html = element_html.replace(regexp, "wr_item_"+arr[2]);
						//Shortcode name in MegaMenu
						regexp = new RegExp($.HandleElement.capitalize(arr[0]), "g");
						element_html = element_html.replace(regexp, $.HandleElement.capitalize(arr[2]));
						//"Convert to" button
						regexp = new RegExp(Wr_Megamenu_Translate.convertText + arr[2], "g");
						element_html = element_html.replace(regexp, Wr_Megamenu_Translate.convertText + arr[0]);
					}

				}
			})

		}
		if (typeof(element_html) != 'undefined') {
			// Remove editted flag
			element_html	= element_html.replace(new RegExp(editted_flag_str, 'g'), '');
		}
		active_shortcode.html(element_html);
		// reopen Modal with Converted Shortcode
		if(action_ == "convert")
			active_shortcode.find(".element-edit").trigger('click', [true]);
		else
			active_shortcode.removeClass('active-shortcode');
		$.HandleSetting.updateState(0);
		// Hide Loading in Group elements
		if ( $(active_shortcode).parents('#group_elements').length ) {
			$(active_shortcode).parents('#group_elements').find('.jsn-item').last().find('.jsn-icon-loading').remove();
		}

		// Check if in Fullmode, then turn live preview on

		if ($(active_shortcode).parents('.wr-mm-form-container.fullmode').length > 0) {
			$.HandleElement.turnOnShortcodePreview(active_shortcode);
		}


		/* Update package attribute label common json */
		$('body').trigger('on_update_attr_label_common');
		$('body').trigger('on_update_attr_label_setting');

	}

	// finalize when click Save/Cancel modal
	$.HandleElement.finalize = function(is_submodal, remove_modal){
		// remove modal
		if(remove_modal || remove_modal == null) {
            if (window.parent.jQuery.noConflict()('.jsn-modal').last().find('> #menu-styling').length == 0 ) {
                window.parent.jQuery.noConflict()('.jsn-modal').last().remove();
            }
        }

		$(".wr-mm-form-container").find('.jsn-icon-loading').remove();

		// reset/update status
		$.options.if_childmodal = 0;
		$.PbDoing.addElement = 0;
		$.PbDoing.editElement = 0;

		// remove overlay & loading
		if(!is_submodal) {
			$.HandleElement.hideLoading();
			$.HandleElement.removeModal();
		}
		$('.wr-mm-form-container').trigger('wr-megamenu-layout-changed');
	}


	$.HandleElement.checkSelectMedia = function() {
		$('body').delegate('#wr-select-media', 'change', function () {
			var currentValue = $(this).val();
			if ( currentValue ) {
				var jsonObject = JSON.parse( currentValue );
				$('#wr-select-media').val('');
				var send_attachment_bkp = wp.media.editor.send.attachment;
				var button 				= $(this);

				if (typeof(jsonObject.type) != undefined) {
					var _custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							var select_url 	= attachment.url;

							if ( props.size && attachment.type == jsonObject.type) {
								var select_prop 	= props.size;
								var object 			= {};
								object.type			= 'media_selected';
								object.select_prop	= select_prop;
								object.select_url	= select_url;
								$('#wr-select-media').val(JSON.stringify(object));
							}
						} else {
							return _orwr_send_attachment.apply( this, [props, attachment] );
						};

					}
					// Open wp media editor without select multiple media option
					wp.media.editor.open(button, {
						multiple: false
					});
				}else{
					// Open wp media editor without select multiple media option
					wp.media.editor.open(button, {
						multiple: false
					});
				}
			}
		});
	}


	/**
	 * Turn live preview of a shortcode on
	 */
	$.HandleElement.turnOnShortcodePreview	= function (shortcode_wrapper){
		// Create form and iframe used for submitting data
		// to preview.
		var _rnd_id				= randomString(5);
		var _shortcode_params	= $(shortcode_wrapper).find('textarea.shortcode-content').clone();
		_shortcode_params.attr('name', 'params').removeAttr('data-sc-info').removeClass('shortcode-content');

		var _shorcode_name		= $(shortcode_wrapper).find('textarea.shortcode-content').attr('shortcode-name');
		if ( typeof(_shorcode_name) == 'undefined' || _shorcode_name == null ) {
			return;
		}
		$(shortcode_wrapper).find('.jsn-overlay').show();

		if ($(shortcode_wrapper).find('form.shortcode-preview-form').length == 0){
			var _form				= $('<form/>', {
				'class': 'shortcode-preview-form',
				'method': 'post',
				'target': 'iframe-' + _rnd_id,
				'action': Wr_Megamenu_Ajax.wr_modal_url + '&wr_shortcode_preview=1' + '&wr_shortcode_name=' + _shorcode_name + '&wr_nonce_check=' + Wr_Megamenu_Ajax._nonce
			});
			var _iframe				= $('<iframe/>', {
				'scrolling': 'no',
				'id': 'iframe-' + _rnd_id,
				'name': 'iframe-' + _rnd_id,
				'width': '100%',
				'height': '50',
				'class': 'shortcode-preview-iframe'
			});
			var _preview_container	= $(shortcode_wrapper).find('.shortcode-preview-container');

			// Append cloned shortcode content to temporary form

			_shortcode_params.appendTo(_form);

			// Append form and iframe to shorcode preview div
			_form.appendTo(_preview_container);
			_iframe.appendTo(_preview_container);
			_form.submit();
		}else{
			var _form	= $(shortcode_wrapper).find('form.shortcode-preview-form').first();
			_form.find('textarea').remove();
			_shortcode_params.appendTo(_form);
			_form.submit();
			_iframe	= $('#' + _form.attr('target'));
		//_iframe.css('height', '50');
		}

		$('.shortcode-preview-container', shortcode_wrapper).show();
		// Show preview content after preview iframe loaded successfully
		_iframe.on('load', function (){
			// Return if current mode is not Full mode
			var cur_url			= window.location.search.substring(1);
			if ($.HandleElement.getCookie('wr-mm-mode-' + cur_url) != 2) {
				return;
			}

			var self	= this;
			var	_frame_id	= $(this).attr('id');
			setTimeout(function (){
				$(self).contents().find('#shortcode_inner_wrapper').css({
					'height': 'auto',
					'width': $(self).width()
				});
				if (document.getElementById(_frame_id).contentWindow.document.getElementById('shortcode_inner_wrapper')){
					var _contentHeight	= document.getElementById(_frame_id).contentWindow.document.getElementById('shortcode_inner_wrapper').scrollHeight - 10;
					$(self).height(_contentHeight) ;
					$(self).contents().find('#shortcode_inner_wrapper').height(_contentHeight);
				}

			}, 100);
			$(this).parents('.jsn-item').find('.jsn-overlay').hide('slow');
			// Hide shorcode title when iframe loaded
			$(this).parents('.jsn-item').find('.wr-mm-element').hide('slow');
			// update content for Classic editor - to make php "Save post hook" works well
			var tab_content = '';
			$(".wr-mm-form-container textarea[name^='shortcode_content']").each(function(){
				tab_content += $(this).val();
			});
			$.HandleElement.updateClassicEditor(tab_content);
		});
	}

	/**
	 * Update UI of WR MegaMenu
	 */
	$.HandleElement.updateMegamenu = function (tab_content, callback){
		// disable WP Update button
		$('#publishing-action #publish').attr('disabled', true);
		// show loading indicator
		$(".wr-mm-form-container").css('opacity',0);
		$("#wr-mmd-loading").css('display','block');
		if($.trim(tab_content) != ''){
			$.post(
					Wr_Megamenu_Ajax.ajaxurl,
				{
					action 		: 'text_to_pagebuilder',
					content   : tab_content,
					wr_nonce_check : Wr_Megamenu_Ajax._nonce
				},
				function( data ) {
					self_(data);
				});
		}
		else
			self_('');

		function self_(data){
			// remove current content of WR MegaMenu
			$("#jsn-add-container").prevAll().remove();

			// insert placeholder text to &lt; and &gt; before prepend, then replace it
			data = wr_mm_add_placeholder( data, '&lt;', 'wrapper_append', '&{0}lt;');
			data = wr_mm_add_placeholder( data, '&gt;', 'wrapper_append', '&{0}gt;');
			$(".wr-mm-form-container").prepend(data);
			$(".wr-mm-form-container").html(wr_mm_remove_placeholder($(".wr-mm-form-container").html(), 'wrapper_append', ''));

			if(callback != null)
				callback();

			// show WR MegaMenu
			$("#wr-mmd-loading").hide();
			$(".wr-mm-form-container").animate({
				'opacity':1
			},200,'easeOutCubic');

			// active WP Update button
			$('#publishing-action #publish').removeAttr('disabled');
		}
	}

	/**
	 * Update Content of Classic Editor
	 */
	$.HandleElement.updateClassicEditor	= function (tab_content, callback){
		// update Visual tab content
		if(tinymce.get('content'))
			tinymce.get('content').setContent(tab_content);
		// update Text tab content

		$("#wr_editor_tab1 #content").val(tab_content);

		if(callback != null)
			callback();
		// active WP Update button
		$('#publishing-action #publish').removeAttr('disabled');
	}

	// Disable click on a tag inside preview iframe
	$.HandleElement.disableHref = function() {
		$('#modalOptions a:not(.preview-submenu), #shortcode_inner_wrapper a:not(.preview-submenu)').click(function(e){
			e.preventDefault();
		});
		// disable form submit
		$('#shortcode_inner_wrapper form').submit(function(e){
			e.preventDefault();
			return false;
		});
	}

	/**
	 * Update Content of Classic Editor
	 */
	$.HandleElement.getContent	= function (){
		var tab_content = '';
		$(".wr-mm-form-container.jsn-layout textarea[name^='shortcode_content']").each(function(){
			tab_content += $(this).val();
		});
		return tab_content;
	}

	/**
	 * Deactivate element
	 */
	$.HandleElement.deactivateShow = function() {
		// Disable element
		$('.shortcode-content').each(function(){
			var content = $(this).val();
			var shortcode = $(this).attr('shortcode-name');
			var regex = new RegExp("\\[" + shortcode + '\\s' + '([^\\]])*' + 'disabled_el="yes"' + '([^\\]])*' + '\\]', "g");
			var val = regex.test(content);
			if (val) {
				$(this).parent().addClass('disabled');
				var deactivate_btn = $(this).parent().find('.element-deactivate');
				deactivate_btn.attr('title', Wr_Megamenu_Translate.disabled.reactivate);
				deactivate_btn.find('i').attr('class', 'icon-checkbox-partial');
			}

		});
	}

	/**
	 * Custom CSS for post
	 */
	$.HandleElement.customCss = function () {

		// Show modal
		var modal_width = 600;
		var frameId = 'wr-custom-css-modal';
		var modal;

		var post_id = $('#wr-mm-css-value').val();
		var frame_url = Wr_Megamenu_Ajax.wr_modal_url  + '&wr_custom_css=1' + '&pid=' + post_id;

		$('#page-custom-css').click(function(e){
            e.preventDefault();
			if( input_enter ) {
				return;
			}
			modal = new $.WRModal({
				frameId: frameId,
				dialogClass: 'wr-dialog jsn-bootstrap3',
				jParent : window.parent.jQuery.noConflict(),
				title: Wr_Megamenu_Translate.custom_css.modal_title,
				url: frame_url,
				buttons: [{
					'text'	: Wr_Megamenu_Ajax.save,
					'id'	: 'selected-custom-css',
					'class' : 'btn btn-primary',
					'click'	: function () {

						var jParent = window.parent.jQuery.noConflict();

						// Get css files (link + checked status), save custom css
						var iframe_content = jParent( '#' + frameId ).contents();

						var css_files = [];
						iframe_content.find('#wr-mm-custom-css-box').find('.jsn-items-list').find('li').each(function(i){
							var input = $(this).find('input');
							var checked = input.is(':checked');
							var url = input.val();

							var item = {
								"checked": checked,
								"url": url
							};
							css_files.push(item);
						});
						var css_files = JSON.stringify({data: css_files});

						// get Custom css code
						var custom_css = iframe_content.find('#custom-css').val();

						// save data
						$.post(
							Wr_Megamenu_Ajax.ajaxurl,
							{
								action 		: 'wr_megamenu_save_css_custom',
								post_id	: post_id,
								css_files   : css_files,
								custom_css   : custom_css,
								wr_nonce_check : Wr_Megamenu_Ajax._nonce
							},
							function( data ) {
								// close loading
								$.HandleElement.hideLoading();
						});

						// close modal
						$.HandleElement.finalize(0);
						// show loading
						$.HandleElement.showLoading();
					}
				},{
					'text'	: Wr_Megamenu_Ajax.cancel,
					'id'	: 'close-cunstom-css',
					'class' : 'btn btn-default',
					'click'	: function () {
						$.HandleElement.hideLoading();
						// close modal
						$.HandleElement.finalize(0);
					}
				}],
				loaded: function (obj, iframe) {
				},
			fadeIn:200,
				scrollable: true,
				width: modal_width,
				height: $(window.parent).height()*0.9
			});
			modal.show();
		});
		// show tooltip
		$.HandleElement.initTooltip( '[data-toggle="tooltip"]', 'auto left' );
	}

	/**
	 * Recognize when hit Enter on textbox
	 */
	$.HandleElement.inputEnter = function() {
		$("input:text").keypress(function (e) {
			if (e.keyCode == 13) {
				input_enter = 1;
			} else {
				input_enter = 0;
			}
		});
    }

    /**
     * Extract shortcode parameters
     */
    $.HandleElement.extractScParam = function(shortcode_content) {
        var result = {};

        var regexp = /(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/g;
        var res = shortcode_content.match(regexp);
        for (var i = 0; i < res.length; i++){
            var key_val = res[i];
            if( ! ( key_val.indexOf('[') >= 0 || key_val.indexOf('=') < 0 ) ) {
                var arr     = key_val.split('=');
                var key     = arr[0];
                var value   = $.trim(arr[1]);

                value       = value.replace(/(^"|"$)/g, '');
                result[key] = value;
            }
        }

        return result;
	}

	/**
	 * Renerate a random string
	 */
    function randomString (length) {
		var result 	= '';
		var chars	= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
		return result;
	}

	/**
	 * Method to resize modal when window resized
	 */
    $.HandleElement.resetModalSize = function (has_submodal, _return) {
		var modal_width, modal_height;

		if( has_submodal == 0 ){
			modal_width = $(window).width()*0.9;
            var height   = $(window.parent).height() * 0.8;
            modal_height = ( height > 720 ) ? 720 : height;
		}
		else{
            var width    = parent.document.body.clientWidth * 0.9;
            modal_width  = (width > 750) ? 750 : width;
            var height   = parent.document.body.clientHeight*0.8;
            modal_height = ( height > 720 ) ? 720 : height;
		}
		if (_return == 'w'){
			return modal_width;
		}else{
			return modal_height;
		}
	}

	// Init WR MegaMenu element
	$.HandleElement.init = function() {
		$.HandleElement.inputEnter();
		$.HandleElement.addItem();
		$.HandleElement.addElement();
		$.HandleElement.deleteElement();
		$.HandleElement.editElement();
		$.HandleElement.cloneElement();
		$.HandleElement.deactivateElement();
		$.HandleElement.deactivateShow();
		$.HandleElement.customCss();
		$.HandleElement.checkSelectMedia();
		$.HandleElement.disableHref();
	};

	$(document).ready($.HandleElement.init);

	// Fix conflict click event
	$('.wr-element-container.wr-element-megamenu_image a').click(function(){

		var check_fancybox = $(this).hasClass( 'mm-image-fancy' );
		
		if(!check_fancybox){

			var url_image = $(this).attr('href');
			var url_black_image = $(this).attr('target');

			if(url_black_image == '_blank'){
				window.open(url_image, url_black_image);
			} else{
				window.location.href = url_image;
			}

		}

	})

})(jQuery);
