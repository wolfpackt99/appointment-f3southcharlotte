(function () {
    var injectParams = [];
    var regionFactory = function () {
        var factory = {
            regions: [
            {
                id: 0,
                label: 'All Regions',
                val: ''
            },
            {
                id: 1,
                label: 'Area 51',
                val: 'Area 51'
            },
            {
                id: 2,
                label: 'SOB/Indian Land',
                val: 'SOB'
            },
            {
                id: 3,
                label: 'Union County',
                val: 'Union County'
            }]
        };
        return factory;
    };

    regionFactory.$inject = injectParams;

    angular.module('ScheduleApp').factory('regionService', regionFactory);
}());