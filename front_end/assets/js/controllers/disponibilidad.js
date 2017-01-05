'use strict';

/* Controllers */

angular.module('app')
    .controller('disponibilidadCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'medicalOfficesService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, medicalOfficesService) {

        $scope.mensaje = "Consultorios";
}]);
