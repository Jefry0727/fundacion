'use strict';

/* Controllers */

angular.module('app')
     .controller('SpecialistCtrl', [

        '$scope',
        '$state',
        '$rootScope',
        'peopleService',
        'rolesService',
        'patientsService',
        'usersService',
        'specialistService',
        'departmentsService',
        'municipalitiesService',
        'fileUploadSignature',
        'fileUpload',
        '$location',
        '$localStorage',
        function(
        $scope, 
        $state,
        $rootScope,
        peopleService,
        rolesService,
        patientsService,
        usersService,
        specialistService,
        departmentsService,
        municipalitiesService,
        fileUploadSignature,
        fileUpload,
        $location,
        $localStorage) {


    //patients to set people
    $scope.specialists = $localStorage.specialists;

    $scope.specialists = {
        people_id: "",
    };

    $scope.selectedTypeId = undefined;

    $scope.calculateAgeChange = function(date){

        $scope.calculated_age = calculateAge(date);

    }


    $scope.changeSelectedGender = function(){

        if($scope.selectGender == undefined){

            $scope.people.gender = undefined;

        }else{

            $scope.people.gender = $scope.selectGender.code;
        }

        console.log($scope.people);
    }


     /** 
         * Model Information for informacion demografica paciente.
         * @type {Object}
         */
        $scope.people = {   

            id: 0,
            document_types_id:"",
            identification:"",
            first_name: "",
            middle_name: "",
            last_name:"",
            last_name_two:"",
            birthdate: "",
            gender:"",
            address: "",
            phone: "",
            email: "",
            municipalities_id:""
        }

        $scope.searchPeople = {
            identification:""
        };

        $scope.calculated_age ="";


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

        $scope.idPatients = ""; 

        $scope.selectGender = $scope.gender[0];

        $scope.viewEditSpecialists = function(specialists){

            $localStorage.patients = specialists;

            console.log('algo');

            console.log(specialists);

            $state.go('app.editPeople');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        $scope.showSpecialist = function(specialists){


            $state.go('app.specialist');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }

        $scope.showPatients = function(){

            $state.go('app.patients');

            // $location.path("/app/editPeople.html" + patients.person.id);
        }


        /**
         * Funcion que detecta el cambio en el tipo de documento.
         */
        $scope.setSelectedTypeId = function(){

            $scope.people.document_types_id = $scope.selectedTypeId;

            console.log($scope.people.document_types_id);

        }

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
        $scope.getPeoples = function(id){

            console.log('muestra id:');

            console.log(id);


            peopleService.getPeoples({id:id},function(res){

                console.log('resultado de eso:');

                $scope.editPeople = res.result;

                console.log($scope.editPeople);

                if($scope.editPeople.gender == 1){

                    $scope.selectGender = $scope.gender[1];

                }else{

                    $scope.selectGender = $scope.gender[0];
                }

                }, function (error) {

                    console.log(error);
            });

        }

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageGetSpecialist = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeGetSpecialist = 10;

        /**
        * Function to get the last added user
        */
        $scope.getSpecialist = function(page){

             var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10;
            }

            specialistService.getPagSpecialist({offset : offset},function(res){

                $scope.specialists = res.specialists;

                $scope.total = res.total;

                // $scope.editUser = res.specialists[0].user;

                console.log('devolvio especialistas');

                console.log(res);

                
                }, function (error) {

            });

        }

        $scope.getSpecialist();

         $scope.editUser = {

            username:"",
            password:"wadsfd",
            roles_id:"",
            people_id:"",
        }


        $scope.newUser = {

            username:"",
            password:"werew",
            roles_id: 3,
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
         * Function to add new people
         */
        $scope.desactivatedUser = function(specialists){

            
            console.log('entro acà');

            $scope.sepecialist = specialists;

            console.log($scope.sepecialist);
            /**
             * calling service to add a new people
             */
            usersService.desactivatedUsers($scope.sepecialist,function(res){

                console.log('devolvio acà');


                    console.log(res);

                    $scope.getSpecialist();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }

         /**
         * Function to add new people
         */
        $scope.activatedUser = function(specialists){

            $scope.sepecialist = specialists;

            console.log($scope.sepecialist);
            /**
             * calling service to add a new people
             */
            usersService.activatedUsers($scope.sepecialist,function(res){


                    console.log(res);

                    $scope.getSpecialist();

                    if (res.success == true){

                      
                    }
                    
                }, function (error) {

                   

            });

        }


        $scope.goToSpecialistProfile = function(specialist){

            console.log(specialist);

            $localStorage.specialist = specialist;

            $state.go('app.professionalProfile');


        }

        /**
          * Get the list of departments for the  dropdown
          * @return {[type]} [description]
          */
          $scope.getDepartments = function(){

            departmentsService.get(function(res){

             $scope.Departments = res.departments;
             $scope.selectedDepatment = $scope.Departments[0];
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

    function calculateAge(date)
         {
           
       // console.log(date);
       if(date != undefined && date !=""){
        var dt = date;

        console.log(dt);
        dt = dt.split("-");

        dt = dt[2]+'/'+dt[1]+'/'+dt[0];

        var formato = "dd/mm/yyyy";
        var separador = "/";

        var  fecha = new Date()
        var  mmes = ""
        var mdia = ""
        switch (formato.substring(0, 2).toLowerCase()) {
            case "dd":
            var mes = dt.substring(3, 5)
            if (mes < 10 && mes.length == 1) {
                mmes = "0" + mes
            } else {
                mmes = "" + mes
            }
            var  dia = dt.substring(0, 2)
            if (dia < 10 && dia.length == 1) {
                mdia = "0" + dia
            } else {
                mdia = "" + dia
            }
            var  anno = dt.substring(6, 10)
            break;
            case "mm":
            var mes = dt.substring(0, 2)
            if (mes < 10) {
                mmes = "0" + mes;
            } else {
                mmes = "" + mes;
            }
            var       dia = dt.substring(3, 5)
            if (dia < 10) {
                mdia = "0" + dia
            } else {
                mdia = "" + dia
            }
            var   anno = dt.substring(6, 10)
            break;
            case "yy":
            var  mes = dt.substring(5, 7)
            if (mes < 10) {
                mmes = "0" + mes;
            } else {
                mmes = "" + mes;
            }
            var   dia = dt.substring(8, 10)
            if (dia < 10) {
                mdia = "0" + dia
            } else {
                mdia = "" + dia
            }
            var      anno = dt.substring(0, 4)
            break;
        }

        var  fecha = new Date(parseInt(anno), parseInt(mmes, 10) - 1, parseInt(mdia, 10));
        var   birthTime = new Date(fecha);
        var todaysTime = new Date();

        var MNames = new Array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");

        //Año mes y dia de la fecha actual.
        var yd = todaysTime.getFullYear()
        var md = todaysTime.getMonth()
        var dd = todaysTime.getDate()
        md = md + 1;

        var yb = birthTime.getFullYear()
        var mb = birthTime.getMonth()
        var db = birthTime.getDate()
        mb = mb + 1;
        //meses de 0-11

        var mLength = parseInt(new Date(yd, (md == 1? 12 : (md-1)), 0).getDate());
        var ma = 0
        var ya = 0

        var da = dd - db;
        // This is the all-important day borrowing code.
        if (da < 0) 
        {
            md--
            da = dd + (mLength - db)
            if (md < 1) {
                yd--
                md = 12;
            }
        }
        ma = md - mb
        // Month borrowing code - borrows months from years.
        if (ma < 0) 
        {
            yd--
            ma = md + (12 - mb)
        }

        ya = yd - yb;
        if (birthTime > todaysTime) {
            ya = ma = da = '0';
        }

        var formattedAge = ya + "." + ma + "." + da;

       // var formattedAge = ya;

       return  formattedAge;
       // $('#age').val(formattedAge);
   }
}


/**
 * Buscar un paciente de acuerdo a su numero de identificacion 
 */
 $scope.searchPatients = function(elm){


        // if($scope.searchPeople.identification != null || $scope.searchPeople.identification != undefined){

        //     patientsService.searchPatients({id:$scope.searchPeople.identification},function(res){

        //         // console.log('entro');

        //         // console.log(res);

        //         /**
        //          * Si se encuentra el paciente
        //          */
        //         if(res.success == true){

        //             $(elm).popover('hide');

               
        //         }else {


        //             if($scope.searchPeople.identification != null){

        //                  $scope.canSetService = false;

        //                  $scope.people.identification = $scope.searchPeople.identification;

        //                  $scope.error = 'PROFESIONAL DE LA SALUD NO ENCONTRADO.';

        //                  // $scope.people = null;

        //                  // $scope.patient = null;



        //                     /** 
        //                      * Model Information for informacion demografica paciente.
        //                      * @type {Object}
        //                      */
        //                     $scope.people = {   

        //                         id:0,
        //                         document_types_id:  undefined,
        //                         identification:     "",
        //                         first_name:         "",
        //                         middle_name:        "",
        //                         last_name:          "",
        //                         last_name_two:      "",
        //                         birthdate:          "",
        //                         gender:             undefined,
        //                         address:            "",
        //                         phone:              "",
        //                         email:              "",
        //                         municipalities_id:  undefined
        //                     }


        //                  $scope.selectedTypeId = null;

        //                  $scope.selectGender = null;

        //                  $scope.calculated_age = null;


        //          }

        //      }

        //  }, function (error) {

        //  });

       
        //         // $location.path("/app/editPeople.html" + patients.person.id);
    
        // }                

    }
       


        $scope.myFile;

        // Item List Arrays
        $scope.specialists = [];





         


    

     /**
          * Guardar nuevos datos demograficos de paciente
          */
        $scope.addPeople = function(){

                /**
                 * Cambio de ciudad
                 */
                $scope.changeSelectedMunicipality();

                $scope.people.identification = $scope.searchPeople.identification;

                patientsService.addPeoples($scope.people,function(res){

                    console.log("agregado");

                    console.log(res);

                    if (res.success == true){

                        $scope.people.id = res.person.id;

                        $scope.newSpecialist.people_id = res.person.id;

                        $scope.newUser.people_id = res.person.id;

                        $scope.newUser.username = $scope.people.identification;

                        $scope.unique  = '';

                        $scope.addUser();

                    }else{

                        // $scope.uniqueEmail = res.errors.email.unique;

                        // $scope.uniqueIdentification = res.errors.identification.unique;

                        // console.log(res.errors);
                    }
                    
                }, function (error) {

                    // $scope.unique = res.errors.email.unique;

                    // console.log($scope.unique);

                });


         } 

         $scope.addUser = function(){

            console.log($scope.newUser);
            /**
             * calling service to add a new user
             */
            usersService.addUsers($scope.newUser,function(res){

                    if (res.success == true){

                        console.log('entro users');

                        $scope.newSpecialist.users_id = res.person.id;

                        $scope.newSpecialist.people_id = res.person.people_id;
                        
                        $scope.addSpecialist();

                    }else{

                        console.log('error'); 

                        console.log(res.errors.email);
                    }

                    console.log(res);

                    
                }, function (error) {


                    console.log(res);

            });

        }

        $scope.newSpecialist = {

            users_id:"",
            people_id:"",
            signature:"",
            professionar_card:"",
            speciality:""

        }


        /**
         * envento para la carga de la foto de perfil
         */
       $scope.triggerClickUploadSign = function(){

            angular.element(document.querySelector('#signFileInput')).click();

       }



        /**
         * Function to add new patients
         */
        
        $scope.addSpecialist = function(){

            console.log('entro especialista');

            console.log($scope.newSpecialist);
            /**
             * calling service to add a new patients
             */
            specialistService.addSpecialist($scope.newSpecialist,function(res){

                    console.log('registro specialist');

                    console.log(res);

                    console.log(res.success);



                    $scope.uploadFile(res.specialist);

                    
                }, function (error) {


                    console.log(res.person);

            });

        }




        $scope.uploadFile = function(specialist){
        

            var typeOfFile = typeof $scope.myFile;  
            

            if(typeOfFile != 'undefined'){

                var file = $scope.myFile;

                console.log(file);
                
                fileUploadSignature.uploadFileSignature(file,specialist.id,function(res){
                    
                    $state.go('app.specialists');

                    console.log(res);

                    }, function (error) {
                
                });

            }else{

                $state.go('app.specialists');
            }
        
        };

        



}]);