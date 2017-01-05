'use strict';

/* Controllers */

angular.module('app')
    .controller('AuthCtrl', ['$scope', '$state','$rootScope','$localStorage','Auth','$location','$timeout', function($scope, $state, $rootScope, $localStorage, Auth, $location, $timeout) {
 
        $scope.loginData = {
          username: '',
          password: ''
        };

        $scope.errorLogin = undefined;

        $scope.doLogin = function(){

            $scope.errorLogin = undefined;

            Auth.signin($scope.loginData, function(res){
                console.log(res);
              
                $localStorage.token = res.data.token;
                  
                $scope.tokenClaims = Auth.getTokenClaims();  
                
                $localStorage.user = $scope.tokenClaims.user;

                $localStorage.person = $scope.tokenClaims.person;

                $localStorage.role = $scope.tokenClaims.user.roles_id;

                $rootScope.getPermissions();

                $scope.getUserFromLs();

                $location.path('app/home');

            }, function (res) {

                console.log(res);

                $scope.errorLogin = res.data.message;
            
            });

        }
    
    }]);
