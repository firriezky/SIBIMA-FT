/*
 * Chained - jQuery / Zepto chained selects plugin
 *
 * Copyright (c) 2010-2014 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/chained
 *
 * Version: 1.0.0
 *
 */

;(function($, window, document, undefined) {
    "use strict";

    $.fn.remoteChained = function(options) {
        var settings = $.extend({}, $.fn.remoteChained.defaults, options);

        /* Loading text always clears the select. */
        if (settings.loading) {
            settings.clear = true;
        }

        return this.each(function() {

            /* Save this to self because this changes when scope changes. */
            var self = this;
            var request = false; /* Track xhr requests. */

            $(settings.parents).each(function() {
                $(this).bind("change", function() {
                    /* Build data array from parents values. */
                    var data = {};
                    $(settings.parents).each(function() {
                        var id = $(this).attr(settings.attribute);
                        var value = ($(this).is("select") ? $(":selected", this) : $(this)).val();
                        data[id] = value;

                        /* Optionally also depend on values from these inputs. */
                        if (settings.depends) {
                            $(settings.depends).each(function() {
                                /* Do not include own value. */
                                if (self !== this) {
                                    var id = $(this).attr(settings.attribute);
                                    var value = $(this).val();
                                    data[id] = value;
                                }
                            });
                        }
                    });

                    /* If previous request running, abort it. */
                    /* TODO: Probably should use Sinon to test this. */
                    if (request && $.isFunction(request.abort)) {
                        request.abort();
                        request = false;
                    }

                    if (settings.clear) {
                        if (settings.loading) {
                            /* Clear the select and show loading text. */
                            build.call(self, {"" : settings.loading});
                        } else {
                            /* Clear the select. */
                            if (settings.append) {
                                // console.log("append true");
                                $('option')
                                    .filter(function() {return !this.value || $.trim(this.value).length == 0;})
                                    .remove();
                            } else {
                                $("option", self).remove();
                            }
                        }

                        /* Force updating the children to clear too. */
                        $(self).trigger("change");
                    }

                    // console.log(data);
                    request = $.getJSON(settings.url, data, function(json) {
                        // console.log(json);
                        build.call(self, json);
                        /* Force updating the children. */
                        $(self).trigger("change");
                    });
                });

                /* If we have bootstrapped data given in options. */
                if (settings.bootstrap) {
                    build.call(self, settings.bootstrap);
                    settings.bootstrap = null;
                }
            });

            /* Build the select from given data. */
            function build(json) {
                var backup_json = json;
                /* If select already had something selected, preserve it. */
                var selected_key = $(":selected", self).val();

                /* Clear the select. */
                if (settings.append) {
                    $('option', self)
                        .filter(function() {return !this.value || $.trim(this.value).length == 0;})
                        .remove();
                    
                } else if (settings.removePlaceholder == false) {
                    // console.log("remove placeholder false");
                    $('option', self)
                        .filter(function() {return this.value != ''})
                        .remove();

                } else {
                    $("option", self).remove();
                }

                var option_list = [];
                if ($.isArray(json)) {
                    if ($.isArray(json[0])) {
                        /* JSON is already an array of arrays. */
                        /* [["","--"],["series-1","1 series"],["series-3","3 series"]] */
                        option_list = json;
                    } else {
                        /* JSON is an array of objects. */
                        /* [{"":"--"},{"series-1":"1 series"},{"series-3":"3 series"}] */
                        // console.log("build array of objects");

                        if (settings.bima_mode){
                            option_list = json;
                        } else {
                            option_list = $.map(json, function(value) {
                                return $.map(value, function(value, index) {
                                    return [[index, value]];
                                });
                            });
                        }
                    }
                } else {
                    /* JSON is an JavaScript object. Rebuild it as an array. */
                    /* {"":"--","series-1":"1 series","series-3":"3 series"} */
                    for (var index in json) {
                        if (json.hasOwnProperty(index)) {
                            option_list.push([index, json[index]]);
                        }
                    }
                }

                // if(settings.bima_mode){
                //     console.log('option_list : ', option_list);
                // }

                /* Add new options from json. */
                for (var i=0; i!==option_list.length; i++) {
                    var key = option_list[i][0];
                    var value = option_list[i][1];

                    /* Set the selected option from JSON. */
                    if ("selected" === key) {
                        selected_key = value;
                        continue;
                    }

                    if(settings.bima_mode && option_list[i].id){
                        var option = $("<option />").val(option_list[i].id)
                            .append(option_list[i].nim + "  -  " + option_list[i].mentee);
                        // console.log(option);
                        $(self).append(option);

                    } else if (key) {
                        var option = $("<option />").val(value).append(value);
                        $(self).append(option);
                    }
                }

                /* Loop option again to set selected. IE needed this... */
                $(self).children().each(function() {
                    if ($(this).val() === selected_key + "") {
                        $(this).attr("selected", "selected");
                    }
                });

                /* If we have only the default value disable select. */
                if (1 === $("option", self).length && $(self).val() === "") {
                    $(self).prop("disabled", true);
                } else {
                    $(self).prop("disabled", false);
                }
            }
        });
    };

    /* Alias for those who like to use more English like syntax. */
    $.fn.remoteChainedTo = $.fn.remoteChained;

    /* Default settings for plugin. */
    $.fn.remoteChained.defaults = {
        attribute: "name",
        depends : null,
        bootstrap : null,
        loading : null,
        clear : false
    };

})(window.jQuery || window.Zepto, window, document);