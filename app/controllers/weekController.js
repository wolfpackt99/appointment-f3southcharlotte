(function () {
    var injectParams = ["calendarService", "regionService", "typeService", "$rootScope", "_", '$route'];

    var weekController = function (calendarService, regionService, typeService, $rootScope, _, $route) {
        var vm = this,
            dayOfWeek = [{ 'val': 0, "day": 'Monday' }, { 'val': 1, "day": 'Tuesday' }, { 'val': 2, "day": 'Wednesday' }, { 'val': 3, "day": 'Thursday' }, { 'val': 4, "day": 'Friday' }, { 'val': 5, "day": 'Saturday' }, { 'val': 6, "day": 'Sunday' }];

        vm.thisweek = [];

        $rootScope.regions = regionService.regions;
        $rootScope.types = typeService.types;

        $rootScope.region = $rootScope.regions[0];
        $rootScope.type = $rootScope.types[0];

        $rootScope.$route = $route;

        $rootScope.showRegion = true;

        vm.selectedRegion = '';
        vm.selectedType = '';

        $rootScope.setSelected = function () {
            vm.selectedRegion = $rootScope.region.val;
        };

        $rootScope.setType = function (){
            vm.selectedType = $rootScope.type.val;
        }

        $rootScope.title = "Schedule";



        var x = calendarService.getWeek();

        x.$loaded()
            .then(function (x) {
                displayEvents(x);
            });

        x.$watch(function (event) {
            displayEvents(x);
        });

        function displayEvents(x) {
            angular.forEach(x, function (item, i) {
                item.Day = moment(item.Start).format("dddd");
                item.DayOfMonth = moment(item.Start).format("D");
                item.DayOfYear = moment(item.Start).format("DDD");
                item.DayNumber = _.findWhere(dayOfWeek, { day: item.Day }).val;
            });
            var grpd = _.groupBy(x, 'DayOfYear');
            //console.log(grpd);
            var mapped = _.map(grpd, function (item, key) {
                return {
                    DayOfYear: key,
                    DayOfMonth: key,
                    Day: item[0].Day,
                    Items: item,
                    Date: item.length > 0 ? moment(item[0].Start).format('MM/DD/YYYY') : '',
                    Datum: new Date(item[0].Start)
                };
            });
            vm.items = mapped;
        }

    };

    weekController.$inject = injectParams;
    angular.module('ScheduleApp').controller('WeekController', weekController);
}());