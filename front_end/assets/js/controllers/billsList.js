'use strict';

/* Controllers */

angular.module('app')
.controller('billsListCtrl', [

 '$scope',

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout',

 'usersService',

 'urls',

 'BillsService',

 '$compile',

 'ordersService',

 'uiCalendarConfig',
 
 'specializationsService',

 'costCentersService',
 'BillDetailsService',
 'saleNoteService',
 
 'peopleService',


 function(

  $scope, 

  $state, 

  $rootScope, 

  $localStorage, 

  $location, 

  $timeout, 

  usersService,

  urls,

  BillsService,

  $compile,

  ordersService,

  uiCalendarConfig,

  specializationsService,

  costCentersService,
  
  BillDetailsService,
  
  saleNoteService,
  
  peopleService

  ) {

  $scope.itemsBills;
  /**
   * Funciones para Habilitar la Anulacion  de Facturas.
   * @type {Boolean}
   */
   $scope.isEnabled = false;

   $scope.rol = $localStorage.user.roles_id;
   if($scope.rol == 6 || $scope.rol == 10){
    $scope.isEnabled = true
  }else
  {$scope.isEnabled = false;
  } 
  console.log('El Usuario ' + $localStorage.user.username + '... esta habilitado '+ $scope.isEnabled);

$scope.$watch('selectedDate',function(){
  if($scope.selectedDate > $scope.selectedDateEnd){
    $scope.selectedDateEnd = $scope.selectedDate;
    
  }
});


  $scope.showOrders = false;
/**
 * Resetear Orden si esta existe.
 * @type {[type]}
 */
 $localStorage.order = undefined;

 $scope.userData = $localStorage.person;
// console.log($scope.userData);


$scope.collapse = function(item){
 this.props.isExpanded  = !this.props.isExpanded;
 this.showArrow = !this.showArrow;
 $scope.currentItem = item;
};




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
 $scope.cancelBills = undefined;
  /**
   * Observaciones de por que se va a cancelar la cita.
   * @type {[type]}
   */
   $scope.observations = undefined;




 /**
 * Modal Add Confirmation
 */

 $scope.Confirmation = function(id){

  $localStorage.order = id;

  // console.log(id);

  $state.go('app.agendamientoCita'); 
  

} 
$scope.editReazon = true;

/**
 * Muestra modal con los detalles de la anulacion o Nota de venta de la Factura.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-12-15
 * @datetime 2016-12-15T16:32:30-0500
 * @param    {[type]}                 bill [description]
 * @return   {[type]}                      [description]
 */
 $scope.showModalDropConfirmation = function(bill){

  var bill_state = bill.canceled;


  if(bill_state == 0){
   $scope.cancelBills = bill ;

   $scope.editReazon = true;
   $('.delete-confirmation').modal('show');
   $('[name=confirm-bill-delete]').show();
   /* modifica la apariencia de la ventana modal dependiendo de la acción que se desee realizar*/
   $('[name=button-hide-delete-order]').removeClass('col-xs-12').addClass('col-xs-6');
   $scope.cancelReasons = "";
   
 }else
 {
  if(bill_state ==1){

   $scope.cancelBills = bill ;
   BillsService.getCancelReazons({id:$scope.cancelBills.all.id},function(res){

     console.log('RAZON CANCELACION');
     console.log(res);
     console.log($scope.cancelBills);
     if(res.success){
     // $scope.cancelBills = res.cancelBill.reazons;
     $scope.cancelReasons = res.cancelBill;
     $scope.editReazon = false;

     /* modifica la apariencia de la ventana modal dependiendo de la acción que se desee realizar*/
     $('.delete-confirmation').modal('show');
     $('[name=confirm-bill-delete]').hide();
     $('[name=button-hide-delete-order]').removeClass('col-xs-6').addClass('col-xs-12');        
   }

 },function(error){});
 }else{

  if(bill_state ==2){

   // $scope.ShowModalNota(bill);
   saleNoteService.getSaleNotesReazons({id:bill.id},function(res){
    console.log('Obtiene Informacion de la Nota de Venta');
    $scope.billDetails = {};

    if(res.success){

      $scope.editReazon = false;
      $scope.saleNoteRezons = res.saleNote; 
      $scope.billDetails.bills = $scope.saleNoteRezons.bill;
      $scope.billDetails.bills_numbers = res.saleNote.bill.bill_number;

      $scope.billDetails.payments = {};
      var payment = res.saleNote.bill.payments.length -1;
      var pago = {};
      var newPago = new Array();

      pago.bill_number = res.saleNote.bill.bill_number,
      pago.discount  = parseInt(res.saleNote.bill.payments[payment].discount);
      pago.donation  = parseInt(res.saleNote.bill.payments[payment].donation);
      pago.copayment  = parseInt(res.saleNote.bill.payments[payment].copayment);

      if(res.saleNote.bill.payments[payment].debit > 0){
        pago.subtotal = parseInt(res.saleNote.bill.payments[payment].debit) + parseInt( res.saleNote.bill.payments[payment].discount) + parseInt( res.saleNote.bill.payments[payment].donation);
        pago.total =  parseInt(res.saleNote.bill.payments[payment].debit);
      }else{
        pago.subtotal = parseInt(res.saleNote.bill.payments[payment].credit )+ parseInt(res.saleNote.bill.payments[payment].copayment);
        pago.total = parseInt(res.saleNote.bill.payments[payment].credit);
      }

      newPago.push(pago);
      $scope.billDetails.payments = newPago;

        // FORMATO DE FECHAS
        $scope.billDetails.details = res.saleNote.bill.bill_details[0];
        $scope.billDetails.details.bill_expiration = moment(res.saleNote.bill.bill_details[0].bill_expiration).format('YYYY-MM-DD');
        $scope.billDetails.details.bill_created = moment(res.saleNote.bill.bill_details[0].bill_created).format('YYYY-MM-DD');

        console.log('Detalles dela factrua');
        console.log($scope.billDetails);


      /**
       * Obtiene Items de facturacion.
       * @author Deicy Rojas <deirojas.1@gmail.com>
       * @date     2016-12-23
       * @datetime 2016-12-23T14:03:44-0500 
       * */
       BillDetailsService.getBillDetailsByBillId({id:bill.id},function(res){

         if(res.success){

          $scope.billDetails.items =  res.resultado;

          console.log($scope.billDetails);

        }
        else{
        }

      },function(error){
      });

     }

   },function(error){

   });




   $('.delete-Notes').modal('show');
   $('[name=confirm-bill-sale-note').hide();
   $('[name=button-hide-sale-note]').removeClass('col-xs-6').addClass('col-xs-12');       
   console.log('Como Obtendo datos');




        // $('.delete-Notes').modal('show');
        // $('[name=confirm-bill-sale-note').show();
        // $('[name=button-hide-sale-note]').removeClass('col-xs-12').addClass('col-xs-6');       

      }
    }



  }


  bill_state = undefined;


}

/**
 * Oculta la modal si ya no se va  a cancelar la cita.
 * @return {[type]} [description]
 */
 $scope.hideModalDropConfirmation = function(){

  $('.delete-confirmation').modal('hide');
  $scope.cancelBills = undefined;

}


$scope.getCenters = function(){

  ordersService.getCenters(function(res){

    $scope.centers = res.center;


  }, function (error) {

  });

}
// llama la funcion pra obtener las sedes. 
$scope.getCenters();


/**
 * funcion para formatear, los datos a mostrar. 
 */
 $scope.formatData= function (data){
  console.log("--formatData--");
  console.log(data);
  
  //if($scope.optionSelected = '1' || $scope.optionSelected == 1 ){


    var listBills = new Array();
    var longitud =  Object.keys( data ).length || data.length;

    
    $scope.totalEntidad = 0;
    $scope.totalParticular = 0;
    $scope.totalDescuento = 0;

    for (var i = 0; i < longitud; i++) {
      if(!data[i]){
        continue;
      }

      if(data[i] != null){
       var item  = {
        id: data[i].id,
        order_id: data[i]._matchingData.Orders.id,
        order_code: data[i]._matchingData.Orders.order_consec,
        bill_code: data[i].bill_number,
        people: data[i]._matchingData.People,
        
        total: data[i].subtotal,
        debit : data[i].payments[0].debit,
        credit  : data[i].payments[0].credit,
        donation: data[i].payments[0].donation + data[i].payments[0].discount,

        fecha:  moment(data[i].created).format('YYYY-MM-DD'),
        user: data[i].user.person.first_name +' '+ data[i].user.person.last_name,
        rate:data[i]._matchingData.Rates.name,
        canceled:data[i].canceled,
        all: data[i], 
        shwoNote: moment(new Date()).format('YYYY-MM-DD') ==  moment(data[i].created).format('YYYY-MM-DD') 
      }
      if( item.canceled == 0  ){
        $scope.totalEntidad += parseFloat( item.credit );
        $scope.totalParticular += parseFloat( item.debit );
        $scope.totalDescuento += parseFloat( item.donation );
      }
      listBills.push(item);
    }
  }

  l("--itemsBills--");
  l(listBills);
  $scope.itemsBills = listBills;
//}
}


/**
 * Obtiene la facturacion del dia.
 * @return {[type]} [description]
 */
 $scope.getBills = function(){



  BillsService.getBills({dateIni:$scope.selectedDate,dateEnd:$scope.selectedDateEnd,center:$scope.selectedCenter, users_id : $scope.Informe.username.id, filter: $scope.optionSelected},function(res){
    console.log("datos ordenes sin pago");
    console.log(res); 

    if( res.success ){
      $scope.formatData(res.bills);



    }


  }, function(error){

    console.log(error);

  });
} 




/** funcion que llama las funciones si ya se ha seleccionado toda la informacion. */
$scope.loadValues = function (){


    // obtiene las ordenes que no tienen un pago.
    if($scope.optionSelected == 1 ||  $scope.optionSelected == 3 || $scope.optionSelected == 4 ){

      if($scope.selectedDateEnd !=undefined && $scope.selectedDate != undefined &&  $scope.selectedCenter != undefined ) {

        $scope.getBills();

      }
      console.log( $scope.selectedCenter + " " + $scope.selectedDate+ " "+ $scope.selectedDateEnd   );
    }

    if($scope.optionSelected == 2)
    {
      $scope.showOrders = true;
      if($scope.selectedDateEnd !=undefined && $scope.selectedDate != undefined &&  $scope.selectedCenter != undefined ) {

        $scope.getProductBills();

      }
      console.log( $scope.selectedCenter + " " + $scope.selectedDate+ " "+ $scope.selectedDateEnd   );
    }

  }

// funcion para detectar cuando se cambia el radio button. 
$scope.$watch('optionSelected', function(){

  $scope.loadValues();

});




//-------------------------------- Save cancel Reason --------------------------------------------

$scope.cancelReasons ={
  reazons: '',
  bill_number:'',
  bills_id:''

}

/**
 * Registra el comentario de por que se cancela.
 * @param  {[type]} id [description]
 * @return {[type]}    [description]
 */
 $scope.cancelBilling = function(){

//id, bill_number, reazons, bills_id, created, modified

if($scope.cancelBills.canceled == 0 && $scope.isEnabled){


  $scope.cancelReasons.bill_number= $scope.cancelBills.all.bill_number;
  $scope.cancelReasons.bills_id = $scope.cancelBills.all.id;
  $scope.cancelReasons.all = $scope.cancelBills.all;

  console.log($scope.cancelReasons);


  BillsService.cancelBill($scope.cancelReasons,function(res){
    if(res.success){
     $scope.getBills();

     $scope.hideModalDropConfirmation();
     $scope.cancelBills = undefined;
     $scope.cancelReasons = undefined;
        // if(res){
        //   console.log('guardo cancelado');
        //   console.log(res);
        // }
      }
    },function(error){});
}

}

// -------------------------------- End Save cancel Reason --------------------------------------------



// ---------------------------- Inicio Notas de Venta --------------------------------------------------

$scope.getAllOrderBills = function(bill_id){
  BillsService.getAllOrderBills({id:bill_id},function(res){
    if(res.success){
      return res.bills;
    }
  },function(error){});
} 




$scope.billDetails = {
  saleNote_bill:'',
  bills_numbers:'',
  bills:'',
  items:'',

};

$scope.noteBills = undefined;



/**
 * Abre modal Nota de ventas
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-12-05
 * @datetime 2016-12-05T15:28:57-0500
 */
 $scope.ShowModalNota = function(bill){

  $scope.billDetails = undefined;

  $scope.billDetails = {};

  $scope.saleNoteRezons = undefined;

  $scope.noteBills = bill;


  $scope.billDetails.saleNote_bill = bill;
  
  /**
   * Obtiene todas las facturas activas de la orden. 
   * @author Deicy Rojas <deirojas.1@gmail.com>
   * @date     2016-12-20
   * @datetime 2016-12-20T14:51:39-0500
   * @param    {[type]}res){BillDetailsService.getBillDetailsByBillId({id:$scope.noteBills.id} [description]
   * @param    {[type]}function(res){ if(res.success){      $scope.billDetails [description]
   * @return   {[type]}[description]
   */

   BillsService.getBillByOrder({id:$scope.noteBills.order_id},function(res){
    
    if(res.success){
      /**
       * Obtiene las facturas activas de la orden a la cual se va a realizar la nota de venta.
       * @type {[type]}
       */
       $scope.billDetails.bills = res.bills;


       $scope.billDetails.payments = {};
       var pagos =new Array();
       for (var i = res.bills.length - 1; i >= 0; i--) {

        var newPago = new Array();
        newPago['bill_number']= res.bills[i].bill_number,
        newPago['discount'] = parseInt(res.bills[i].payments[0].discount);
        newPago['donation'] = parseInt(res.bills[i].payments[0].donation);
        newPago['copayment'] = parseInt(res.bills[i].payments[0].copayment);

        if(res.bills[i].payments[0].debit > 0){
          newPago['subtotal'] = parseInt(res.bills[i].payments[0].debit) + parseInt( res.bills[i].payments[0].discount) + parseInt( res.bills[i].payments[0].donation);
          newPago['total'] =  parseInt(res.bills[i].payments[0].debit);
        }else{
          newPago['subtotal'] = parseInt(res.bills[i].payments[0].credit )+ parseInt(res.bills[i].payments[0].copayment);
          newPago['total'] = parseInt(res.bills[i].payments[0].credit);
        }
        pagos.push(newPago);

        if($scope.billDetails.bills_numbers == undefined){

         $scope.billDetails.bills_numbers = res.bills[i].bill_number;

       }else
       {
         $scope.billDetails.bills_numbers += '  -  '+ res.bills[i].bill_number;

       }
        // Obtiene los detalles de factura
        $scope.billDetails.details = res.bills[i].bill_details[0];
      }


      $scope.billDetails.payments = pagos;
        // FORMATO DE FECHAS
        $scope.billDetails.details.bill_expiration = moment($scope.billDetails.details.bill_expiration).format('YYYY-MM-DD');
        $scope.billDetails.details.bill_created = moment($scope.billDetails.details.bill_created).format('YYYY-MM-DD');
        console.log('Detalles dela factrua');
        console.log($scope.billDetails);


      /**
       * Obtiene Items de facturacion.
       * @author Deicy Rojas <deirojas.1@gmail.com>
       * @date     2016-12-23
       * @datetime 2016-12-23T14:03:44-0500 
       * */
       BillDetailsService.getBillDetailsByBillId({id:$scope.noteBills.id},function(res){

         if(res.success){

          $scope.billDetails.items =  res.resultado;

          console.log($scope.billDetails);

        }
        else{
        }

      },function(error){
      });

     }

   },function(error){

   })

   if($scope.editReazon == false && $scope.saleNoteRezons.id == undefined){
      $scope.editReazon = true;
      $('[name=button-hide-sale-note]').removeClass('col-xs-12').addClass('col-xs-6');       
   }
   $('[name=confirm-bill-sale-note]').show();
   $('.delete-Notes').modal('show');

 }

/**
 * Oculta modal si ya  no se va a realizar la nota de venta.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-12-05
 * @datetime 2016-12-05T15:31:37-0500
 * @return   {[type]}                 [description]
 */
 $scope.hideModalNotsConfirmation = function(){

  $('.delete-Notes').modal('hide');
  $scope.noteBills = undefined;

}

$scope.saleNoteRezons = undefined;


/**
 * Se genera nota de venta.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-12-07
 * @datetime 2016-12-07T16:04:24-0500
 * @return   {[type]}                 [description]
 */
 $scope.saveSaleNote = function(){

  console.log('Detalles de Facturacion');
  console.log($scope.billDetails);
  console.log('----*************************-----');
  if($scope.noteBills.canceled == 0 && $scope.isEnabled){
    var cleared = false;
    var sale = new Array();
    for (var i = $scope.billDetails.bills.length - 1; i >= 0; i--) {

      console.log('factura');
      console.log($scope.billDetails.bills[i]);

      $scope.newSaleNote = {};
      $scope.newSaleNote.bill_number= $scope.billDetails.bills[i].bill_number;
      $scope.newSaleNote.bills_id = $scope.billDetails.bills[i].id;
      $scope.newSaleNote.users_id = $localStorage.user.id;
      $scope.newSaleNote.observations = 'Nota de venta a Factura : '+ $scope.billDetails.bills[i].bill_number + ' -- '+ $scope.saleNoteRezons.observations ;

      sale.push($scope.newSaleNote)
      $scope.newSaleNote = undefined;
      console.log($scope.saleNoteRezons);

    }
  // $timeout(function () {
   saleNoteService.saleNoteBills(sale,function(res){

    if(res){
      res.cleared = true;
         // $scope.saleNoteRezons = undefined;
         $scope.hideModalNotsConfirmation();
       }

     },function(error){});

     // }, 1000);

   }

 }


  /*
    Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
    Fecha: 2017-01-03 08:44:42
    Tipo de retorno:  void
    Descripción: genera la lista de usuarios o el buscador dependiendo del rol
  */
 function Informe(){
   // variables
    this.username = {
      rol  : $localStorage.role,
      name : $localStorage.person.first_name+" "+$localStorage.person.middle_name+" "+$localStorage.person.last_name+" "+$localStorage.person.last_name_two,
      id   : $localStorage.user.id
    }

    this.listaUsuarios = [];

    var _this = this;

    if( this.username.rol != 1 && this.username.rol != 10){

      $( '[name=usuario]' ).prop( 'disabled', true );

    }



    // busqueda y seleccion de usuario
    this.buscarUsuario = function(){

      if( this.username.name != '' && this.username.name != null && isNaN( parseInt( this.username.name ) ) ){
        
        // si es una busqueda
        peopleService.searchUsersByName(
          {
            name : this.username.name
          },
          function( success ){
            _this.listaUsuarios = success.results;
          },
          function( error ){

          }
        );
      }
      else{

        // si es númerico ( una seleccion )
        if( !isNaN( parseInt( this.username.name ) ) ){
          
          var indice = parseInt( this.username.name );
          _this.username.id = _this.listaUsuarios[ indice ].id;
          _this.username.name = _this.listaUsuarios[ indice ].name;
          $scope.loadValues();
        
        }
        else{

          _this.username.id = null;
          _this.username.name = null;
          $scope.loadValues();

        }

      }
    }
    this.imprimirPDF = function(){

      var data = {
        bills   : $scope.itemsBills,
        dateIni : $scope.selectedDate,
        dateEnd : $scope.selectedDateEnd,
        user    : $('[name=usuario]').val(),
        filter  : ($scope.optionSelected == 1? 'TODAS LAS FACURAS CON ORDENES': ( $scope.optionSelected == 3? 'TODAS LAS FACTURAS POR ENTIDAD' : 'TODAS LAS FACTURAS POR PARTICULAR' ))
      }

      BillsService.generateBillDetailReport(
        data,
        function( success ){

        },
        function( error ){
          
        }
      );

    }

 }
 $scope.Informe = new Informe();


  // INFORME POR USUARIO
  







   // Final controlador
 }]);