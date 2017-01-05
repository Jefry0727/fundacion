'use strict';

/* Controllers */

angular.module('app')
    .controller('HomeCtrl', ['$scope','usersService', '$localStorage', function($scope, usersService, $localStorage) {



        /**
         * Julián Andrés Muñoz Cardozo
         * 2016-09-07 15:52:08
         * mostrar modal de menu cuando se carga la pagina de inicio
         * 
         */
        
        // $scope.message = $localStorage.person.first_name;

        // l('aaa'+ +$scope.message);
      

        // $scope.showWelcome = function() {
            
        //     $('.welcome-to').modal('show');
        // }

        //   $scope.showWelcome();

        // $scope.hideWelcome = function() {
            
        //     $('.welcome-to').modal('hide');

            

        //      //location.reload(true);
        // }
        
        $scope.userName = $localStorage.person.first_name;

        $scope.userSecondName = $localStorage.person.middle_name;

        $scope.userLastName = $localStorage.person.last_name;
        

         $scope.showModalMenu();

        // window.onload = function () {window.location.reload()}
          

     
    }]);
