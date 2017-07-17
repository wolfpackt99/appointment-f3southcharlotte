(function(){
    var injectParams = ['calendarService','regionService','$rootScope','$route'];

    var scheduleController = function (calendarService, regionService, $rootScope, $route) {
        var vm = this;
        $rootScope.title = 'Schedule';
        
        $rootScope.regions = regionService.regions;
        $rootScope.region = $rootScope.regions[0];
        $rootScope.$route = $route;
        $rootScope.showRegion = true;

        vm.selectedRegion = '';

        $rootScope.setSelected = function () {
            vm.selectedRegion = $rootScope.region.val;
        };

        vm.list = calendarService.getCalendars();
        
    };

    scheduleController.$inject = injectParams;
    angular.module('ScheduleApp').controller('ScheduleController', scheduleController);
}());