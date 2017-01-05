'use strict';

/* Controllers */

angular.module('app')
    .controller('attentionConsultationsCtrl', ['$scope','$state','$rootScope', '$localStorage', 'attentionConsultationsService', function($scope, $state, $rootScope, $localStorage, attentionConsultationsService) {


    $scope.attentionConsultation;
    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentPageAttentionConsultation = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeAttentionConsultation = 10;


    $scope.attentionConsultationTotal;

    /**
     * Función que asigna los elementos a mostrar en la paginación actual
     * @param  {Int} page Numero de la pagina
     */
    $scope.pageAttentionConsultation = function(page){


            var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

            attentionConsultationsService.getConsult({offset: offset}, function(res){


        
                console.log(res);                   

                /**
                 * Número total de items
                 * @type {Int}
                 */
                $scope.attentionConsultationTotal = res.attentionConsultationsTotal;

                
                $scope.attentionConsultation = res.attentionConsultations;    


                console.log($scope.attentionConsultation);    


            }, function (error) {
        
        });

    };

    $scope.pageAttentionConsultation(0);

     

}]);









