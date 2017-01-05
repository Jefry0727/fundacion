'use strict';

/* Controllers */

angular.module('app')
.controller('informsCtrl',
 ['$scope', 

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout', 

 'urls',

 'excelServices',
 'ripsService',

 function($scope, 

  $state, 

  $rootScope, 

  $localStorage, 

  $location, 

  $timeout, 

  urls,

  excelServices,

  ripsService){



  $scope.getPeople = function(){



  }


         $scope.ripsModel = {

            dateStart: '',
            dateEnd:   '',
            client:'',
            entity:''

         }

        $scope.getAllClients = function(){

            ripsService.getClients(function(res){

                //console.log('trae todos los clientes'+''+res);

                if(res.success == true){

                    $scope.listClients = res.clients;

                    //console.log('mis clientes papa'+' '+ $scope.listClients);
                }

            });

        }

        $scope.getAllClients();

        $scope.getAllResolution = function(){

            excelServices.generateResolutions({client:$scope.ripsModel.client.id},function(res){
            	console.log('Resultado Consulta');
            	
            	if(res.success){

            		console.log(res.query);

            		excelServices.generateExcelTemplate({model:$scope.ripsModel, data:res.query},function(res){
                        window.location.href = urls.BASE_API + '/ExcelGenerator/downloadRes/';
            		});
            	}
            },function(error){});
        }


 }]);
