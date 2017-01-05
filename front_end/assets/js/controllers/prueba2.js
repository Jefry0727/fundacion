'use strict';

/* Controllers con este permite que la ventana pueda mostrar la informacion o el enviar la informacion por post pero debe
de existir un servicio en services, ademas debe de existir en el config.js el nombre del .controller(pruebaCtrl*/
//pueba.js que se debe crear en assets js controller en el front-end
angular.module('app')
    .controller('prueba2Ctrl', //nombre que se pone en le config
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






        }]);