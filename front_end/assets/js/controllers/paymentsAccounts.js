'use strict';

/* Controllers */

angular.module('app')
    .controller('paymentsAccountsCtrl', 
    	['$scope',
    	 '$state',
    	 '$rootScope',
    	 '$localStorage',
    	 '$location',
    	 '$timeout', 
    	 'paymentsAccountsService', 
         'ripsService',
         'urls',
    	 function($scope, 
    	 $state, 
    	 $rootScope, 
    	 $localStorage, 
    	 $location, 
    	 $timeout, 
    	 paymentsAccountsService,
         ripsService,
         urls
    	 ) {


             /*------------------- ESTE TROZO ES PARA LA COMPATIBILIDAD ENTRE NAVEGADORES ---------------------*/
             if (!Object.prototype.watch) {
                 Object.defineProperty(Object.prototype, "watch", {
                     enumerable: false
                     , configurable: true
                     , writable: false
                     , value: function (prop, handler) {
                         var
                             oldval = this[prop]
                             , newval = oldval
                             , getter = function () {
                                 return newval;
                             }
                             , setter = function (val) {
                                 oldval = newval;
                                 return newval = handler.call(this, prop, oldval, val);
                             }
                             ;

                         if (delete this[prop]) { // can't watch constants
                             Object.defineProperty(this, prop, {
                                 get: getter
                                 , set: setter
                                 , enumerable: true
                                 , configurable: true
                             });
                         }
                     }
                 });
             }

             // object.unwatch
             if (!Object.prototype.unwatch) {
                 Object.defineProperty(Object.prototype, "unwatch", {
                     enumerable: false
                     , configurable: true
                     , writable: false
                     , value: function (prop) {
                         var val = this[prop];
                         delete this[prop]; // remove accessors
                         this[prop] = val;
                     }
                 });
             }

             /*-------------------./ END COMPATIBILIDAD---------------------*/





             /* Carlos Felipe Aguirre Taborda 2016-11-28 09:59:46
                Clase de FacturaCliente, contiene todas las propiedades y metodos para trabajar 
                con ella
             */

             $scope.FacturaCuenta = function (){
                 var _this = this;


                 // Fecha de inicio facturación
                 $scope.FacturaCuenta.dateStart = moment(new Date()).format('YYYY-MM-DD');
       
                 // Fecha final de facturación
                 $scope.FacturaCuenta.dateEnd   = moment(new Date()).format('YYYY-MM-DD');

                 // La sede de donde se va a sacar la facturacion
                 $scope.FacturaCuenta.center = '';

                 // Cliente al cual pertenece la factura
                 $scope.FacturaCuenta.client = '';
                 
                 // El id del plan tarifacio del cliente
                 $scope.FacturaCuenta.rate   = '';

                 // filtro que se va a ocupar en la consulta
                 $scope.FacturaCuenta.filter;

                 // Offset de la consulta para la páginacion
                 $scope.FacturaCuenta.offset = 1;

                 // Facturas que se muestran en la cuenta de cobro
                 $scope.FacturaCuenta.facturas= [];

                 // Item actual
                 $scope.FacturaCuenta.currentItem;


                 // pone uno de los estilos de impresion
                 $("[href='assets/css/printPaymentAccounts.css']").prop('media','print');

                 // pone la fecha en la factura de cobro 
                 var date = new Date();
                 $('[name=date-account]').html( date.toISOString().substring( 0, 10 ) );



                 // Abre la modal para el borrado de la factura 
                 $scope.FacturaCuenta.setItem = function( index ){
                     
                     $scope.FacturaCuenta.currentItem = index;
                     $('.modal-delete-bill').modal('show');
                 }

                 // Borra la factura de la cuenta de cobro
                 $scope.FacturaCuenta.deleteBill = function(){
                    
                     $scope.FacturaCuenta.facturas.splice( $scope.FacturaCuenta.currentItem, 1 );
                     $('.modal-delete-bill').modal('hide');
                     $scope.FacturaCuenta.calculateTotal();
                 
                 }

                 // Obtener todas las facturas para hacer la cuenta de cobro
                 $scope.FacturaCuenta.generatePaymentAccount = function(){

                     var data = {
                             dateIni : $scope.FacturaCuenta.dateStart,
                             dateEnd : $scope.FacturaCuenta.dateEnd,
                             sede    : $scope.FacturaCuenta.center,
                             cliente : $scope.FacturaCuenta.client,
                             plan    : $scope.FacturaCuenta.rate

                      };

                      for( var index in data ){
                          if( data[ index ] == '' || data[ index ] == undefined ){
                              $("#error-messaje").show(500);
                              return;
                          }
                      }

                     ripsService.generatePaymentAccount(
                         data,
                         function( success ){
                             
                             if( success.resultado.length > 0 ){
                                 $scope.FacturaCuenta.facturas = success.resultado;
                                 $scope.FacturaCuenta.calculateTotal();
                             }

                         },
                         function( error ){

                         }
                     );
                 }



                 // Añade el plan tarifacio a la factura cuando se ha seleccionado
                $scope.$watch( 'rates', function( newVal, oldVal ){
                    
                    if( newVal != undefined ){
                        console.log( newVal );
                        $scope.FacturaCuenta.rate = newVal.rates_id;
                    
                    }
                    else{
                        $scope.FacturaCuenta.rate = undefined;
                    }
                    return newVal;
                } );

                 
                 // Obtiene todas las faturas
                 $scope.FacturaCuenta.getBills = function(){
                     $scope.resultado = [];

                     var data = {
                             dateIni : $scope.FacturaCuenta.dateStart,
                             dateEnd : $scope.FacturaCuenta.dateEnd,
                             sede    : $scope.FacturaCuenta.center,
                             cliente : $scope.FacturaCuenta.client,
                             plan    : $scope.FacturaCuenta.rate,
                             filter  : $scope.FacturaCuenta.filter,
                             offset  : $scope.FacturaCuenta.offset

                      };

                      var llaves = Object.keys( data );
                      

                      // cuando un campo esta vacío para la función y muestra un mensaje
                     for(var index in data){

                         if( data[ index ] == undefined ){
                             $("#error-messaje").show( 450 );
                             l( index );
                             return;
                         }

                     }

                     $("#error-messaje").hide( 450 );
                      

                     ripsService.setRipProperties(
                         data
                         ,
                         function( res ){
                             if( res.resultado.length >= 1 ){

                                 $scope.resultado = res.resultado;

                             }
                             else{
                                 $scope.resultado = [];
                                 if( $scope.FacturaCuenta.offset > 1 ){
                                     $scope.FacturaCuenta.offset--;
                                 }
                             }
                         },
                         function( res ){

                         }
                     );

                 }

                 // Establece la sede en el objeto cuando esta se ha seleccionado
                 $scope.$watch('selectCenter',function( newVal, oldVal ){

                     if( newVal != undefined ){
                          $scope.FacturaCuenta.center = newVal;
                     }
                     else{
                         $scope.FacturaCuenta.center = undefined;
                     }
                     return newVal;
                 
                });

                // establece el offset para la paginación
                $scope.FacturaCuenta.setPage = function( accion ){
                   
                    var paginaActual = $scope.FacturaCuenta.offset;

                    if( accion == '-'){
                    
                        if( $scope.FacturaCuenta.offset > 1 ){
                    
                            $scope.FacturaCuenta.offset--;
                            
                        }
                        
                    }
                    else{
                    
                        $scope.FacturaCuenta.offset++;
                    
                    }

                    if( paginaActual != $scope.FacturaCuenta.offset ){

                        $scope.FacturaCuenta.getBills();

                    }
                }


                // Calcula el total en la cuenta de cobro
                $scope.FacturaCuenta.calculateTotal = function(){

                    l( $scope.FacturaCuenta.facturas );
                    var total = 0;
                    var totalService=0;
                    var totalCopayment =0;
                    
                    for(var index in $scope.FacturaCuenta.facturas ){
                    
                       total += $scope.FacturaCuenta.facturas[ index ]._matchingData.Payments.credit; 
                       totalService += $scope.FacturaCuenta.facturas[ index ]._matchingData.Payments.credit + $scope.FacturaCuenta.facturas[ index ]._matchingData.Payments.copayment;
                       totalCopayment += $scope.FacturaCuenta.facturas[ index ]._matchingData.Payments.copayment
                    }
                    $('[name=total-account]')[0].innerHTML = "$"+total;
                    $('[name=total-account]')[1].innerHTML = "$"+total;
                    $('[name=total-values]').html( "$"+totalService );
                    $('[name=total-copayment]').html( "$"+totalCopayment );
    
                }

                // guarda y genera la factura 
                $scope.FacturaCuenta.printAndSaveAccount = function(){
                    
                    for( var index in $scope.FacturaCuenta.facturas ){

                        $scope.FacturaCuenta.facturas[index].clients_id = $scope.FacturaCuenta.client;
                        $scope.FacturaCuenta.facturas[index].rates_id   = $scope.FacturaCuenta.rate;
                        $scope.FacturaCuenta.facturas[index].date_ini   = $scope.FacturaCuenta.dateStart;
                        $scope.FacturaCuenta.facturas[index].date_end   = $scope.FacturaCuenta.dateStart;
                        $scope.FacturaCuenta.facturas[index].users_id   = $localStorage.user.id;
                        $scope.FacturaCuenta.facturas[index].bills_id   = $scope.FacturaCuenta.facturas[index].id;
                        delete $scope.FacturaCuenta.facturas[index].id;

                    }
                    
                    ripsService.saveAccount(
                            
                        $scope.FacturaCuenta.facturas
                        
                        ,
                        function( res ){
                            if( res.success ){
                                
                                $("[name='payment-account-consec']").html("NRO. "+ res.resultado.consec );
                                $("[name='people-name']").html( $localStorage.person.first_name+' '+$localStorage.person.middle_name+' '+$localStorage.person.last_name+' '+$localStorage.person.last_name_two );
                                
                                var printContents = document.getElementById('print-area').innerHTML;
                                var originalContents = document.body.innerHTML;
                            
                                document.body.innerHTML = printContents;
                            
                                window.print();
                            
                                document.body.innerHTML = originalContents;

                                window.location.reload(); 
                        
                            }
                        },
                        function( error ){
                            l(error);
                        }
                    );
                }



             };
             $scope.FacturaCuenta.prototype.constructor.call(this);
             /*-------------------FINAL DEL OBJETO FacturaCuenta-----------------------*/ 


             /* Carlos Felipe Aguirre Taborda 2016-11-28 09:59:20
                Clase de Cliente, contiene todas las propiedades y metodos para trabajar 
                con el
             */
             $scope.Cliente = function(){
                 // Inicializa todas las propiedades del el objeto cliente
                 $scope.Cliente.id                 = '';
                 $scope.Cliente.nit                = '';
                 $scope.Cliente.social_reazon      = '';
                 $scope.Cliente.ars_code           = '';
                 $scope.Cliente.address            = '';
                 $scope.Cliente.responsible        = '';
                 $scope.Cliente.email              = '';
                 $scope.Cliente.phone              = '';
                 $scope.Cliente.phone2             = '';
                 $scope.Cliente.state              = '';
                 $scope.Cliente.municipalities_id  = '';
                 $scope.Cliente.ciiu               = '';
                 var _this                         = this;

                 // Obtiene todos los cliesntes
                 this.getClients = function () {
                     paymentsAccountsService.clients(function (res) {

                         if (res.success == true) {

                             $scope.clients = res.clients;


                         } else {

                             $scope.clientsModel.id = undefined;
                         }

                     });
                 }

                 // Establece el codigo cuando ya se halla seleccionado
                 // el cliente
                 $scope.$watch('client', function (newVal, oldval) {

                     // si ya se seleccionó un cliente trae el codigo ars y las tarifas
                     if(newVal != undefined ){
                         
                         $scope.Cliente.ars_code = newVal.ars_code;
                         $scope.Cliente.id       = newVal.id;

                         $scope.FacturaCuenta.client = newVal.id;
                         $scope.Cliente.nit      = newVal.nit;
                         _this.getAllRatesClient();

                     }
                     else{
                        $scope.FacturaCuenta.client = undefined;
                        $scope.Cliente.ars_code = undefined;
                     }
                     
                     return newVal;
                 });

                 // Obtiene las tarifas cuando se halla seleccionado un cliente
                 this.getAllRatesClient = function () {
                     if($scope.client != undefined){

                         $scope.Cliente.id = $scope.client.id;

                         paymentsAccountsService.getRatesClients({ id: $scope.Cliente.id }, function (res) {

                             console.log(res);

                             if (res.success == true) {

                                 $scope.ratesClients = res.ratesClient;

                             } else if ($scope.ratesClients = undefined) {

                                 $scope.ratesC.id = updateRatesC.id;

                             }

                         });
                     }else{
                         $scope.ratesC = new Object();
                         $scope.ratesC.id = undefined;
                     }
                 }
                 
             }


             /* 
                Carlos Felipe Aguirre Taborda 2016-11-28 09:57:40
                Clase de Sede, contiene todas las propiedades y metodos para trabajar 
                con ella
             */
             var Center = function(){
                 
                 // Obtiene las sedes que se encuentran disponibles
                 Center.getCenters = function () {
                     paymentsAccountsService.getCenters(function (res) {

                         console.log(res);

                         if (res.success == true) {

                             $scope.AllCenters = res.centers;


                         }

                     });

                 }
             }
             Center.prototype.constructor.call(this);
             Center.getCenters();            

             var Client = new $scope.Cliente();
             Client.getClients();    
             $('#header-payment-account').prop( 'src', urls.BASE + '/assets/img/logo_londono.png' );
             $('#footer-payment-account').prop( 'src', urls.BASE + '/assets/img/payment_account_footer.png' );



}]);
