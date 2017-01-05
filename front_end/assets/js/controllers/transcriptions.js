'use strict';

/* Controllers */

angular.module('app')
.controller('transcriptionsCtrl', [

 '$scope',

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout',

 'usersService',

 'urls',

 'ordersService',

 'appointmentService',

 'costCentersService',

 'OrderAppointmentsService',

 'lendPlatesService',

 'attentionsService',

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

  appointmentService,

  costCentersService,

  OrderAppointmentsService,

  lendPlatesService,

  attentionsService
  ) {

   $scope.lend = {};

   $scope.$watch('selectedDate',function(){
  if($scope.selectedDate > $scope.selectedDateEnd){
    $scope.selectedDateEnd = $scope.selectedDate;
    
  }
});



   $scope.collapse = function(item){
     this.props.isExpanded  = !this.props.isExpanded;
     this.showArrow = !this.showArrow;
     $scope.currentItem = item;
   };

   $scope.showModalReturnPlate = function(order, appointment){

    $scope.lend.attentions_id = appointment.attentions[0].id;
    $scope.lend.users_id = order.users_id;
    $('.refund-plates').modal('show');
  }


  $scope.returnPlate = function(){
    attentionsService.updateLendPlateState($scope.lend, function(res){
      console.log(res);
      $('.refund-plates').modal('hide');
    }, function(){});
  }



/**
 * Search
 */

  $scope.sortType     = 'name'; // set the default sort type
  $scope.sortReverse  = false;  // set the default sort order
  $scope.searchFishOrder   = '';     // set the default search/filter term
  

  $scope.selectedDate = moment(new Date()).format('YYYY-MM-DD');
  $scope.selectedDateEnd = moment(new Date()).format('YYYY-MM-DD');

  $('#timepicker').timepicker(); 


  $scope.optionSelected;

  // modelo de especialidad seleccionada.
  //$scope.center.id  = undefined;
  
  /**
   * Get Center
   */
   $scope.selectedCenter  = undefined;

   $scope.selectSpecializations = undefined;



   $scope.getCenters = function(){

    ordersService.getCenters(function(res){

      $scope.centers = res.center;
      $scope.selectedCenter = $scope.centers[0].id;


    }, function (error) {

    });

  }
// llama la funcion pra obtener las sedes. 
$scope.getCenters();

/**
 * [getSpecializations Obtiene las especializaciones]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-12
 * @datetime 2016-12-12T08:53:13-0500
 * @param    {[type]}                 center [description]
 * @return   {[type]}                        [description]
 */
 $scope.getCostCenters = function(){

   costCentersService.get(function(res){

    if(res.success == true){

      $scope.allCostCenters = res.costCenter;

    }

  },function (error) {

  });

 }

 $scope.getCostCenters();


// /**
//  * Get all The specializations
//  * @return {[type]} [description]
//  */
//  $scope.getSpecialization = function(){

//    costCentersService.get(function(res){

//     $scope.Specializations = res.specialization;

//   }, function(error){
//     console.log(error);
//   });
// }

// $scope.getSpecialization();


/**
 * funcion para formatear, los datos a mostrar. 
 */
 function formatDataOrder(data){
  var orderList =new Array();

   // recorre el listado de ordenes
   for (var i = 0; i < data.length; i++) {

     var order = data[i].order;
     var appointments = data[i].appointments;

     var list = new Array();  

     for (var j = 0; j < appointments.length; j++) {

      var item= {

        study_cup:  appointments[j].study.cup, 

            study_name:  appointments[j].study.name, //  nombre estudio.
            
            date_attent: moment(appointments[j].attentions[0].date_time_ini).format('YYYY-MM-DD hh:mm'),

            lend_plates: appointments[j].attentions[0].lend_plates,

            appointment:appointments[j],

          }

          list.push(item);
        }

        var options = {

          id: i+1,

          order: order,
          // consecutivo de la orden
          order_consec:order.order_consec,

          people_document:order.patient.person.identification, // numero de documento paciente

          people_name: order.patient.person.first_name
          +" "+ order.patient.person.middle_name 
          +" "+ order.patient.person.last_name
          +" "+ order.patient.person.last_name_two, // nombres y apellidos paciente

          total: order.total,

          subtotal:order.subtotal,

          appointments:list,

          count: list.length,

        }


        orderList.push(options);

      }

      $scope.orders = orderList;
    }



/**
 * Obtiene las ordenes que  no se han generado factura.  
 * @return {[type]} [description]
 */
 $scope.getOrdersWithOutTranscription = function(){

  l($scope.selectSpecializations +" este");

  ordersService.getWithoutResult({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter, cost_centers: $scope.selectSpecializations},function(res){

   console.log(res.result);
   if(res.success){
    formatDataOrder(res.result);
  } else{
    $scope.orders =undefined;
  }


}, function(error){

  console.log(error);

});
} 



/**
 * Obtiene las ordenes que  no se han generado factura.  
 * @return {[type]} [description]
 */
 $scope.getOrdersLendPlates = function(){


  ordersService.getLendPlatesResult({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter},function(res){

   console.log(res.result);
   if(res.success){
    formatDataOrder(res.result);
  } else{
    $scope.orders =undefined;
  }


}, function(error){

  console.log(error);

});
} 


/**
 * Obtiene las ordenes que  no se han generado factura.  
 * @return {[type]} [description]
 */
 $scope.getOrdersWithTranscription = function(state, complement){

    // moment(new Date()).format('YYYY-MM-DD');

    ordersService.getWhitResult({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter, cost_centers: $scope.selectSpecializations,state: state, complement: complement},function(res){

     console.log(res.result);

     if(res.success){

      formatDataOrder(res.result);
    }
    else{
      $scope.orders = undefined;
    }



  }, function(error){

    console.log(error);

  });
  } 





  $scope.disabled = true;


  /** funcion que llama las funciones si ya se ha seleccionado toda la informacion. */
  $scope.loadValues = function (){

    if($scope.selectedCenter != undefined && $scope.selectedDate !=undefined && $scope.selectedDateEnd !=undefined 
        && $scope.selectSpecializations != undefined){
      
      var complement = 0;

      // Sin Confirmar -  sin transcripcion
      if($scope.optionSelected == 1){

        $scope.getOrdersWithOutTranscription();
      }

      // con transcripcion. 
      if($scope.optionSelected == 2){

        $scope.getOrdersWithTranscription(0, complement);

      }   

      if($scope.optionSelected == 3){

        $scope.getOrdersWithTranscription(1, complement);

      }

      if($scope.optionSelected == 4){

        $scope.getOrdersWithTranscription(2, complement);

      }
      if($scope.optionSelected == 5){

        complement = 1;

        $scope.getOrdersWithTranscription(0, complement);
      }
       // con transcripcion. 
       if($scope.optionSelected == 6){

        $scope.getOrdersLendPlates();

      }   

    }
  }


// funcion para detectar cuando se cambia el radio button. 
$scope.$watch('optionSelected', function(){

  $scope.loadValues();

});

/**
 * funcion para prestamo de placas.
 */
 $scope.lendData = function(order,appointment){

   var data ={ 
    tipo: 3,
    order: order,
    appointment:appointment
  };
  console.log(data);

  $scope.lend.attentions_id = appointment.attentions[0].id;

  $scope.tempLend = appointment;

  //   $localStorage.order = data;

  // $state.go('app.studyTranscription');
  
  $('.lend-plates').modal('show');
}


/**
 * funcion de transcripcion
 */
 $scope.verDatos = function(order,appointment){
  var data ={ 
    tipo: $scope.optionSelected,
    order: order,
    appointment:appointment
  };
  //console.log(data.tipo + " , " + order.id + " , " +appointment.id +" datos para ver");

  $localStorage.order = data;

  $state.go('app.studyTranscription'); 
  
}

//funcion para imprimir los stickers en transcripciones.
$scope.PrintSticker = function(order,appointment){

  var data ={ 
    order: order,
    appointment:appointment
  };

  console.log(data);

  OrderAppointmentsService.printSticker(data,function(res){

    console.log('entro');

    console.log(res);

    var fileName = res.storedFileName.storedFileName

    window.location.href = urls.BASE_API + '/OrderAppointments/downloadPrev/' + fileName;

  }, function(error){

    console.log(error);

  });
  

}


$scope.LendAppointment = function(){

  console.log($scope.lend);

  lendPlatesService.addLend($scope.lend,function(res){
    if(res.success){
      editAttentionLend({id:$scope.lend.attentions_id},function(res){

      },function(error){
        console.log(error);
      });
    }


  },function(erorr){console.log(error);});






  $('#modal-lends-plates').modal('hide');
}

$scope.hideModalDropConfirmation = function(){

 $('.lend-plates').modal('hide');

 $scope.lend = {};

}




   // Final controlador
 }]);