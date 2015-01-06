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

    function JSNLayoutCustomizer() { }
(function ($) {
    JSNLayoutCustomizer.prototype = {
        init:function (_this) {
            // Get necessary elements
            this.wrapper = $(".wr-mm-form-container.jsn-layout");
            this.wrapper_width = 0;
            this.columns = $(_this).find('.jsn-column-container');
            this.addcolumns = '.add-container';
            this.addelements = '.wr-more-element';
            this.resizecolumns = '.ui-resizable-e';
            this.deletebtn = '.item-delete';
            this.moveItemEl = "[class^='jsn-move-']";
            this.resize = 1;
            this.effect = 'easeOutCubic';

            // Initialize variables
            this.maxWidth = $('.wr-mm-form-container.jsn-layout').width();

            // Do this to prevent columns drop
            $('.wr-mm-form-container.jsn-layout').css('width', this.maxWidth + 'px');
            this.spacing = 12;
            var self    = this;

            // Has not inited before, so call all functions
            this.addRow(this, this.wrapper);
            this.updateSpanWidthPBDL(this, this.wrapper, this.maxWidth);
            this.initResizable(-1);
            this.addColumn($("#tmpl-wr_megamenu_column").html());
            this.removeItem();
            this.moveItem();
            this.moveItemDisable(this.wrapper);
            this.resizeHandle(this);
            this.addElement();
            this.showAddLayoutBox();
            this.showSaveLayoutBox();
            this.searchElement();
            this.rebuildSortable();
            this.closeFilterElementOnPopover();
        },

        // Make click outside to close the dropdown on popover.
        closeFilterElementOnPopover: function() {
            $('.popover').on("click", function(e) {
                var el = $(e.target);
                if (el.parents("#s2id_jsn_filter_element").length == 0) {
                    $("#jsn_filter_element").select2("close");
                }
            });
        },

        // Update sortable event for row and column layout
        rebuildSortable:function () {
            // Sortable for columns in row
            var self    = this;
            $(".wr-row-content").sortable({
                axis:'x',
                //   placeholder:'ui-state-highlight',
                start:$.proxy(function (event, ui) {
                    ui.placeholder.append(ui.item.children().clone());
                    $(ui.item).parents(".wr-row-content").find(".ui-resizable-handle").hide();
                }, this),
                handle:".jsn-handle-drag",
                stop:$.proxy(function (event, ui) {
                    $(ui.item).parents(".wr-row-content").find(".ui-resizable-handle").show();
                    self.wrapper.trigger('wr-megamenu-layout-changed', [ui.item]);
                }, this)
            });
            $(".wr-row-content").disableSelection();

            // Sortable for columns
            this.sortableElement();
        },

        // Update column width when window resize
        resizeHandle:function (self) {
            $(window).resize(function() {
                if($('body').children('.ui-dialog').length)
                    $('html, body').animate({scrollTop: $('body').children('.ui-dialog').first().offset().top - 60}, 'fast');
                self.fnReset(self);
                var _rows   = $('.jsn-row-container', self.wrapper);
                self.wrapper.trigger('wr-megamenu-column-size-changed', [_rows]);
            });
            $("#wr_page_builder").resize(function() {
                self.fnReset(self);
            });
        },

        // Reset when resize window/megamenu
        fnReset:function(self, trigger){
            if((self.resize || trigger) && $("#form-mm-design-content").width()){
                // Do this to prevent columns drop
                $(".wr-mm-form-container.jsn-layout").width($("#form-mm-design-content").width() + 'px');
                self.maxWidth = $(".wr-mm-form-container.jsn-layout").width();

                // Re-calculate step width
                self.calStepWidth(0, 'reset');
                self.initResizable(-1, false);
                self.updateSpanWidthPBDL(self, self.wrapper, self.maxWidth);


            }
            // Sortable elements
            this.sortableElement();
        },

        // Calculate step width when resize column
        calStepWidth:function(countColumn, reset){
            var this_column = this.columns;
            if(reset != null){
                this_column = $(".wr-mm-form-container.jsn-layout").find(".jsn-row-container").first().find('.jsn-column-container');
            }

            var formRowLength = (countColumn > 0) ? countColumn : this_column.length;
            this.step = parseInt((this.maxWidth - (this.spacing * (formRowLength -1))) / 12);

        },

        // Resize columns
        initResizable:function (countColumn, getStep) {
            var self = this;
            if(getStep == null || getStep)
                self.calStepWidth(countColumn);

            var step = self.step;
            var handleResize = $.proxy(function (event, ui) {
                var thisWidth = ui.element.width(),
                bothWidth = ui.element[0].__next[0].originalWidth + ui.originalSize.width,
                nextWidth = bothWidth - thisWidth;

                if (thisWidth < step) {
                    thisWidth = step;
                    nextWidth = bothWidth - thisWidth;

                    // Set min width to prevent column from collapse more
                    ui.element.resizable('option', 'minWidth', step);
                } else if (nextWidth < step) {
                    nextWidth = step;
                    thisWidth = bothWidth - nextWidth;

                    // Set max width to prevent column from expand more
                    ui.element.resizable('option', 'maxWidth', thisWidth);
                }
                var this_span = parseInt(thisWidth / step);
                var next_span = parseInt(nextWidth / step);
                thisWidth = parseInt(parseInt(this_span)*bothWidth/(this_span + next_span));
                nextWidth = parseInt(parseInt(next_span)*bothWidth/(this_span + next_span));

                // Snap column to grid
                ui.element.css('width', thisWidth + 'px');

                // Resize next sibling element as well
                ui.element[0].__next.css('width', nextWidth + 'px');

                // Show % width
                self.percentColumn($(ui.element),"add",step);
                var _row    = $(ui.element).parents('.jsn-row-container');
                self.wrapper.trigger('wr-megamenu-column-size-changed', [_row]);
            }, this);
            // Reset resizable column

            $(".jsn-column").each($.proxy(function (i, e) {
                $(e).resizable({
                    handles:'e',
                    minWidth:step,
                    grid:[step, 0],
                    start:$.proxy(function (event, ui) {
                        ui.element[0].__next = ui.element[0].__next || ui.element.parent().next().children();
                        ui.element[0].__next[0].originalWidth = ui.element[0].__next.width();
                        ui.element.resizable('option', 'maxWidth', '');

                        // Disable resize handle
                        self.resize = 0;
                    }, this),
                    resize:handleResize,
                    stop:$.proxy(function (event, ui) {
                        var oldValue = parseInt(ui.element.find(".jsn-column-content").attr("data-column-class").replace('span', '')),
                        // Round up, not parsetInt
                        newValue = Math.round(ui.element.width() / step),
                        nextOldValue = parseInt(ui.element[0].__next.find(".jsn-column-content").attr("data-column-class").replace('span', ''));
                        // Update field values
                        if (nextOldValue > 0 && newValue > 0) {
                            ui.element.find(".jsn-column-content").attr("data-column-class", 'span' + newValue);
                            ui.element[0].__next.find(".jsn-column-content").attr('data-column-class', 'span' + (nextOldValue - (newValue - oldValue)));
                            // Update visual classes
                            ui.element.attr('class', ui.element.attr('class').replace(/\bspan\d+\b/, 'span' + newValue));
                            ui.element[0].__next.attr('class', ui.element[0].__next.attr('class').replace(/\bspan\d+\b/, 'span' + (nextOldValue - (newValue - oldValue))));
                            ui.element.find("[name^='shortcode_content']").first().text(ui.element.find("[name^='shortcode_content']").first().text().replace(/span\d+/, 'span' + newValue));
                            ui.element[0].__next.find("[name^='shortcode_content']").first().text(ui.element[0].__next.find("[name^='shortcode_content']").first().text().replace(/span\d+/, 'span' + (nextOldValue - (newValue - oldValue))));
                            $(e).css({
                                "height":"auto"
                            });
                        }

                        // Enable resize handle
                        self.resize = 1;
                        /// self.updateSpanWidthPBDL(self, self.wrapper, $(".wr-mm-form-container").width());

                        self.percentColumn($(ui.element),"remove",step);
                    }, this)
                });
            }, this));

            // Remove duplicated resizable-handle div
            if(countColumn > 0){
                $(".jsn-column").each(function(){
                    if($(this).find('.ui-resizable-handle').length > 1)
                        $(this).find('.ui-resizable-handle').last().remove();
                })
            }
        },
        toFixed:function(value, precision){
            var power = Math.pow(10, precision || 0);
            return String(Math.round(value * power) / power);
        },
        getSpan:function(this_){
            return $(this_).find('.jsn-column-content').first().attr('data-column-class').replace('span', '');
        },
        percentColumn:function (element, action,step) {
            var self = this;
            if (action == "add") {

                var this_parent = $(element).parents(".jsn-column-container");
                // Get current columnm & next column
                var cols = [this_parent.find('.jsn-column'), this_parent.next('.jsn-column-container').find('.jsn-column')];

                // Count total span of this column & next column
                var spans = 0;
                $.each(cols, function () {
                    spans += parseInt(self.getSpan(this));
                })

                // Show percent tooltip of this column & the next column
                var updated_spans = [];
                $.each(cols, function (i) {
                    var thisCol = this;
                    var round = (i == cols.length - 1) ? 1 : 0;
                    var thisSpan = parseInt($(this).width() / step) + round;
                    if(i > 0){
                        thisSpan = ((spans - updated_spans[i - 1]) < thisSpan) ? (spans - updated_spans[i - 1]) : thisSpan;
                    }
                    updated_spans[i] = thisSpan;
                    self.showPercentColumn(thisCol, thisSpan);
                });

                // Show percent tooltip of other columns
                $(element).parents(".jsn-row-container").find(".jsn-column").each(function(){
                    if(!$(this).find(".wr-mm-layout-percent-column").length){
                        var thisCol = this;
                        var thisSpan = self.getSpan(this);
                        self.showPercentColumn(thisCol, thisSpan);
                    }
                })

            }
            if (action == "remove") {
                var container = $(element).parents(".jsn-row-container");
                $(container).find(".wr-mm-layout-percent-column").remove();
            }
        },
        // Show percent tooltip when know span of this column
        showPercentColumn:function(thisCol, thisSpan){
            var maxCol = 12;
            var percent = this.toFixed(thisSpan / maxCol * 100, 2).replace(".00", "") + "%";
            var thumbnail = $(thisCol).find(".thumbnail");
            $(thumbnail).css('position', 'relative');
            // $(thumbnail).find("percent-column").remove();
            if ($(thumbnail).find(".wr-mm-layout-percent-column").length) {
                $(thumbnail).find(".wr-mm-layout-percent-column .jsn-percent-inner").html(percent);
            } else {
                $(thumbnail).append(
                    $("<div/>", {"class":"jsn-percent-column wr-mm-layout-percent-column"}).append(
                        $("<div/>", {"class":"jsn-percent-arrow"})
                    ).append(
                        $("<div/>", {"class":"jsn-percent-inner"}).append(percent)
                    )
                )
            }
            var widthThumbnail = $(thumbnail).width();
            var widthPercent = $(thumbnail).find(".wr-mm-layout-percent-column").width();
            $(thumbnail).find(".wr-mm-layout-percent-column").css({"left":parseInt((widthThumbnail + 10) / 2) - parseInt(widthPercent / 2) + "px"});
            $(thumbnail).find(".wr-mm-layout-percent-column .jsn-percent-arrow").css({"left":parseInt(widthPercent / 2) - 4 + "px"});
        },

        // Add Row
        addRow:function(self, this_wrapper){

            this.wrapper.delegate('#jsn-add-container',"click",function(e, get_chosen_layout) {
                e.preventDefault();
                self._addRow(this_wrapper, this, get_chosen_layout);
            });

            this.wrapper.delegate('.wr-layout-thumbs .thumb-wrapper', 'click', function(event) {
                $(this).parent().find('.active').removeClass('active');
                $(this).addClass('active');

                $('#jsn-add-container').trigger('click', [true]);
            });

            // Set animation on hover "Add Row" button
            this.wrapper.delegate('#jsn-add-container', 'mouseover', function(event) {
                if ( ! $('.wr-layout-thumbs').hasClass('open') ) {
                    $('.wr-layout-thumbs').addClass('open');
                    if ( $(window).width() < 990 ) {
                        $('.wr-layout-thumbs').height(100);
                    } else {
                        $('.wr-layout-thumbs').height(50);
                    }
                    $('.wr-layout-thumbs').addClass('open');
                }
            });
            $('#form-mm-design-content').on('mouseleave', function () {
                if ( $('.wr-layout-thumbs').hasClass('open') ) {
                    $('.wr-layout-thumbs').removeClass('open');
                    $('.wr-layout-thumbs').height(0);
                }
            });

        },
        _addRow: function(this_wrapper, target, get_chosen_layout) {

            var self = this;

            if($(".wr-mm-form-container.jsn-layout").find('.jsn-row-container').last().is(':animated')) return;

            // Animation
            var row_html = $(wr_mm_remove_placeholder($('#tmpl-wr_megamenu_row').html(), 'custom_style', 'style="display:none"'));
            var full_row_html = row_html.find('.wr-row-content').html();
            var html = '';
            if( get_chosen_layout && $('.wr-layout-thumbs .active').length > 0 ) {
                var columns = $('.wr-layout-thumbs .active').attr('data-columns');
                columns = columns.split(',');
                $.each( columns, function( i, v ) {
                    html += full_row_html.replace( /\bspan\d+\b/g, 'span' + v );
                });
            }
            if ( html !== '' )
                row_html.find('.wr-row-content').html( html );

            $(target).before(row_html);

            var new_el = $(".wr-mm-form-container.jsn-layout").find('.jsn-row-container').last();
            var height_ = new_el.height();
            new_el.css({'opacity' : 0, 'height' : 0, 'display' : 'block'});
            new_el.addClass('overflow_hidden');
            new_el.show();
            new_el.animate({height: height_},300,self.effect, function(){
                $(this).animate({opacity:1},300,self.effect,function(){
                    new_el.removeClass('overflow_hidden');
                });
            });

            //last_row.fadeIn(1000);

            // Update width for colum of this new row
            var parentForm = self.wrapper.find(".jsn-row-container").last();
            self.updateSpanWidth(1, self.maxWidth, parentForm);

            // Enable/disable move icons
            self.moveItemDisable(this_wrapper);
            self.rebuildSortable();
            self.updateSpanWidthPBDL(self, self.wrapper, $(".wr-mm-form-container.jsn-layout").width());

        },
        // Wrap content of row
        wrapContentRow:function(a,b,direction){
            var self = this;
            if(a.is(':animated') || b.is(':animated')) return;
            var this_wrapper = self.wrapper;
            var stylea = self.getBoxStyle(a);
            var styleb = self.getBoxStyle(b);
            var time = 500, extra1 = 16, extra2 = 16, effect = self.effect;
            if(direction > 0){
                a.animate({top: '-'+(styleb.height + extra1)+'px'}, time, effect, function(){});
                b.animate({top: ''+(stylea.height + extra2)+'px'}, time, effect, function(){
                    a.css('top', '0px');
                    b.css('top', '0px');
                    a.insertBefore(b);
                    self.moveItemDisable(this_wrapper);
                });
            }
            else{
                a.animate({top: ''+(styleb.height + extra2)+'px'}, time, effect, function(){});
                b.animate({top: '-'+(stylea.height + extra1)+'px'}, time, effect, function(){
                    a.css('top', '0px');
                    b.css('top', '0px');
                    a.insertAfter(b);
                    self.moveItemDisable(this_wrapper);
                });
            }
        },

        // Handle when click Up/Down Row Icons
        moveItem:function(){
            var self = this;
            this.wrapper.delegate(this.moveItemEl, "click",function(){
                if(!$(this).hasClass("disabled")){
                    var otherRow, direction;
                    var class_ = $(this).attr("class");
                    var parent = $(this).parents(".jsn-row-container");
                    var parent_idx = parent.index(".jsn-row-container");
                    if(class_.indexOf("jsn-move-up") >= 0){
                        otherRow = self.wrapper.find(".jsn-row-container").eq(parent_idx-1);
                        direction = 1;
                    }else if(class_.indexOf("jsn-move-down") >= 0){
                        otherRow = self.wrapper.find(".jsn-row-container").eq(parent_idx+1);
                        direction = -1;
                    }
                    if(otherRow.length == 0) return;
                    self.wrapContentRow(parent, otherRow, direction);
                    // Set trigger timeout to be sure it happens after animation
                    setTimeout(function (){
                        self.wrapper.trigger('wr-megamenu-layout-changed', [parent]);
                    }, 1001);

                }
            });
        },

        // Disable Move Row Up, Down Icons
        moveItemDisable:function(this_wrapper){
            var self    = this;
            this_wrapper.find(this.moveItemEl).each(function(){
                var class_ = $(this).attr("class");
                var parent = $(this).parents(".jsn-row-container");
                var parent_idx = parent.index(".jsn-row-container");

                // Add "disabled" class
                if(class_.indexOf("jsn-move-up") >= 0){
                    if(parent_idx == 0)
                        $(this).addClass("disabled");
                    else
                        $(this).removeClass("disabled");
                }
                else if(class_.indexOf("jsn-move-down") >= 0){
                    if(parent_idx == this_wrapper.find(".jsn-row-container").length -1)
                        $(this).addClass("disabled");
                    else
                        $(this).removeClass("disabled");
                }
            });
        },

        // Update span width of columns in each row of MegaMenu at Page Load
        updateSpanWidthPBDL:function(self, this_wrapper, totalWidth){
            this_wrapper.find(".jsn-row-container").each(function(){
                var countColumn = $(this).find(".jsn-column-container").length;
                self.updateSpanWidth(countColumn, totalWidth, $(this));
            })
        },

        // Update span width of columns in each row
        updateSpanWidth:function(countColumn, totalWidth, parentForm){
            //12px is width of the resizeable div
            var seperateWidth = (countColumn - 1) * 12;
            var remainWidth = totalWidth - seperateWidth;

            parentForm.find(".jsn-column-container").each(function (i) {
                var selfSpan = $(this).find(".jsn-column-content").attr("data-column-class").replace('span','');
                if(i == parentForm.find(".jsn-column-container").length - 1)
                    $(this).find('.jsn-column').css('width', Math.ceil(parseInt(selfSpan)*remainWidth/12) + 'px');
                else
                    $(this).find('.jsn-column').css('width', Math.floor(parseInt(selfSpan)*remainWidth/12) + 'px');
            });
        },

        // Add Column
        addColumn:function(column_html){
            var self = this;
            this.wrapper.delegate(this.addcolumns,"click",function(){
                var parentForm = $(this).parents(".jsn-row-container");
                var countColumn = parentForm.find(".jsn-column-container").length;
                if (countColumn < 12) {
                    countColumn += 1;
                    var span = parseInt(12 / countColumn);
                    var exclude_span = (12 % countColumn != 0)? span + (12 % countColumn) : span;

                    // Update span old columns
                    parentForm.find(".jsn-column-container").each(function () {
                        $(this).attr('class', $(this).attr('class').replace(/span[0-9]{1,2}/g, 'span'+span));
                        $(this).html($(this).html().replace(/span[0-9]{1,2}/g, 'span'+span));
                    });

                    // Update span new column
                    column_html = column_html.replace(/span[0-9]{1,2}/g, 'span'+exclude_span);

                    // Add new column
                    parentForm.find(".wr-row-content").append(column_html);

                    // Update width for all columns
                    self.updateSpanWidth(countColumn, self.maxWidth, parentForm);
                }

                // Actiave resizable for columns
                self.initResizable(countColumn);
                self.rebuildSortable();
                self.wrapper.trigger('wr-megamenu-layout-changed', [parentForm]);
            });
        },

        // Remove Row/Column/Element Handle
        removeItem:function(){
            var self = this;
            var this_wrapper = this.wrapper;
            this.wrapper.delegate(this.deletebtn,"click",function(){
                if($(this).hasClass('row')){
                    $.HandleCommon.removeConfirmMsg($(this).parents(".jsn-row-container"), 'row');
                    self.wrapper.trigger('wr-megamenu-layout-changed', [parentForm]);
                }
                else if($(this).hasClass('column')){
                    var totalWidth = this_wrapper.width();
                    var parentForm = $(this).parents(".jsn-row-container");
                    var countColumn = parentForm.find(".jsn-column-container").length;
                    countColumn -= 1;
                    if(countColumn == 0){
                        // Remove this row
                        $.HandleCommon.removeConfirmMsg(parentForm, 'column', $(this).parents(".jsn-column-container"));
                        self.wrapper.trigger('wr-megamenu-layout-changed', [parentForm]);
                        return true;
                    }
                    var span = parseInt(12 / countColumn);
                    var exclude_span = (12 % countColumn != 0)? span + (12 % countColumn) : span;

                    // Remove current column
                    if(!$.HandleCommon.removeConfirmMsg($(this).parents(".jsn-column-container"), 'column', null, function(){
                        // Update span remain columns
                        parentForm.find(".jsn-column-container").each(function () {
                            $(this).attr('class', $(this).attr('class').replace(/span[0-9]{1,2}/g, 'span'+span));
                            $(this).html($(this).html().replace(/span[0-9]{1,2}/g, 'span'+span));
                        });

                        // Update span last column
                        parentForm.find(".jsn-column-container").last().html(parentForm.find(".jsn-column-container").last().html().replace(/span[0-9]{1,2}/g, 'span'+exclude_span));

                        // Update width for all columns
                        self.updateSpanWidth(countColumn, totalWidth, parentForm);

                        // Actiave resizable for columns
                        self.initResizable(countColumn);
                        self.rebuildSortable();
                        self.wrapper.trigger('wr-megamenu-layout-changed', [parentForm]);
                    }))
                        return false;
                }
                self.updateSpanWidthPBDL(self, self.wrapper, $(".wr-mm-form-container.jsn-layout").width());
            });
        },

        // Get element's dimension
        getBoxStyle:function(element){
            var style = {
                width:element.width(),
                height:element.height(),
                outerHeight:element.outerHeight(),
                outerWidth:element.outerWidth(),
                offset:element.offset(),
                margin:{
                    left:parseInt(element.css('margin-left')),
                    right:parseInt(element.css('margin-right')),
                    top:parseInt(element.css('margin-top')),
                    bottom:parseInt(element.css('margin-bottom'))
                },
                padding:{
                    left:parseInt(element.css('padding-left')),
                    right:parseInt(element.css('padding-right')),
                    top:parseInt(element.css('padding-top')),
                    bottom:parseInt(element.css('padding-bottom'))
                }
            };

            return style;
        },

        // Sortable Element
        sortableElement:function(){
            var self    = this;
            $(".jsn-element-container").sortable({
                connectWith: ".jsn-element-container",
                placeholder: "ui-state-highlight",
                handle: '.drag-element-icon',
                start: function(event, ui) {
                    // Store original data
                    ui.item.css('position', '');
                    ui.item.parent().find('.ui-state-highlight, .ui-sortable-placeholder').hide();
                    ui.item.css('position', 'absolute');
                    ui.item.parent().find('.ui-state-highlight, .ui-sortable-placeholder').show();
                },
                activate: function(event, ui) {
                    console.log(ui);
                    // Store orignal data
                },
                deactivate: function(event, ui) {
                    // Clean-up
                },
                receive: function(event, ui) {

                },

                stop: function (e, ui){
                    self.wrapper.trigger('wr-megamenu-layout-changed', [ui.item]);
                }
            });
            $(".jsn-element-container").disableSelection();
        },

        // Show popover box
        showPopover:function(box, e, self, this_, callback1, callback2){
            $(document).trigger('click');
            if(box.is(':animated')) return;
            e.stopPropagation();
            box.hide();
            box.fadeIn(500);

            if(callback1)
                callback1();

            // Show popover
            var elmStylePopover = self.getBoxStyle(box.find(".popover")),
            parentStyle = self.getBoxStyle(this_),
            offset_ = {};
            offset_.left = parentStyle.offset.left - elmStylePopover.outerWidth / 2 + parentStyle.outerWidth / 2;
            offset_.top = parentStyle.offset.top - elmStylePopover.height;

            // Check if is first row or not
            var row_idx= $(".wr-mm-form-container.jsn-layout .jsn-row-container").index(this_.parents('.jsn-row-container'));
            var element_in_col= this_.parent('.jsn-column-content').find('.jsn-element').length;
            offset_.top = (row_idx == 0 && element_in_col < 3) ? (offset_.top + 30) : offset_.top;
            box.offset(offset_).click(function (e) {
                e.stopPropagation();
            });
            if($(window).height() > elmStylePopover.height){
                $('html, body').animate({scrollTop: offset_.top - 60}, 'fast');
            }
            $(document).click(function(e){
                if (e.button == 0) {
                    box.hide();
                }
            });

            if(callback2)
                callback2();
        },

        // Show Add Elements Box
        addElement:function(){
            var self = this;

            this.wrapper.delegate(this.addelements,"click",function(e){

                e.preventDefault();
                // Load modal instead of show popover.
                $.HandleElement.showLoading();
                $(window).scrollTop(0);

                var modal = new $.WRModal({
                     dialogClass: 'wr-dialog jsn-bootstrap3',
                     jParent: window.parent.jQuery.noConflict(),
                     title: 'Select Elements',
                     url: Wr_Megamenu_Ajax.wr_modal_url + '&wr_add_element=1',
                     loaded: function (obj, iframe) {
                         
                         if ( $('#wr-add-element-modal').length == 0 ) {
                             obj.container.attr('id', 'wr-add-element-modal');
                         }

                         var jParent  = $(iframe).contents();
                         var html_box = jParent.find("#wr-add-element").clone();
                         $('.jsn-modal').html('<div id="wr-add-element" class="wr-add-element add-field-dialog jsn-bootstrap3">' + html_box.html() + '</div>');
                         // Replace close button by WR own close link
                         var close_button = $('<a type="button" class="close wr-popover-close">&times;</a>');                         
                         $('.ui-dialog-titlebar-close').after(close_button);                         
                         $('.ui-dialog-titlebar-close').remove();

                         $(close_button).on('click', function(e) {
                             e.preventDefault();
                             obj.close();
                             $.HandleElement.removeModal();
                         });

                         $.HandleCommon.setFilterFields('.wr-add-element:last');
                         $.HandleCommon.setQuickSearchFields('.wr-add-element:last');

                         // Set the height for content container   
                         $('#wr-add-element .jsn-items-list').height(this.height - 160);
                         self.updateSpanWidthPBDL(self, self.wrapper, $(".wr-mm-form-container.jsn-layout").width());
                         self.updateSpanWidthPBDL(self, self.wrapper, $(".wr-mm-form-container.jsn-layout").width());

                     },
                     fadeIn:200,
                     scrollable: true,
                     width: $.HandleElement.resetModalSize(0, 'w'),
                     height: $(window.parent).height()*0.8
                 });

                $(window).resize(function() {
                    self.reCalculateSize('.wr-dialog');
                });

                modal.show();
            })
        },
        // re-calculate sizes for modal select elements
        reCalculateSize: function (box) {

            var width = $.HandleElement.resetModalSize(0, 'w');
            var height = $(window.parent).height() * 0.8;
            $(box).width(width);
            $(box).height(height);
            $('.jsn-items-list', $(box)).height(height);
            $(box).css({
                           top :'50%',
                           left :'50%',
                           margin :'-'+ (height / 2) +'px 0 0 -'+ ( (width / 2) - 7) +'px',
                           'z-index': '100001'
                       });
        },

        // Show Add Layout Box
        showAddLayoutBox:function(){
            var self = this;
            var box = $("#wr-add-layout");
            $('#premade-layout').click(function(e){
                self.showPopover(box, e, self, $(this));
            });

            // Toggle Save/Upload layout form
            $('.layout-action').click(function(e){
                $(this).toggleClass('hidden');
                $(this).next('.layout-toggle-form').toggleClass('hidden');
            });
        },

        // Save layout
        showSaveLayoutBox:function(){
            $('#wr-mm-save-layout').click(function(e){
                $(this).toggle();
                $('#wr-mm-layout-form').toggleClass('hidden');
            });
        },

        // Search elements in "Add Element" Box
        searchElement:function(){
            var self = this;
            $.HandleCommon.setQuickSearchFields('#wr-add-element');
        },

        // Animation filter
        elementFilter:function(id_parent, value, data){
            var $container = $(id_parent + ' .jsn-items-list');
            var selector = '.jsn-item';
            var item = selector;
            if(data == null) {
                data = 'data-value';
            }
            if(value == '' || value == 'all') {
                selector += '['+data+'!="shortcode"]';
            }
            if(value != '' && value != 'all')
                selector += '['+data+'*="'+value+'"]';
            var data_sort = $(id_parent + ' select.jsn-filter-button').val();
            if(data == 'data-value' && data_sort != 'all'){
                selector += '[data-sort="'+data_sort+'"]';
            }
            // Process for case is 'all'
            if ( data_sort == 'all' ) {
                var new_selector = '';
                // Get all options in option group contain 'all' case
                var option_selected = $(id_parent + ' select.jsn-filter-button option:selected');
                if ( $(option_selected).parent('optgroup').length > 0 ) {
                    var option_selector_arr = [];
                    $(option_selected).parent('optgroup').find('option').each(function () {
                        option_selector_arr.push( selector + '[data-sort="'+$(this).val()+'"]' );
                    });
                    new_selector = option_selector_arr.join(',');
                }
                // Build selector with all cases.
                selector = new_selector;
            }
            $container.find(item).fadeOut(100);
            $container.find(selector).fadeIn();

            if (value == 'shortcode') {
                $(id_parent + ' .jsn-quicksearch-field').hide(100);
            }else{
                if ($(id_parent + ' .jsn-quicksearch-field').css('display') == 'none') {
                    $(id_parent + ' .jsn-quicksearch-field').show(100);
                }
            }
        },

        // Filter elements in "Add Element" Box
        filterElement:function(value, filter_data){
            var resultsFilter = $('#wr-add-element .jsn-items-list');
            if (value != "all") {
                $(resultsFilter).find("li").hide();
                $(resultsFilter).find("li").each(function () {
                    var textField = (filter_data == 'value') ? $(this).attr("data-value").toLowerCase() : $(this).attr("data-sort").toLowerCase();
                    if (textField.search(value.toLowerCase()) === -1) {
                        $(this).hide();
                    } else {
                        $(this).fadeIn(500);
                    }
                });
            }
            else $(resultsFilter).find("li").show();
        }
    };

    // Separate become common functions to call directly.
    $.HandleCommon = $.HandleCommon || {};

    // Confirm message when delete item
    $.HandleCommon.removeConfirmMsg = function(item, type, column_to_row, callback){
        var self = this;
        var msg = "";
        var show_confirm = 1;
        switch(type){
            case 'row':
                if(item.find('.jsn-column-content').find('.shortcode-container').length == 0)
                    show_confirm = 0;
                msg = Wr_Megamenu_Translate.delete_row;
                break;
            case 'column':
                var check_item = (column_to_row != null) ? column_to_row : item;
                if(check_item.find('.shortcode-container').length == 0)
                    show_confirm = 0;
                msg = Wr_Megamenu_Translate.delete_column;
                break;
            default:
                msg = Wr_Megamenu_Translate.delete_element;
        }

        var confirm_ = show_confirm ? confirm(msg) : true;
        if(confirm_){
            if(type == 'row'){
                item.animate({opacity:0},300,JSNLayoutCustomizer.prototype.effect,function(){
                    item.animate({height:0},300,JSNLayoutCustomizer.prototype.effect,function(){
                        item.remove();
                        JSNLayoutCustomizer.prototype.moveItemDisable($(".wr-mm-form-container.jsn-layout"));
                    });
                });
            }
            else if(type == 'column'){
                item.animate({height:0},500,JSNLayoutCustomizer.prototype.effect,function(){
                    item.remove();
                    if(callback != null) callback();
                });
            }
            else
                item.remove();
            return true;
        }
        else
            return false;
    };

    // Add event for filter field after load select element popover
    $.HandleCommon.setFilterFields = function (id_parent) {
        // Filter
       // $(id_parent + " select.jsn-filter-button").select2("destroy");

        var filter_select = $(id_parent + " select.jsn-filter-button");
        filter_select.select2({
            minimumResultsForSearch:-1
        });

        if($(id_parent + " .jsn-quicksearch-field").val() != ''){
            $(id_parent + " #reset-search-btn").trigger("click");
        }
        else
            JSNLayoutCustomizer.prototype.elementFilter(id_parent, filter_select.val(), 'data-sort');

        $(id_parent + " .jsn-quicksearch-field").focus();
    };

    $.HandleCommon.setQuickSearchFields = function (id_parent) {
        $.fn.delayKeyup = function (callback, ms) {
            var timer = 0;
            var el = $(this);
            $(this).keyup(function () {
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback(el)
                }, ms);
            });
            return $(this);
        };
        $(id_parent + ' .jsn-quicksearch-field').keydown(function (e) {
            if(e.which == 13)
                return false;
        });
        $(id_parent + ' .jsn-quicksearch-field').delayKeyup(function(el) {
            if($(el).val() != '')
                $(id_parent + " #reset-search-btn").show();
            else
                $(id_parent + " #reset-search-btn").hide();

            ///self.filterElement($(el).val(), 'value');
            JSNLayoutCustomizer.prototype.elementFilter(id_parent, $(el).val().toLowerCase());
        }, 500);
        $(id_parent + ' .jsn-filter-button').change(function() {
            ///self.filterElement($(this).val(), 'type');
            JSNLayoutCustomizer.prototype.elementFilter(id_parent, $(this).val(), 'data-sort');
        })
        $(id_parent + ' #reset-search-btn').click(function(){
            ///self.filterElement("all");
            JSNLayoutCustomizer.prototype.elementFilter(id_parent, '');
            $(this).hide();
            $(id_parent + " .jsn-quicksearch-field").val("");
        })
    };

})(jQuery);