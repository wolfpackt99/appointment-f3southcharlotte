(function () {
    var underscore = angular.module('underscore', []);
    underscore.factory('_', function () {
        return window._; //Underscore must already be loaded on the page
    });
    var app = angular.module('ScheduleApp', [
    'ngRoute',
    'ngResource',
    'firebase',
    'underscore',
    'angularMoment',
    'ngCookies'
    ]);

    app.config(function ($routeProvider, $sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
            // Allow same origin resource loads.
            'self',
            // Allow loading from our assets domain.  Notice the difference between * and **.
            'https://f3sclt.apphb.com/**'
        ]);
        
        $routeProvider.when('/', {
            controller: 'WeekController',
            templateUrl: '/wp-content/themes/appointment-f3southcharlotte/app/templates/week.html',
            reloadOnSearch: false,
            controllerAs: 'vm',
            activeTab: 'week'
        });

        $routeProvider.when('/schedule', { 
            controller: 'ScheduleController',
            templateUrl: '/wp-content/themes/appointment-f3southcharlotte/app/templates/schedule.html',
            reloadOnSearch: false,
            controllerAs: 'vm',
            activeTab: 'schedule'
        });

        $routeProvider.when('/week', {
            controller: 'WeekController',
            templateUrl: '/wp-content/themes/appointment-f3southcharlotte/app/templates/week.html',
            reloadOnSearch: false,
            controllerAs: 'vm',
            activeTab: 'week'
        });

        $routeProvider.when('/stats', {
            controller: 'LeaderboardController',
            templateUrl: '/wp-content/themes/appointment-f3southcharlotte/app/templates/leaderboard.html',
            reloadOnSearch: false,
            controllerAs: 'vm',
            activeTab: 'stats'
        });

        $routeProvider.when('/map', {
            controller: 'MapController',
            templateUrl: '/wp-content/themes/appointment-f3southcharlotte/app/templates/map.html',
            reloadOnSearch: false,
            controllerAs: 'vm',
            activeTab: 'map'
        });
    });



}())
