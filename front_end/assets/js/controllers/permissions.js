'use strict';

/* Controllers */

angular.module('app')
    .controller('PermissionsCtrl', ['$scope','$state','$rootScope', '$localStorage', 'permissionsService', function($scope, $state, $rootScope, $localStorage, permissionsService) {


    	//Role to set permissions
    	$scope.role = $localStorage.role;


        /**
         * All permissions available
         */
    	$scope.completePermissions;


        /**
         * calling service to get all permissions
         */
        permissionsService.getAllPermissions({roleId: $scope.role.id}, function(res){

    			$scope.completePermissions = res.completePermissions;

               	console.log($scope.completePermissions);

            }, function (error) {


                console.log(error);

        });    	
    	
		
        
        /**
         * Function to update a permission by role
         */
        $scope.updatePermissionRole = function(permission){


            var updateData = {
                roleId: $scope.role.id, 
                permissionId: permission.id, 
                roleHasChildPermission: permission.roleHasChildPermission
            };


            /**
             * calling service to add a new role
             */
            permissionsService.updatePermissionRole(updateData, function(res){

                console.log(res);

                }, function (error) {


                    console.log(error);

            });     

        }		




    }]);
