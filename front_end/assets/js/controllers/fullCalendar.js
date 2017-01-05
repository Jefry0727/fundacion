'use strict';

/* Controllers */

angular.module('app')
    .controller('fullCalendarCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'medicalOfficesService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, medicalOfficesService) {

       $scope.calendar = "Disponibilidad del Consultorio X";
}]);