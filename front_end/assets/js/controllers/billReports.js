'use strict';

/* Controllers */

angular.module('app')
.controller('billReportsCtrl', [

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

  BillDetailsService

  ) {

  $('[name=date-ini]').datepicker({
    format : 'yyyy-mm-dd'
  });

  $('[name=date-end]').datepicker({
    format : 'yyyy-mm-dd'
  });






  function Bill(){

    



    this.date_ini = moment( new Date() ).format('YYYY-MM-DD');
    this.date_end = moment( new Date() ).format('YYYY-MM-DD');
    this.listaSedes = [];
    this.center    = undefined;
    this.tabla = [];
    var _this = this;
    // this.totalDebit = 0;
    // this.totalCredit = 0;
    // this.totalDiscount = 0;
    // this.totalDonations = 0;
    // this.totalGeneral = 0; 




    ordersService.getCenters(
      function( success ){

        _this.listaSedes = success.center;

      },
      function( error ){

      }
      );

    this.getSalesByClient = function(){

      if(_this.date_ini != undefined && _this.date_end != undefined  && _this.center != undefined){

        ordersService.getSalesByClient(
        {
          dateIni : _this.date_ini,
          dateEnd : _this.date_end,
          center  : _this.center
        },

        function( res ){

          if( res.success ){
            _this.tabla = res.sales;

              //for( var index in res.sales ){
              //  _this.totalDebit += parseFloat(res.sales[ index ].debit);
              //  _this.totalCredit += parseFloat(res.sales[ index ].credit);
              //  _this.totalDiscount += parseFloat(res.sales[ index ].discount);
              //  _this.totalDonations += parseFloat(res.sales[ index ].donations);
             // }
             _this.total = 'TOTAL';
             _this.totalDebit = res.totales[0].debit;
             _this.totalCredit = res.totales[0].credit;
             _this.totalDiscount = res.totales[0].discount;
             _this.totalDonations = res.totales[0].donations;
             _this.totalGeneral = res.totales[0].total;
             
             

           }

         },

         function( error ){

         }
         );
      }

    }


  }




  $scope.Bill = new Bill();

      $scope.$watch('Bill.date_ini',function(){
  if($scope.Bill.date_ini > $scope.Bill.date_end){
      $scope.Bill.date_end = $scope.Bill.date_ini;
    
  }
});

   // Final controlador
 }]);

