'use strict';

/* Controllers */

angular.module('app')
.controller('manualBillsCtrl', 
 ['$scope', 
 '$state',
 '$rootScope',
 '$localStorage',
 '$location',
 '$timeout', 
 'urls',
 'medicalOfficesService',
 'attentionPatientService',
 'peopleService',
 'BillsService',
 'costCentersService',
 'ordersService',
 'clientsService',
 'ratesClientsService',
 'storageUbicationsService',

 function($scope, 
  $state, 
  $rootScope, 
  $localStorage, 
  $location, 
  $timeout, 
  urls,
  medicalOfficesService,
  attentionPatientService,
  peopleService,
  BillsService,
  costCentersService,
  ordersService,
  clientsService,
  ratesClientsService,
  storageUbicationsService
  ) {



  $scope.getUserSede = function(){

  }

  $scope.newBill = {
    number : 'PREVIEW - 001',
    id : ''
  };
  $scope.valid = false;
  $scope.hasBill = false;

  $scope.gender = [
  {name:'Masculino', code:0},
  {name:'Femenino',  code:1}
  ];


  $scope.bill = {
   bill_resolutions_id:'', 
   people_id:'', 
   observations:'', 
   subtotal:0, 
   discount:0,
   total:0, 
   donation:0, 
   total_cancel:0,  
   users_id:'', 
   bill_types_id:2,
   form_payments_id:'',
   credit_card_number:'',
   copayment: 0,
   order_consec: '',
   calculated_age: '',
   validator: '',
   calculated_age : '0',
   order_consec : '0',

 };

 $scope.billProducts = {
  cup:'',
  name:'',
  quantity:0,
  total:0,
  manual_bills_id:0,
  products_id:undefined

}

$scope.people = {
  identification:'',
  first_name:'',

};

$scope.selectBodega={
  id:''
};

$scope.bodegas;



$scope.billsItems = new Array(); 

//-------------------------- SELECCIONA EL TIO DE FACTURACION 

     /**
      * [getBillTypes description]
      * @return {[type]} [description]
      */
      $scope.getBillTypes = function(){

        attentionPatientService.getBilltypes(function(res){

          $scope.billTypes = res.billTypes;

          $scope.bill.bill_types_id = 2;

        });

      }


      $scope.getBillTypes();


      $scope.formTypes  = undefined;

      /** [getFormPay description] */
      $scope.getFormPay = function(){

        attentionPatientService.getFormPayments(function(res){

          $scope.formTypes = res.formPayment;

          $scope.bill.form_payments_id = 1;

        });

      }

      $scope.changePaymentMethod = function(){

      }


      $scope.getFormPay();

      $scope.costCenter = undefined;
      $scope.selectedCostCenter = undefined;

 /**
        * Function to get all  Centros de costos  
        */
        $scope.getCostCenters = function(){

          console.log("Centros de costos ");

          costCentersService.get(function(res){

            console.log(res.costCenter);

            $scope.costCenter = res.costCenter;


          }, function (error) {
            console.log(error);

          });

        }
        $scope.getCostCenters();



        $scope.centers = undefined;
        $scope.selectedCenter = undefined;
         /**
        * Function to get all sedes  
        */
        $scope.getCenters = function(){

          ordersService.getCenters(function(res){


            $scope.centers = res.center;

            $scope.selectedCenter  = $scope.centers[0];

          }, function (error) {

          });

        }


        // load all the Centers
        $scope.getCenters();


        /** Obtiene listado de tarifas segun el cliente seleccionado  */
        $scope.getRateByClient =function(){


          var clientId = $scope.selectedClient.id;


          if(clientId != undefined){

            console.log(clientId);
            
                // $scope.order.clients_id.id;
                
                ratesClientsService.getByClient({id:clientId}, function(res){

                  $scope.rates =  new Array();

                  for (var i = 0; i < res.rates.length; i++) {

                    var option = {id:res.rates[i].id,rate_id:res.rates[i].rate.id, rate_name:res.rates[i].rate.name};

                    $scope.rates.push(option);

                  }

                  console.log($scope.rates);

                }, function (error) {
                  console.log(error);
                });
              }


            }


            /** Obtiene todos lo clientes HABILITADOS */

            $scope.getClients = function(){

              clientsService.getEnable(function(res){

                $scope.clients = res.clients;

                // Pone por defecto el ciente PARTICULARES
                l('--Clientes--');
                $scope.selectedClient = new Object();
                for( var indice in $scope.clients ){
            

                  if($scope.clients[ indice ].name.toLowerCase().indexOf('particul') != -1){

                    $scope.selectedClient = $scope.clients[ indice ];
                    l( $scope.selectedClient );

                  }

                }               
                $scope.getRateByClient();


              }, function (error) {
                console.log(error);
              });
            }

            $scope.getClients();

//------------------------------------------------------------------------------------------------------------------


// Cambia el valor del select de clientes
// Carlos Felipe Aguirre Taborda 
// 2016-10-19

$scope.changeSelectedClient = function() {

  l("--cliente--");
  l($scope.selectedClient);
  //Hace que se actualice el campo de tarifas dependiendo del cliente
  $scope.getRateByClient();

}





$scope.subTotal = 0;
        /**
         * Funcion para calcular el subtotal
         * @return {[type]} [description]
         */
         $scope.calculateSubtotal = function(){
          $scope.subTotal = 0;
          for (var i = $scope.services.length - 1; i >= 0; i--) {
            if($scope.services[i].total != undefined){ 

              $scope.subTotal += $scope.services[i].total;
              console.log($scope.subTotal);
            }
          }
          $scope.cancelTotal = $scope.subTotal;
        }

        $scope.selectedClientObj = undefined;


    /**
     * Valor a cancelar
     * @type {Number}
     */
     $scope.cancelValue = 0;
     /**
      * Valor del descuento
      * @type {Number}
      */
      $scope.tempDiscount = 0;
     /**
      * Valor de la donacion.
      * @type {Number}
      */
      $scope.tempDonation = 0;

     /**
      * Calcular descuento a realizar.
      * @param  {[type]} percent [description]
      * @return {[type]}         [description]
      */
      $scope.calculateDiscountCancelValue = function(percent){

        if(percent != undefined){

          $scope.bill.discount = (($scope.cancelTotal /100) * percent);

          $scope.tempDiscount = $scope.bill.discount;

        }else{   
         $scope.bill.discount = $scope.tempDiscount;
       }

      //  $scope.cancelValue = $scope.cancelTotal - $scope.bill.discount - $scope.bill.donation; 
      $scope.calculateRemainingBalance();

    }


      /**
      * Calcular Donacion a realizar.
      * @param  {[type]} percent [description]
      * @return {[type]}         [description]
      */
      $scope.calculateDonationCancelValue = function(percent){

        if(percent != undefined){

          $scope.bill.donation = (($scope.cancelTotal /100) * percent);

          $scope.tempDonation  = $scope.bill.donation;


        }else{   
         $scope.bill.donation = $scope.tempDonation;
       }

        // $scope.cancelValue = $scope.cancelTotal - $scope.bill.discount - $scope.bill.donation; 
        
        $scope.calculateRemainingBalance();

      }
     /**
      * Validar  Descuento
      * @return {[type]} [description]
      */
      $scope.doCalnculateDiscountCancel = function(){

        if($scope.tempDiscount != undefined){

          var text = $scope.tempDiscount + '';


          if(text.indexOf('%') != -1)
          {

            var numb = text.match(/\d/g);

            numb = numb.join("");

            numb = parseInt(numb);

            $scope.calculateDiscountCancelValue(numb);

          }else{

            $scope.calculateDiscountCancelValue();
          }

        }else{

          $scope.calculateDiscountCancelValue(0);

        }

      }
    /**
     * Validar Donacion
     * @return {[type]} [description]
     */
     $scope.doCalnculateDonationCancel = function(){

      if($scope.tempDonation != undefined){

        var text = $scope.tempDonation + '';


        if(text.indexOf('%') != -1)
        {

          var numb = text.match(/\d/g);

          numb = numb.join("");

          numb = parseInt(numb);

          $scope.calculateDonationCancelValue(numb);

        }else{

          $scope.calculateDonationCancelValue();
        }

      }else{

        $scope.calculateDonationCancelValue(0);

      }

    }


    $scope.calculateTotalCopay = function(){

      console.log("asdasd");


      $scope.bill.debit =  $scope.cancelValue;

      $scope.bill.total =  0;


      $scope.calculateRemainingBalance();
    }

     /**
      * Calcular Saldos con descuento
      * @return {[type]} [description]
      */
      $scope.calculateRemainingBalance = function(){
        //$scope.bill.total = $scope.subtotal;


        $scope.cancelValue = $scope.cancelTotal - $scope.bill.discount - $scope.bill.donation; 

        console.log($scope.cancelValue+' tipo : '+$scope.bill.bill_types_id);


        $scope.bill.debit = $scope.cancelValue;

        $scope.bill.credit = $scope.subTotal - $scope.bill.discount - $scope.bill.donation - $scope.cancelValue;

        $scope.bill.total_cancel =  parseInt($scope.cancelValue);        

      } 


    /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('tempDiscount', function() { 

        $scope.doCalnculateDiscountCancel();

      });

      /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('tempDonation', function() { 

        $scope.doCalnculateDonationCancel();

      });


    /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('cancelTotal', function() { 


        $scope.doCalnculateDiscountCancel();

        $scope.doCalnculateDonationCancel();

        $scope.calculateTotalCopay(); 
        
      });

     /**
      * deteccion de cambio total a cancelar para asignarlo al total de copago
      */
      $scope.$watch('cancelValue', function() { 

        console.log('Entro y modifico - FACTURACION - '+   $scope.bill.debit);
        $scope.bill.debit =  $scope.cancelValue;
        if($scope.cancelValue >= 0){ $scope.valid = "true";}

      });

//------------------------------------------------------------------ PREVISUALIZACION DE FACTURA -------------------------------------------------

function toObject(arr) {
  var rv = {};
  for (var i = 0; i < arr.length; ++i)
    rv[i] = arr[i];
  return rv;
}

     /**
      * Funcion para previsualizar factura
      */
      $scope.prevBill = function(isPrev){    


        console.log('TODOS LOS ITEMS A FACTURACION');
        console.log($scope.services);

        var itemBills = new Array();
        var count = 1;
        for (var i = $scope.services.length - 1; i >= 0; i--) {

          var detail = new Array();

                // adicionar Studio a items de facturacion..
                detail['id'] =  $scope.services[i].product_id;    
                detail['index'] = count;
                detail['ref'] = $scope.services[i].product_cup;
                detail['desc'] = $scope.services[i].product_name;
                detail['cant'] = $scope.services[i].quantity;
                detail['valor'] = $scope.services[i].product_value;
                detail['cost'] = $scope.services[i].total;
                detail['type'] = false; // studio
                detail['service'] ='';
                detail['supplies'] = $scope.services[i].product_id;
                detail['isService'] = true;

                detail = Object.assign({}, detail);
                
                itemBills.push(detail);
                count ++;
              }


              $scope.bill.center = $scope.selectedCenter.id;


              $scope.plan = {
                name: $scope.selectedRates.name
              };
              $scope.bill.people_id = $scope.people.id;

              $scope.bill.centers_id = $scope.selectedCenter;
        

              // Poner la sede en la factura
              
              for( var i =0 ; i < $scope.centers.length; i++){
                
                if( $scope.centers[ i ].id == $scope.selectedCenter ){
                
                  $scope.bill.center = $scope.centers[ i ];
                
                }
              
              }


        /**
         * Datos de la factura
         * @type Object
         */
         var prevBill = {

          patient:        $scope.people,

          order:          $scope.bill,

          services:       toObject(itemBills),

          payment:        $scope.bill,

          clients:        $scope.selectedClient,

          costCenter:     $scope.selectedCostCenter,

          plan:           $scope.selectedRates,         

          billNumber:     $scope.newBill.number,

          billId:         $scope.newBill.id,

          isPrev:         isPrev,

          affiliation_type: $scope.people.affiliation_type,

          regimes         : $scope.people.regimes

        }
        
        if( prevBill.isPrev === false ){

          prevBill.first = true;

        }


        
        




        console.log(prevBill);

        $scope.bill.donationValue = $scope.bill.donation; 

        $scope.bill.discountValue = $scope.bill.discount; 

        $scope.bill.subtotal = $scope.subTotal;

        console.log($scope.selectGender);

        prevBill.patient.gender = ( ( typeof( $scope.selectGender ) == "undefined" )? "" : $scope.selectGender.name );

        console.log(prevBill);

        // console.log($scope.factServices[0]);

        BillsService.generateBill(prevBill, function(res){

        //    console.log(res);

        window.location.href = urls.BASE_API + '/Bills/downloadPrev/'+people.identification+"/"+res.message;

      });


        // window.location.href = urls.BASE_API +'/Bills/prevBill/'+encodeURIComponent(JSON.stringify(prevBill));

      }


     // $scope.prevBill();



     $scope.saveBillProducts  = function(id){

      $scope.services; 

      BillsService.saveManualBillProduct({id:id,services:$scope.services},function(res){
        if(res.success){
          $scope.valid = false;
        }


      },function(error){});



    }
     /**
      * Guardado de la factura
      * @return {[type]} [description]
      */
      $scope.saveBill = function(){

        // id, 
        // bill_resolutions_id, people_id, observations, subtotal, discount, total, donation, total_cancel, users_id, bill_number, bill_types_id, form_payments_id, credit_card_number

        $scope.bill.people_id = $scope.people.id;

        $scope.bill.users_id = $localStorage.user.id;

        $scope.bill.center = $scope.selectedCenter;

        console.log($scope.bill);

        BillsService.saveManualBill($scope.bill,function(res){
          if(res.success){

           $scope.newBill.number = res.newManualBill.bill_number;        
           $scope.newBill.id     = res.newManualBill.bills_id;

           $scope.saveBillProducts(res.newManualBill.id);

           $scope.prevBill(false);
           $scope.hasBill  = true;
           // console.log(res);
         }
         else{
          $scope.hasBill = false;
         }
       });


      }


//------------------------------- BUSQUEDA DE PRODUCTOS ----------------------


        /**
        * Funcionalidad de busqueda del diagnostico permanente angudiagnostic
        */

        $scope.foundService = undefined;

         /**
          * Arreglo con todos los diagnosticos permanentes
          * @type {Array}
          */
          $scope.services = new Array();

         /**
          * Dirección donde se buscaran los productos
          * @type {[type]}
          */

          $scope.urlSearchServices = urls.BASE_API + '/Products/searchProducts/';

          $scope.changeSearchUrl = function(){
            $scope.urlSearchServices = urls.BASE_API + '/Products/searchProducts/';
            $scope.urlSearchServices += $scope.selectBodega.id+"/";
          }

          console.log($scope.foundService);


         /**
          * detection se seleccion de diagnosticos permanentes por enter o click 
          */
          $scope.$watch('foundService', function() { 


            /**
             * Si el modelo no esta definido
             */
             if($scope.foundService != undefined){

                /**
                 * agregamos el diagnostico permanente al arreglo de servicios
                 */
                 $scope.services.push($scope.foundService.originalObject);

                /**
                 * Se elimina el valor temporal
                 * @type {[type]}
                 */
                 $scope.foundService = undefined;


                 $scope.showDiagnostic = $scope.services[0];

                // se guarda el valor de la cadena en el objeto paciente del campo de diagnostico permanente para guardar en la bd
                $scope.services;

                //  $scope.order.cie_ten_codes_id = $scope.showDiagnostic.id;
                /**
                 * limpiamos el valor del objeto
                 * @type {[type]}
                 */
                 $scope.$broadcast('angucomplete-alt:clearInput','searchProd');
                 console.log($scope.billsItems);
                 $scope.searchStr = undefined;
               }

             }, true);






//-------------- START OPTION SELECT ---------------------------------------------------------------------------------------


    /**
     * Calcula el total del producto
     */
    $scope.calulateTotal = function(item){ 
      console.log(item);
      
      if( isNaN( parseInt(item.product_value) ) ){

        item.product_value = 0;

      }
      
      item.total = item.quantity *  parseInt(item.product_value);
      $scope.calculateSubtotal();
    }
   /**
    * Elimina un producto o item
    */
    $scope.dropService = function(item){

      console.log(item);
      //  delete $scope.services[item];
      $scope.services.splice(item, 1);
      $scope.calculateSubtotal();
    }

//----------------------- PERSONA A LA CUAL SE LE FACTURA ----------------------------------------------------------


$scope.searchPeople = function(){

  console.log($scope.people);

  if($scope.people.identification != ""   &&  $scope.people.identification != undefined){

    peopleService.searchPeople({id:$scope.people.identification, type: $scope.bill.bill_types_id},function(res){

      console.log(res);
      if(res){
        

        // en caso de  que sea un particular
        if( res.success && !res.people.entity){

          $scope.exist = true;
          $scope.people = res.people;
          $scope.name = $scope.people.first_name + ' ' + 
          $scope.people.middle_name + ' '+ 
          $scope.people.last_name + ' ' +
          $scope.people.last_name_two;

          $scope.people.regimes          = res.people.patients[0].regimes_id || res.people.regimes_id;
          $scope.people.affiliation_type = res.people.patients[0].affiliation_type || res.people.affiliation_type;

          for (var i = $scope.gender.length - 1; i >= 0; i--) {
            if($scope.gender[i].code == $scope.people.gender)
              $scope.selectGender = $scope.gender[i];
          }
        }
        // en caso de que sea un tercero
        else{
          $scope.people.first_name    = res.people.first_name;
          $scope.people.middle_name   = res.people.middle_name;
          $scope.people.last_name     = res.people.last_name;
          $scope.people.last_name_two = res.people.last_name_two;


          $("[ng-model=selectGender]").prop( 'disabled', true );
          $scope.name = res.people.name;
          $scope.people.address          = res.people.address;
          $scope.people.phone            = res.people.phone;
          $scope.people.id               = res.people.nit;
          $scope.people.affiliation_type = res.people.affiliation_type;
          $scope.people.regimes       = res.people.regimes_id; 


        
        }

      }else{
        $scope.exist=  false;
      }

    },function(error){});        
  }
}




// Carlos Felipe Aguirre T
// 2016-10-19
// Obtiene las bodegas segun la sede
$scope.getStorageUbications = function(){
  l("--bodegas--");
  storageUbicationsService.getStoragesByCenter(
    {
      id : $scope.selectedCenter
    },
    function(res){
      l('--getAllStorage--');
      l(res);
      
      if(res.success){

        $scope.bodegas =res.bodegas;
      
      } 
    
    },
    function(res){
      l("--getAllStorage--error");
      l(res);
    }
  );
}


// OBTENER LA TARIFA DE PARTICULARES
// Carlos Felipe Aguirre Taborda 
// 2016-11-17 11:55:56

ratesClientsService.getSelectedRate(
  { id: 18 },
  function( res ){
    l('--Parteiculares--');
    
    if( res.success){
      $scope.selectedRates = res.rate;
    }
  },
  function( res ){

  }
);

}]);