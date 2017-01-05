'use strict';

/* Controllers */

angular.module('app')
    .controller('attentionStudiesCtrl', ['$scope','$state','$rootScope', '$localStorage', 'attentionStudiesService', function($scope, $state, $rootScope, $localStorage, attentionStudiesService) {



    // $scope.attentionStudies;
    // /**
    //  * pagina actual
    //  * @type {Number}
    //  */
    // $scope.currentPageAttentionStudies = 0;
    
    // /**
    //  * Tamaño de la pagina
    //  * @type {Number}
    //  */
    // $scope.pageSizeAttentionStudies = 10;


    // $scope.attentionStudiesTotal;

    // /**
    //  * Función que asigna los elementos a mostrar en la paginación actual
    //  * @param  {Int} page Numero de la pagina
    //  */
    // $scope.pageAttentionStudies= function(page){


    //         var offset = 0;

    //         if (page > 1) {

    //             offset = (page - 1) * 10
    //         }

    //         attentionStudiesService.getConsult({offset: offset}, function(res){


        
    //             console.log(res);                   

    //             /**
    //              * Número total de items
    //              * @type {Int}
    //              */
    //             $scope.attentionStudiesTotal = res.attentionStudyTotal;

                
    //             $scope.attentionStudies = res.attentionStudy;    


    //             console.log($scope.attentionStudies);    


    //         }, function (error) {
        
    //     });

    // };

    // $scope.pageAttentionStudies(0);


     

}]);









