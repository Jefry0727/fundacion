'use strict';

/* Controllers */

angular.module('app')
    .controller('availablePeriodsCtrl', ['$scope','$state','$rootScope', '$localStorage', 'medicalOfficesService', function($scope, $state, $rootScope, $localStorage, medicalOfficesService) {


    $scope.medicalOffices;
    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentPageMedicalOffices = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeMedicalOffices = 10;


    $scope.medicalOfficesTotal;

    /**
     * Función que asigna los elementos a mostrar en la paginación actual
     * @param  {Int} page Numero de la pagina
     */
    $scope.pageAvailablePeriods = function(page){


            var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

            medicalOfficesService.getMedicalOfficesAvailable({offset: offset}, function(res){
        
                console.log(res);                   

                /**
                 * Número total de items
                 * @type {Int}
                 */
                $scope.medicalOfficesTotal = res.total;

                
                $scope.medicalOffices = res.medicalOffices;    


                console.log($scope.medicalOffices);    


            }, function (error) {
        
        });

    };

    $scope.pageAvailablePeriods(0);

    // $scope.goTogetavailablePeriods = function (medicalOffice) {

    //     $localStorage.medicalOffice = medicalOffice;

    //     $state.go('app.medicalOfficesList');
            
    // };    

}]);









