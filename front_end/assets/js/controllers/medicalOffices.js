'use strict';

/* Controllers */

angular.module('app')
    .controller('MedicalOfficesCtrl', [
        '$scope',

        '$state',

        '$rootScope',

        '$localStorage',

        '$location',

        '$timeout',

        'medicalOfficesService',

        'specializationsService',

        'studiesService',

        'studiesSpecialistService',

        /**
         * Servicio para los servicios de los consultorios
         */
        'studiesMedicalOffices',


        // 'orderDetailsService',

        'appointmentService',


        function(
            $scope, 

            $state, 

            $rootScope, 

            $localStorage, 

            $location, 

            $timeout, 

            medicalOfficesService,

            specializationsService,

            studiesService, 

            studiesSpecialistService,

            studiesMedicalOffices,

            // orderDetailsService,

            appointmentService

            ) {


    $scope.medicalOfficeRestriction = undefined;



    $scope.newMedicalOffice = {
        code: '',
        name: '',
        description: '',
        state: 1
    };    

    $scope.resetNewMedicalOffice = function(){

        $scope.newMedicalOffice = {
            code: '',
            name: '',
            description: '',
            state: 1
        };    

    }    


    $scope.editMedicalOffice = {
        id: 0,
        code: '',
        name: '',
        description: '',
        state: 1
    };    




    $scope.medicalOfficeToDrop = {};


    $scope.showModalAddMedicalOffices = function(){

        $('.add-medical-office').modal('show');

    }


    $scope.hideModalAddMedicalOffices = function(){

        $('.add-medical-office').modal('hide');

    }

    $scope.showModalEditMedicalOffices = function(editMedicalOffice){

        $scope.editMedicalOffice = editMedicalOffice;

        $('.edit-medical-office').modal('show');

    }

    $scope.hideModalEditMedicalOffices = function(){

        $('.edit-medical-office').modal('hide');

    }



    $scope.showModalDeleteMedicalOffice = function(medicalOfficeToDrop){

        $scope.medicalOfficeToDrop = medicalOfficeToDrop;

        $('.delete-medical-offices').modal('show');
    }





    $scope.hideModalDeleteMedicalOffices = function(){

        $('.delete-medical-offices').modal('hide');

    }


    $scope.medicalOffices;


    $scope.addMedicalOffice = function(){

        medicalOfficesService.addMedicalOffice($scope.newMedicalOffice, function(res){
        

                    if(res.success == true){

                        $scope.resetNewMedicalOffice();
  
                        $scope.hideModalAddMedicalOffices();
  
                        $scope.pageResultsMedicalOffices(0);
  
                    }


            }, function (error) {
        
        });


    }


    $scope.doEditMedicalOffice = function(){

        medicalOfficesService.editMedicalOffice($scope.editMedicalOffice, function(res){
    

                    if(res.success == true){

                        $scope.hideModalEditMedicalOffices();
                        $scope.pageResultsMedicalOffices(0);
                    }


            }, function (error) {
        
        });


    }


    $scope.dropMedicalOffice = function(){


        medicalOfficesService.dropMedicalOffice({id: $scope.medicalOfficeToDrop.id}, function(res){
        



                    if(res.success == true){

                        $scope.hideModalDeleteMedicalOffices();
                        $scope.pageResultsMedicalOffices(0);
                    }

            }, function (error) {
        
        });

    }


    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentPageMedicalOffices = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeMedicalOffices = 10;


        /**
     * Función que asigna los elementos a mostrar en la paginación actual
     * @param  {Int} page Numero de la pagina
     */
    $scope.pageResultsMedicalOffices = function(page){


            var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

            medicalOfficesService.getMedicalOffices({offset: offset}, function(res){
        

                console.log(res);                   

                /**
                 * Número total de items
                 * @type {Int}
                 */
                $scope.medicalOfficesTotal = res.total;

                
                $scope.medicalOffices = res.medicalOffices;    


                console.log($scope.medicalOffices);    


            }, function (error) {
        
        });
       
    };



    $scope.setState = function(state, medicalOffice){


        medicalOfficesService.setState({state: state, id: medicalOffice.id}, function(res){
        
                console.log(res.medicalOffice);


                medicalOffice.state = res.medicalOffice.state;

            }, function (error) {
        
        });        


    };



    $scope.goToScheduleIntervals = function (medicalOffice) {

        $localStorage.medicalOffice = medicalOffice;

        $state.go('app.scheduleIntervals');
            
    };    





    $scope.goToMedicalOfficesProfile = function (medicalOfficeProfile) {

        $localStorage.medicalOfficeProfile = medicalOfficeProfile;

        $state.go('app.medicalOfficeProfile');
            
    };    


    /**
     * Variable que contiene la informacion del perfil de un consultorio 
     * @type {[type]}
     */
    $scope.medicalOfficeProfile = $localStorage.medicalOfficeProfile;    


    // console.log($scope.medicalOfficeProfile);      



    /**
     * Servicios de consultorio
     */


 /**
     * Structur studies aviable 
     * 
     * @type {Object}
     */
    $scope.Studies ={
        id:"",
        name:"",
        specializations_id:"",
        cup:"",
        average_time:""

    }
    /**
     * Struct of studies asigned  to the 
     * @type {Object}
     */
    $scope.StudiesAsignated ={
        id:"",
        name:"",
        specializations_id:"",
        cup:"",
        average_time:""

    }

    /**
     * Structur Especialidades  que existen.
     * @type {Object}
     */
    $scope.Specializations = {
        id:"",
        specialization:"",
        parent_specialization:"",
        code:"",
        created:"",
        modified:""
    }
    


    /**
     * espacio donde se guardan el valor seleccionado de la lista desplegable de especializacion
     */
    $scope.selectedSpecialization;
    /** 
     * espacio donde se guardan el valor seleccionado de la lista desplegable de especializacion ya asignadas. 
     */
    $scope.medicalOfficeSpecialization;



    /**
     * Especializaciones pertenecientes al consultorio
     */
    $scope.getMedicalOfficesSpecializations = function(){


        if($scope.medicalOfficeProfile != undefined ){

            // studiesMedicalOffices.getSpecializations({medicalOfficeId: $scope.medicalOfficeProfile.id},function(res){
                        
            //     if(res.success){
            //     var options = new Array();

            //     /**
            //      * Todas las especializaciones consultadas
            //      * @type {[type]}
            //      */
            //     var specializations = res.specializations;

            //     /**
            //      * Adición de opción por defecto
            //      * @type {Number}
            //      */
            //     options.push({id: 0, specialization: 'Todas'});

            //     *
            //      * agregar opciones al nuevo arreglo options
                 
            //     for (var i = 0; i < specializations.length; i++) {
                      
            //          options.push({id: specializations[i].id, specialization: specializations[i].specialization});
                
            //     }

            //     $scope.medicalOfficeSpecialization = options;
                    
            //     console.log(options);

            //     $scope.selectedMedicalOfficeSpecialization = options[0];


            //     $scope.GetStudyAsignament();
            //     }
            // }, function(error){
                      
            //     console.log(error);
                    
            // });
            
        }

    }
        
    $scope.getMedicalOfficesSpecializations();


    /**
      * Get the list of departments for the  dropdown
      * @return {[type]} [description]
      */
    $scope.getSpecialization = function(){

        specializationsService.get(function(res){

             var options = new Array();

            /**
             * Todas las especializaciones consultadas
             * @type {[type]}
             */
            var specializations = res.specialization;

            /**
             * Adición de opción por defecto
             * @type {Number}
             */
            options.push({id: 0, specialization: 'Todas'});

            /**
             * agregar opciones al nuevo arreglo options
             */
            for (var i = 0; i < specializations.length; i++) {
                  
                 options.push(specializations[i]);
            
            }

            /**
             * Asignación de todas las opciones
             * @type {[type]}
             */
            $scope.Specializations = options;

            // $scope.Specializations = res.specialization;
            // $scope.Specializations_copy = res.specialization;
            
            /**
             * Asignacion de opcion por defecto
             * @type {[type]}
             */
            $scope.selectedSpecialization = options[0];


            console.log(res);
        
            // $scope.Specializations = res.specialization;
        



            

            //$scope.selectedSpecialization = $scope.Specializations[0];
                
            }, function(error){
        
                console.log(error);
        
            });
        

        }

        $scope.getSpecialization();
 
        /**
          * obtener la lista de servicios por especialidad
          * @return {[type]} [description]
          */
        $scope.GetStudy= function(){

            /**
             * Obtener todos los estudios
             */
            if($scope.selectedSpecialization == undefined || $scope.selectedSpecialization.id == 0){

                /**
                 * obtener estudios por especialidad
                 */
                studiesService.get(function(res){

                    if(res.studies){
                        
                            $scope.Studies = res.studies;  
                    
                        }else{
                    
                            $scope.Studies = undefined; 
                    
                    }
               
                }, function(error){

                    console.log(error);
                });


            }else{

                /**
                 * obtener estudios por especialidad
                 */
                studiesService.getBySpecialization({id:$scope.selectedSpecialization.id},function(res){

                    if(res.studies){
                    
                        $scope.Studies = res.studies;  
                
                    }else{
                
                        $scope.Studies = undefined; 
                
                    }
                
                }, function(error){
                
                    console.log(error);
                
                });

            }    

        }


        $scope.GetStudy();


        
    
          /**
           * Guardar los estudios seleccionados
           * @return {[type]} [description]
           */
         $scope.saveSelectedStudies = function (){ 


            if($scope.selectedStudies != undefined){

                var selectedStudiesList= new Array();
               
                for (var i = 0; i < $scope.selectedStudies.length; i++) {

                        console.log($scope.selectedStudies[i].id);
              
                        selectedStudiesList.push({

                            studies_id: $scope.selectedStudies[i].id,

                            medical_offices_id: $scope.medicalOfficeProfile.id

                        });
                    
                    }


                    studiesMedicalOffices.addAll(selectedStudiesList,function(res){
                    
                        if (res.success == true){

                             $scope.getAllBySpecialist();

                             console.log(res);

                        }else{
     
                            $scope.getAllBySpecialist();


                         }}, function(error){
                             
                             console.log(error);
                    });
                
    
                selectedStudiesList = null;
            


            }else{
                // mensaje...

            }

         }


         /**
          * Funcion que asigna los estudios seleccionados a un consultorio
          */
         $scope.saveAllStudies = function(){

            /**
             * Estudios seleccionados
             * @type {Array}
             */
             var selectedStudies= new Array();


                if($scope.Studies != undefined){

                    for (var i = 0; i < $scope.Studies.length; i++) {

                        
                        /**
                         * Formacion del objeto de estudio por consultorio
                         * @type Object
                         */
                        selectedStudies.push({
                            studies_id:         $scope.Studies[i].id,
                            medical_offices_id:  $scope.medicalOfficeProfile.id
                        });

                    }

                    /**
                     * Se envian los estudios a guardar
                     */
                    studiesMedicalOffices.addAll(selectedStudies,function(res){

                        console.log(res);
                        
                        // if (res.success == true){

                        //       //carga servicios asignados..
                        //     $scope.getAllBySpecialist();
                          
                        // }else{     
                        //     $scope.getAllBySpecialist4();
                        // }
                     
                        }, function(error){
                      
                           console.log(error);
                    
                    });
                }

            }
         /**
          * Obtiene todos los estudios ya asignados a un especialista. 
          */
 
      $scope.GetStudyAsignament = function (){


           if($scope.selectedMedicalOfficeSpecialization == undefined || $scope.selectedMedicalOfficeSpecialization.id == 0){


                studiesMedicalOffices.getMedicalOfficesServices({medicalOfficeId: $scope.medicalOfficeProfile.id}, function(res){

                    $scope.StudiesAsignated = res.services;


                }, function(error){
                
                    console.log(error);
                
                });


           }else{



            studiesMedicalOffices.getMedicalOfficesServicesBySpecialization({medicalOfficeId: $scope.medicalOfficeProfile.id, specializationId: $scope.selectedMedicalOfficeSpecialization.id},function(res){


                if(res.services){

                    $scope.StudiesAsignated = res.services;  
                
                }else{
            
                    $scope.StudiesAsignated = undefined;
            
                }

            }, function(error){
                console.log(error);
            });

           }


    }

    
    

    $scope.deleteAsigned = function(){
           

           if($scope.selectedStudiesAsignated != undefined){


            var selectedStudies= new Array();


                console.log($scope.selectedStudiesAsignated);

                for (var i = 0; i < $scope.selectedStudiesAsignated.length; i++) {

                    selectedStudies.push({
                        id: $scope.selectedStudiesAsignated[i].id
                    });
                    console.log(selectedStudies[i]);


                }


                studiesSpecialistService.delete(selectedStudies,function(res){

                    console.log(res);


                    if (res.success == true){
                         // carga servicios asignados.. 
                         $scope.getAllBySpecialist();


                     }else{   

                        $scope.getAllBySpecialist();    
                     }

                 }, function(error){
                   console.log(error);
               });


            }else{

                /**
                 * Mensaje
                 */
            }


            }

        $scope.deleteAllAsigned = function(){
           
            var selectedStudies= new Array();
                console.log($scope.StudiesAsignated);

                for (var i = 0; i < $scope.StudiesAsignated.length; i++) {

                    selectedStudies.push({
                        id: $scope.StudiesAsignated[i].id
                    });
                    console.log(selectedStudies[i]);


                }

        studiesSpecialistService.delete(selectedStudies,function(res){

                    console.log(res);
                   
                  
                    if (res.success == true){
                         // carga servicios asignados.. 
                          $scope.getAllBySpecialist();

                      
                    }else{   $scope.getAllBySpecialist();  }
                 
                 }, function(error){
                         console.log(error);
            });
        }









        // /**
        //  * Detalles de la nueva orden
        //  * @type {Object}
        //  */
        // $scope.orderDetail = {

        //     /**
        //      * Subtotal
        //      * @type {Number}
        //      */
        //     subtotal                :0,

        //     /**
        //      * Validador
        //      * @type {String}
        //      */
        //     validator               :'',

        //     /**
        //      * Coopago
        //      * @type {Number}
        //      */
        //     coopago                 :0,

        //     /**
        //      * Total
        //      * @type {Number}
        //      */
        //     total                   :0,


        //     /**
        //      * Observaciones
        //      * @type {String}
        //      */
        //     observations            :'',

        //     /**
        //      * Edad Calculada
        //      * @type {String}
        //      */
        //     calculated_age          :'',

        //     /**
        //      * Cortesia
        //      * @type {Number}
        //      */
        //     courtesy                :0,

        //     /**
        //      * Descuento
        //      * @type {Number}
        //      */
        //     discount                :0,

        //     /**
        //      * Identificador de cliente
        //      * @type {Number}
        //      */
        //     clients_id              :1,

        //     /**
        //      * Identificador de tarifa
        //      * @type {Number}
        //      */
        //     rates_id                :1,

        //     /**
        //      * Identificador de paciente
        //      * @type {Number}
        //      */
        //     patients_id             :1,

        //     /**
        //      * Identificador especialista
        //      * @type {Number}
        //      */
        //     external_specialists_id :1,

        //     /**
        //      * Estado de la orden
        //      * @type {Number}
        //      */
        //     order_states_id         :1,


        //     /**
        //      * Tipo de servicio
        //      * @type {Number}
        //      */
        //     service_type_id         :1,


        //     /**
        //      * Tipo de orden
        //      * @type {Number}
        //      */
        //     order_types_id          :1, 


        //     /**
        //      * Sede
        //      */
        //      centers_id             :1

        // };


        // /**
        //  * Funcion para guardar un detalle de una orden
        //  * @return {[type]} [description]
        //  */
        // $scope.doNewOrderDetail = function(){


        //     /**
        //      * asignar valores
        //      */

        //     orderDetailsService.newOrderDetail($scope.orderDetail,function(res){

        //                 console.log(res);
                      
                     
        //              }, function(error){
        //                      console.log(error);
              

        //     });

        // }


        //  // $scope.doNewOrderDetail();
    
            

        // *
        //  * Nueva cita
        //  * @type {Object}
         
        // $scope.appointment = {

        //     /**
        //      * identificador de consultorio
        //      * @type {Number}
        //      */
        //     medical_offices_id      : 7,
                
        //     /**
        //      * identificador de 
        //      * @type {Number}
        //      */
        //     order_details_id        : 12,


        //     /**
        //      * [studies_id description]
        //      * @type {Number}
        //      */
        //     studies_id              : 1,

        //     /**
        //      * Valor del estudio
        //      * @type {Number}
        //      */
        //     studies_value           : 10,


        // };


        // /**
        //  * Fechas de la cita
        //  * @type {Object}
        //  */
        // $scope.appointmentDates = {

        //     /**
        //      * Identificador de la cita
        //      * @type {Number}
        //      */
        //     appointments_id         :1,

        //     /**
        //      * estado de la cita, inicialmente 1: Reservada
        //      * @type {Number}
        //      */
        //     appointment_states_id   :1,

        //     /**
        //      * Fecha y hora de inicio de la cita
        //      * @type {String}
        //      */
        //     date_time_ini           :'2016-10-10 10:10:10',

        //     /**
        //      * Fecha y hora de finalizacion de la cita
        //      * @type {String}
        //      */
        //     date_time_end           :'2016-10-10 10:10:20',
        // }


        // $scope.saveAppointment = function(){

        //     appointmentService.saveAppointment($scope.appointment,function(res){

        //             console.log(res);
                      
                     
        //         }, function(error){
                
        //         console.log(error);
              
        //     });


        // }

        // // $scope.saveAppointment();


        // $scope.saveAppointmentDates = function(){

        //     appointmentService.saveAppointmentDates($scope.appointmentDates,function(res){

        //             console.log(res);
                      
                     
        //         }, function(error){
        //            console.log(error);
        //   });

        // }


        // // $scope.saveAppointmentDates();



        // $scope.getAppointment = function(id){


        //     appointmentService.getAppointment({id:id},function(res){

        //             console.log(res);
                      
                     
        //         }, function(error){

        //             console.log(error);
        
        //     });

        // }


        // // $scope.getAppointment(1);



        // $scope.deleteAppointment = function(id){


        //     appointmentService.deleteAppointment({id:id},function(res){

        //             console.log(res);
                      
                     
        //         }, function(error){

        //             console.log(error);
        
        //     });

        // }


        // // $scope.deleteAppointment(2);




}]);
















