'use strict';

/* Controllers */

angular.module('app')
.controller('ordersListCtrl', [

 '$scope',

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout',

 'usersService',

 'urls',

 'ordersService',

 '$compile',

 'appointmentService',

 'uiCalendarConfig',
 
 'specializationsService',

 'costCentersService',


 function(

  $scope, 

  $state, 

  $rootScope, 

  $localStorage, 

  $location, 

  $timeout, 

  usersService,

  urls,

  ordersService,

  $compile,

  appointmentService,

  uiCalendarConfig,

  specializationsService,

  costCentersService

  ) {

  $scope.showOrders = false;
  /**
   * Resetear Orden si esta existe.
   * @type {[type]}
   */
   $localStorage.order = undefined;

   $scope.collapse = function(item){
     this.props.isExpanded  = !this.props.isExpanded;
     this.showArrow = !this.showArrow;
     $scope.currentItem = item;
   };



$scope.$watch('selectedDate',function(){
  if($scope.selectedDate > $scope.selectedDateEnd){
    $scope.selectedDateEnd = $scope.selectedDate;
    
  }
});

/**
 * Search
 */

  $scope.sortType     = 'name'; // set the default sort type
  $scope.sortReverse  = false;  // set the default sort order
  $scope.searchFish   = '';     // set the default search/filter term


  $scope.searchFishOrder   = '';     // set the default search/filter term
  

  $scope.selectedDate = moment(new Date()).format('YYYY-MM-DD');
  $scope.selectedDateEnd = moment(new Date()).format('YYYY-MM-DD');

  $('#timepicker').timepicker(); 




// modelo datos Ordenes
$scope.orders = {}



$scope.optionSelected;

$scope.appointments ={}

  // modelo de especialidad seleccionada.
  $scope.selectedSpeciality  = undefined;
  
  /**
   * Get Center
   */
   $scope.selectedCenter  = undefined;


/**
 * define cita a cancelar
 * @type {[type]}
 */
 $scope.cancelAppointment = undefined;
  /**
   * Observaciones de por que se va a cancelar la cita.
   * @type {[type]}
   */
   $scope.observations = undefined;




 /**
 * Modal Add Confirmation
 */

 $scope.Confirmation = function(id){

  $localStorage.order = id.id;
  console.log('VALOR QUE SE ENVIA A AGENDAMIENTO CITA');
  console.log(id.id);
  $state.go('app.agendamientoCita'); 
}

/**
 * Muestra Modal con la cita a acancelar.
 */
 $scope.showModalDropConfirmation = function(appointment){


  $scope.cancelAppointment = appointment ;
  l("Cancelar appointment");
  l(appointment);

  $('.delete-confirmation').modal('show');

}

/**
 * Oculta la modal si ya no se va  a cancelar la cita.
 * @return {[type]} [description]
 */
 $scope.hideModalDropConfirmation = function(){

  $('.delete-confirmation').modal('hide');
  $scope.cancelAppointment = undefined;

}

/**
 * Obtiene Centro de costos.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-10-06
*/
$scope.getCenters = function(){

  ordersService.getCenters(function(res){

    $scope.centers = res.center;
    var code = res.center.length+1;
    $scope.centers.push({code:"0"+code, id:"all", name:"TODOS"});
    console.log($scope.centers);
  }, function (error) {

  });

}
/**
 * llama la funcion pra obtener las sedes.
 */
$scope.getCenters();

/**
 * Get all The specializations
 * @return {[type]} [description]
 */
 $scope.getSpecialization = function(){

   costCentersService.get(function(res){
    l('Centros de Costos');
    l(res);
    
    $scope.Specializations = res.costCenter;

  }, function(error){
    l(error);
  });
 }

 $scope.getSpecialization();


/**
 * funcion para formatear, los datos a mostrar. 
 */
 function formatDataStudy(data){

   var appointment = data;
   l('--formatStudy()--parametro recibido');
   console.log(appointment);

   var appointmentlist = new Array(); 
   
    if(appointment != undefined){
       for (var i = 0; i < appointment.length; i++) {

        var study = appointment[i].study;

            var orders = appointment[i].orders[0]; // detalle de la orden.

            var options = {

              id_appointment:appointment[i].id,

              id_appointmentsData: appointment[i]._matchingData.AppointmentDates, // 

              id_order:orders, // numero de detalle de orden -> si se necesita consultar si ya tiene orden.

              people_document:orders.patient.person.identification, // numero de documento paciente

              people_name: orders.patient.person.first_name

              +" "+ orders.patient.person.middle_name 
              
              +" "+ orders.patient.person.last_name +" "+ orders.patient.person.last_name_two, // nombres y apellidos paciente


              service_name:appointment[i].study.name, // nombre del studio


              service_hour: moment(appointment[i]._matchingData.AppointmentDates.date_time_ini).format('YYYY-MM-DD hh:mm a'),   // hora inicio de atencion

              order_state:appointment[i]._matchingData.AppointmentDates.appointment_states_id, // estado de la cita .

              medical_office: appointment[i].medical_office.name


            }
      
          appointmentlist.push(options);

        }
      }

      $scope.appointments = appointmentlist;

      console.log($scope.appointments);


    }

    $scope.specialistExtarnalName = undefined;

/**
 * Funcion para obtener los servicios  confirmados pero no han sido atendidos
 * @return {[type]} [description]
 */
 $scope.getConfirmAppoinments = function(){

  var speciality = $scope.selectedSpeciality;
  if($scope.selectedSpeciality == undefined){
    speciality = 0;
  }
  
  l(speciality);
  ordersService.getConfrimAppoinmentsByDay({date:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter,speciality:speciality},function(res){

    l('respuesta de la consultas confirmadas');
       formatDataStudy(res.query);

  }, function(error){

    l(error);

  });
} 





  /**
   * funcion para obtener todos los servicios sin confirmacion. 
   * @return {[type]} [description]
   */
   $scope.getUnconfirmateAppointments = function(){

    var speciality = $scope.selectedSpeciality;
    if($scope.selectedSpeciality == undefined){
      speciality = 0;
    }
    

    ordersService.getUnconfAppointmentsDay({date:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter,speciality:speciality},function(res){

     // l(res);

     formatDataStudy(res.query);

   }, function(error){

    l(error);

  });
  } 

/**
 * servicos que ya fueron atendidos.
 * @return {[type]} [description]
 */
 $scope.getAttencionAppointments = function(){

  var speciality = $scope.selectedSpeciality;
  if($scope.selectedSpeciality == undefined){
    speciality = 0;
  }

  ordersService.getAttentionAppoinmentsByDay({date:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter,speciality:speciality},function(res){

     // l(res);

     formatDataStudy(res.query);

   }, function(error){

    l(error);

  });
} 




/**
 * funcion para formatear, los datos a mostrar. 
 */
 function formatDataOrder(data){

   var order = data;
   for(var i =0; i < order.length; i++){
     if(order[i].appointments.length == 0 || order[i].appointments == undefined){
       order.splice(i,1);
     }
   }

   var orderList = new Array(); 

   // recorre el listado de ordenes
   for (var i = 0; i < order.length; i++) {

      //recorre  el listado de studios de esa orden.
      
      var list = new Array();  
      
      if( order[i].appointments != undefined && order[i].appointments.length >0){

        
        for (var j = 0; j < order[i].appointments.length; j++) {
          
          l(order[i].appointments[j]);

        // obtener el ultimo registro de esa cita.
        var itemDetailLeng  = order[i].appointments[j].appointment_dates.length;

        var fechaAtencion;
        var stado;

        if(itemDetailLeng >=1){

          fechaAtencion=moment(order[i].appointments[j].appointment_dates[itemDetailLeng-1].date_time_ini).format('YYYY-MM-DD hh:mm a'); // falta validar bien 
          stado = order[i].appointments[j].appointment_dates[itemDetailLeng-1].appointment_state.state ; 
        }

        l(itemDetailLeng);

        var item= {

          id:j+1,

          study_cup:  order[i].appointments[j].study.cup, 
          
            study_name:  order[i].appointments[j].study.name, //  nombre estudio.
            
            date_attent: fechaAtencion,

            state: stado,
          }

          l(item);

          list.push(item);
        }

        var options = {
          
          id: i+1,
          order_consec:order[i].order_consec,

          people_document:order[i].patient.person.identification, // numero de documento paciente

          people_name: order[i].patient.person.first_name
          +" "+ order[i].patient.person.middle_name 
          +" "+ order[i].patient.person.last_name
          +" "+ order[i].patient.person.last_name_two, // nombres y apellidos paciente

          total: order[i].total,
          subtotal:order[i].subtotal,
          appointments:list,

        }


      }

      orderList.push(options);

    }

    l(orderList);
    $scope.orders = orderList;


  }


/**
 * Obtiene las ordenes que  no se han generado factura.  
 * @return {[type]} [description]
 */
 $scope.getOrdersWithoutPayment = function(){


  ordersService.getWithoutPayment({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter},function(res){
   l("datos ordenes sin pago");
   l(res.query);

   //evita que en la lista aparezcan index sin información
   for(var i =0; i < res.query.length; i++){
     if(res.query[i].appointments.length == 0 || res.query[i].appointments == undefined){
       l(res.query[i]);
       res.query.splice(i,1);
     }
   }
   l(res.query);

   formatDataOrder(res.query);
   //l(appointments);

 //  $scope.orders = res.query;



 l(res);


}, function(error){

  l(error);

});
} 



/**
 * Obtiene las ordenes que  no se han generado factura.  
 * @return {[type]} [description]
 */
 $scope.getOrdersWithPayment = function(){


  ordersService.getWithPayment({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter},function(res){
   l("datos ordenes con  pago");
   l(res.query);
   formatDataOrder(res.query);

 //  $scope.orders = res.query;


 l(res);


}, function(error){

  l(error);

});
} 


$scope.disabled = true;


/** funcion que llama las funciones si ya se ha seleccionado toda la informacion. */
$scope.loadValues = function (){



  if($scope.selectedCenter != undefined  && $scope.selectedDate !=undefined){


      // Sin Confirmar - Asignadas, reasignadas
      if($scope.optionSelected == 1){
        $scope.showOrders = false;
        $scope.getUnconfirmateAppointments();
      }

      // Confirmadas ?? no se si se muestra las ya atendidas.... 
      if($scope.optionSelected == 2){
        $scope.showOrders = false;
        $scope.getConfirmAppoinments();
      }   

      // atenciones.
      if($scope.optionSelected == 3){
        $scope.showOrders = false;
        $scope.getAttencionAppointments();

      }

    }

    
    // obtiene las ordenes que no tienen un pago.
    if($scope.optionSelected == 4){
      $scope.showOrders = true;

      if($scope.selectedDateEnd !=undefined && $scope.selectedDate != undefined &&  $scope.selectedCenter != undefined ) {

        $scope.getOrdersWithoutPayment();

      }
      l( $scope.selectedCenter + " " + $scope.selectedDate+ " "+ $scope.selectedDateEnd   );
    }

    if($scope.optionSelected == 5)
    {
      $scope.showOrders = true;
      if($scope.selectedDateEnd !=undefined && $scope.selectedDate != undefined &&  $scope.selectedCenter != undefined ) {

        $scope.getOrdersWithPayment();

      }
      l( $scope.selectedCenter + " " + $scope.selectedDate+ " "+ $scope.selectedDateEnd   );
    }

  }

// funcion para detectar cuando se cambia el radio button. 
$scope.$watch('optionSelected', function(){

  $scope.loadValues();

});


//-------------------------------- Save cancel Reason --------------------------------------------

$scope.cancelResons ={
  content: ''
}

/**
 * Registra el comentario de por que se cancela.
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
 $scope.comentCancelAppointment = function(id){

  var data ={
   content: $scope.cancelResons.content,
   appointment_dates_id:id
 }

 appointmentService.cancelReasons(data,function(res){

  if(res.success){

   $scope.hideModalDropConfirmation();
   $scope.loadValues();

 }

}, function (error) {

});
}


/**
 * Funcion para cancelar cita. 
 * @return {[type]} [description]
 */
 $scope.cancelAppointments = function(){


  l($scope.cancelAppointment);

  var oldAppointment = $scope.cancelAppointment.id_appointmentsData;
  var appointment = {
    appointments_id:  oldAppointment.appointments_id,
    date_time_ini:moment(oldAppointment.date_time_ini).format('YYYY-MM-DD hh:mm:ss'),
    date_time_end: moment(oldAppointment.date_time_end).format('YYYY-MM-DD hh:mm:ss'),
    appointment_states_id: 4
  }

  appointmentService.cancelAppointmentDates(appointment,function(res){

    l(res);

    if(res.success){

      var id = res.appointmentDates.id;
      l(res.appointmentDates.id);



      $scope.comentCancelAppointment(id);

    }

  }, function (error) {

  });

  

  $('.delete-confirmation').modal('show');

}



// -------------------------------- End Save cancel Reason --------------------------------------------


   // Final controlador
 }]);