'use strict';

/* Controllers */

angular.module('app')
    .controller('professionalProfileCtrl', 
      [

      '$scope', 
      
      '$state',
      
      '$rootScope',
      
      '$localStorage',
      
      '$location',
      
      '$timeout', 
      
      'ordersService',
      
      'studiesSpecialistService',
      
      'specializationsService',
      
      'costCentersService',
      
      'studiesService',
      
      'fileUploadSignature',
      
      'specialistService', 

      'specialistsAvailablesService',

      'sheduleSpecialistsService',

      'appointmentService',

    function($scope,
        $state,
        $rootScope,
        $localStorage, 
        $location, 
        $timeout,
        ordersService,
        studiesSpecialistService,
        specializationsService,
        costCentersService,
        studiesService,
        fileUploadSignature,
        specialistService,
        specialistsAvailablesService,
        sheduleSpecialistsService,
        appointmentService
    ){



    $scope.editProfessionalProfile = {

      id:'',
      document_types_id:'',
      identification:'',
      first_name: '',
      middle_name: '',
      last_name:'',
      last_name_two:'',
      birthdate: '',
      gender: '',
      address: '',
      phone: '',
      email: ''


    };

    $scope.editSpecilist = {

      id:'',
      people_id:'',
      user_id:'',
      created:'',
      modified:'',
      signature:'',
      professionar_card:'',
      speciality:''


    };
    
    /**
     * Object Structur especialist
     * @type {Object}
     */
    $scope.specialist = $localStorage.specialist;

    console.log('aaaaaa');
    console.log($scope.specialist );

    console.log("ver");
    console.log($scope.specialist.id);

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


    $scope.showModalAddAvailability = function(){
      $('.add-disponibility').modal('show');
    }
    $scope.hideModalAddAvailability = function(){
      $('.add-disponibility').modal('hide');
    }


    $scope.showModalAddException = function(){
      $('.add-exception-specialist').modal('show');
    }

    $scope.hideModalAddException = function(){
      $('.add-exception-specialist').modal('hide');
    }


    $scope.showModalEditException = function(exception){
      $scope.editExceptionSpecialist = exception.id;
      $scope.editExceptionSpecialist = exception;
      $scope.editExceptionSpecialist.date_ini = exception.date_ini.substr(0,10);
      $scope.editExceptionSpecialist.date_end = exception.date_end.substr(0,10);

      $('.edit-exception-specialist').modal('show');
    }

    $scope.hideModalEditException = function(){
      $('.edit-exception-specialist').modal('hide');
    }


    
    /*
      Estructura de los consulorios
     */
    $scope.medicalOffices = undefined;


    /**
     * espacio donde se guardan el valor seleccionado de la lista desplegable de especializacion
     */
    $scope.selectedSpecialization ;
    /** 
     * espacio donde se guardan el valor seleccionado de la lista desplegable de especializacion ya asignadas. 
     */
    $scope.selectedSpecialization_copy;
   
    /**
      * Obtiene la lista de especializaciones disponibles. 
      * @return {[type]} [description]
      */
    $scope.getSpecialization = function(){

        specializationsService.get({idCenter:$scope.selectedCenter},function(res){
            // console.log(res);

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
            options.push({id: 0, specialization: '--Seleccione Especialidad--'});

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
            $scope.Specializations_copy = undefined;
            
            /**
             * Asignacion de opcion por defecto
             * @type {[type]}
             */
            $scope.selectedSpecialization = options[0];
            $scope.GetStudy();
            

            
            }, function(error){
                console.log(error);
            });
         }

        // $scope.getSpecialization();
 
        /**
          * Obtiene todos los estudios de acuerdo a la especializacion seleccionada. 
          * @return {[type]} [description]
          */
         

        /**
        * Get all The specializations
        * @return {[type]} [description]
        */
        $scope.getCenters = function(){

        costCentersService.get(function(res){
                console.log('Centros de Costos');
                console.log(res);
                
                $scope.Cost = res.costCenter;

              }, function(error){
                console.log(error);
              });
        }

        // load all the Regimens types.
        $scope.getCenters();
  
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
                studiesService.getBySpecialization({idSpecialization:$scope.selectedSpecialization.id},function(res){

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
       * Obtiene todos los estudios asignados a un specialista. 
       * @return {[type]} [description]
       */
       $scope.getAllBySpecialist = function(){

             studiesSpecialistService.getAllBySpecialist({id:$scope.specialist.id},function(res){

                $scope.StudiesAsignated = res.studyBySpecialist;

                console.log(res.studyBySpecialist);
                $scope.getSpecializationsById(res.studyBySpecialist);
            }, function(error){
                console.log(error);
            });
         } 
       
        /**
          * Obtiene todos los estudios ya asignados a un especialista. 
          */
         
      $scope.getSpecializationsById = function(datos){
        if(datos == undefined){
          return false;
        }

        var attentions_id = new Array();
        for(var i =0 ; i < datos.length; i++){
          attentions_id.push(datos[i].study.specializations_id);
        }
        l('--getSpecializationsById--');
        l(attentions_id);

        //Obtiene la lista de consultorios en los cuales puede antender el especialista
        var studies_id = new Array();
        for(var i=0; i< $scope.StudiesAsignated.length ;i++){
          studies_id.push($scope.StudiesAsignated[i].studies_id);
        }
        console.log('--get medical centers--');
        $scope.medicalCenters = appointmentService.getMedicalOfficesByService({studyId:studies_id}, function(res){
          var opciones = new Array();

          for(var i=0; i<res.medicaOffices.length; i++){
            opciones.push({id:res.medicaOffices[i].MedicalOffices.id, label:res.medicaOffices[i].MedicalOffices.name});
          }
          

          $scope.medicalOffices = opciones;
          console.log($scope.medicalOffices);
          l(res);
        }, function(res){

        });
        

        specializationsService.getSpecializationsById({attentions_id:attentions_id}, function(res){
          l(res);
          $scope.Specializations_copy = res;
        },function(res){});
        
      }
 
      $scope.GetStudy_asignament = function (){

           // $scope.getAllBySpecialist();

            studiesSpecialistService.getFilterStudies({idSpecialist: $scope.specialist.id,idSpecialization:$scope.selectedSpecialization_copy.id},function(res){
                if(res.studyBySpecialist){
                    $scope.StudiesAsignated= res.studyBySpecialist;


                }else{
                        $scope.StudiesAsignated= "";
                 } 


                console.log(res.studyBySpecialist);
            }, function(error){
                console.log(error);
            });
    }
          /** 
           * carga los estudios ya asignados al abrir la pagina. 
           */
          $scope.getAllBySpecialist();

          /**
           * Save los estudios seleccionados
           * @return {[type]} [description]
           */
         $scope.saveSelectedStudies = function (){ 
            
                var selectedStudiesList= new Array();
               

                for (var i = 0; i < $scope.selectedStudies.length; i++) {
                    console.log($scope.selectedStudies[i].id);
              
                        selectedStudiesList.push({
                            studies_id: $scope.selectedStudies[i].id,
                            specialists_id:$scope.specialist.id
                        });
                    
                    }

                    studiesSpecialistService.addAll(selectedStudiesList,function(res){
                    
                    if (res.success == true){

                         $scope.getAllBySpecialist();
                        console.log(res);

                    }else{
                        $scope.getAllBySpecialist();

                     }}, function(error){
                         
                         console.log(error);
                        });
                
            selectedStudiesList = null;
         }

    /**
     * guarda todos lo estudios disponibles en segun especialidad seleccionada.
     * @return {[type]} [description]
     */
         $scope.saveAllStudies = function(){

             var selectedStudies= new Array();
                console.log($scope.Studies);

                for (var i = 0; i < $scope.Studies.length; i++) {

                    selectedStudies.push({
                        studies_id: $scope.Studies[i].id,
                        specialists_id:$scope.specialist.id
                    });

                }

                studiesSpecialistService.addAll(selectedStudies,function(res){

                    console.log(res);
                    
                    if (res.success == true){
                          //carga servicios asignados..
                        $scope.getAllBySpecialist();
                      
                    }else{     
                        $scope.getAllBySpecialist4();
                     }
                 
                 }, function(error){
                         console.log(error);
                        });

                console.log(selectedStudies);

            }
        


   
    /**
     * Elimina todos los estudios seleccionados ya asignados al especialista. 
     * @return {[type]} [description]
     */
    $scope.deleteAsigned = function(){
           
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

                      
                    }else{   $scope.getAllBySpecialist();    }
                 
                 }, function(error){
                         console.log(error);
                        });
        }

/**
 * Elimina todos los estudios asignados al especialista. 
 * @return {[type]} [description]
 */
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








    /**
     * Excepciones
     */


        $('[name=iniHour]').timepicker();

        $('[name=endHour]').timepicker();

        $('[name=iniDate]').datepicker({
          format : 'yyyy-mm-dd'
        });

        $('[name=endDate]').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('[name=iniHourException]').timepicker({
          timeFormat : 'HH:mm:ss'
        });
        $('[name=endHourException]').timepicker({
          timeFormat : 'HH:mm:ss'
        });

        

    
    $scope.newException = {
        specialists_id:'',
        date_ini:'',
        date_end:'',
        description: '',
        hour_ini_exception: '',
        hour_end_exception: ''
    };

    $scope.editExceptionSpecialist = {
        id:'',
        date_ini:'',
        date_end:'',
        description: '',

    };

    $scope.dropExeption= {};




    $scope.hideModaException = function(){

        $('.edit-new-exception').modal('hide');
    }






    //añade las restricciones en el horario de los especialistas
    $scope.addNewException = function(){   
      $scope.newException.specialists_id = $scope.specialist.id;
      l('--addNewException()--');
      
      //Concatena la hora a la fecha de la excepcion
      $scope.newException.date_ini += ' '+moment($scope.newException.hour_ini_exception, 'h:mm a').format('HH:mm:ss');
      $scope.newException.date_end += ' '+moment($scope.newException.hour_end_exception, 'h:mm a').format('HH:mm:ss');
      l($scope.newException);
      

      specialistService.saveSpecialistRestriction($scope.newException, function(res){
      
        l(res);
        console.log('si');
        $scope.hideModalAddException();
        $scope.pagesResultScheduleEspecialistRestriction(0);
      
      }, function(res){
      
        l('--Error addNewException()--');
        l(res);
      
      });
    }




     //Show Modal Service
    $scope.showModalService = function(){

        $('.services-professional-profile').modal('show');

    }

    //Hide Modal Service
    
    $scope.hideModalService = function(){

        $('.services-professional-profile').modal('hide');

    }

    //Show Modal Availability 
    
    $scope.showModalAvailability = function(){

        $('.availability-professional-profile').modal('show');

    }

    // Hide Modal Availability 
    $scope.hideModalAvailability = function(){

        $('.availability-professional-profile').modal('hide');

    }

    //Show Modal Edit Professional Profile
    $scope.showModalEditProfile = function(){

    $('.edit-professional-profile').modal('show');

    }


    // Hide Modal Edit Professional Profile
    
    $scope.hideModalEditProfile = function(){

    $('.edit-professional-profile').modal('hide');

    }


    $scope.saveException = function(){



        specialistService.saveSpecialistRestriction($scope.newException, function(res){

            console.log('retorno');
            console.log(res);

            if(res.success == true){

                $scope.addNewException();
                $scope.hideModalAddException();

            }

        });

    }

    //guarda los horarios de disponibilidad del especialista
    $scope.saveAvailability = function(){
      l('--saveAvailability--640');
  
      $scope.newAvailable.specialists_id = $scope.specialist.id;
      l($scope.specialist);
      $scope.newAvailable.time_ini = moment($scope.newAvailable.time_ini, 'hh:mm a').format('HH:mm');
      $scope.newAvailable.time_end = moment($scope.newAvailable.time_end, 'hh:mm a').format('HH:mm');
      l($scope.newAvailable);
      sheduleSpecialistsService.add($scope.newAvailable, function(res){
        l(res);
        $scope.hideModalAddAvailability();
      }, function(res){
        l('error saveAvailability line 685');
      });

    }

    $scope.editException = function(){
        l('--editException--');
        $scope.editExceptionSpecialist.date_ini+=' '+moment($scope.editExceptionSpecialist.hour_ini_exception, 'hh:mm a').format('HH:mm:ss');
        $scope.editExceptionSpecialist.date_end+=' '+moment($scope.editExceptionSpecialist.hour_end_exception, 'hh:mm a').format('HH:mm:ss');
        l($scope.editExceptionSpecialist);

        specialistService.editSpecialistRestriction($scope.editExceptionSpecialist, function(res){
            $scope.editExceptionSpecialist=undefined;
            l('--editException--editado');

            if(res.success == true){

                $scope.hideModalEditException();
                $scope.pagesResultScheduleEspecialistRestriction(0);

            }

        },function(res){
          l('--editException--error');
          l(res);
        });

    }
    

    $scope.currentPageScheduleEspecialistRestriction = 0;

    $scope.pageSizeScheduleEspecialistRestriction = 10;

    $scope.pagesResultScheduleEspecialistRestriction = function(page){

         var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }


        specialistService.getSpecialistRestriction({offset :offset}, function(res){

            console.log(res);

            $scope.scheduleEspecialistRestrictionTotal = res.totalScheduleEspecialistRestriction;

            $scope.scheduleEspecialistRestrictions = res.scheduleEspecialistRestrictions;

            console.log($scope.scheduleEspecialistRestrictions); 

            }, function (error) {


        });

    }

    $scope.pagesResultScheduleEspecialistRestriction(0);


 /** 
  * Disponibility  start Module to
  * 
  */
 

 $scope.checkboxDay = {
       Domingo:"0",
       Lunes:"1",
       Martes:"2",
       Miercoles:"3",
       Jueves:"4",
       Viernes:"5",
       Sabado:"6"
     };

$scope.specialistAvailable={
  id:"",
  day:"",
  time_ini:"",
  time_end:"",
  state:""
}

$scope.newAvailable = { 
  day:"",
  time_ini:"",
  time_end:"",
  description:"",
  schedule_specialist_types_id:"",
  medical_offices_id:""
  }



  $scope.selectedDay;

  console.log($scope.checkboxDay);

  $scope.config = function(day){

   //console.log($day);
      // $('[name=day-availability]').val(day);

      $scope.newAvailable.day = day;

      $scope.showModalAddAvailability();
      $scope.hideModalAvailability();

  }


  $scope.checkDay = function($day){



        //specialistAvailableService

    // si no existe muestro modal para adicionar 
    // 
    // chequear si ya existe el dia-- 
    //  
    //  si existe se cambia el estado 
    //  
   
}
     // $scope.showModalAddException();

// $scope.gender = [

//     {name:'Masculino', code:0},
//     {name:'Femenino', code:1}
// ];


        $scope.getDisponibilityByDay= function(){


        }



        /**
         * envento para la carga de la foto de perfil
         */
       $scope.triggerClickUploadSign = function(){

            angular.element(document.querySelector('#uploadSignatureProfessional')).click();

       }


       /**
        * modelo de archivo para la firma
        */
        $scope.fileSingature;


        $scope.image_source = undefined;

        /**
         * Subir firma
         * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
         * @date     2016-09-09
         * @datetime 2016-09-09T11:09:53-0500
         * @return   {[type]}                 [description]
         */
        $scope.uploadSignature = function(){
        
            var typeOfFile = typeof $scope.fileSingature;  
        
            if(typeOfFile != 'undefined'){

                var file = $scope.fileSingature;

                console.log(file);
                
                fileUploadSignature.uploadFileSignature(file,$scope.specialist.id,function(res){

                    console.log(res);

                    }, function (error) {
                      l('error --uploadSignature()--');
                      l(error);
                
                });

            }
        };

    /**
     * obtener firma
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-09
     * @datetime 2016-09-09T11:09:44-0500
     * @return   {[type]}                 [description]
     */
    $scope.getSignature = function(){

        if($scope.specialist != undefined){

          specialistService.getSpecialistSignature({id: $scope.specialist.id }, function(res){

                console.log(res);

                if(res.success == true){

                    console.log("signature...");

                    $scope.image_source = res.picture.url;

                }else{


                    console.log("signature...");

                    $scope.image_source = undefined;

                }

                

                }, function (error) {
            
            });

        }  

    };

    /**
     * Obetener Firma primera vez
     */
    $scope.getSignature();


     /**
      * Vista previa para un archivo
      * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
      * @date     2016-09-09
      * @datetime 2016-09-09T11:10:18-0500
      * @param    {[type]}                 element [description]
      */
     $scope.setFile = function(element) {


      
        var reader = new FileReader();

        reader.onload = function(event) {
        
          $scope.image_source = event.target.result;
          
              $scope.$apply();
        }
        
        // when the file is read it triggers the onload event above.
        reader.readAsDataURL(element.files[0]);
      
      }

   
      /**
       * Guardado de información de especialista
       * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
       * @date     2016-09-09
       * @datetime 2016-09-09T11:10:32-0500
       * @return   {[type]}                 [description]
       */
     $scope.saveSpecialist = function(){


        $scope.uploadSignature();

        

        $timeout(function () {
  
             $state.go('app.specialists');

             l('a donde en via si entra');
  
         }, 600);


     }


     $scope.deleteScheduleEspecialistRestriction= function(id){

      specialistService.dropSpecialistRestriction({id:id}, function(res){
        l('--deleteScheduleEspecialistRestriction--borrado');
        var longitud = $scope.scheduleEspecialistRestrictions.length;

        for(var a=0 ; a < longitud; a++){
          if($scope.scheduleEspecialistRestrictions[a].id == id){
            $scope.scheduleEspecialistRestrictions.splice(a, 1);
          } 
        }
      
      }, function(res){
        l('Error--deleteScheduleEspecialistRestriction--');
        l(res);
      });
     }




    }]);



