'use strict';

/* Controllers */

angular.module('app')
    .controller('PatientsCtrl', ['$scope', '$state','$rootScope', 'patientsService','peopleService','rolesService','usersService','$localStorage', '$location', function($scope, $state, $rootScope, patientsService, rolesService, peopleService, usersService, $localStorage, $location) {

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

        $scope.patients;

        $scope.searchPeople = {
            identification:""
        };

        $scope.idPatients = "";

        $scope.gender = [
            {name:"Masculino",code:0},
            {name:"Femenino",code:1}
        ];

        $scope.viewEditPatient = function(patients){

            $localStorage.patients = patients;

            $state.go('app.editPeople');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        $scope.showPatients = function(){

            $state.go('app.patients');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        $scope.searchPatients = function(){

            console.log($scope.searchPeople.identification);

            patientsService.searchPatients({id:$scope.searchPeople.identification},function(res){

                console.log('entro');

                $scope.newPeople = res.result;

                console.log(res);

                }, function (error) {

            });

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageGetPatients = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeGetPatients = 10;

        /**
        * Function to get the last added user
        */
        $scope.getPatients = function(page){

            var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10;
            }

            patientsService.getallPatients({offset : offset},function(res){

                $scope.patients = res.patient;

                $scope.total = res.total;

                console.log('entro a patients');

                console.log(res);
                
                }, function (error) {

            });

        }

        $scope.getPatients();

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
        * Function to get the last people
        */
        $scope.getLastPeople = function(){

            peopleService.getLastPeople(function(res){

                $scope.newUser.people_id = res.results.id;

                console.log('id_last_people:');

                console.log($scope.newUser.people_id);
                
                }, function (error) {

            });

        }

        $scope.newUser = {

            username:"",
            password:"wadsfd",
            roles_id: 9,
            people_id:"",
        }

        /**
        * Function to get all document_types
        */
        $scope.getDocumentTypes = function(){

            patientsService.getDocumentTypes(function(res){

                $scope.documentTypes = res.documentTypes;
                // Default Option
               // $scope.facitSelected = $scope.documentTypes;

                console.log(res.documentTypes);
                
                }, function (error) {

            });

        }

        $scope.getDocumentTypes();

        $scope.addPeople = function(){
            /**
             * calling service to add a new people
             */
            patientsService.addPeoples($scope.newPeople,function(res){

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

                        $scope.newPatient.users_id = res.person.id;

                        $scope.newPatient.people_id = res.person.people_id;

                        console.log($scope.newPeople.users_id);

                        $scope.addPatient();

                    }else{

                        console.log('error'); 

                        console.log(res.errors.email);
                    }

                    console.log(res);

                    
                }, function (error) {


                    console.log(res);

            });

        }

        $scope.newPatient = {

            users_id:"",
            people_id:"",

        }

        /**
         * Function to add new patients
         */
        
        $scope.addPatient = function(){

            console.log('entro pacientes');

            console.log($scope.newPeople);
            /**
             * calling service to add a new patients
             */
            patientsService.addPatients($scope.newPatient,function(res){

                    console.log('registro patients');

                    console.log(res.success);
                    
                }, function (error) {


                    console.log(res);

            });

        }

        /**
         * Function to add new people
         */
        $scope.desactivatedUser = function(patients){

            $scope.patients = patients.user;

            console.log($scope.patients);
            /**
             * calling service to add a new people
             */
            usersService.desactivatedUsers($scope.patients,function(res){


                    console.log(res);

                    $scope.getPatients();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }

         /**
         * Function to add new people
         */
        $scope.activatedUser = function(patients){

            $scope.patients = patients.user;

            console.log($scope.patients);
            /**
             * calling service to add a new people
             */
            usersService.activatedUsers($scope.patients,function(res){


                    console.log(res);

                    $scope.getPatients();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }



}]);