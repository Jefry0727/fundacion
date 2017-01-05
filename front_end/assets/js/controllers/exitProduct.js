'use strict';

/* Controllers */

angular.module('app')
.controller('exitProductCtrl', [
  '$scope', 
  '$state',
  '$rootScope',
  '$localStorage',
  '$location',
  '$timeout',
  'ordersService',
  'usersService',
  'storageUbicationsService',
  'productsService',
  'StorageInputsService',
  'providersService',
  'urls',
  'marksService',
  'invimaCodesService', 
  'outputsService',
  'costCentersService',
  function(
    $scope, 
    $state, 
    $rootScope, 
    $localStorage, 
    $location, 
    $timeout, 
    ordersService, 
    usersService, 
    storageUbicationsService,
    productsService,
    StorageInputsService,
    providersService, 
    urls,
    marksService,
    invimaCodesService,
    outputsService,
    costCentersService
    ) {


         // $state.go('app.exitProduct');
         // 


         $('#timepicker').timepicker();

         $scope.selectedProduct = undefined;

         $scope.selectedStorage = undefined;

         $scope.selectedUser = undefined;

         $scope.inputProduct = {

          quant_input: '',

          remaining:'', 

          observations:'', 

          single_value:'', 

          value:'', 

        bill_code:'', // fecha expiracion

        state:'',

        inputDate:'',

        storage_ubications_id:'', //selectedStorage

        temperature:'',  // temperatura de ingreso

        product_details_id:'', 

      }

      $scope.productDetails = {

        expiration_date: '',

        lot: '',

        temp_store: '',

        order_code: '',

        products_id: '',

        marks_id: '',

        units_id: '',

        total:'',


      }

      $scope.outputs = {

        request_code: '',

        observation: '',

        outputs: $scope.remaining,

        users_id: $scope.selectedUser,

        state: 1,


      }


    	/**
    	 * [date description]
    	 * @type {[type]}
    	 */
      $scope.date = moment(new Date()).format('YYYY-MM-DD');

      /**
       * [showInformationInventory description]
       * @return {[type]} [description]
       */
       $scope.showInformationInventory = function(){

         $('.information-inventory').modal('show');

       }

       $scope.setSetSelectedUser = function(){

        // $scope.selectedUser = $scope.inputProduct.id;

      }

      /**
       * [hideInformationInventory description]
       * @return {[type]} [description]
       */
       $scope.hideInformationInventory = function(){

         $('.information-inventory').modal('hide');

       }


       $scope.getUsersInventory = function(){

         usersService.getUsersInventory(function(res){

          $scope.users = res.data;

     //     console.log($scope.users);

        }, function (error) {

        });
       }

       $scope.getUsersInventory();

       $scope.getAllCostCenters = function (){


        console.log('respueta centro costos');
        
        costCentersService.get(function(res){
          console.log(res);
          // $scope.costCenters =res.costCenters;



        },function(error){
        });
       }


$scope.getAllCostCenters();

       $scope.getAllStorage = function(){

         storageUbicationsService.getAllStorage(function(res){

          $scope.storages = res.storage;

          console.log($scope.storages);

        }, function (error) {

        });
       }

       $scope.getAllStorage();

      /**
       * Get all the products
       * @return {[type]} [description]
       */
       $scope.getAllProducts = function(){

        console.log($scope.selectedStorage);

        StorageInputsService.getAllStorageInputs({id:$scope.selectedStorage},function(res){

          console.log(res);

          if(res){

            $scope.products = res.query;

          }

        }, function(error){

          console.log(error);

        });

      }


      // funcion para actualizar los valores en stock
      $scope.updateInputQuote = function(items){

        console.log('items a actualizar cantidad');

        var tempUpdate = new Array();

        for (var j = items.length - 1; j >= 0; j--) {
        

         var tempExit =  items[j].salida;

         var itemToUpdate = items[j].all;

          console.log(itemToUpdate);

 
          for (var i = 0 ; i <= itemToUpdate.length - 1;  i++) {

            console.log('temporal exit '+tempExit);
            

            if(tempExit >= itemToUpdate[i].remaining && tempExit> 0 ){

              tempExit = tempExit - itemToUpdate[i].remaining;

              itemToUpdate[i].remaining = 0;
              itemToUpdate[i].equal = itemToUpdate[i].remaining;
              itemToUpdate[i].inputs_id = itemToUpdate[i].storage_inputs_id;

              tempUpdate.push(itemToUpdate[i]);


            }else{
              if(tempExit < itemToUpdate[i].remaining && tempExit >0){

                itemToUpdate[i].remaining = itemToUpdate[i].remaining - tempExit;
                itemToUpdate[i].equal = itemToUpdate[i].remaining;
                itemToUpdate[i].inputs_id = itemToUpdate[i].storage_inputs_id;

                tempExit = 0;

                tempUpdate.push(itemToUpdate[i]);

               

              }
              
          }
        }
      }


        // se envia para actualzar en bd
              StorageInputsService.updateInputQuote({items:tempUpdate},function(res){

              // $scope.storages = res.storage;

            }, function (error) {

            });


      console.log('temporal items a actualizar');
      console.log(tempUpdate);
        // StorageInputsService.updateInputQuote({items:items},function(res){

        //       // $scope.storages = res.storage;

        //     }, function (error) {

        //     });
      }

      $scope.totalProduct = 0;

      $scope.getInputProduct = function(){

            // console.log($scope.selectedProduct);

            // console.log($scope.selectedStorage);

            StorageInputsService.getStorageProduct({idProduct:$scope.selectedProduct,idStorage:$scope.selectedStorage},function(res){
              // DETALLES DEL PRODCUTO. 
              console.log('Detalles del producto');
              console.log(res);

              if(res.success){

                $scope.inputProduct.all = res.query;

                $scope.totalProduct = 0;

                for (var i = res.query.length - 1; i >= 0; i--) {
                  $scope.totalProduct += parseInt(res.query[i].remaining);
                }

                $scope.inputProduct.remaining = $scope.totalProduct;

                 // //se guarda una temporal para hacer un reset al valor de la cantidad disponible ORIGINAL
                $scope.tempUnit = $scope.totalProduct; //res.query[0].remaining;

                $scope.remaining = $scope.totalProduct;//res.query[0].remaining;

                // $scope.productDetails = res.inputs[0].product_detail;

                $scope.productDetails.products_id = res.query[0].product_details_id;

                $scope.productDetails.marks_id = res.query[0].mark;

                // // se cambia el formato de la hora
                $scope.productDetails.expiration_date = moment(res.query[0].expiration_date).format('YYYY-MM-DD');

                $scope.productDetails.units_id = res.query[0].units;

                $scope.productDetails.invima_codes_id = res.query[0].invima_codes;

                $scope.productCode = res.query[0].codigo_producto;

                $scope.productDetails.lot = res.query[0].lot;

                $scope.storageName = res.query[0].storage_name;           

                $scope.storage_id = res.query[0].storage_id;

                $scope.product_name = res.query[0].name_product;

                $scope.product_details_id = res.query[0].product_details_id;

                $scope.transfer_id = res.query[0].transfer_id;

                $scope.storage_inputs_id = res.query[0].storage_inputs_id;

                $scope.quoteExit = 0;


                console.log('Total Enbodega  '+ $scope.totalProduct + ' -  '+ $scope.tempUnit);


              } 

            }, function (error) {

            });
          }

      // Item List Arrays
      $scope.items = [];
      $scope.checked = [];


      // añade un item a lista de registros de salida
      $scope.addItem = function () {

          //editamos el regitro de stock en los inputs 
          // se crea un array con los items necesarios para mostrar en el listado
          $scope.items.push({

            all:             $scope.inputProduct.all,
            code:            $scope.productCode,
            name:            $scope.product_name,
            salida:          $scope.quoteExit,
            unidades:        $scope.productDetails.units_id,
            lote:            $scope.productDetails.lot,
            marca:           $scope.productDetails.marks_id,
            bodega:          $scope.storageName,
            userId:          $scope.selectedUser,
            observation:     $scope.outputs.observation,
            requestCode:     $scope.outputs.request_code,
            equal:           $scope.equal,
            storage_id:      $scope.storage_id,
            remaining:       $scope.inputProduct.remaining,
            product_details: $scope.product_details_id,
            transfer_id:     $scope.transfer_id,
            inputs_id:       $scope.storage_inputs_id   

          });

        //  Clear input fields after push
        //  $scope.inputProduct = "";
        // $scope.selectedStorage = "";
        $scope.quoteExit = "";
        $scope.selectedProduct = "";
        // $scope.productCode = "";
        // $scope.productDetails = "";

      };

      // se elimina un item de la lista del array items
      // index es la pocision del objeto en el array
      $scope.removeItem = function(index,item){

        var salidaItem = parseInt(item.salida) + parseInt(item.equal);

        console.log('entro');

        console.log(salidaItem);

        // $scope.updateInputQuote(item.id,salidaItem);

        $scope.items.splice(index, 1);

      }


      //se realiza el descuento de la cantidad disponible
      $scope.discountAvailable = function(){



        console.log('Cambio Salida');
        console.log('sacar '+$scope.quoteExit +' queda '+ $scope.inputProduct.remaining +'Total incial '+$scope.tempUnit );//descuento msanual + stock

        // tempUnit -> Cantidad ORIGINAL 
        $scope.inputProduct.remaining = $scope.tempUnit;

        $scope.quoteExit;


        $scope.equal = ''; // resultado remaining  menos quoteExtit 

        if($scope.quoteExit != undefined || $scope.quoteExit > 0){

            //si el valor en stock es mayor al de retiro se realiza el descuento de lo 
            //contrario se le asigna el valor del retiro el mismo valor del stock
            
            console.log(parseInt($scope.inputProduct.remaining) >= parseInt($scope.quoteExit));


            if(parseInt($scope.inputProduct.remaining) > parseInt($scope.quoteExit)){

             $scope.equal = $scope.inputProduct.remaining - $scope.quoteExit;

             $scope.inputProduct.remaining =  $scope.equal;

             console.log($scope.equal);

           }else{

            console.log($scope.tempUnit);

            $scope.quoteExit = $scope.tempUnit;

            $scope.equal  = 0;

            $scope.inputProduct.remaining =  $scope.equal;

          }
        }else{

          $scope.inputProduct.remaining = $scope.equal;
          console.log($scope.equal); 
          if($scope.totalProduct > 0){
            $scope.getInputProduct.remaining = $scope.totalProduct;
          }
        }

      }


        //funcion para añadir todos los outputs
        $scope.addOutputs = function(){

          for (var i = 0; i < $scope.items.length; i++) {

          //listado de productos
          //asignamos la observacion para todos los items en el array
          $scope.items[i].observation = $scope.outputs.observation;

        }
        console.log('items a descontar');
        console.log($scope.items);

        $scope.updateInputQuote($scope.items);


        outputsService.addOutputs({items:$scope.items},function(res){

          console.log(res);

          if(res){

           location.reload();

     }

   }, function(error){

    console.log(error);

  });

      } 


    }]);

     /**
     * validación popover
     */
        // angular.module('app')
        // .directive('validateAttachedFormElement', function() {
        //     return {
        //         restrict: 'A',
        //         require: '?ngModel',
        //         link: function(scope, elm, attr, ctrl) {
        //             if (!ctrl) {
        //                 return;
        //             }



        //             elm.on('blur', function() {
        //                 if (ctrl.$invalid && !ctrl.$pristine) {
        //                     $(elm).popover('show');
        //                     console.log(elm);
        //                 } else {
        //                     $(elm).popover('hide');
        //                 }
        //             });

        //             elm.closest('form').on('submit', function() {
        //                 if (ctrl.$invalid) {
        //                     $(elm).popover('show');
        //                 } else {
        //                     $(elm).popover('hide');
        //                 }
        //             });

        //         }
        //     };

        // });