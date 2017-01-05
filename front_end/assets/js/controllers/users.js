'use strict';

/* Controllers */

angular.module('app')
    .controller('UsersCtrl', ['$scope', '$state','$rootScope', 'peopleService', 'usersService','$localStorage', 'departmentsService','municipalitiesService',
        function($scope, $state, $rootScope, peopleService, usersService, $localStorage,departmentsService,municipalitiesService) {

        /** @type {[type]} [description] */
        //$scope.selectRole = undefined;

        /**
         * [newPeople Model description]
         * Model New People
         * @type {Object}
         */
        $scope.newPeople = {

            id:'',
            document_types_id: undefined,
            identification:'',
            first_name: '',
            middle_name: '',
            last_name:'',
            last_name_two:'',
            birthdate: '',
            gender: '',
            address: '',
            phone: '',
            email: '',
            municipalities_id:''
            
        }

        $scope.rol = $localStorage.role;

        /**
         * [EditNewPeople Model description]
         * Model Edit People
         * @type {Object}
         */
        $scope.EditNewPeople = {

            id:'',
            document_types_id: undefined,
            identification:'',
            first_name: '',
            middle_name: '',
            last_name:'',
            last_name_two:'',
            birthdate: '',
            gender: '',
            address: '',
            phone: '',
            email: '',
            municipalities_id:''
            
        }

        /**
         * [resetNewPeople description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T16:17:50-0500
         * @return   {[type]}                 [Function Reset New People Model]
         */
        $scope.resetNewPeople = function(){

            $scope.newPeople = {

            id:'',
            document_types_id: undefined,
            identification:'',
            first_name: '',
            middle_name: '',
            last_name:'',
            last_name_two:'',
            birthdate: '',
            gender: '',
            address: '',
            phone: '',
            email: '',
            municipalities_id:''
            
        }

        }

        //wadsfd

        $scope.newUser = {

            id:'',
            username:'',
            password:'',
            roles_id: undefined,
            people_id:'',
            active:'',
            created:'',
            modified:''


        }

         $scope.editNewUser = {

            id:'',
            username:'',
            password:'',
            roles_id: '',
            people_id:'',
            active:'',
            created:'',
            modified:''


        }

        $scope.resetNewUser = function(){

            $scope.newUser = {

            id:'',
            username:'',
            password:'',
            roles_id: undefined,
            people_id:'',
            active:'',
            created:'',
            modified:''


        }

        }

     	$scope.users;

        /**
         * [listUsers description]
         * @type {Object}
         */
        $scope.listUsers={
            id:"",
        };

        /**
         * [gender description]
         * @type {Array}
         */
        $scope.typeGender = [

        {name:'Masculino', code:0},
        {name:'Femenino', code:1}

        ];

        $scope.stateUser = [

        { name:'Activo', code:0},
        {name:'Inactivo', code:1}

        ];

        $scope.restorePassword={
            id : '',
            password_new : '',
            password_repeat:''
        };


        $scope.showModalRestorePassword = function(user){
            l('--showModalRestorePassword--');
            $scope.restorePassword.id = user.id 
            l(user);
            $('.restore-password').modal('show');
        }

        $scope.hideModalRestorePassword = function(){
            $('.restore-password').modal('hide');
        }

        /**
         * [selectDocumentType Model]
         * @type {[type]}
         */
        $scope.selectDocumentType = undefined;

        $scope.date = new Date();
        $scope.date = $scope.date.toISOString().substring(0,10);

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageGetUser = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeGetUser = 10;





        /**
         * [getListUsers description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T11:54:35-0500
         * @param    {[type]}                 page [description]
         * @return   {[type]}                      [Get All user And Filters]
         */
        $scope.getListUsers = function(page){

            var offset = 0;

                if (page > 1) {

                    offset = (page - 1) * 10;
                }

            usersService.listAllUsers({offset : offset}, function(res){

                if(res.success == true){

                    $scope.allUsers = res.users;

                    console.log($scope.allUsers);

                    $scope.total = res.total;

                }

            });

        }

        $scope.getListUsers();

        /**
         * [showNewUser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T12:04:33-0500
         * @return   {[type]}                 [Show Modal New User]
         */
        $scope.showNewUser = function(){

            $('.new-user').modal('show');

        }


        /**
         * [hideNewUser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T14:36:10-0500
         * @return   {[type]}                 [Show Modal New User]
         */
        $scope.hideNewUser = function(){

            $('.new-user').modal('hide');

        }

        /**
         * [showEdituser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-14
         * @datetime 2016-09-14T10:04:16-0500
         * @return   {[type]}                 [Show Molda Edit User]
         */
        $scope.showEdituser = function(user){

            $scope.editNewUser = user;

            $scope.EditNewPeople = user.person;

            console.log($scope.EditNewPeople);

            $('.edit-user').modal('show');

        }

        /**
         * [hideEdituser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-14
         * @datetime 2016-09-14T10:45:55-0500
         * @return   {[type]}                 [Hide Molda Edit User]
         */
        $scope.hideEdituser = function(){

            $('.edit-user').modal('hide');
        }

        


        /**
         * [allDocumentTypes description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T15:55:41-0500
         * @return   {[type]}                 [Function Get All Documents Types]
         */
        $scope.allDocumentTypes = function(){

            usersService.getDocumentTypes(function(res){

                console.log(res);

                if(res.success == true){

                    $scope.listDocumentTypes = res.typeDocuments;
                }

            });

        }
        //Initilization
        $scope.allDocumentTypes(0);



         /**
          * Get the list of departments for the  dropdown
          * @return {[type]} [description]
          */
          $scope.getDepartments = function(){

            departmentsService.get(function(res){

               $scope.Departments = res.departments;
               $scope.selectedDepatment = '';
               $scope.getMunicipalities();

           }, function(error){
            console.log(error);
        });
        }
        
        /**
         * function que selecciona un departamento por su indice para el dropdown
         */
         $scope.selectDeparment = function(index){

           $scope.selectedDepatment = $scope.Departments[index];

       }  

         /**
          * obtener la lista de municipios para un departamentos seleccionado. 
          * @param  {[type]} cityId [description]
          * @return {[type]}        [description]
          */
          $scope.getMunicipalities = function(cityId){

            municipalitiesService.getByDepartment({id:$scope.selectedDepatment.id}, function(res){

                $scope.Municipalities = res.municipalities;

                if(cityId === undefined){

                    $scope.selectedMunicipalitie = $scope.Municipalities[0];

                }else{

                    for (var i = 0; i < $scope.Municipalities.length; i++) {

                        if($scope.Municipalities[i].id == cityId){

                            $scope.selectedMunicipalitie = $scope.Municipalities[i];
                            
                            break;
                        }          
                    }
                }

            }, function(error){

                console.log(error);

            });

        }
         /**
          * Obtener el departamento al cual pertenece un  municipio
          * @return {[type]} [description]
          */
          $scope.getByMunicipality = function(){


             $scope.idCity = $scope.people.municipalities_id; // get the 
             
             municipalitiesService.getByMunicipality({id:$scope.idCity}, function(res){

                for (var i = 0; i < $scope.Departments.length; i++) {

                    if($scope.Departments[i].id == res.municipalities[0].department_id){


                        $scope.selectDeparment(i); 

                        $scope.getMunicipalities($scope.idCity);

                        break;
                    }

                }



            }, function(error){
                console.log(error);

            });
         }


         $scope.getDepartments();


    /**
     * evento de cambio de seleccion de ciudad
     */
     $scope.changeSelectedMunicipality = function(){

        $scope.people.municipalities_id = $scope.selectedMunicipalitie.id;


    }



        /**
         * [getRoles description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-13
         * @datetime 2016-09-13T16:03:15-0500
         * @return   {[type]}                 [Funtion Get ALl Roles ]
         */
        $scope.getRoles = function(){

            usersService.getAllRoles(function(res){

                console.log(res);

                if(res.success == true){

                    $scope.listAllRoles = res.roles;

                }

            });

        }

        //Initialization
        
        $scope.getRoles(0);

        /**
         * [addPeople Fucntion]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-14
         * @datetime 2016-09-14T08:11:03-0500
         */
        $scope.addPeople = function(){
            $scope.newPeople.municipalities_id = $scope.selectedMunicipalitie.id;

            peopleService.addUserPeo($scope.newPeople, function(res){

                if(res.success == true){

                    $scope.newUser.people_id = res.person.id;

                   usersService.addUsers($scope.newUser ,function(res){

                    if(res.success == true){

                        $scope.resetNewPeople();
                        $scope.resetNewUser();
                        $scope.getListUsers();
                        $scope.hideNewUser();

                        }

                   });

                }

            });

        }
        /**
         * [editUser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-14
         * @datetime 2016-09-14T17:08:01-0500
         * @return   {[type]}                 [Edit Resgister User]
         */
        $scope.editUser = function(){

            usersService.editUserPe($scope.EditNewPeople, function(res){

                console.log(res);

                if(res.success == true){

                    $scope.editNewUser.people_id = res.person.id;

                    usersService.editUserPeop($scope.editNewUser, function(res){

                        console.log(res);
                        if(res.success == true){

                            $scope.getListUsers();
                            $scope.hideEdituser();

                        }

                    });

                }

            });
        }

        /**
         * [changeStateUser description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-09-15
         * @datetime 2016-09-15T11:10:50-0500
         * @param    {[type]}                 user [User Register in the System]
         * @return   {[type]}                      [Set User State]
         */
        $scope.changeStateUser = function(user){

            $scope.editNewUser = user;

            if($scope.editNewUser.active == 1){ 


                $scope.editNewUser.active = 0;

            }else{

                $scope.editNewUser.active = 1;
            }

            usersService.editUserPeop($scope.editNewUser, function(res){

                console.log(res);

                if(res.success == true){

                    $scope.getListUsers();
                }

            });

        }


        $scope.restorePasswordUser = function(user){
            l('--restorePasswordUser--');
            l($localStorage.user);
            usersService.editUser({id:$scope.restorePassword.id, password: $scope.restorePassword.password_new, action: 'restore'}, function(res){
                l('--restorePasswordUser--restablecida');
                $("#restore-password-success").show(500);
                setTimeout(
                    function(){
                        $scope.hideModalRestorePassword();
                        $("#restore-password-success").hide();
                    },
                    3000
                );
            }, function(res){
                l('--restorePasswordUser--error');
                l(res);
                $scope.hideModalRestorePassword();
            });
        }

        $scope.showPeople = function(){

            $state.go('app.people');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        /**
         * Function to add new people
         */
        $scope.desactivatedUser = function(user){

            $scope.listUsers.id = user.id;

            console.log(user.id);
            /**
             * calling service to add a new people
             */
            usersService.desactivatedUsers($scope.listUsers,function(res){


                    console.log(res);

                    $scope.getUsers();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }

         /**
         * Function to add new people
         */
        $scope.activatedUser = function(user){

            $scope.listUsers.id = user.id;

            console.log(user.id);
            /**
             * calling service to add a new people
             */
            usersService.activatedUsers($scope.listUsers,function(res){

                    console.log(res);

                    if (res.success == true){

                        $scope.getUsers();
                      
                    }
                    
                }, function (error) {

                  

            });

        }

         $scope.viewEditUser = function(user){

            $localStorage.patients = user;

            $state.go('app.editPeople');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }


                /**
         * Function to add new people
         */
        $scope.editPeoples = function(){

            console.log('entro a edit');

            console.log($scope.editPeople);

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
         * call users first time
         */
        // $scope.getUsers();

}]);