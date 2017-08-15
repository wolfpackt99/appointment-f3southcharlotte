<?php

/**

Template Name: Schedule App

*/

get_header();

get_template_part('index','banner'); ?>

<!-- Blog Section with Sidebar -->

<div class="page-builder">
    <style>
    .row-app { padding-left: 15px !important; padding-right: 15px !important; }
    </style>
	<div id="container" class="container" ng-app="ScheduleApp">
        <ul>
            <li><a href='/schedule-app/#/schedule/'>Fitness - 1st F</a></li>
            <li><a href='/schedule-app/#/schedule/'>Fellowship - 2nd F</a></li>
            <li><a href='/3rd-f/'>Faith - 3rd F</a></li>

        <div class="row row-app">
            <div class="col-md-3 col-sm-6"> 
                <h3 ng-show="!showRegion">{{title}}</h3>
                <select ng-options='r.label for r in regions track by r.label' ng-show="showRegion" ng-model="region" ng-change="setSelected()" class="form-control" style="margin-bottom: 5px;"></select>
            </div>
            <div class="col-md-3 col-sm-6"> 
                <select ng-options='a.label for a in types track by a.label' ng-show="showRegion" ng-model="type" ng-change="setType()" class="form-control" style="margin-bottom: 5px;"></select>
            </div>
        </div>
        <ng-view></ng-view>
    </div>

</div>

<!-- /Blog Section with Sidebar -->
<script src="/wp-content/themes/appointment-f3southcharlotte/app/moment.min.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/angular.min.js"></script>
<script src="https://cdn.firebase.com/js/client/2.2.9/firebase.js"></script>
<script src="https://cdn.firebase.com/libs/angularfire/1.1.2/angularfire.min.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/angular-route.min.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/angular-resource.min.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/angular-cookies.min.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/angular-moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>

<script src="/wp-content/themes/appointment-f3southcharlotte/app/scheduleApp.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/controllers/scheduleController.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/controllers/weekController.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/controllers/leaderboardController.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/controllers/mapController.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/services/calendarService.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/services/regionService.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/services/leaderService.js"></script>
<script src="/wp-content/themes/appointment-f3southcharlotte/app/services/typeService.js"></script>
<?php get_footer(); ?>
