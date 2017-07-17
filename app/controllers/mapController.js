(function () {
    var injectParams = ["$rootScope", "_", '$route'];

    var mapController = function ($rootScope, _, $route) {
        var vm = this;
        vm.thisweek = [];

        $rootScope.$route = $route;
        $rootScope.showRegion = false;
        
        $rootScope.title = 'Map';
        vm.title = 'Map';
    };

    mapController.$inject = injectParams;
    angular.module('ScheduleApp').controller('MapController', mapController);
}());