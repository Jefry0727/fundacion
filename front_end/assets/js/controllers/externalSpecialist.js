'use strict';

/* Controllers */

angular.module('app')
    .controller('externalSpecialistCtrl', ['$scope', '$state','$rootScope', 'externalSpecialistsService','urls','$localStorage', function($scope, $state, $rootScope, externalSpecialistsService, urls, $localStorage) {

    	$scope.searchSpecialist = {
            names:""
        };

        $scope.showSpecialist = {

            id:"",
            name:""
        };


    	$scope.searchSpecialist = function(){


            console.log($scope.searchSpecialist.names);

            externalSpecialistsService.getSearchSpecialist({names:$scope.searchSpecialist.names},function(res){

                console.log('entro');

                $scope.showSpecialist = res.result;

                console.log(res.result);

                }, function (error) {

            });

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageGetExternal = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeGetExternal = 10;
         /**
        * Function to get the last added user
        */
        $scope.getExternalSpecialist = function(page){

             var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10;
            }

            externalSpecialistsService.getExternalSpecialist({offset : offset},function(res){

                $scope.externalSpecialists = res.external;

                $scope.total = res.total;

                console.log('esto respondio');

                console.log(res);
                
                }, function (error) {

            });

        }

        $scope.getExternalSpecialist();

        $scope.searchStrExtSpe;

        /**
         * Function to add new role
         */
        $scope.addSpecialist = function(){

            console.log($scope.showSpecialist.name);
            /**
             * calling service to add a new role
             */
            externalSpecialistsService.addSpecialist($scope.showSpecialist,function(res){

                    console.log(res);
                    
                    if (res.success == true){

                        $scope.getExternalSpecialist();

                    }else{

                        console.log('error');
                    }
                    
                
                }, function (error) {

                    console.log(error);

            });

        }

        /**
         * Funcionalidad de busqueda de los servicios
         */

         $scope.foundServiceExtSpe = undefined;

         /**
          * Arreglo con todos los servicios encontrado
          * @type {Array}
          */
         $scope.servicesExtSpe = new Array();

         /**
          * Dirección donde se buscaran los servicios
          * @type {[type]}
          */
         $scope.urlSearchServicesExtSpe = urls.BASE_API + '/ExternalSpecialists/querySpecialist/';


         /**
          * detection se seleccion de servicio por enter o click 
          */
         $scope.$watch('foundServiceExtSpe', function() { 

            /**
             * Si el modelo no esta definido
             */
            if($scope.foundServiceExtSpe != undefined){

                /**
                 * agregamos el servicio al arreglo de servicios
                 */
                $scope.servicesExtSpe.push($scope.foundServiceExtSpe.originalObject);

                /**
                 * Se elimina el valor temporal
                 * @type {[type]}
                 */
                $scope.foundServiceExtSpe = undefined;

                $scope.showSpecialist = $scope.servicesExtSpe[0];

                /**
                 * limpiamos el valor del objeto
                 * @type {[type]}
                 */
                $scope.$broadcast('angucomplete-alt');

            }

        }, true);

}]);