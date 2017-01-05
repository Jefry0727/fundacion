'use strict';

/* Controllers con este permite que la ventana pueda mostrar la informacion o el enviar la informacion por post pero debe
de existir un servicio en services, ademas debe de existir en el config.js el nombre del .controller(pruebaCtrl*/
//pueba.js que se debe crear en assets js controller en el front-end
angular.module('app')
    .controller('pruebaCtrl', //nombre que se pone en le config
    	['$scope', 
    	'$state',
    	'$rootScope',
    	'$localStorage',
    	'$location',
    	'$timeout', 
    	'pruebaService', 
    	function(
    		$scope, 
    		$state, 
    		$rootScope, 
    		$localStorage, 
    		$location, 
    		$timeout, 
    		pruebaService) {

       
      $scope.usersModel = {

      	id:0,
      	name:'',
      	lastName:''

      }

      $scope.carro = [

      {name:'w', code:0},
      {name:'m', code:1},
      {name:'c', code:2},
      {name:'r', code:3}

      ];


      $scope.recorreCarro = function(){

      	for(var i = 0; i < $scope.carro.lenth; i++){
      		l('entra al for');
      	
      		if(i == 2){

      			$scope.pos = $scope.carro[i].name;

      			l($scope.pos);
      		}
      	}


      	

      }

      $scope.recorreCarro();
      $scope.getUsers = function(){

      	pruebaService.getAllUsers({id: $scope.usersModel.id},function(res){

      		if(res.success == true){

      			$scope.all = res.users;

      			l('200 ok');
      			console.log($scope.all);

      		}

      	});

      }

      $scope.getUsers();

      $scope.showModalPrueba = function(){

      	$('.modalPrueba').modal('show');

      }

$scope.hideModalPrueba = function(){

      	$('.modalPrueba').modal('hide');

      }
      
}]);

    