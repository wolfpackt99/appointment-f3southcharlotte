(function(){
    var injectParams = ['calendarService','regionService','typeService','$rootScope','$route'];

    var scheduleController = function (calendarService, regionService, typeService, $rootScope, $route) {
        var vm = this;
        $rootScope.title = 'Schedule';

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

        vm.list = calendarService.getCalendars();
    };

    scheduleController.$inject = injectParams;
    angular.module('ScheduleApp').controller('ScheduleController', scheduleController);
}());