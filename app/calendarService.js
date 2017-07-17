define(['jquery'], function ($) {
    var settings = {};
    function initialize(options) {
        $.extend(settings, options);
    }
    function getEvents(id, all, success, error) {
        $.ajax({
            url: settings.calSvcUrl  + "?id=" + id + "&all=" + all,
            type: 'GET'
        })
        .success(function (data) {
            success(data);
        })
        .error(function (err) {
            error(err);
        });
    };

    function getList(success, error) {
        $.ajax({
            url: settings.calListUrl,
            type: 'GET'
        })
        .success(function (data) {
            success(data);
        })
        .error(function (err) {
            error(err);
        });
    }

    return {
        initialize: initialize,
        getEvents: getEvents,
        getList: getList
    };
});