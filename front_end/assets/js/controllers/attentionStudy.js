'use strict';

/* Controllers */

angular.module('app')
.controller('attentionStudyCtrl', 
  ['$scope',

  '$state',

  '$rootScope',

  '$localStorage',

  '$location',

  '$timeout', 

  'attentionStudiesService',

  'mammogramService',

  'cardiologyEkgService', 

  'CardiologyErgometryService', 

  'cardiologyMonitoringService', 

  'tacsService', 

  'nuclearService', 

  'xrayService',

  'CardiologyConsultarionEcoService', 

  'specialistRoleService',

  'suppliesService',

  'attentionsService',

  'controlFormatsService',

  'appointmentService',

  'lendPlatesService',

  function($scope,

    $state,
    
    $rootScope, 
    
    $localStorage, 

    $location, 

    $timeout, 
    
    attentionStudiesService, 
    
    mammogramService, 
    
    cardiologyEkgService,
    
    CardiologyErgometryService, 
    
    cardiologyMonitoringService, 
    
    tacsService, 
    
    nuclearService, 
    
    xrayService, 
    
    CardiologyConsultarionEcoService,
    
    specialistRoleService,
    
    suppliesService,

    attentionsService,

    controlFormatsService,
    
    appointmentService,

    lendPlatesService
    )

  {



    $scope.datesAppointment  = undefined;

    $scope.template_type = undefined;

    $scope.attention = undefined;

    $scope.showTableProducts = false;

    $scope.nameRole = $localStorage.person.first_name;

    l($localStorage.person.first_name);
    l('nombre');
    l($scope.nameRole);


    $('#timepicker').timepicker();

        //upload a template.
        



        /**
         * [resetFormat description]
         * @return {[type]} [description]
         */
         $scope.resetFormat = function(){


          $scope.format = {

            //basic Control_format

            //plates_number: 0, //numero de placas studios anteriores.
            
            format_consec: '0001', // consecutivo del formato

            format_type_id:     $scope.study.format_types_id, // tipo de formato segun studio
            
            patients_id:        $scope.order.patients_id, // id del paciente

            attentions_id:      undefined, // id de la atencion
            
            specialists_id :    undefined,// specialista id.

            has_past_studies:   undefined, // trajo estudios anteriores

            observations: '',

            responsable:'',



            //mamograma

            control_formats_id:'', // formato de control

            broken_plate: undefined, // placas rotas

            broken_plate_cause: '', // causa placas rotas

            rejected_study:undefined, // estudios rechazados

            rejected_study_cause: '', // causa estudios rechazados

            number_expositions:'', // numero de expociociones

            //radiation_dose_type:undefined, // tipo de radiacion

            radiation_dose: 0, // dosis de radiacion 

            MA: '',

            KV: '',

            radiation_dose_time: '',


            // diferentes para tacs 
            // control formats, broken plate, broken plate cause,
            // number expocicions, radiation dosis type, radiation dose 
            
            contrat_iv_quantity: '', // cantidad de contraste

            radiation_dose_time: '', //tiempo dosis de radiacion

            // diferentes para nuclear
            // control format, broken plate and cause,
            // reject study and ccause 
            radiopharmaceutical:'',   // radio farmaco..
            radiation_dose_mci:'',    // dosis de radicion en MCI 

            // diferentes rayos X
            // control formats, broken plate and cause,contract iv quantity, number espocicions 
            // radiation dose type and time, radiation dose
            // doStudie: 1,
            // diferntes cardiology  consulta 
            // control format, reject study and cause.
            

            // cardiology monitorin 
            // control formats, reject study and cause
            

            // cardiology ergometry 
            // control format, reject study, cause
            

            // cardiology EKG
            // control formats, rejected study and cause

          };

          l('-- entro al resetFormat ');

          console.log($scope.format);

        }

        $scope.setValueSpecialist= function (){

          var item = parseInt( $("[ng-model=selectEspecialist]").val() );
          item= $scope.Specilist[ item ];
          $scope.format.specialists_id = item.specialists_id;
        }

        /**
        * [optionStudyRejected description]
        * @type {Array}
        */
        $scope.optionStudyRejected = [

        {name:'Si', code:1},

        {name:'No', code:0}

        ];

        /**
        * [typeRadiation description]
        * @type {Array}
        */
        $scope.typeRadiation = [

        {name:'MA', code:1},

        {name:'KV', code:0}

        ];


        $scope.optionBroken = [

        {name:'Si', code:1},

        {name:'No', code:0}

        ];

        $scope.estudiosAnteriores = [

        {name:'Si', code:1},

        {name:'No', code:0}

        ];

        // cantidad en militros para el contraste
        $scope.contraste = [

        {name: '0 ml', code: 0.1},

        {name: '50 ml', code: 50},

        {name: '75 ml', code: 75},

        {name: '100 ml', code: 100},

        {name: '125 ml', code: 125}

        ];



        // $scope.typeStudy = [

        // {name: 'Mamografía', code: 1},

        // {name: 'Ecografia', code: 0}
        
        // ];

        $scope.date = moment(new Date()).format('DD-MM-YY');

        /**
         * seleccionar plantilla de acuerdo al studio -> formato de atencion relacionado.
         * @type {[type]}
         */
         $scope.showEndAttention = false;


         $scope.selectTemplate = function(){

          console.log('studio xxd');

          console.log($scope.study);

          $scope.template_type = $scope.study.format_types_id;

          console.log($scope.template_type);

          switch($scope.template_type){

          case 1: //MAMOGRAMAS

          $scope.template = "tpl/formatControls/mammogram.html";
          break;

          case 2: //TACS

          $scope.template = "tpl/formatControls/tac.html"; //Se llama al html xRays puesto que esta plantilla es identica para rayos x y para tomografias  
          $scope.nameFormatControl = "Tomografía";  
          break;

          case 3:// NUCLEAR

          $scope.template = "tpl/formatControls/nuclear.html";   
          break;

          case 4: // RAYOS X


          $scope.template = "tpl/formatControls/xRays.html";
          $scope.nameFormatControl = "Rayos X";  

          //nombre de acuerdo a la maquina que realice los rayos x
          if($scope.centerCode == 1){

            $scope.time = 'mAs';

          }else{

            $scope.time = "Tiempo";

          }
          
          break;

          case 5: // CARDIOLOGIA

          $scope.template = "tpl/formatControls/cardiology.html";   

          $scope.nameCardiology = "EKG";   

          break;

          case 6: //CARDIOLOGIA ERGOMETRIA

          $scope.template = "tpl/formatControls/cardiology.html";

          $scope.nameCardiology = "Prueba Ergométrica";  
          
          break;
          case 7: // CARDIOLOGIA MONITOREOS

          $scope.template = "tpl/formatControls/cardiology.html";   

          $scope.nameCardiology = "Monitoreos"; 

          break;

          case 8: // CARDIOLOGIA ECOS

          $scope.template = "tpl/formatControls/cardiology.html";   

          $scope.nameCardiology = "Consulta y ECO";

          break;

          case 0: // SIN PLANTILLA DE ATENCION
          console.log('NO SE HA DEFINIDO PARA ESTE STUDIO UN  TIPO O NO REQUIERE DE FORMATO');
          console.log($scope.study);
          $scope.showEndAttention = true;

          break;

          default:
          $scope.showEndAttention
          break;

        } 
      }


 //------------------------------------------------------ CONFIGURACION PRODUCTOS ---------------------------------------------

 $scope.studySupplies = undefined;

 

 $scope.newCant = undefined;

    /**
         * Calcular el valor de a cuerdo a la cantidad ingresada.
         * @param  {[type]} item [description]
         * @return {[type]}      [description]
         */
         $scope.changeCant = function(item){

          console.log('res ITEM ENVIADO A EDICION');
          console.log(item);



          if(item != null){

            item.cost = item.products_study.service.value * item.quantity;

           // $scope.factServices[index] = item;
           suppliesService.editAppointmentsSupplies({id:item.id,quantity:item.quantity,cost:item.cost},function(res){
            if(res.success){

              console.log('cambiado OK ');


            }
          });
         }


       }

    /**
     * Obtener los productos necesario para el studio.
     * @return {[type]} [description]
     */
     $scope.getProducts = function(){

      // obtiene Id del localStorage.... 
      var items = $localStorage.appointment.appointmentDate.appointments_id;
      console.log('Ingreso a consultar supplies .... ')
      console.log(items);

      if(items != undefined){

        suppliesService.getSuppliesByIdAppointment({idAppointment:items},function(res){

         console.log("get  productos necesarios ");

         console.log(res.appointmentsSupply);

         if( res.success){

           $scope.showTableProducts = true;


           var supplies = res.appointmentsSupply;

           $scope.studySupplies = res.appointmentsSupply;


         }else{
          $scope.showTableProducts = false;

        }

      }, function(error){

       console.log(error);

     });
      }

    }
//------------------------------------------------------------------------------------------------------------------------------


/**
 * [addAttention Añade las atenciones ]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-23
 * @datetime 2016-12-23T17:27:06-0500
 */
$scope.addAttention = function(){


  var validado = $scope.validateForms();

  if($scope.template_type != 0){

   if( validado !== true ){

    $scope.error_message = "El campo "+validado+" no se ha ingresado";
    $('#error_message').show(500);
    return;

  }
  $('#error_message').hide(500);

}

$scope.attentions.date_time_end = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');

attentionsService.addAttention($scope.attentions,function(res){
  console.log('resultado attencion');
  console.log(res);


  if(res.success){
    $scope.attention = res.attention;

    $localStorage.dateIni = undefined;

    $scope.format.attentions_id = $scope.attention.id;

    if($scope.template_type != 0){

     $scope.showConfirmSave();

     $scope.saveControlFormat();

   }else{

    $scope.loadPage();

  }




}    

}, function (error) {

});
}
  /**
   * Finalizar atencion, Cambiar fecha final atencion. 
   * @return {[type]} [description]
   */
   $scope.finishAttention = function(){

     $scope.attention.date_time_end = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');

     $scope.attention.date_time_ini = moment($scope.attention.date_time_ini).format('YYYY-MM-DD HH:mm:ss');

     attentionsService.editAttention($scope.attention,function(res){

      if(res.success){

        //Adicionar registro en appointmens date e

        var appointment = {
          appointments_id:  $scope.datesAppointment.appointmentDate.appointments_id,
          date_time_ini:moment($scope.datesAppointment.appointmentDate.date_time_ini).format('YYYY-MM-DD hh:mm:ss'),
          date_time_end: moment($scope.datesAppointment.appointmentDate.date_time_end).format('YYYY-MM-DD hh:mm:ss'),
          appointment_states_id: 5
        }

        appointmentService.saveAttention(appointment,function(res){
          console.log('Atencion Guardada');

        },function(error){});

        $scope.attention = res.attention;


        
        $scope.resetFormat();
        // se limpia localstore y se redirige a heat professional.
        
        $localStorage.order = undefined;
        $localStorage.appointment = undefined;
        $state.go('app.healthProfessional');

      }    

    }, function (error) {

    });

   }


/**
 * [loadPage Carca la pagina healthProfessional y limipia el storage]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-15
 * @datetime 2016-12-15T12:12:34-0500
 * @return   {[type]}                 [description]
 */
 $scope.loadPage = function () {

  $scope.resetFormat();
        // se limpia localstore y se redirige a heat professional.
        
        $localStorage.order = undefined;
        $localStorage.appointment = undefined;
        $state.go('app.healthProfessional');
        //$scope.hideConfirmSave();

      }


  /**
   * Obtiene los datos guardados del appointment a atender
   * @return {[type]} [description]
   */
   $scope.getAllData = function(){

    $scope.datesAppointment = $localStorage.appointment;

    $scope.people = $scope.datesAppointment.patient;

    $scope.order = $scope.datesAppointment.order;

    $scope.study = $scope.datesAppointment.study;

    $scope.centerCode = $localStorage.centerCode;

    $scope.selectTemplate();

    console.log('Todos los Datos appointment');

    console.log($scope.datesAppointment);

    $scope.people.birthdate = moment($scope.people.birthdate).format('YYYY-MM-DD');


    $scope.getProducts();

    //crea el objeto attentions con la fecha de inicio de atención
    $scope.attentions  = {
      date_time_ini: $localStorage.dateIni,
      date_time_end: undefined,
      appointments_id: $scope.datesAppointment.appointmentDate.appointments_id
    }

    $scope.resetFormat();

  }

  $scope.getAllData();








        // $scope.updateFormat = function(){

            // $scope.format = angular.extend($scope.format, $scope.mammogram);
        // }   
        
      // $scope.updateFormat();

//---------------------------------------------------------- CONFIGURACION PLANILLAS DE ATENCION -------------------------

     /**
      * detection se seleccion de servicio por enter o click 
      */
      $scope.$watch('format', function() { 

       //console.log($scope.format);

     }, true);


      /**
      * Function to save mammogram
      */
      $scope.saveMammogram = function(){
        
        
        mammogramService.addMammogram($scope.format,function(res){

          if(res.success){

            console.log('LOG ADD MAMOGRAMAS');
            console.log(res);
           // $scope.finishAttention();
         }


       }, function (error) {

       });
      }

      

      /**
      * Function to save CardiologyEkg
      */
      $scope.saveCardiologyEkg = function(){

        l($scope.format);

        cardiologyEkgService.addCardiologyEkg($scope.format,function(res){

          if(res.success){

            console.log('LOG ADD CARDIOLOGIA EKG');
            console.log(res);
           // $scope.finishAttention();
         }


       }, function (error) {

       });

      }

      /**
      * Function to save CardiologyErgo
      */
      $scope.saveCardiologyErgo = function(){

         //$scope.saveControlFormat();

         CardiologyErgometryService.addCardiologyErgo($scope.format,function(res){


          if(res.success){

            console.log('LOG ADD CARDIOLOGIA ERGOMETRIA');
            console.log(res);
            //$scope.finishAttention();
          }


        }, function (error) {

        });

       }

      /**
      * Function to save Tacs
      */
      $scope.saveTacs = function(){
         //$scope.saveControlFormat();


         tacsService.addTacs($scope.format,function(res){
           console.log('Entro a guardar Tacs');

           if(res.success){
             console.log('LOG ADD TACS');
             console.log(res.tacs);
             //$scope.finishAttention();


           }else
           {
            console.log(res.error);
          }


        }, function (error) {

        });

       }




      /**
      * Function to save Tacs
      */
      $scope.saveCardiologyMonitoring = function(){

       //  $scope.saveControlFormat();

       cardiologyMonitoringService.addCardiologyMonitoring($scope.format,function(res){


        if(res.success){
          console.log('LOG ADD CARDIOLOGIA MONITOREOS');
          console.log(res);
          //$scope.finishAttention();
        }


      }, function (error) {

      });

     }


      /**
      * Function to save nuclear
      */
      $scope.saveNuclear = function(){

       // $scope.saveControlFormat();

       nuclearService.addNuclear($scope.format,function(res){

        if(res.success){
          console.log('LOG ADD NUCLEAR');
          console.log(res);
          //$scope.finishAttention();
        }


      }, function (error) {

      });

     }

      /**
      * Function to save nuclear
      */
      $scope.saveXray = function(){

        //$scope.saveControlFormat();

        xrayService.addXray($scope.format,function(res){
          l('entre una vez');
          if(res.success){

           console.log('LOG ADD RAYOS X');

           console.log(res);
         //  $scope.finishAttention();
       }


     }, function (error) {


     });

      }

      /**
      * Function to save CardologyConsul
      */
      $scope.saveCardologyConsul = function(){

       // $scope.saveControlFormat();

       CardiologyConsultarionEcoService.addCardologyConsul($scope.format,function(res){



        if(res.success){

          console.log('LOG ADD CARDIOLOGIA CONSULT');
          console.log(res);
          //$scope.finishAttention();
        }


      }, function (error) {

      });

     }



        /**
         * guardar el registro del formato de  control.
         * @return {[type]} [description]
         */
         $scope.saveControlFormat =function(){
          l('Inicio del saveControlFormat--respuesta addAttention en el res--');
          console.log($scope.attention);


          //convierte en entero el contraste debido a que se debe 
          //tener con valor 0.1, puesto que en validación al tomar valor cero este 
          //lo esta tomando como si estuviera vacio
          if($scope.format.contrat_iv_quantity == 0.1){

           $scope.format.contrat_iv_quantity = parseInt($('[ng-model="format.contrat_iv_quantity"]').val())

          }

          controlFormatsService.saveControlFormats($scope.format, function(res){
            if(res.success){

              l('respuesta--saveControlFormats');
              l(res);
              $scope.controlFormat = res.controlFormat;

              $scope.format.control_formats_id = res.controlFormat.id;

              console.log('entro a asignar  control format id '+ $scope.controlFormat + " "+ $scope.template_type);

              switch($scope.template_type){

                case 1: //MAMOGRAMAS
                $scope.saveMammogram();
                break;

                case 2: //TACS
                $scope.saveTacs();
                break;

                case 3:// NUCLEAR
                $scope.saveNuclear();
                break;

                case 4: // RAYOS X
                $scope.saveXray();

                break;

                case 5: // CARDIOLOGIA
                $scope.saveCardiologyEkg();
                break;

                case 6: //CARDIOLOGIA ERGOMETRIA
                $scope.saveCardiologyErgo();    
                break;

                case 7: // CARDIOLOGIA MONITOREOS
                $scope.saveCardiologyMonitoring();     
                break;

                case 8: // CARDIOLOGIA ECOS
                $scope.saveCardologyConsul();
                break;

                case 0: // SIN PLANTILLA DE ATENCION
                console.log('NO SE HA DEFINIDO PARA ESTE STUDIO UN  TIPO O NO REQUIERE DE FORMATO');
                console.log($scope.study);
                break;
              } 

              //$scope.loadPage();

            }else{

            }

          }, function(res){
            l('error saveControlFormat');
            l(res);
          });


        }




      /**
      * Function to get SpecialistRole
      */
      $scope.getSpecialistRoles = function(){



        specialistRoleService.getSpecialistRole({id:$scope.study.specializations_id},function(res){

          l("ESPECIALISTAS");
          console.log(res);

          $scope.Specilist = res.specialistsList;

        }, function (error) {

        });

      }

      $scope.getSpecialistRoles();




      /**
       * [validateForms valida los campos para las plantillas de atención]
       * @author Jefry Londoño <jjmb2789@gmail.com>
       * @date     2016-12-20
       * @datetime 2016-12-20T14:01:15-0500
       * @return   {[type]}                 [description]
       */
       $scope.validateForms = function(){

        l('--entre a validar--');


        //Validadciones que no pertenece a plantilla de cardiologia
        if($scope.template_type != 5 && $scope.template_type != 6 && $scope.template_type != 7 && $scope.template_type != 8){// && $scope.format.doStudie != 0){

         if(!$('[ng-model="format.broken_plate"]').val() ){
          return "Placa Dañada";
        }


      }

      if( !$('[ng-model="format.broken_plate_cause"]').val() && $scope.format.broken_plate == 1 ){
        return "Causa de la Placa Dañada";
      }      

      if($scope.template_type == 3){

        if(!$scope.format.radiopharmaceutical){

          return "Radiofarmaco"

        }


        if(!$scope.format.radiation_dose_mci || isNaN( parseInt( $('#radiopharma').val() ) ) ){

          return "Dosis de Radiación Recibida"

        }

      }



      if($scope.template_type == 2 || $scope.template_type == 4){


        if( !$scope.format.contrat_iv_quantity || isNaN(parseInt($('[ng-model="format.contrat_iv_quantity"]').val())) ){
          return "Contraste IV";
        }

      }

      if($scope.template_type != 3 ){//&& $scope.format.doStudie != 0){

        //Validaciones que no pertenecen a la plantilla de cardiologia
        if($scope.template_type != 5 && $scope.template_type != 6 && $scope.template_type != 7 && $scope.template_type != 8){


          if( !$scope.format.number_expositions || $scope.format.number_expositions == 0 || isNaN(parseInt($('[ng-model="format.number_expositions"]').val())) ){
            return "Número de Expociociones";
          }

        }


      }

      if($scope.template_type == 2){

        if(!$scope.format.radiation_dose || $scope.format.radiation_dose == 0 || isNaN(parseInt($('[ng-model="format.radiation_dose"]').val())) ){

          return "Dosis de Radiación"

        }

      }
      
      //Validacion para mamografias y rayos x
      if(($scope.template_type == 1 || $scope.template_type == 4) ){//&& $scope.format.doStudie != 0 ){

        if( !$scope.format.MA || $scope.format.MA == 0 || isNaN(parseInt($('[ng-model="format.MA"]').val())) ){

          return "MA";

        }

        if(!$scope.format.KV || $scope.format.KV == 0 || isNaN(parseInt($('[ng-model="format.KV"]').val())) ){

          return "KV";

        }
        //validacion para rayos x
        if($scope.template_type == 4){

          if(!$scope.format.radiation_dose_time || isNaN(parseInt($('[ng-model="format.radiation_dose_time"]').val())) ){

            return $scope.time;

          }

        }      

      }


      if( !$('[ng-model="format.specialists_id"]').val() && !$scope.format.specialists_id ){
        return "Médico";
      }

      if( !$('[ng-model="format.has_past_studies"]').val() && !$scope.format.has_past_studies ){
        return "Trae Estudios Anteriores";
      }

      if( (!$('[ng-model="format.number_studies"]').val() || isNaN(parseInt($('[ng-model="format.number_studies"]').val())) || $scope.format.number_studies == 0) && $scope.format.has_past_studies == 1  ){
        return "Cantidad de Estudios";
      } 


      return true;


    }


// $scope.calculateRadiationDose = function () {

//   //$scope.format.radiation_dose = ($scope.study.radiation_dose*$scope.format.number_expositions);
//   l($scope.format.contrat_iv_quantity);

// }

// $scope.$watch('format.radiation_dose',function () {
//   // body...

// });

  //Muestra la modal de los prestamos de placas
  $scope.showModalLendPlate= function(attention){

    l("--attention--");
    $scope.lend = $scope.attention;

    //l($scope.lend);
    //obtiene el id de attentions necessario para hacer el update
    $scope.lend.attentions_id = $scope.attention.id;
    $scope.lend.users_id = $localStorage.user.id;

    $('.add-confirmation').modal('show');

    $scope.hideConfirmSave();

  }


  /**
   * [hideModalLendPlate oculta la modal de prestamo de placas]
   * @author Jefry Londoño <jjmb2789@gmail.com>
   * @date     2016-12-23
   * @datetime 2016-12-23T17:31:41-0500
   * @return   {[type]}                 [description]
   */
  $scope.hideModalLendPlate = function(){

    $('.add-confirmation').modal('hide');

    $timeout(function () {

      $scope.loadPage();

    }, 700);
    

  }


  /**
   * [showConfirmSave muestra la modal que solicita si la atención tiene prestamos de placas]
   * @author Jefry Londoño <jjmb2789@gmail.com>
   * @date     2016-12-23
   * @datetime 2016-12-23T17:33:34-0500
   * @return   {[type]}                 [description]
   */
  $scope.showConfirmSave = function () {
    l($scope.state +' estado');
    $('.confirm-save-ok').modal('show');

    $scope.message = 'La Atención tiene Prestamo de Placas?';

  }



/**
 * [hideImpressionResult Oculta la modal que pide 
 * la confirmación de prestamo de placas]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-14
 * @datetime 2016-12-14T11:52:23-0500
 * @return   {[type]}                 [description]
 */
 $scope.hideConfirmSave =  function(item){

  $('.confirm-save-ok').modal('hide');

  if(item == 1){



  $timeout(function() {

        $scope.loadPage();

      }, 700);

  }

  
}

/**
 * [updateLendPLate Actualiza la atención con un prestamo de placas]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-22
 * @datetime 2016-12-22T09:47:31-0500
 * @return   {[type]}                 [description]
 */
$scope.updateLendPLate= function(){

  attentionsService.editAttentionLend({ id : $scope.lend.id,lend_plates: 1},function(res){

    console.log("se pudo ejecutar la actualizacion");

    $('.add-confirmation').modal('hide');

  },function(res){

    //console.log("no se pudo ejecutar la actualizacion");

    $('.add-confirmation').modal('hide');

  });

  console.log($scope.lend);

  console.log(lendPlatesService);

  lendPlatesService.addLend($scope.lend, function(res){

    if(res.success){

      $scope.hideModalLendPlate();

    }

    

  }, function(error){});

  

  
}
}]);









