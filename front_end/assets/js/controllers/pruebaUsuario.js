'use strict';

/* Controllers con este permite que la ventana pueda mostrar la informacion o el enviar la informacion por post pero debe
de existir un servicio en services, ademas debe de existir en el config.js el nombre del .controller(pruebaCtrl*/
//pueba.js que se debe crear en assets js controller en el front-end
angular.module('app')
.controller('pruebaUsuarioCtrl', //nombre que se pone en le config
['$scope', 
'$state',
'$rootScope',
'$localStorage',
'$location',
'$timeout', 
'pruebaUsuarioService', 
function(
    $scope, 
    $state, 
    $rootScope, 
    $localStorage, 
    $location, 
    $timeout, 
    pruebaUsuarioService) {


$scope.userPruebaUsuario={

    id:0,
    nombre:'',
    apellido:'',
    cedula:'',
    telefono:'',
    celular:'',
    direccion:''

}

$scope.savePrueba = function (userPruebaUsuario) {

    $scope.temp = $scope.userPruebaUsuario;

    l("Entra");

    console.log($scope.temp);


    pruebaUsuarioService.saveUserPrueba({entity:$scope.temp},function(res){

        if(res.success== true){

            l("guardo");

        }


    });
    
}


        }]);