'use strict';

/* Controllers */

angular.module('app')
     .controller('PeopleCtrl', ['$scope', '$state','$rootScope', 'peopleService','rolesService','patientsService','usersService','$localStorage',function($scope, $state, $rootScope, peopleService, rolesService, patientsService, usersService, $localStorage) {

        //patients to set people
        $scope.patients = $localStorage.patients;


    // patient model
        $scope.newPeople = {

            document_types_id:"",
            identification:"",
            first_name: "",
            middle_name: "",
            last_name:"",
            last_name_two:"",
            birthdate: "",
            gender: "",
            address: "",
            phone: "",
            email: "",
            
        }

        // patient model
        $scope.editPeople = {

            id:"",
            document_types_id:"",
            identification:"",
            first_name: "",
            middle_name: "",
            last_name:"",
            last_name_two:"",
            birthdate: "",
            gender: "",
            address: "",
            phone: "",
            email: "",
            
        }

        $scope.gender = [
            {name:"Masculino",code:0},
            {name:"Femenino",code:1}
        ];

        $scope.selectGender = $scope.gender[0];
       
        /**
        * Function to get all roles
        */
        $scope.getRoles = function(){

            rolesService.getRoles(function(res){

                $scope.roles = res.roles;
                // Default Option
                $scope.facitSelected = $scope.roles;

                console.log($scope.roles);
                
                }, function (error) {

            });

        }

        $scope.getRoles();

        /**
        * Function to get the last added user
        */
        $scope.getLastPeople = function(){

            peopleService.getLastPeople(function(res){

                $scope.newUser.people_id = res.results.id;

                console.log('id_last_people:');

                console.log($scope.newUser.people_id);
                
                }, function (error) {

            });

        }

        /**
        * Function to get the people
        */
        $scope.getPeoples = function(){

            peopleService.getPeoples({id:$scope.patients.people_id},function(res){

                console.log('resultado de eso');

                $scope.editPeople = res.result;

                $scope.editUser = res.result;

                if($scope.editPeople.gender == 1){

                    $scope.selectGender = $scope.gender[1];

                }else{

                    $scope.selectGender = $scope.gender[0];
                }

                console.log($scope.editPeople.gender);

                }, function (error) {

                    
            });

        }

        $scope.getPeoples();

        $scope.editUser = {

            username:"",
            password:"wadsfd",
            roles_id:"",
            people_id:"",
        }

        /**
        * Function to get all document_types
        */
        $scope.getDocumentTypes = function(){

            patientsService.getDocumentTypes(function(res){

                $scope.documentTypes = res.documentTypes;
                // Default Option
                $scope.facitSelected = $scope.documentTypes;

                console.log(res.documentTypes);
                
                }, function (error) {

            });

        }

        $scope.getDocumentTypes();

        /**
         * Function to add new people
         */
        $scope.addPeoples = function(){

            /**
             * calling service to add a new people
             */
            peopleService.addPeoples($scope.newPeople,function(res){

                    console.log("agregado");
        

                    // $scope.getLastPeople();

                    if (res.success == true){

                        $scope.newUser.people_id = res.person.id;

                        $scope.unique  = '';

                        $scope.addUser();

                    }else{

                        $scope.uniqueEmail = res.errors.email.unique;

                        $scope.uniqueIdentification = res.errors.identification.unique;

                        console.log(res.errors.email);
                    }
                    
                }, function (error) {

                    $scope.unique = res.errors.email.unique;

                    console.log($scope.unique);

            });

        }

        /**
         * Function to add new people
         */
        $scope.editPeoples = function(){

            console.log('entro a edit');

            console.log($scope.editPeople);

            $scope.editPeople.gender = $scope.selectGender.code;

            /**
             * calling service to add a new people
             */
            peopleService.editPeoples($scope.editPeople,function(res){

                    // $scope.getLastPeople();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }

        /**
         * Function to add new user
         */
        
        $scope.addUser = function(){

            console.log($scope.newUser);
            /**
             * calling service to add a new user
             */
            usersService.addUsers($scope.newUser,function(res){

                    if (res.success == true){

                        console.log('entro users');

                        console.log($scope.newPeople.users_id);

                    }else{

                        console.log('error'); 

                        console.log(res.errors.email);
                    }

                    console.log(res);

                    
                }, function (error) {


                    console.log(res);

            });

        }

}]);