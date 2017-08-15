(function () {
    var injectParams = [];
    var typeFactory = function () {
        var factory = {
            types: [{
                id: 0,
                label: 'All Types',
                val: ''
            },
            {
                id: 1,
                label: 'Boot Camp',
                val: 'Boot Camp'
            },
            {
                id: 2,
                label: 'Boot Camp/Moderate Intensity',
                val: 'Boot Camp/Moderate Intensity'
            },
            {
                id: 3,
                label: 'Boot Camp/OCR Training',
                val: 'Boot Camp/OCR Training'
            },
            {
                id: 4,
                label: 'Flexibility/Stretch',
                val: 'Flexibility/Stretch'
            },
            {
                id: 5,
                label: 'Gear',
                val: 'Gear'
            },
            {
                id: 6,
                label: 'Running',
                val: 'Running'
            },
            {
                id: 7,
                label: 'Running/Long Distance',
                val: 'Running/Long Distance'
            },
            {
                id: 8,
                label: 'Weight Training',
                val: 'Weight Training'
            },
            {
                id: 9,
                label: '2nd F Opportunities',
                val: '2nd F Opportunities'
            }]
        };
        return factory;
    };

    typeFactory.$inject = injectParams;
    angular.module('ScheduleApp').factory('typeService', typeFactory);
}());