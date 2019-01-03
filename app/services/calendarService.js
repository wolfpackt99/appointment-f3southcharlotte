(function () {
    var injectParams = ['$http', '$q', '$firebaseArray', '$firebaseAuth','_'];
    var calendarFactory = function ($http, $q, $firebaseArray, $firebaseAuth, _) {
        var factory = {},
            dayOfWeek = [{ 'val': 0, "day": 'Monday' }, { 'val': 1, "day": 'Tuesday' }, { 'val': 2, "day": 'Wednesday' }, { 'val': 3, "day": 'Thursday' }, { 'val': 4, "day": 'Friday' }, { 'val': 5, "day": 'Saturday' }, { 'val': 6, "day": 'Sunday' }];

        factory.getCalendars = function () {
            var ref = new Firebase("https://f3area51.firebaseio.com/events");
            var x = $firebaseArray(ref);
            x.$loaded()
                .then(function (x) {
                    massageData(x);
                })
                .catch(function (error) {

                });

            x.$watch(function (event) {
                massageData(x);
            });

            return x;
        }

        factory.getWeek = function (callback) {
            var ref = new Firebase("https://f3area51.firebaseio.com/thisweek");
            var x = $firebaseArray(ref);
            x.$loaded()
                .then(function (x) {
                    massageThisWeek(x);
                })
                .catch(function (error) {

                });

            x.$watch(function (event) {
                massageThisWeek(x);
            });

            return x;
        }

        function massageData(x) {
            angular.forEach(x, function(item, i) {
                try {
                    var json = JSON.parse(item.Description);
                    item.SiteQ = json.SiteQ;
                    item.Meets = json.Meets;
                    item.DayOfWeek = _.findWhere(dayOfWeek, { day: item.Meets }) !== null ? _.findWhere(dayOfWeek, { day: item.Meets }).val : item.Meets;
                    item.LocationHint = json.LocationHint;
                    item.DisplayLocation = json.DisplayLocation;
                    item.Time = json.Time;
                    item.SignupLink = json.SignupLink;
                    item.Region = json.Region;
                    setSlug(item, json);

                } catch (e) {
                    item.SiteQ = item.Description;
                    item.Meets = item.Meets;
                    item.LocationHint = null;
                    item.DisplayLocation = item.Location || "";
                    item.Time = null;
                    item.SignupLink = null;
                }
            });
        }

        function setSlug(item, json)
        {
            if (json.hasOwnProperty("slug")){
                item.Slug = json.slug;
                return;
            }
            var slug = item.Name;
            slug = slug.replace(/'/g, '');
            slug = slug.replace(/ /g, '-');
            item.Slug = slug;
            return;
        }

        function massageThisWeek(x) {
            angular.forEach(x, function (item, i) {
                try {
                    var json = JSON.parse(item.Description);
                    item.CustomDescription = json.description;
                }
                catch (e) {
                    if (e.description !=="Invalid character"){
                        console.log(e);
                    }
                }
                if (item.IsCustomDateTime === true) {
                    if (!item.IsAllDay) {
                        item.StartTimeFormat = moment(item.StartTime).format("HHmm");
                        item.EndTimeFormat = moment(item.EndTime).format("HHmm");
                    }
                   
                }
            });
        }

        return factory;
    };

    calendarFactory.$inject = injectParams;

    angular.module('ScheduleApp').factory('calendarService', calendarFactory);

}());