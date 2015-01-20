(function ($) {
    var root = this,
        RebelMouseWidget = function(baseUrl){
            var base = this;
            base.widget_id = '';
            base.API_BASE_URL = baseUrl || 'https://www.rebelmouse.com/res/';
            base.WIDGET_ID_NAME = 'rebelmouse_widget';

            (function(base) {
                base.Site = {
                        details : function(sitename, callback) {
                            base.request(['site', 'details', sitename], {}, function (response) {
                                callback(response);
                            }, 'cb');
                        }
                };
            })(base);
        };

    RebelMouseWidget.prototype.request = function(endpoint, params, callback, callback_name) {

      endpoint = $.isArray(endpoint) ? endpoint.join('/') : endpoint;
      params   = params || {};

      $.ajax({
        url:      this.API_BASE_URL + endpoint,
        dataType: 'jsonp',
        success:  callback,
        jsonp: callback_name || 'callback',
        data:     params,
      });

    };
    RebelMouseWidget.prototype.bindWidget = function () {

        var widget = this, widget_id, prefix;
        $('.rm-input-sitename').change(function(e) {
            widget_id = $(this).attr('id').substring('widget-rebelmouse_widget-'.length).split('-')['0'] || 0;
            prefix = 'widget-rebelmouse_widget-' + widget_id;
            widget.disabledFeatures(prefix);
            widget.Site.details($(this).val(), function(result) {
                if (result.paid_site) {
                    widget.enabledFeatures(prefix);
                } else {
                    widget.disabledFeatures(prefix);
                }
            });
        });

    };
    RebelMouseWidget.prototype.bindSettings = function () {
        var widget = this, tab_id, prefix;
        $('#rebelmouse_home_sitename, #rebelmouse_page_sitename').change(function(e) {
            tab_id = $(this).attr('id').split('_')['1'];
            prefix = 'rebelmouse-' + tab_id;
            widget.disabledFeatures(prefix);
            widget.Site.details($(this).val(), function(result) {
                if (result.paid_site) {
                    widget.enabledFeatures(prefix);
                } else {
                    widget.disabledFeatures(prefix);
                }
            });
        });
    }
    RebelMouseWidget.prototype.init = function () {

        var base = this;
        if ($('#rebelmouse_settings_content').length > 0) {
            base.bindSettings();
        } else {
            base.bindWidget();
            $(document).ajaxSuccess(function(e, xhr, settings) {
                if (settings.hasOwnProperty('data')) {
                    if (settings.data.search('action=save-widget') != -1 && settings.data.search('id_base=' + base.WIDGET_ID_NAME) != -1) {
                        base.bindWidget();
                    }
                }
            });
        }

    };
    RebelMouseWidget.prototype.disabledFeatures = function (prefix) {
        $('#' + prefix + '-features').val("false");
        $('#' + prefix + '-explanation').show();
        $('#' + prefix + '-features-controls').addClass('inactive');
        $('#' + prefix + '-features-controls input:checkbox').each(function(){
            $(this).attr("disabled", true);
            $(this).removeAttr("checked");
        });
    };
    RebelMouseWidget.prototype.enabledFeatures = function (prefix) {
        $('#' + prefix + '-features').val("true");
        $('#' + prefix + '-explanation').hide('slow');
        $('#' + prefix + '-features-controls').removeClass('inactive');
        $('#' + prefix + '-features-controls input:checkbox').each(function(){
            $(this).removeAttr("disabled");
        });
    };

    $(function() {
        (new RebelMouseWidget()).init();
    });

})(jQuery);
