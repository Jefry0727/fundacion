'use strict';

/* Controllers */

angular.module('app')
     .controller('RolesCtrl', ['$scope', '$state','$rootScope', 'rolesService','$localStorage', function($scope, $state, $rootScope, rolesService, $localStorage) {


        $scope.roles;

        /**
         * Function to get all roles
         */
        $scope.getRoles = function(){

            rolesService.getRoles(function(res){

                $scope.roles = res.roles;

                console.log($scope.roles);
                
                
                }, function (error) {

            });



        }

        /**
         * call roles first time
         */
        $scope.getRoles();
     

        // role model
        $scope.newRole = {

            name: "",
            description: ""

        }   

        // role model
        $scope.updateRole = {
            id: "",
            name: "",
            description: ""

        }

        // role model
        $scope.deleteRole = {
            id: ""

        }

        $scope.unique ="";

        /**
         * Function to add new role
         */
        $scope.addRole = function(){


            /**
             * calling service to add a new role
             */
            rolesService.addRole($scope.newRole, function(res){

                    console.log(res);
                    
                    if (res.success == true){

                        $scope.hideModalAddRole();

                        $scope.getRoles();


                    }else{

                        $scope.unique = res.errors.name.unique;

                        console.log(res.errors.name);
                    }
                    
                
                }, function (error) {

                    console.log(error);

            });

        }

        /**
         * Function to show the add role modal
         */
        $scope.showModalAddRole = function(){

            $('.add-role').modal('show');
        }

        /**
         * Function to show the add role modal
         */
        $scope.hideModalAddRole = function(){

            $('.add-role').modal('hide');
        }



        /**
         * Function to add new role
         */
        $scope.editRole = function(){


            /**
             * calling service to add a new role
             */
            rolesService.updateRole($scope.updateRole,function(res){

                    console.log(res);
                    
                     
                    if (res.success == true){

                        $scope.hideModalEditRole();

                        $scope.getRoles();


                    }else{

                        $scope.unique = res.errors.name.unique;

                        console.log(res.errors.name);
                    }
                
                }, function (error) {

                    console.log(error);

            });

        }



        /**
         * Function to show the update role modal
         */
        $scope.showModalEditRole = function(role){

            
            $scope.updateRole = role;

            console.log($scope.updateRole);
            
            $('.edit-role').modal('show');
        }

        /**
         * Function to show the update role modal
         */
        $scope.hideModalEditRole = function(){

            $('.edit-role').modal('hide');
        }



           /**
         * Function to delete a new role
         */
        $scope.deleteRole = function(){

            /**
             * calling service to delete a role
             */
            rolesService.deleteRoles({id:$scope.deleteRole.id},function(res){

                    console.log(res);
                    
                    $scope.hideModalDeleteRole();

                    $scope.getRoles();
                
                }, function (error) {


                    console.log(error);

            });

        }


        /**
         * Function to show the update role modal
         */
        $scope.showModalDeleteRole = function(role){

            $scope.deleteRole.id = role.id;

            console.log($scope.deleteRole.id);

            $('.delete-role').modal('show');
        }

        /**
         * Function to show the update role modal
         */
        $scope.hideModalDeleteRole = function(){

            $('.delete-role').modal('hide');
        }

        $scope.goToRolePermissions = function (role) {

            $localStorage.role = role;

            $state.go('app.permissions');
            
        };



    }]);
