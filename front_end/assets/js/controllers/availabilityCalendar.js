'use strict';

angular.module('app')
    .controller('availabilityCalendarCtrl', [

      '$scope',
      
      '$state',
      
      '$rootScope',
      
      '$localStorage',

      '$timeout',
      
      'medicalOfficesService',
      
      '$compile',

      'appointmentService',
      
      'uiCalendarConfig',

      'avaibilityCalendarService',

      'urls',

     function(

       $scope, 
       
       $state, 
       
       $rootScope, 
       
       $localStorage,

       $timeout,
       
       medicalOfficesService, 
       
       $compile,

       appointmentService,

       uiCalendarConfig,

       avaibilityCalendarService,

       urls

       ) {

      $('#timepicker').timepicker();

      $scope.myUser = $localStorage.person.first_name;


      $scope.searchFish   = '';     // set the default search/filter term


      $scope.startDate = moment(new Date()).format('YYYY-MM-DD');

      $scope.dateEnd = moment(new Date()).format('YYYY-MM-DD');


      $scope.selectMedical = undefined;


      /**
       * [listAppoiments description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-09
       * @datetime 2016-11-09T15:58:06-0500
       * @param    {[type]}                 selectMedical [Obtiene las citas del un consultorio selecionado por sede]
       * @return   {[type]}                               [description]
       */
      $scope.listAppoiments = function(selectMedical){


        if($scope.selectMedical != undefined){

          avaibilityCalendarService.avaibilityCalendar({dateS : $scope.startDate, dateE: $scope.dateEnd,
          idCenter:$scope.center.id, idMedical: $scope.selectMedical.id},function(res){

          l('las res');
          console.log(res);

          if(res.success == true){

            var con = 0;

             $scope.listAppoimentsCalendar = res.avaibilityCalendar;


             console.log('el estado actual');

             console.log($scope.listAppoimentsCalendar);

             /**
              * Evita el duplicado de la informacion de un paciente  --> revisar ya no deberia llegar duplicada.
              */

             // for( var j = 0; j < $scope.listAppoimentsCalendar.length; j++){

             //  if($scope.listAppoimentsCalendar[j].appointments_id === $scope.listAppoimentsCalendar[j].appointments_id){

             //    $scope.listAppoimentsCalendar.splice(j, 1);

             //    l($scope.listAppoimentsCalendar);

             //  }

             // }
             
             // for(var j = 0; j < $scope.listAppoimentsCalendar.length; j++){

             //    for(var k = 0; k < $scope.listAppoimentsCalendar.length; k++){

             //        if($scope.listAppoimentsCalendar[j].appointments_id === $scope.listAppoimentsCalendar[k].appointments_id){


             //        l($scope.listAppoimentsCalendar[j].appointments_id);

                    
             //      delete $scope.listAppoimentsCalendar[j].appointments_id;

             //      }

             

             //    }

             // }

            if($scope.listAppoimentsCalendar != 0){

              var con = 0;

            // for( var i = 0; i < $scope.listAppoimentsCalendar.length; i++){

            //       var cadena = $scope.listAppoimentsCalendar[i].nameStudy,
            //       inicio = 0,
            //       fin    = 500,
            //       subCadena = cadena.substring(inicio, fin);

            //       $scope.subNameStudy = subCadena+' '+'...';


            // }

            console.log($scope.listAppoimentsCalendar);
            $scope.getTotalAppoiments();
            $scope.getAssigned();
            $scope.getReAssigned();
            $scope.getConfirmed ();
            $scope.getCancel();
            $scope.getAppoimentsAttended();

            }else{

              $scope.showNoResults();
              $scope.totalAppoiments = 0;
              $scope.appointmentsAssigned = 0;
              $scope.appointmentsReAssigned = 0;
              $scope.appointmentsConfirmeds = 0;
              $scope.totalCancel = 0;
              $scope.totalAttended = 0;


            }

            }

          });
        }


      }

      /**
       * [getTotalAppoiments description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:45:38-0500
       * @return   {[type]}                 [Total de Citas]
       */
      $scope.getTotalAppoiments = function(){

        var con = 0;

        for(var i = 0; i < $scope.listAppoimentsCalendar.length; i++){

          con++;

          $scope.totalAppoiments = con;

        }

      }

      /**
       * [getAssigned description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:52:59-0500
       * @return   {[type]}                 [Total Asignadas]
       */
      $scope.getAssigned = function(){

        var con = 0;

        for(var i = 0; i < $scope.listAppoimentsCalendar.length; i++){

          if($scope.listAppoimentsCalendar[i].appointment_states_id == 1){

            con ++;


            $scope.appointmentsAssigned = con;

          }else{

            $scope.appointmentsAssigned = con;
          }

        }

      }

      /**
       * [getAssigned description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:52:59-0500
       * @return   {[type]}                 [Total ReAsignadas]
       */
      $scope.getReAssigned = function(){

        var con = 0;

        for(var i = 0; i < $scope.listAppoimentsCalendar.length; i++){

          if($scope.listAppoimentsCalendar[i].appointment_states_id == 2){

            con ++;


            $scope.appointmentsReAssigned = con;

          }else{

            $scope.appointmentsReAssigned = con;
          }

        }

      }

      /**
       * [getAssigned description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:52:59-0500
       * @return   {[type]}                 [Total Confirmadas]
       */
      $scope.getConfirmed = function(){

        var con = 0;

        for(var i = 0; i < $scope.listAppoimentsCalendar.length; i++){

          if($scope.listAppoimentsCalendar[i].appointment_states_id == 3){

            con ++;


            $scope.appointmentsConfirmeds = con;

          }else{

            $scope.appointmentsConfirmeds = con;
          }

        }

      }
      

      /**
       * [getCancel description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:30:26-0500
       * @return   {[type]}                 [Total de Citas Canceladas]
       */
      $scope.getCancel = function(){

        var con = 0;

        for (var i = 0; i < $scope.listAppoimentsCalendar.length; i++) {

          if($scope.listAppoimentsCalendar[i].appointment_states_id == 4){

            con ++;

            $scope.totalCancel = con;

          }else{

            $scope.totalCancel = con;
          }

        }

      }

       /**
       * [getCancel description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-08
       * @datetime 2016-11-08T08:30:26-0500
       * @return   {[type]}                 [Total de Citas Atendidas]
       */
      $scope.getAppoimentsAttended = function(){

        var con = 0;

        for (var i = 0; i < $scope.listAppoimentsCalendar.length; i++) {

          if($scope.listAppoimentsCalendar[i].appointment_states_id == 5){

            con ++;

            $scope.totalAttended = con;

          }else{

            $scope.totalAttended = con;

          }

        }

      }




      $scope.showOrder = function(orderId){
        l("Id de la orden");
        l(orderId);
        $localStorage.order = orderId;
        window.location = urls.BASE+"/#/app/agendamientoCita";
      }



      
      /**
       * [center Model Center]
       * @type {Object}
       */
      $scope.center = {

        id:'',
        code:'',
        contact:'',
        state:''
              }

      $scope.listAppoiments();

      /**
       * [selectCenter description]
       * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
       * @date     2016-11-09
       * @datetime 2016-11-09T15:59:17-0500
       * @return   {[type]}                 [cedes]
       */
      $scope.selectCenter = function(){

        avaibilityCalendarService.getSelectCenter(function(res){

          if(res.success == true){

            $scope.centers  = res.center;

            console.log( $scope.centers);

          }

        });

      }

$scope.selectCenter();



/**
 * [medicalOffices description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-11-09
 * @datetime 2016-11-09T16:00:21-0500
 * @param    {[type]}                 center [description]
 * @return   {[type]}                        [Permite seleccionar el consultorio dependiendo de la cede]
 */
$scope.medicalOffices = function(center){

    if(center.id == undefined){
      $scope.listAppoimentsCalendar = "";
      return;
    }
   if($scope.center.id != undefined){

     avaibilityCalendarService.getMedicalOffice({id:center.id}, function(res){

      if(res.success == true){

        $scope.allMedicalOffices = res.medicalOffices;

      }


    });

   }else{

    $scope.allMedicalOffices = undefined;

   }
}

$scope.showNoResults = function(){

  $('.noResults').modal('show');

}

$scope.hideNoResults = function(){

  $('.noResults').modal('hide');

}

$scope.goToAgendamientoCita = function(){

   $state.go('app.agendamientoCita'); 

}

      
}]);









