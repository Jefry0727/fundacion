'use strict';

/* Controllers */

angular.module('app')
    .controller('healthProfessionalCtrl', ['$scope',
    
    '$state',
    
    '$rootScope',
    
    '$localStorage',
    
    '$location',
    
    '$timeout', 
    
    'medicalOfficesService', 

    'ordersService',
    
    'specializationsService', 

    'attentionsService',

    'externalSpecialistsService',

    'clientsService',

    'urls',

    'lendPlatesService',

    

    function(

      $scope, 

      $state, 

      $rootScope, 

      $localStorage, 

      $location, 

      $timeout, 

      medicalOfficesService, 

      ordersService,

      specializationsService,

      attentionsService,

      externalSpecialistsService,

      clientsService,

      urls,

      lendPlatesService


      ) {


    /**
 * Prestamo de placas 
 */
$scope.lend ={
    name: '',
    observations:'',
    delivered:'',
    phone:'',
    document:'',
    returned:0,
    attentions_id:undefined,
    direction:'',
    users_id: ''
}

  //Muestra la modal de los prestamos de placas
 $scope.showModalLendPlate= function(attention){
    l("--attention--");
    $scope.lend = attention;
    l(attention);
    //obtiene el id de attentions necessario para hacer el update
     $scope.lend.attentions_id = attention.id;
     $scope.lend.users_id = $localStorage.user.id;

     $('.add-confirmation').modal('show');
 }

 $scope.hideModalLendPlate = function(){

  $('.add-confirmation').modal('hide');

 }

 $scope.updateLendPLate= function(){
    attentionsService.editAttentionLend({
      id : $scope.lend.id,
      lend_plates: 1
    },function(res){
      console.log("se pudo ejecutar la actualizacion");
      $('.add-confirmation').modal('hide');
    },function(res){
      console.log("no se pudo ejecutar la actualizacion");
      $('.add-confirmation').modal('hide');
    });

    console.log($scope.lend);
    console.log(lendPlatesService);
    lendPlatesService.addLend($scope.lend, function(res){

    }, function(res){});
 }





    $localStorage.appointment = undefined;

    $scope.message = function(){
      if($localStorage.medicalOffices != undefined){

        $scope.healthP = 'Agenda'+' '+$localStorage.medicalOffices.name+': '+$localStorage.person.first_name+' '+ $localStorage.person.last_name ;

      
      }else
      {
        $scope.healthP = 'Agenda Programada';
      }
    }

    
    $scope.message();
     
  /**
   * Search Health Professional
   */

  	$scope.sortType     = 'name'; // set the default sort type
  	$scope.sortReverse  = false;  // set the default sort order
    $scope.searchFish   = '';     // set the default search/filter term

    /**
     * Model Select Medical Center
     */
    $scope.selectedCenter  = undefined;

    //Model Select Medical Offices
    //
    $scope.selectedType = 1;

    $scope.selectedMedicalOffice = undefined;

  /**
   * Method get Center
   */
   $scope.getCenters = function(){

            ordersService.getCenters(function(res){

                $scope.centers = res.center;

               //  $scope.getMedicalOffice();
                
            }, function (error) {

            });

        }
	// load all the Regimens types.
    $scope.getCenters();

    $scope.getMedicalOffice = function(){

      var id = $scope.selectedCenter;

            medicalOfficesService.getMedicalByCenter({id:id},function(res){

                $scope.MedicalOffice = res.medicalOffices;

                
            }, function (error) {

            });

        }


  	// $scope.getSpecialization = function(){

   //      specializationsService.get(function(res){
   //          // console.log(res);
            
   //          *
   //           * Asignación de todas las opciones
   //           * @type {[type]}
             
   //          $scope.Specializations = res.specialization;

   //        }, function(error){
   //              console.log(error);
   //          });
   //       }

   //      $scope.getSpecialization();


	/**
 	* Busqueda
 	*/
 
	  $scope.sortType     = 'name'; // set the default sort type
	  $scope.sortReverse  = false;  // set the default sort order
	  $scope.searchFish   = '';     // set the default search/filter term
	  

	  /**
	   * Show modal healt patient
	   */
	  
	  $scope.showModalHealthProfessional = function(){
      // console.log('consultorio actual memoria');
      // console.log($localStorage.medicalOffices);
      if($localStorage.medicalOffices == undefined){

	  	    $('.show-healthProfessional').modal('show');
      
      }else
      {
        $scope.selectedMedicalOffice = $localStorage.medicalOffices;
        // console.log('consultorio Asignado');
        // console.log($scope.selectedMedicalOffice);
      }
	  
    }

	  $scope.showModalHealthProfessional();

    /**
     * Hide modal health patient
     */
    
    $scope.hideModalHealthProfessional = function(){

      $('.show-healthProfessional').modal('hide');
       // que es esto ?? 
      $scope.healthP = 'Agenda'+' '+$localStorage.medicalOffices.name+': '+$localStorage.person.first_name+' '+ $localStorage.person.last_name ;

      $localStorage.centerCode = $scope.selectedCenter;

      $scope.asignedAppointments(0);

    }

    $scope.changeMedicalOffice = function(){

      $localStorage.medicalOffices = $scope.selectedMedicalOffice;

    }

	  /**
     *Paginate 
     */

     $scope.currentPageHealthProfessional = 0;

     $scope.pageSizePageHealthProfessional = 10;

    

     /**
      * Go to attention Patient
      */ 
     $scope.goToAttentionPatient = function(data){

      /**
       * Preguntar el estudio sobre el que se presiona atender
       * Si es un estudio, se lleva a attentionStudy
       * Si es una consulta se lleva a consulta 
       */

       $localStorage.dateIni = moment(new Date()).format('YYYY-MM-DD HH:mm:ss');

       var studyType = data.study.type;

       if(studyType == '0'){

         $localStorage.appointment = data;

         $state.go('app.attentionStudy');

       }
       else
       {
        $localStorage.appointment = data;
        $state.go('app.attentionPatient');

       }
       console.log(data);

      

        // $state.go('app.consulta...');

     }



    /**
     * Informacion de citas asiganadas
     */
    $scope.asignedAppointmentsInfo;

    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentAsignedAppointments = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeAsignedAppointments = 10;

    /**
     * Total de datos
     * @type {Number}
     */
    $scope.asignedAppointmentsTotal = 0;


    /**
     * Informacion de citas confirmadas
     */
    $scope.appointmentForAttentionInfo;


    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentappointmentForAttention = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeappointmentForAttention = 10;

    /**
     * Total de datos
     * @type {Number}
     */
    $scope.appointmentForAttentionTotal = 0;

    /**
     * Informacion de citas atendidas
     */
    $scope.attendedAppointmentsInfo;


    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentattendedAppointments = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeattendedAppointments = 10;

    /**
     * Total de datos
     * @type {Number}
     */
    $scope.attendedAppointmentsTotal = 0;





    $scope.formatAttentionInfo = function(info){


      var data = new Array();
      console.log('Respuesta Datos .....');
      console.log(info);

      if(info != undefined){



        for (var i = 0; i < info.length; i++) {


          // YYYY-MM-DD 
          info[i]._matchingData.AppointmentDates.date_time_ini = moment(info[i]._matchingData.AppointmentDates.date_time_ini).format('hh:mm:ss a'); 

          info[i]._matchingData.AppointmentDates.date_time_end = moment(info[i]._matchingData.AppointmentDates.date_time_end).format('hh:mm:ss a'); 


          if(info[i].attentions != undefined){



            info[i].attentions[0].date_time_ini = moment(info[i].attentions[0].date_time_ini).format('hh:mm:ss a');  

            info[i].attentions[0].date_time_end = moment(info[i].attentions[0].date_time_end).format('hh:mm:ss a');  


            data.push({

              appointmentDate:  info[i]._matchingData.AppointmentDates,

              patient:      info[i].orders[0].patient.person,

              order:        info[i].orders[0],

              attention:    info[i].attentions[0],

              study:        info[i].study,

              all: info[i],

            });

          }else{

            data.push({

              appointmentDate: info[i]._matchingData.AppointmentDates,

              patient:      info[i].orders[0].patient.person,

              order:        info[i].orders[0],

              study:        info[i].study,

              all: info[i],

            });
          }

        }
      }

      return data;

    }



      /**
       * funcion para 
       */
       $scope.asignedAppointments = function(page){

        if($scope.selectedMedicalOffice != undefined){
          var offset = 0;

          if (page > 1) {

            offset = (page - 1) * 10
          }
          console.log($scope.selectedMedicalOffice);
          attentionsService.asignedAppointments({id:$scope.selectedMedicalOffice.id,offset: offset},function(res){
            
            $scope.asignedAppointmentsInfo = $scope.formatAttentionInfo(res.appointments);

            $scope.asignedAppointmentsTotal = res.total;

          });
        }
      }

      /**
       * funcion para 
       */
       $scope.appointmentForAttention = function(page){

        if($scope.selectedMedicalOffice != undefined){


          var offset = 0;

          if (page > 1) {

            offset = (page - 1) * 10
          }


          attentionsService.appointmentForAttention({id: $scope.selectedMedicalOffice.id,offset: offset},function(res){

            $scope.appointmentForAttentionInfo = $scope.formatAttentionInfo(res.appointments);

            $scope.appointmentForAttentionTotal = res.total;

          });
        }
      }



//valores para colocar en la impresion del  sticker
$scope.infoSticker = {
  external_specialist: undefined,
  study: undefined,
  person: undefined,
  appointment: undefined,
  order: undefined,
  attentions: undefined,
  client: undefined
};

//funcion que imprime el sticker
$scope.printSticker = function(info){
       $scope.infoSticker.study = info.all.study;

        externalSpecialistsService.getExternalSpecialistById({id:info.all._matchingData.Orders.external_specialists_id},
          function(res){
            l('getExternalSpecialistById()--funciono');
            //establece las propiedades del objeto que se va enviar
            $scope.infoSticker.external_specialist = res.externalSpecialist;
            $scope.infoSticker.person = info.order.patient.person;
            $scope.infoSticker.appointment =  info.appointmentDate;
            $scope.infoSticker.order = info.order;
            l(info);
            

            attentionsService.getAttentionsByAppointmentId({id: $scope.infoSticker.appointment.appointments_id}, function(res){
              l('--getAttentionsByAppointmentId--');
              l(res);
              if(res.success){
                $scope.infoSticker.attentions = res.attention[0];
              }

              clientsService.getClientSelected({id: info.order.clients_id},
                function(res){
                  l('--getClientSelecte--');
                  l(res);
                  $scope.infoSticker.client = res.clients[0];
                  l($scope.infoSticker);

                  attentionsService.printSticker($scope.infoSticker,function(res){

                    console.log('entro');

                    console.log(res);

                    var fileName = res.storedFileName.storedFileName

                    window.location.href = urls.BASE_API + '/OrderAppointments/downloadPrev/' + fileName;

                    }, function(error){
                      l('printSticker');
                      console.log(error);

                    });

                },
                function(res){
                  l('--getClientSelected--error');
                  l(res);
                }
                );
            }, function(res){
              l('--getAttentionsByAppointmentId--error');
              l(res);
            });
          },
          function(res){
            l('getExternalSpecialistById()--fallo');
            l(res);
          }
        );
      }




      /**
       * Funcion para
       */    
       $scope.attendedAppointments = function(page){

        if($scope.selectedMedicalOffice != undefined){

          var offset = 0;

          if (page > 1) {

            offset = (page - 1) * 10
          }


          attentionsService.attendedAppointments({id: $scope.selectedMedicalOffice.id,offset: offset},function(res){

            $scope.attendedAppointmentsInfo = $scope.formatAttentionInfo(res.appointments);

            $scope.attendedAppointmentsTotal = res.total;

          });
        }
      }

        /**
        * detection se seleccion de tipo 
        */
        $scope.$watch('selectedType', function() { 

            var selectedType = parseInt($scope.selectedType); 

            switch(selectedType){

                case 1:

                    $scope.asignedAppointments(0);

                  break;

                case 2:

                    $scope.appointmentForAttention(0);
        
                  break;

                case 3:

                    $scope.attendedAppointments(0);

                  break;

            }
          

         }, true);




        $scope.showModalSelectMedicalOffice = function(){
          delete $localStorage.medicalOffices;
          location.reload(true);
        }

        

}]);
















