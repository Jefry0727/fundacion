 'use strict';

 /* Controllers */

 angular.module('app')
 .controller('attentionPatientCtrl', 
  ['$scope', 
  '$state',
  '$rootScope',
  '$localStorage',
  '$location',
  '$timeout', 
  'specialistService', 
  'resultsService',
  'resultsProfileService',
  'attentionsService', 
  'appointmentService',
  'ripsService',
  'patientsService',
  function($scope, 
    $state, 
    $rootScope, 
    $localStorage, 
    $location, 
    $timeout, 
    specialistService, 
    resultsService,
    resultsProfileService,
    attentionsService,
    appointmentService,
    ripsService,
    patientsService) {

    $('#timepicker').timepicker();

    $('#timepickerend').timepicker();

      /**
       * Funcion para definir el tamaño inicial del summernote
       * @type {Object}
       */
       $scope.summernote_options = {
           height: 200,
           toolbar: [
            ['edit',['undo','redo']],
            ['headline', ['style']],
            ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript']],
            // ['fontname', ['fontname']],
            ['textsize', ['fontsize']],
            ['alignment', ['ul', 'ol', 'paragraph']],  
            ['table', ['table']],
            ['view', ['fullscreen','codeview']],
        ],
         fontNames: ['Verdana'],
    }
    

 /**
     * Specialista selecccionado
     * @type {[type]}
     */
     $scope.selectedSpecialist = undefined;
     $scope.Specialists ={}


     /**
      * Obtiene specialista segun usuario.
      * @author Deicy Rojas <deirojas.1@gmail.com>
      * @date     2016-09-17
      * @datetime 2016-09-17T10:16:58-0500
      * @return   {[type]}                 [description]
      */
      $scope.selectedSpecialist = function(){
        // Ingreso a obtener toda la informacion...
         
        if($scope.selectedSpecialist = undefined){
          specialistService.getByUser(function(res){
            if(res.success)
            {
              var id =  res.specialists.id;

              for (var i = $scope.Specialists.length - 1; i >= 0; i--) {
                if(  $scope.Specialists[i].id == id){ 
                  $scope.selectedSpecialist = $scope.Specialists[i];
                }
              }
            }
           
          },function(error){});
        }
        $scope.getAllData();
       
      }

       /**
     * funcion para obtener todos los specialista. 
     * @return {[type]} [description]
     */
     $scope.loadSpecialists = function (){

      specialistService.getAllSpecialist(function(res){
        // console.log(res.specialists);  
        $scope.Specialists =(res.specialists);
        $scope.selectedSpecialist();

      }, function(error){

        console.log(error);

      });
    } 


    $scope.loadSpecialists();


      /**
       * [selectedDate description]
       * @type {[type]}
       */
       $scope.selectedDate = moment(new Date()).format('YYYY-MM-DD, HH:mm:ss');
   /**
     * Obtiene los valores enviados desde transcriptions
     * @type {[type]}
     */
     $scope.order = $localStorage.Order;
     $scope.action = undefined;

    /**
     * Obtiene la infromacion de la Orden.
     * @type {Object}
     */
     $scope.appointment ={}
     $scope.people = {}
    /**
     * Modelo Results Profile.
     * @type {Object}
     */

     $scope.resultsProfile = undefined;

     $scope.formatSelected =undefined;

    /**
     * load values from the results
     */
     $scope.result = {}


     $scope.saveResult= function(){

      if($scope.attention.id != undefined){
        console.log('INGRESO A GUARDAR RESULTADO');

        $scope.result.attentions_id = $scope.attention.id;

        $scope.result.content = $scope.summernote;

        $scope.result.complement = $scope.complement;

        $scope.result.specialists_id = $scope.selectedSpecialist.id;

        console.log($scope.result);

        resultsService.add($scope.result,function(res){

          console.log(res);

          if(res.success){
            $state.go('app.healthProfessional'); 
          }

        }, function(error){

          console.log(error);

        });

      }

    }

  /**
   * [typeIdentyti description]
   * @type {Array}
   */
  
  $scope.usertype = [

    {name:"Contributivo",code:0},
    {name:'Subsidiado',code:1},
    {name:'Vinculado',code:2},
    {name:'Particular',code:3},
    {name:'Otro',code:4}

     ];



/* Carlos Felipe Aguirre Taborda 2016-11-30 16:03:58
   trae los tipos de documentos apenas se carga la página
*/

patientsService.getDocumentTypes(
  function( success ){

    $scope.typeIdentyti = new Object();

    for( var index in success.documentTypes ){

      $scope.typeIdentyti[ index ] = success.documentTypes[ index ];
      $scope.typeIdentyti[ index ].name = $scope.typeIdentyti[ index ].type;
    
  }
  
    console.log( $scope.typeIdentyti );
  
},
  function( error ){

  }
);



/**
 * [ripUsers description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-11-15
 * @datetime 2016-11-15T12:31:38-0500
 * @param    {[type]}                 order [description]
 * @return   {[type]}                       [Save all information for RIPUS from attentionPatient]
 */
$scope.ripUsers = function(order){

  $scope.idClients = $scope.order.clients_id;

  l('el clien'+' '+$scope.idClients);

  $scope.idRates = $scope.order.rates_id;

  l('el rate'+' '+$scope.idRates);


  $timeout(function() {

    appointmentService.getRatesClients({idClient: $scope.idClients, idRate: $scope.idRates}, function(res){

      l(res);

      if(res.success == true){

        $scope.allRatesClients = res.ratesClient;

        l('con los rates');
        console.log($scope.allRatesClients);

      }

    });

  }, 300);




  $timeout(function() {

  $scope.infoRates = $scope.allRatesClients;
  l('yeah');
  
  console.log($scope.infoRates);


  $scope.complement;


  //$scope.plates = $scope.getInfoForPlates[0].lend_plates;

  // l('el complemento');

  // console.log($scope.complement);

  $scope.infoUs = $scope.order;

  $scope.regimen = $scope.infoUs.patient.regimes_id;


for (var i = 0; $scope.usertype.length; i++) {

    if(i == $scope.regimen){

      $scope.selectRegimen = $scope.usertype[i].name;

      l('el regimen'+' '+ $scope.selectRegimen);

    }
   
  }
  l('US');
  console.log($scope.infoUs);

  $scope.infoUS = {

    id:0,
    tipo: $scope.infoUs.patient.person.document_type.initials,
    identificacion:$scope.infoUs.patient.person.identification,
    cod_ars:$scope.infoRates[0].ars_code,
    tipo_usuario:'',
    apellido1:'',
    apellido2:'',
    nombre1:'',
    nombre2:'',
    edad:'',
    edad_unidad:'',
    sexo:'',
    cod_depto:'',
    cod_municipio:'',
    zona:'',
    fecha:'',
    entidad:'',
    state:'',
    orderConsectuiva:'',
    clientName:'',
    ratesName:'',
    stateClient:'',
    stateRates:'',
    idrRatesClient:''




  }

  // ripsService.getRipsUser(function(res){




  // });


  }, 1000);



}


  //$scope.peopleAC = {};

  $scope.pruebaAC = function(people, order, study){

    if($scope.study.type){

    l('es true para '+' '+$scope.study.type);

    $scope.peopleAC = $scope.people;

    $scope.orderAC = $scope.order;

    $scope.studyAC = $scope.study;

    if($scope.order.centers_id == 1){

      $scope.codeCenter = '630010001601';

    }else{

      $scope.codeCenter = '630010001604';

    }

    

    for(var i = 0; i <= $scope.typeIdentyti.length; i++ ){

      if( i == $scope.people.document_types_id){

        $scope.peopleIdentity = $scope.typeIdentyti[i].name;

      }

    }

    ripsService.billNumber({id:$scope.order.id}, function(res){

        l('200 ok');

        if(res.success == true){

          $scope.unicNumberBill = res.processFiles;

          console.log('num bill'+''+$scope.unicNumberBill);

        }

    });

    $timeout(function() {

      $scope.numFactura = $scope.unicNumberBill;

      //console.log($scope.numFactura[0].Bills.bill_number);

    }, 1000);


      $timeout(function() {

      $scope.infoAC = {      

      id:'',
      num_factura:$scope.numFactura[0].Bills.bill_number,
      cod_ips:$scope.codeCenter,
      identificacion:$scope.peopleIdentity,
      num_identificacion:$scope.peopleAC.identification,
      fec_consulta:moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
      num_autorizacion:$scope.orderAC.order_consec,
      cod_consulta:$scope.studyAC.cup,
      finalidad:10,
      causa_externa:15,
      cod_dx:$scope.orderAC.consultation_endings_id,
      cod_dx_rel1:'',
      cod_dx_rel2:'',
      cod_dx_rel3:'',
      tipo_dx:1,
      val_consulta:$scope.orderAC.subtotal,
      val_copago:$scope.orderAC.copayment,
      val_neto:$scope.orderAC.total,
      entidad: $scope.orderAC.clients_id,
      tipoEstudio: $scope.studyAC.type

    }

    ripsService.saveRipsQueryFiles($scope.infoAC, function(res){

      l('200 ok save');

      if(res.success == true){

        l('guarda en AC');
      }

    });

      }, 2000);

    }else{

      alert('El tipo de Studio es != 1');
    }

  

    

  }

 

    $scope.getAllResultsProfile = function(){

      if($scope.selectedSpecialist != undefined){

       var idSpecialist =$scope.selectedSpecialist.id;
       var idStudie =   $scope.study.id;

       resultsProfileService.getAllResultsProfile({idSpecialist:idSpecialist,idStudie:idStudie},function(res){

        if(res.success){

         $scope.resultsProfile = res.resultProfile;

              // $scope.summernote = $scope.resultsProfile.content;
            }
          }, function(error){

            console.log(error);

          });
     }
 }



   $scope.addAttention = function(){

     $scope.attention  = {
      date_time_ini: moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
      date_time_end: moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
      users_id: $localStorage.user.id,
      appointments_id: $scope.datesAppointment.appointmentDate.appointments_id,
      lend_plates:0
    }

    attentionsService.addAttention($scope.attention,function(res){
      console.log('resultado attencion');
      console.log(res);

      if(res.success){
        $scope.attention = res.attention;
        $scope.getAllResultsProfile();

      }    

    }, function (error) {

    });
  }
  /**
   * Finalizar atencion, Cambiar fecha final atencion. 
   * @return {[type]} [description]
   */
   $scope.finishAttention = function(people, order, study){

     $scope.attention.date_time_end = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');

     $scope.attention.date_time_ini = moment($scope.attention.date_time_ini).format('YYYY-MM-DD HH:mm:ss');

     attentionsService.editAttention($scope.attention, function (res) {

       if (res.success) {

         if ($scope.study.type) {

           l('es true para ' + ' ' + $scope.study.type);

           $scope.peopleAC = $scope.people;

           $scope.orderAC = $scope.order;

           $scope.studyAC = $scope.study;

           if ($scope.order.centers_id == 1) {

             $scope.codeCenter = '630010001601';

           } else {

             $scope.codeCenter = '630010001604';

           }

           console.log( $scope.people.document_types_id );
           for (var i = 0; i <= $scope.typeIdentyti.length; i++) {

             if (i == $scope.people.document_types_id) {

               $scope.peopleIdentity = $scope.typeIdentyti[i].name;

             }

           }

           ripsService.billNumber({ id: $scope.order.id }, function (res) {

             l('200 ok');

             if (res.success == true) {

               $scope.unicNumberBill = res.processFiles;

               console.log('num bill' + '' + $scope.unicNumberBill);

             }

           });

           $timeout(function () {

             $scope.numFactura = $scope.unicNumberBill;

             //console.log($scope.numFactura[0].Bills.bill_number);

           }, 1000);


           $timeout(function () {

             $scope.infoAC = {

               id: '',
               num_factura: $scope.numFactura[0].Bills.bill_number,
               cod_ips: $scope.codeCenter,
               identificacion: $scope.peopleIdentity,
               num_identificacion: $scope.peopleAC.identification,
               fec_consulta: moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
               num_autorizacion: $scope.orderAC.order_consec,
               cod_consulta: $scope.studyAC.cup,
               finalidad: 10,
               causa_externa: 15,
               cod_dx: $scope.orderAC.consultation_endings_id,
               cod_dx_rel1: '',
               cod_dx_rel2: '',
               cod_dx_rel3: '',
               tipo_dx: 1,
               val_consulta: $scope.orderAC.subtotal,
               val_copago: $scope.orderAC.copayment,
               val_neto: $scope.orderAC.total,
               entidad: $scope.orderAC.clients_id,
               tipoEstudio: $scope.studyAC.type

             }

             ripsService.saveRipsQueryFiles($scope.infoAC, function (res) {

               l('200 ok save');

               if (res.success == true) {

                 l('guarda en AC');
               }

             });

           }, 2000);

         }

         $scope.saveResult();

         //Adicionar registro en appointmens dates5
         appointmentService.saveAttention({ id: $scope.datesAppointment.appointmentDate.id }, function (res) {
           console.log('Atencion Guardada');
           console.log(res.appointmentDates);

         }, function (error) { });
         // $scope.resetFormat();
         $scope.attention = res.attention;

         // se limpia localstore y se redirige a heat professional.

         $localStorage.order = undefined;
         $localStorage.appointment = undefined;
         $state.go('app.healthProfessional');

       }

     }, function (error) {

     });

   }

$scope.people.birthdate = moment($scope.people.birthdate).format('YYYY-MM-DD');

  /**
   * Obtiene los datos guardados del appointment a atender
   * @return {[type]} [description]
   */
   $scope.getAllData = function(){

    $scope.datesAppointment = $localStorage.appointment;

    $scope.people = $scope.datesAppointment.patient;

    $scope.order = $scope.datesAppointment.order;

    $scope.study = $scope.datesAppointment.study;

    console.log('Todos los Datos appointment');

    console.log($scope.datesAppointment);

    $scope.addAttention ();

  }


  $scope.changeSelectedFormat = function(){
    console.log($scope.formatSelected);
    $scope.summernote = $scope.formatSelected.content;
  }


}]);