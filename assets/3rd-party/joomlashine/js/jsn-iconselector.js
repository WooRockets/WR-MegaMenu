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

(
    function ($) {
        var JSNIconSelector = function (params) {

        }

        JSNIconSelector.prototype = {
            GenerateSelector:function (container, actionSelector, value) {
                var self = this;

                var resultsFilter = $("<ul/>", {"class":"jsn-items-list"});

                $("#jsn-quicksearch-icons").val("");

                $(container).find(".jsn-reset-search").hide();
                
                var is_font_awesome = value.search('fa fa-');
                var checked_font_awesome = '';
                
                if( is_font_awesome >= 0 ) {
                    checked_font_awesome = 'selected="selected"';
                    self.renderListIconSelector(resultsFilter, self.Awesome(), actionSelector, value);
                } else {
                    self.renderListIconSelector(resultsFilter, self.Icomoon(), actionSelector, value);
                }

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

                var oldIconFilter = "";

                return $("<div/>", {"class":"jsn-iconselector"}).append(
                        
                    $("<div/>", {"class":"wr-select-font"}).append(
                        $("<select/>", {"id":"wr-select-font","class":"form-control select2-select"}).append(
                            '<option value="Icomoon">Font IconMoon</option><option value="Awesome" ' + checked_font_awesome + ' >Font Awesome</option>'
                        ).change( function() {
                            var font = $(this).val();
                            if( font == 'Icomoon' ){
                                self.renderListIconSelector(resultsFilter, self.Icomoon(), actionSelector, value);
                            } else if( font == 'Awesome' ) {
                                self.renderListIconSelector(resultsFilter, self.Awesome(), actionSelector, value);
                            }
                        } )
                    )
                    
                ).append(
                    $("<div/>", {"class":"jsn-fieldset-filter"}).append(
                        $("<fieldset/>").append(
                            $("<div/>", {"class":"jsn-quick-search"}).append(
                                $("<input/>", {"class":"form-control", "type":"text","id":"jsn-quicksearch-icons", "placeholder":"Search..."}).
                                delayKeyup(function (el) {
                                    if ($(el).val() != oldIconFilter) {
                                        oldIconFilter = $(el).val();
                                        self.filterResults($(el).val(), resultsFilter);
                                    }
                                    if($(el).val() == ""){
                                        $(el).parents(".jsn-iconselector").find(".jsn-reset-search").hide();
                                    }else{
                                        $(el).parents(".jsn-iconselector").find(".jsn-reset-search").show();
                                    }
                                }, 500)
                            ).append(
                                $("<a/>",{"href":"javascript:void(0);","title":"Clear Search","class":"jsn-reset-search"})
                                .append($("<i/>",{"class":"icon-remove"}))
                                .click(function(){
                                    $(this).parents(".jsn-iconselector").find("#jsn-quicksearch-icons").val("");
                                    oldIconFilter = "";
                                    self.filterResults("", resultsFilter);
                                    $(this).hide();
                                })
                            )
                        )
                    )
                ).append(resultsFilter);

            },

            filterResults:function (value, resultsFilter) {
                $(resultsFilter).find("li").hide();
                if (value != "") {
                    $(resultsFilter).find("li").each(function () {
                        var textField = $(this).find("a").attr("data-value").toLowerCase();
                        if (textField.search(value.toLowerCase()) == -1) {
                            $(this).hide();
                        } else {
                            $(this).fadeIn(1200);
                        }
                    });
                } else {
                    $(resultsFilter).find("li").each(function () {
                        $(this).fadeIn(1200);
                    });
                }
            },
            renderListIconSelector:function ( container, list, actionSelector, valueDefault) {

                $(container).find("li").removeClass("active");
                $(container).html("");

                var _nonIconClass   = 'jsn-item';
                if (!valueDefault) {
                    _nonIconClass   = 'jsn-item active';
                }
                $(container).append(
                        $("<li/>", {'class': _nonIconClass}).append(
                            $("<a/>", {"href":"javascript:void(0)", "class":"icons-item", "data-value":''}).append('None').click(function () {
                                actionSelector(this);
                            })
                        )
                );

                $.each(list, function (value, title) {
                    var classActive = {"class":"jsn-item"};
                    if (value == valueDefault) {
                        classActive = {"class":"jsn-item active"};
                    }
                    // remove title
                    $(container).append(
                        $("<li/>", classActive).append(
                            $("<a/>", {"href":"javascript:void(0)", "class":"icons-item", "data-value":value}).append($("<i/>", {"class":value})).click(function () {
                                actionSelector(this);
                            })
                        )
                    );
                });
            },
            Icomoon:function () {
                return {
                    "icon-home":"home",
                    "icon-user":"user",
                    "icon-locked":"locked",
                    "icon-comments":"comments",
                    "icon-comments-2":"comments-2",
                    "icon-out":"out",
                    "icon-redo":"redo",
                    "icon-undo":"undo",
                    "icon-file-add":"file-add",
                    "icon-plus":"plus",
                    "icon-pencil":"pencil",
                    "icon-pencil-2":"pencil-2",
                    "icon-folder":"folder",
                    "icon-folder-2":"folder-2",
                    "icon-picture":"picture",
                    "icon-pictures":"pictures",
                    "icon-list-view":"list-view",
                    "icon-power-cord":"power-cord",
                    "icon-cube":"cube",
                    "icon-puzzle":"puzzle",
                    "icon-flag":"flag",
                    "icon-tools":"tools",
                    "icon-cogs":"cogs",
                    "icon-cog":"cog",
                    "icon-equalizer":"equalizer",
                    "icon-wrench":"wrench",
                    "icon-brush":"brush",
                    "icon-eye":"eye",
                    "icon-checkbox-unchecked":"checkbox-unchecked",
                    "icon-checkbox":"checkbox",
                    "icon-checkbox-partial":"checkbox-partial",
                    "icon-star":"star",
                    "icon-star-2":"star-2",
                    "icon-star-empty":"star-empty",
                    "icon-calendar":"calendar",
                    "icon-calendar-2":"calendar-2",
                    "icon-help":"help",
                    "icon-support":"support",
                    "icon-warning":"warning",
                    "icon-checkmark":"checkmark",
                    "icon-cancel":"cancel",
                    "icon-minus":"minus",
                    "icon-remove":"remove",
                    "icon-mail":"mail",
                    "icon-mail-2":"mail-2",
                    "icon-drawer":"drawer",
                    "icon-drawer-2":"drawer-2",
                    "icon-box-add":"box-add",
                    "icon-box-remove":"box-remove",
                    "icon-search":"search",
                    "icon-filter":"filter",
                    "icon-camera":"camera",
                    "icon-play":"play",
                    "icon-music":"music",
                    "icon-grid-view":"grid-view",
                    "icon-grid-view-2":"grid-view-2",
                    "icon-menu":"menu",
                    "icon-thumbs-up":"thumbs-up",
                    "icon-thumbs-down":"thumbs-down",
                    "icon-cancel-2":"cancel-2",
                    "icon-plus-2":"plus-2",
                    "icon-minus-2":"minus-2",
                    "icon-key":"key",
                    "icon-quote":"quote",
                    "icon-quote-2":"quote-2",
                    "icon-database":"database",
                    "icon-location":"location",
                    "icon-zoom-in":"zoom-in",
                    "icon-zoom-out":"zoom-out",
                    "icon-expand":"expand",
                    "icon-contract":"contract",
                    "icon-expand-2":"expand-2",
                    "icon-contract-2":"contract-2",
                    "icon-health":"health",
                    "icon-wand":"wand",
                    "icon-refresh":"refresh",
                    "icon-vcard":"vcard",
                    "icon-clock":"clock",
                    "icon-compass":"compass",
                    "icon-address":"address",
                    "icon-feed":"feed",
                    "icon-flag-2":"flag-2",
                    "icon-pin":"pin",
                    "icon-lamp":"lamp",
                    "icon-chart":"chart",
                    "icon-bars":"bars",
                    "icon-pie":"pie",
                    "icon-dashboard":"dashboard",
                    "icon-lightning":"lightning",
                    "icon-move":"move",
                    "icon-next":"next",
                    "icon-previous":"previous",
                    "icon-first":"first",
                    "icon-last":"last",
                    "icon-loop":"loop",
                    "icon-shuffle":"shuffle",
                    "icon-arrow-first":"arrow-first",
                    "icon-arrow-last":"arrow-last",
                    "icon-arrow-up":"arrow-up",
                    "icon-arrow-right":"arrow-right",
                    "icon-arrow-down":"arrow-down",
                    "icon-arrow-left":"arrow-left",
                    "icon-arrow-up-2":"arrow-up-2",
                    "icon-arrow-right-2":"arrow-right-2",
                    "icon-arrow-down-2":"arrow-down-2",
                    "icon-arrow-left-2":"arrow-left-2",
                    "icon-play-2":"play-2",
                    "icon-menu-2":"menu-2",
                    "icon-arrow-up-3":"arrow-up-3",
                    "icon-arrow-right-3":"arrow-right-3",
                    "icon-arrow-down-3":"arrow-down-3",
                    "icon-arrow-left-3":"arrow-left-3",
                    "icon-printer":"printer",
                    "icon-color-palette":"color-palette",
                    "icon-camera-2":"camera-2",
                    "icon-file":"file",
                    "icon-file-remove":"file-remove",
                    "icon-copy":"copy",
                    "icon-cart":"cart",
                    "icon-basket":"basket",
                    "icon-broadcast":"broadcast",
                    "icon-screen":"screen",
                    "icon-tablet":"tablet",
                    "icon-mobile":"mobile",
                    "icon-users":"users",
                    "icon-briefcase":"briefcase",
                    "icon-download":"download",
                    "icon-upload":"upload",
                    "icon-bookmark":"bookmark",
                    "icon-out-2":"out-2"
                }
            },
            Awesome:function () {
                return {
                    "fa fa-glass":"glass",
                    "fa fa-music":"music",
                    "fa fa-search":"search",
                    "fa fa-envelope-o":"envelope-o",
                    "fa fa-heart":"heart",
                    "fa fa-star":"star",
                    "fa fa-star-o":"star-o",
                    "fa fa-user":"user",
                    "fa fa-film":"film",
                    "fa fa-th-large":"th-large",
                    "fa fa-th":"th",
                    "fa fa-th-list":"th-list",
                    "fa fa-check":"check",
                    "fa fa-remove":"remove",
                    "fa fa-close":"close",
                    "fa fa-times":"times",
                    "fa fa-search-plus":"search-plus",
                    "fa fa-search-minus":"search-minus",
                    "fa fa-power-off":"power-off",
                    "fa fa-signal":"signal",
                    "fa fa-gear":"gear",
                    "fa fa-cog":"cog",
                    "fa fa-trash-o":"trash-o",
                    "fa fa-home":"home",
                    "fa fa-file-o":"file-o",
                    "fa fa-clock-o":"clock-o",
                    "fa fa-road":"road",
                    "fa fa-download":"download",
                    "fa fa-arrow-circle-o-down":"arrow-circle-o-down",
                    "fa fa-arrow-circle-o-up":"arrow-circle-o-up",
                    "fa fa-inbox":"inbox",
                    "fa fa-play-circle-o":"play-circle-o",
                    "fa fa-rotate-right":"rotate-right",
                    "fa fa-repeat":"repeat",
                    "fa fa-refresh":"refresh",
                    "fa fa-list-alt":"list-alt",
                    "fa fa-lock":"lock",
                    "fa fa-flag":"flag",
                    "fa fa-headphones":"headphones",
                    "fa fa-volume-off":"volume-off",
                    "fa fa-volume-down":"volume-down",
                    "fa fa-volume-up":"volume-up",
                    "fa fa-qrcode":"qrcode",
                    "fa fa-barcode":"barcode",
                    "fa fa-tag":"tag",
                    "fa fa-tags":"tags",
                    "fa fa-book":"book",
                    "fa fa-bookmark":"bookmark",
                    "fa fa-print":"print",
                    "fa fa-camera":"camera",
                    "fa fa-font":"font",
                    "fa fa-bold":"bold",
                    "fa fa-italic":"italic",
                    "fa fa-text-height":"text-height",
                    "fa fa-text-width":"text-width",
                    "fa fa-align-left":"align-left",
                    "fa fa-align-center":"align-center",
                    "fa fa-align-right":"align-right",
                    "fa fa-align-justify":"align-justify",
                    "fa fa-list":"list",
                    "fa fa-dedent":"dedent",
                    "fa fa-outdent":"outdent",
                    "fa fa-indent":"indent",
                    "fa fa-video-camera":"video-camera",
                    "fa fa-photo":"photo",
                    "fa fa-image":"image",
                    "fa fa-picture-o":"picture-o",
                    "fa fa-pencil":"pencil",
                    "fa fa-map-marker":"map-marker",
                    "fa fa-adjust":"adjust",
                    "fa fa-tint":"tint",
                    "fa fa-edit":"edit",
                    "fa fa-pencil-square-o":"pencil-square-o",
                    "fa fa-share-square-o":"share-square-o",
                    "fa fa-check-square-o":"check-square-o",
                    "fa fa-arrows":"arrows",
                    "fa fa-step-backward":"step-backward",
                    "fa fa-fast-backward":"fa fast-backward",
                    "fa fa-backward":"backward",
                    "fa fa-play":"play",
                    "fa fa-pause":"pause",
                    "fa fa-stop":"stop",
                    "fa fa-forward":"forward",
                    "fa fa-fast-forward":"fa fast-forward",
                    "fa fa-step-forward":"step-forward",
                    "fa fa-eject":"eject",
                    "fa fa-chevron-left":"chevron-left",
                    "fa fa-chevron-right":"chevron-right",
                    "fa fa-plus-circle":"plus-circle",
                    "fa fa-minus-circle":"minus-circle",
                    "fa fa-times-circle":"times-circle",
                    "fa fa-check-circle":"check-circle",
                    "fa fa-question-circle":"question-circle",
                    "fa fa-info-circle":"info-circle",
                    "fa fa-crosshairs":"crosshairs",
                    "fa fa-times-circle-o":"times-circle-o",
                    "fa fa-check-circle-o":"check-circle-o",
                    "fa fa-ban":"ban",
                    "fa fa-arrow-left":"arrow-left",
                    "fa fa-arrow-right":"arrow-right",
                    "fa fa-arrow-up":"arrow-up",
                    "fa fa-arrow-down":"arrow-down",
                    "fa fa-mail-forward":"mail-forward",
                    "fa fa-share":"share",
                    "fa fa-expand":"expand",
                    "fa fa-compress":"compress",
                    "fa fa-plus":"plus",
                    "fa fa-minus":"minus",
                    "fa fa-asterisk":"asterisk",
                    "fa fa-exclamation-circle":"exclamation-circle",
                    "fa fa-gift":"gift",
                    "fa fa-leaf":"leaf",
                    "fa fa-fire":"fire",
                    "fa fa-eye":"eye",
                    "fa fa-eye-slash":"eye-slash",
                    "fa fa-warning":"warning",
                    "fa fa-exclamation-triangle":"exclamation-triangle",
                    "fa fa-plane":"plane",
                    "fa fa-calendar":"calendar",
                    "fa fa-random":"random",
                    "fa fa-comment":"comment",
                    "fa fa-magnet":"magnet",
                    "fa fa-chevron-up":"chevron-up",
                    "fa fa-chevron-down":"chevron-down",
                    "fa fa-retweet":"retweet",
                    "fa fa-shopping-cart":"shopping-cart",
                    "fa fa-folder":"folder",
                    "fa fa-folder-open":"folder-open",
                    "fa fa-arrows-v":"arrows-v",
                    "fa fa-arrows-h":"arrows-h",
                    "fa fa-bar-chart-o":"bar-chart-o",
                    "fa fa-bar-chart":"bar-chart",
                    "fa fa-twitter-square":"twitter-square",
                    "fa fa-facebook-square":"fa facebook-square",
                    "fa fa-camera-retro":"camera-retro",
                    "fa fa-key":"key",
                    "fa fa-gears":"gears",
                    "fa fa-cogs":"cogs",
                    "fa fa-comments":"comments",
                    "fa fa-thumbs-o-up":"thumbs-o-up",
                    "fa fa-thumbs-o-down":"thumbs-o-down",
                    "fa fa-star-half":"star-half",
                    "fa fa-heart-o":"heart-o",
                    "fa fa-sign-out":"sign-out",
                    "fa fa-linkedin-square":"linkedin-square",
                    "fa fa-thumb-tack":"thumb-tack",
                    "fa fa-external-link":"external-link",
                    "fa fa-sign-in":"sign-in",
                    "fa fa-trophy":"trophy",
                    "fa fa-github-square":"github-square",
                    "fa fa-upload":"upload",
                    "fa fa-lemon-o":"lemon-o",
                    "fa fa-phone":"phone",
                    "fa fa-square-o":"square-o",
                    "fa fa-bookmark-o":"bookmark-o",
                    "fa fa-phone-square":"phone-square",
                    "fa fa-twitter":"twitter",
                    "fa fa-facebook-f":"fa facebook-f",
                    "fa fa-facebook":"fa facebook",
                    "fa fa-github":"github",
                    "fa fa-unlock":"unlock",
                    "fa fa-credit-card":"credit-card",
                    "fa fa-rss":"rss",
                    "fa fa-hdd-o":"hdd-o",
                    "fa fa-bullhorn":"bullhorn",
                    "fa fa-bell":"bell",
                    "fa fa-certificate":"certificate",
                    "fa fa-hand-o-right":"hand-o-right",
                    "fa fa-hand-o-left":"hand-o-left",
                    "fa fa-hand-o-up":"hand-o-up",
                    "fa fa-hand-o-down":"hand-o-down",
                    "fa fa-arrow-circle-left":"arrow-circle-left",
                    "fa fa-arrow-circle-right":"arrow-circle-right",
                    "fa fa-arrow-circle-up":"arrow-circle-up",
                    "fa fa-arrow-circle-down":"arrow-circle-down",
                    "fa fa-globe":"globe",
                    "fa fa-wrench":"wrench",
                    "fa fa-tasks":"tasks",
                    "fa fa-filter":"filter",
                    "fa fa-briefcase":"briefcase",
                    "fa fa-arrows-alt":"arrows-alt",
                    "fa fa-group":"group",
                    "fa fa-users":"users",
                    "fa fa-chain":"chain",
                    "fa fa-link":"link",
                    "fa fa-cloud":"cloud",
                    "fa fa-flask":"flask",
                    "fa fa-cut":"cut",
                    "fa fa-scissors":"scissors",
                    "fa fa-copy":"copy",
                    "fa fa-files-o":"files-o",
                    "fa fa-paperclip":"paperclip",
                    "fa fa-save":"save",
                    "fa fa-floppy-o":"floppy-o",
                    "fa fa-square":"square",
                    "fa fa-navicon":"navicon",
                    "fa fa-reorder":"reorder",
                    "fa fa-bars":"bars",
                    "fa fa-list-ul":"list-ul",
                    "fa fa-list-ol":"list-ol",
                    "fa fa-strikethrough":"strikethrough",
                    "fa fa-underline":"underline",
                    "fa fa-table":"table",
                    "fa fa-magic":"magic",
                    "fa fa-truck":"truck",
                    "fa fa-pinterest":"pinterest",
                    "fa fa-pinterest-square":"pinterest-square",
                    "fa fa-google-plus-square":"google-plus-square",
                    "fa fa-google-plus":"google-plus",
                    "fa fa-money":"money",
                    "fa fa-caret-down":"caret-down",
                    "fa fa-caret-up":"caret-up",
                    "fa fa-caret-left":"caret-left",
                    "fa fa-caret-right":"caret-right",
                    "fa fa-columns":"columns",
                    "fa fa-unsorted":"unsorted",
                    "fa fa-sort":"sort",
                    "fa fa-sort-down":"sort-down",
                    "fa fa-sort-desc":"sort-desc",
                    "fa fa-sort-up":"sort-up",
                    "fa fa-sort-asc":"sort-asc",
                    "fa fa-envelope":"envelope",
                    "fa fa-linkedin":"linkedin",
                    "fa fa-rotate-left":"rotate-left",
                    "fa fa-undo":"undo",
                    "fa fa-legal":"legal",
                    "fa fa-gavel":"gavel",
                    "fa fa-dashboard":"dashboard",
                    "fa fa-tachometer":"tachometer",
                    "fa fa-comment-o":"comment-o",
                    "fa fa-comments-o":"comments-o",
                    "fa fa-flash":"flash",
                    "fa fa-bolt":"bolt",
                    "fa fa-sitemap":"sitemap",
                    "fa fa-umbrella":"umbrella",
                    "fa fa-paste":"paste",
                    "fa fa-clipboard":"clipboard",
                    "fa fa-lightbulb-o":"lightbulb-o",
                    "fa fa-exchange":"exchange",
                    "fa fa-cloud-download":"cloud-download",
                    "fa fa-cloud-upload":"cloud-upload",
                    "fa fa-user-md":"user-md",
                    "fa fa-stethoscope":"stethoscope",
                    "fa fa-suitcase":"suitcase",
                    "fa fa-bell-o":"bell-o",
                    "fa fa-coffee":"coffee",
                    "fa fa-cutlery":"cutlery",
                    "fa fa-file-text-o":"file-text-o",
                    "fa fa-building-o":"building-o",
                    "fa fa-hospital-o":"hospital-o",
                    "fa fa-ambulance":"ambulance",
                    "fa fa-medkit":"medkit",
                    "fa fa-fighter-jet":"fighter-jet",
                    "fa fa-beer":"beer",
                    "fa fa-h-square":"h-square",
                    "fa fa-plus-square":"plus-square",
                    "fa fa-angle-double-left":"angle-double-left",
                    "fa fa-angle-double-right":"angle-double-right",
                    "fa fa-angle-double-up":"angle-double-up",
                    "fa fa-angle-double-down":"angle-double-down",
                    "fa fa-angle-left":"angle-left",
                    "fa fa-angle-right":"angle-right",
                    "fa fa-angle-up":"angle-up",
                    "fa fa-angle-down":"angle-down",
                    "fa fa-desktop":"desktop",
                    "fa fa-laptop":"laptop",
                    "fa fa-tablet":"tablet",
                    "fa fa-mobile-phone":"mobile-phone",
                    "fa fa-mobile":"mobile",
                    "fa fa-circle-o":"circle-o",
                    "fa fa-quote-left":"quote-left",
                    "fa fa-quote-right":"quote-right",
                    "fa fa-spinner":"spinner",
                    "fa fa-circle":"circle",
                    "fa fa-mail-reply":"mail-reply",
                    "fa fa-reply":"reply",
                    "fa fa-github-alt":"github-alt",
                    "fa fa-folder-o":"folder-o",
                    "fa fa-folder-open-o":"folder-open-o",
                    "fa fa-smile-o":"smile-o",
                    "fa fa-frown-o":"frown-o",
                    "fa fa-meh-o":"meh-o",
                    "fa fa-gamepad":"gamepad",
                    "fa fa-keyboard-o":"keyboard-o",
                    "fa fa-flag-o":"flag-o",
                    "fa fa-flag-checkered":"flag-checkered",
                    "fa fa-terminal":"terminal",
                    "fa fa-code":"code",
                    "fa fa-mail-reply-all":"mail-reply-all",
                    "fa fa-reply-all":"reply-all",
                    "fa fa-star-half-empty":"star-half-empty",
                    "fa fa-star-half-full":"star-half-full",
                    "fa fa-star-half-o":"star-half-o",
                    "fa fa-location-arrow":"location-arrow",
                    "fa fa-crop":"crop",
                    "fa fa-code-fork":"code-fork",
                    "fa fa-unlink":"unlink",
                    "fa fa-chain-broken":"chain-broken",
                    "fa fa-question":"question",
                    "fa fa-info":"info",
                    "fa fa-exclamation":"exclamation",
                    "fa fa-superscript":"superscript",
                    "fa fa-subscript":"subscript",
                    "fa fa-eraser":"eraser",
                    "fa fa-puzzle-piece":"puzzle-piece",
                    "fa fa-microphone":"microphone",
                    "fa fa-microphone-slash":"microphone-slash",
                    "fa fa-shield":"shield",
                    "fa fa-calendar-o":"calendar-o",
                    "fa fa-fire-extinguisher":"fire-extinguisher",
                    "fa fa-rocket":"rocket",
                    "fa fa-maxcdn":"maxcdn",
                    "fa fa-chevron-circle-left":"chevron-circle-left",
                    "fa fa-chevron-circle-right":"chevron-circle-right",
                    "fa fa-chevron-circle-up":"chevron-circle-up",
                    "fa fa-chevron-circle-down":"chevron-circle-down",
                    "fa fa-html5":"html5",
                    "fa fa-css3":"css3",
                    "fa fa-anchor":"anchor",
                    "fa fa-unlock-alt":"unlock-alt",
                    "fa fa-bullseye":"bullseye",
                    "fa fa-ellipsis-h":"ellipsis-h",
                    "fa fa-ellipsis-v":"ellipsis-v",
                    "fa fa-rss-square":"rss-square",
                    "fa fa-play-circle":"play-circle",
                    "fa fa-ticket":"ticket",
                    "fa fa-minus-square":"minus-square",
                    "fa fa-minus-square-o":"minus-square-o",
                    "fa fa-level-up":"level-up",
                    "fa fa-level-down":"level-down",
                    "fa fa-check-square":"check-square",
                    "fa fa-pencil-square":"pencil-square",
                    "fa fa-external-link-square":"external-link-square",
                    "fa fa-share-square":"share-square",
                    "fa fa-compass":"compass",
                    "fa fa-toggle-down":"toggle-down",
                    "fa fa-caret-square-o-down":"caret-square-o-down",
                    "fa fa-toggle-up":"toggle-up",
                    "fa fa-caret-square-o-up":"caret-square-o-up",
                    "fa fa-toggle-right":"toggle-right",
                    "fa fa-caret-square-o-right":"caret-square-o-right",
                    "fa fa-euro":"euro",
                    "fa fa-eur":"eur",
                    "fa fa-gbp":"gbp",
                    "fa fa-dollar":"dollar",
                    "fa fa-usd":"usd",
                    "fa fa-rupee":"rupee",
                    "fa fa-inr":"inr",
                    "fa fa-cny":"cny",
                    "fa fa-rmb":"rmb",
                    "fa fa-yen":"yen",
                    "fa fa-jpy":"jpy",
                    "fa fa-ruble":"ruble",
                    "fa fa-rouble":"rouble",
                    "fa fa-rub":"rub",
                    "fa fa-won":"won",
                    "fa fa-krw":"krw",
                    "fa fa-bitcoin":"bitcoin",
                    "fa fa-btc":"btc",
                    "fa fa-file":"file",
                    "fa fa-file-text":"file-text",
                    "fa fa-sort-alpha-asc":"sort-alpha-asc",
                    "fa fa-sort-alpha-desc":"sort-alpha-desc",
                    "fa fa-sort-amount-asc":"sort-amount-asc",
                    "fa fa-sort-amount-desc":"sort-amount-desc",
                    "fa fa-sort-numeric-asc":"sort-numeric-asc",
                    "fa fa-sort-numeric-desc":"sort-numeric-desc",
                    "fa fa-thumbs-up":"thumbs-up",
                    "fa fa-thumbs-down":"thumbs-down",
                    "fa fa-youtube-square":"youtube-square",
                    "fa fa-youtube":"youtube",
                    "fa fa-xing":"xing",
                    "fa fa-xing-square":"xing-square",
                    "fa fa-youtube-play":"youtube-play",
                    "fa fa-dropbox":"dropbox",
                    "fa fa-stack-overflow":"stack-overflow",
                    "fa fa-instagram":"instagram",
                    "fa fa-flickr":"flickr",
                    "fa fa-adn":"adn",
                    "fa fa-bitbucket":"bitbucket",
                    "fa fa-bitbucket-square":"bitbucket-square",
                    "fa fa-tumblr":"tumblr",
                    "fa fa-tumblr-square":"tumblr-square",
                    "fa fa-long-arrow-down":"long-arrow-down",
                    "fa fa-long-arrow-up":"long-arrow-up",
                    "fa fa-long-arrow-left":"long-arrow-left",
                    "fa fa-long-arrow-right":"long-arrow-right",
                    "fa fa-apple":"apple",
                    "fa fa-windows":"windows",
                    "fa fa-android":"android",
                    "fa fa-linux":"linux",
                    "fa fa-dribbble":"dribbble",
                    "fa fa-skype":"skype",
                    "fa fa-foursquare":"foursquare",
                    "fa fa-trello":"trello",
                    "fa fa-female":"female",
                    "fa fa-male":"male",
                    "fa fa-gittip":"gittip",
                    "fa fa-gratipay":"gratipay",
                    "fa fa-sun-o":"sun-o",
                    "fa fa-moon-o":"moon-o",
                    "fa fa-archive":"archive",
                    "fa fa-bug":"bug",
                    "fa fa-vk":"vk",
                    "fa fa-weibo":"weibo",
                    "fa fa-renren":"renren",
                    "fa fa-pagelines":"pagelines",
                    "fa fa-stack-exchange":"stack-exchange",
                    "fa fa-arrow-circle-o-right":"arrow-circle-o-right",
                    "fa fa-arrow-circle-o-left":"arrow-circle-o-left",
                    "fa fa-toggle-left":"toggle-left",
                    "fa fa-caret-square-o-left":"caret-square-o-left",
                    "fa fa-dot-circle-o":"dot-circle-o",
                    "fa fa-wheelchair":"wheelchair",
                    "fa fa-vimeo-square":"vimeo-square",
                    "fa fa-turkish-lira":"turkish-lira",
                    "fa fa-try":"try",
                    "fa fa-plus-square-o":"plus-square-o",
                    "fa fa-space-shuttle":"space-shuttle",
                    "fa fa-slack":"slack",
                    "fa fa-envelope-square":"envelope-square",
                    "fa fa-wordpress":"wordpress",
                    "fa fa-openid":"openid",
                    "fa fa-institution":"institution",
                    "fa fa-bank":"bank",
                    "fa fa-university":"university",
                    "fa fa-mortar-board":"mortar-board",
                    "fa fa-graduation-cap":"graduation-cap",
                    "fa fa-yahoo":"yahoo",
                    "fa fa-google":"google",
                    "fa fa-reddit":"reddit",
                    "fa fa-reddit-square":"reddit-square",
                    "fa fa-stumbleupon-circle":"stumbleupon-circle",
                    "fa fa-stumbleupon":"stumbleupon",
                    "fa fa-delicious":"delicious",
                    "fa fa-digg":"digg",
                    "fa fa-pied-piper":"pied-piper",
                    "fa fa-pied-piper-alt":"pied-piper-alt",
                    "fa fa-drupal":"drupal",
                    "fa fa-joomla":"joomla",
                    "fa fa-language":"language",
                    "fa fa-fax":"fa fax",
                    "fa fa-building":"building",
                    "fa fa-child":"child",
                    "fa fa-paw":"paw",
                    "fa fa-spoon":"spoon",
                    "fa fa-cube":"cube",
                    "fa fa-cubes":"cubes",
                    "fa fa-behance":"behance",
                    "fa fa-behance-square":"behance-square",
                    "fa fa-steam":"steam",
                    "fa fa-steam-square":"steam-square",
                    "fa fa-recycle":"recycle",
                    "fa fa-automobile":"automobile",
                    "fa fa-car":"car",
                    "fa fa-cab":"cab",
                    "fa fa-taxi":"taxi",
                    "fa fa-tree":"tree",
                    "fa fa-spotify":"spotify",
                    "fa fa-deviantart":"deviantart",
                    "fa fa-soundcloud":"soundcloud",
                    "fa fa-database":"database",
                    "fa fa-file-pdf-o":"file-pdf-o",
                    "fa fa-file-word-o":"file-word-o",
                    "fa fa-file-excel-o":"file-excel-o",
                    "fa fa-file-powerpoint-o":"file-powerpoint-o",
                    "fa fa-file-photo-o":"file-photo-o",
                    "fa fa-file-picture-o":"file-picture-o",
                    "fa fa-file-image-o":"file-image-o",
                    "fa fa-file-zip-o":"file-zip-o",
                    "fa fa-file-archive-o":"file-archive-o",
                    "fa fa-file-sound-o":"file-sound-o",
                    "fa fa-file-audio-o":"file-audio-o",
                    "fa fa-file-movie-o":"file-movie-o",
                    "fa fa-file-video-o":"file-video-o",
                    "fa fa-file-code-o":"file-code-o",
                    "fa fa-vine":"vine",
                    "fa fa-codepen":"codepen",
                    "fa fa-jsfiddle":"jsfiddle",
                    "fa fa-life-bouy":"life-bouy",
                    "fa fa-life-buoy":"life-buoy",
                    "fa fa-life-saver":"life-saver",
                    "fa fa-support":"support",
                    "fa fa-life-ring":"life-ring",
                    "fa fa-circle-o-notch":"circle-o-notch",
                    "fa fa-ra":"ra",
                    "fa fa-rebel":"rebel",
                    "fa fa-ge":"ge",
                    "fa fa-empire":"empire",
                    "fa fa-git-square":"git-square",
                    "fa fa-git":"git",
                    "fa fa-hacker-news":"hacker-news",
                    "fa fa-tencent-weibo":"tencent-weibo",
                    "fa fa-qq":"qq",
                    "fa fa-wechat":"wechat",
                    "fa fa-weixin":"weixin",
                    "fa fa-send":"send",
                    "fa fa-paper-plane":"paper-plane",
                    "fa fa-send-o":"send-o",
                    "fa fa-paper-plane-o":"paper-plane-o",
                    "fa fa-history":"history",
                    "fa fa-genderless":"genderless",
                    "fa fa-circle-thin":"circle-thin",
                    "fa fa-header":"header",
                    "fa fa-paragraph":"paragraph",
                    "fa fa-sliders":"sliders",
                    "fa fa-share-alt":"share-alt",
                    "fa fa-share-alt-square":"share-alt-square",
                    "fa fa-bomb":"bomb",
                    "fa fa-soccer-ball-o":"soccer-ball-o",
                    "fa fa-futbol-o":"futbol-o",
                    "fa fa-tty":"tty",
                    "fa fa-binoculars":"binoculars",
                    "fa fa-plug":"plug",
                    "fa fa-slideshare":"slideshare",
                    "fa fa-twitch":"twitch",
                    "fa fa-yelp":"yelp",
                    "fa fa-newspaper-o":"newspaper-o",
                    "fa fa-wifi":"wifi",
                    "fa fa-calculator":"calculator",
                    "fa fa-paypal":"paypal",
                    "fa fa-google-wallet":"google-wallet",
                    "fa fa-cc-visa":"cc-visa",
                    "fa fa-cc-mastercard":"cc-mastercard",
                    "fa fa-cc-discover":"cc-discover",
                    "fa fa-cc-amex":"cc-amex",
                    "fa fa-cc-paypal":"cc-paypal",
                    "fa fa-cc-stripe":"cc-stripe",
                    "fa fa-bell-slash":"bell-slash",
                    "fa fa-bell-slash-o":"bell-slash-o",
                    "fa fa-trash":"trash",
                    "fa fa-copyright":"copyright",
                    "fa fa-at":"at",
                    "fa fa-eyedropper":"eyedropper",
                    "fa fa-paint-brush":"paint-brush",
                    "fa fa-birthday-cake":"birthday-cake",
                    "fa fa-area-chart":"area-chart",
                    "fa fa-pie-chart":"pie-chart",
                    "fa fa-line-chart":"line-chart",
                    "fa fa-lastfm":"lastfm",
                    "fa fa-lastfm-square":"lastfm-square",
                    "fa fa-toggle-off":"toggle-off",
                    "fa fa-toggle-on":"toggle-on",
                    "fa fa-bicycle":"bicycle",
                    "fa fa-bus":"bus",
                    "fa fa-ioxhost":"ioxhost",
                    "fa fa-angellist":"angellist",
                    "fa fa-cc":"cc",
                    "fa fa-shekel":"shekel",
                    "fa fa-sheqel":"sheqel",
                    "fa fa-ils":"ils",
                    "fa fa-meanpath":"meanpath",
                    "fa fa-buysellads":"buysellads",
                    "fa fa-connectdevelop":"connectdevelop",
                    "fa fa-dashcube":"dashcube",
                    "fa fa-forumbee":"forumbee",
                    "fa fa-leanpub":"leanpub",
                    "fa fa-sellsy":"sellsy",
                    "fa fa-shirtsinbulk":"shirtsinbulk",
                    "fa fa-simplybuilt":"simplybuilt",
                    "fa fa-skyatlas":"skyatlas",
                    "fa fa-cart-plus":"cart-plus",
                    "fa fa-cart-arrow-down":"cart-arrow-down",
                    "fa fa-diamond":"diamond",
                    "fa fa-ship":"ship",
                    "fa fa-user-secret":"user-secret",
                    "fa fa-motorcycle":"motorcycle",
                    "fa fa-street-view":"street-view",
                    "fa fa-heartbeat":"heartbeat",
                    "fa fa-venus":"venus",
                    "fa fa-mars":"mars",
                    "fa fa-mercury":"mercury",
                    "fa fa-transgender":"transgender",
                    "fa fa-transgender-alt":"transgender-alt",
                    "fa fa-venus-double":"venus-double",
                    "fa fa-mars-double":"mars-double",
                    "fa fa-venus-mars":"venus-mars",
                    "fa fa-mars-stroke":"mars-stroke",
                    "fa fa-mars-stroke-v":"mars-stroke-v",
                    "fa fa-mars-stroke-h":"mars-stroke-h",
                    "fa fa-neuter":"neuter",
                    "fa fa-facebook-official":"fa facebook-official",
                    "fa fa-pinterest-p":"pinterest-p",
                    "fa fa-whatsapp":"whatsapp",
                    "fa fa-server":"server",
                    "fa fa-user-plus":"user-plus",
                    "fa fa-user-times":"user-times",
                    "fa fa-hotel":"hotel",
                    "fa fa-bed":"bed",
                    "fa fa-viacoin":"viacoin",
                    "fa fa-train":"train",
                    "fa fa-subway":"subway",
                    "fa fa-medium":"medium",
                }
            }
        }

        $(document).ready(function() {
            $('body').bind('init_jsn_icon_selector', function () {
                var iconSelector = new JSNIconSelector();

                if($(".icon_selector").length){
                     $(".icon_selector").each(function() {
                        if ( ! $(this).hasClass( 'wr-added' ) ) {
                            var $this = $(this);
                            var inputIcon  = $this.find(":hidden").first();

                            var actionSelector = $.proxy(function (_this) {
                                var value_icon = $(_this).attr("data-value");
                                $(_this).parents(".jsn-items-list").find(".active").removeClass("active");
                                $(_this).parent().addClass("active");
                                inputIcon.val( value_icon );
                                $(_this).parents(".wr-icon").find(".panel-heading .panel-title i").removeClass();
                                $(_this).parents(".wr-icon").find(".panel-heading .panel-title i").addClass($(_this).attr("data-value"));
                                
                                //Inser icon
                                var post_id = $(_this).parents('.icon_selector').attr('data-item_id');
                                $.ajax( {
                                        type   : "POST",
                                        url    : Wr_Megamenu_Ajax.ajaxurl,
                                        data   : {
                                                action         : 'wr_megamenu_insert_icons_database',
                                                post_id        : post_id,
                                                value_icon     : value_icon,
                                                wr_nonce_check : Wr_Megamenu_Ajax._nonce
                                        },
                                        success: function (data) { }
                                } );
                            }, this);

                            $this.append(iconSelector.GenerateSelector($this, actionSelector, inputIcon.val()));
                            // focus selected icon
                            $("[data-value='" + inputIcon.val() + "']").focus() ;
                            $(this).addClass( 'wr-added' );
                        }
                    });
                    $('body').trigger('end_jsn_icon_selector');
                }
           })
           $('body').trigger('init_jsn_icon_selector');
        })
        
        
    })(jQuery)