'use strict';

/* Controllers */

angular.module('app')
    .controller('ScheduleCtrl', ['$scope','$state','$rootScope', '$localStorage', function($scope, $state, $rootScope, $localStorage) {

    /**
     * Medical Office to set period Date intervals
     * @type Object
     */
    $scope.scheduleInterval = $localStorage.scheduleInterval;


    /**
     * Medical Office to set period Date intervals
     * @type Object
     */
    $scope.medicalOffice = $localStorage.medicalOffice;



}]);
