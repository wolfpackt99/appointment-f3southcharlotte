(function () {
    var injectParams = ['leaderboardService', 'regionService', '$rootScope', '$location', '$http', '$cookies','$route','$sce'];

    var leaderboardController = function (leaderboardService, regionService, $rootScope, $location, $http, $cookies, $route, $sce) {
        var vm = this;
        vm.showStrava = false;

        $rootScope.$route = $route;
        $rootScope.showRegion = false;

        var hasApprovedStrava = $cookies.get("allowStrava");
        if (!hasApprovedStrava) {
            vm.showStrava = true;
        } else {
            leaderboardService.getLeaders(function (data) {
                vm.list = data;
            }, function (err) {

            });
        }

        function getAccessToken(code, success) {
            var data = {
                code: $location.search().code
            };
            $http.get("https://f3sclt.apphb.com/Leaderboard/SetAuth?code=" + data.code)
                .then(function (resp) {
                    success(resp.data);
                    leaderboardService.getLeaders(function (data) {
                        vm.list = data;
                    }, function (err) {

                    });
                }, function (response) {
                    //failed
                });
        }



        if ($location.search().code) {
            getAccessToken($location.search().code, function (resp) {
                $cookies.put("allowStrava", true);
                vm.showStrava = false;
            });
        }
        $rootScope.title = 'Stats';

        $rootScope.regions = regionService.regions;
        $rootScope.region = $rootScope.regions[0];

        vm.selectedRegion = '';

        $rootScope.setSelected = function () {
            vm.selectedRegion = $rootScope.region.val;
        };

        vm.login = function () {
            document.location.href = "https://www.strava.com/oauth/authorize?client_id=9524" +
                "&response_type=code&" +
                "redirect_uri=http://f3southcharlotte.com/schedule-app/%23/stats/&" +
                "scope=view_private&" +
                "state=stats&" +
                "approval_prompt=force";
        }

        vm.getStatsByUser = function (user) {
            if (user.ShowStats && user.ShowStats === true) {
                user.ShowStats = false;
            } else if (user.ShowStats === false) {
                user.ShowStats = true;
            } else {
                user.ShowStats = true;
            }
        }


    };




    leaderboardController.$inject = injectParams;
    angular.module('ScheduleApp').controller('LeaderboardController', leaderboardController);
}());