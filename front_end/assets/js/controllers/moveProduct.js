'use strict';

/* Controllers */

angular.module('app')
    .controller('moveProductCtrl',
     ['$scope', 
      '$state',
      '$rootScope',
      '$localStorage',
      '$location',
      '$timeout', 
      'ordersService',
      'usersService',
      'storageUbicationsService',
      'StorageInputsService',
      'productsService',
      'transferService',
    function($scope, 
      $state, 
      $rootScope, 
      $localStorage, 
      $location, 
      $timeout, 
      ordersService,
      usersService,
      storageUbicationsService,
      StorageInputsService,
      productsService,
      transferService
      ) {

    	$('#timepicker').timepicker();


      $scope.selectedProduct = undefined; 

      $scope.storage = undefined; // Bodegas Disponibles

      $scope.selectedExitStorage = undefined; // seleccionar bodega de salida
      
      $scope.selectedInputStorage = undefined; // seleccionar bodega a la cual ingresa

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

        product_details_id:''

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
       * Obtiene usuarios del sistema que pueden solicitar un producto.
       * @return {[type]} [description]
       */
      $scope.getUsersInventory = function(){

           usersService.getUsersInventory(function(res){

              $scope.users = res.data;

              console.log($scope.users);

              }, function (error) {

          });
      }

      $scope.getUsersInventory();



      /**
       * Obtiene las bodegas de almacenamiento disponibles.
       * @return {[type]} [description]
       */
      $scope.getAvailableStorage = function(){

           storageUbicationsService.getAllStorage(function(res){

              $scope.storage = res.storage;

              $scope.exitStorages = $scope.storage;

              console.log($scope.exitStorages);

              }, function (error) {

          });
      }
      
      $scope.getAvailableStorage();


      /**
       * Obtener las bodegas disponibles diferente a la de salida.
       * @return {[type]} [description]
       */
      $scope.getAvailableToMove = function(){

        if($scope.selectedExitStorage){

          var lista = $scope.storage;
         
            var newList = new Array();

            for (var i = lista.length - 1; i >= 0; i--) {

              if(lista[i].id != $scope.selectedExitStorage){

               newList.push( lista[i]);    

              }

            }
           $scope.inputStorage = newList;

           // if($scope.inputStorage){
           //  // si existe al menos una bodega de destino consulta los productos
           //  $scope.getAllProducts();
           // }

        }
      }

        /**
       * Lista de productos activos.
       * @type {[type]}
       */
      $scope.Products = undefined;
      
      /**
       * Producto seleccionado
       * @type {[type]}
       */
      $scope.selectedProduct = undefined;



 // $scope.getInputProduct = function(){

 //            // console.log($scope.selectedProduct.id);

 //            // console.log($scope.selectedStorage);

 //           inventoryService.getInputProduct({idProduct:$scope.selectedProduct.id,idStorage:$scope.selectedStorage},function(res){

 //              console.log(res);

 //              $scope.inputProduct = res.inputs;

 //              $scope.inputProduct.units_id = res.inputs.unit.name;

 //              $scope.inputProduct.marks_id = res.inputs.mark.name;

 //              $scope.productCode = $scope.inputProduct.product.id;

 //              $scope.tempUnit = $scope.inputProduct.remaining;

 //              }, function (error) {

 //          });
 //      }






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

      /**
       * [hideInformationInventory description]
       * @return {[type]} [description]
       */
      $scope.hideInformationInventory = function(){

      	$('.information-inventory').modal('hide');

      }


//-------------------------------------------------- SEBAS CODIGO  DE SALIDA PRODUCTO --------------------------------------

 

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

    

      /**
       * [hideInformationInventory description]
       * @return {[type]} [description]
       */
      $scope.hideInformationInventory = function(){

        $('.information-inventory').modal('hide');

      }



      /**
       * Get all the products
       * @return {[type]} [description]
       */
      $scope.getAllProducts = function(){

        console.log('entro a productos');

        console.log($scope.selectedExitStorage);

        StorageInputsService.getAllStorageInputs({id:$scope.selectedExitStorage},function(res){

          if(res){

            $scope.products = res.query;

          }

        }, function(error){

            console.log(error);

        });

      }


      // // funcion para actualizar los valores en stock
      // // funcion para actualizar los valores en stock
      // $scope.updateInputQuote = function(items){

      //     console.log(items);

      //      StorageInputsService.updateInputQuote({items:items},function(res){

      //         // $scope.storages = res.storage;

      //         }, function (error) {

      //     });
      // }

      // funcion para actualizar los valores en stock
      $scope.updateInputQuote = function(items){

        console.log('items a actualizar cantidad');

        var tempUpdate = new Array();

        l(items);

        for (var j = items.length - 1; j >= 0; j--) {
        
          l(j);
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

      

      $scope.getInputProduct = function(){

            console.log($scope.selectedProduct);

            console.log($scope.selectedExitStorage);

           StorageInputsService.getStorageProduct({idProduct:$scope.selectedProduct.id,idStorage:$scope.selectedExitStorage},function(res){

              l("anterior");

              $scope.inputProduct = res.query[0];
              $scope.inputProduct.all = res.query;

              $scope.totalProduct = 0;

                for (var i = res.query.length - 1; i >= 0; i--) {
                  $scope.totalProduct += parseInt(res.query[i].remaining);
                }

                 $scope.inputProduct.remaining = $scope.totalProduct;

                 // //se guarda una temporal para hacer un reset al valor de la cantidad disponible ORIGINAL
                $scope.tempUnit = $scope.totalProduct; //res.query[0].remaining;

                $scope.remaining = $scope.totalProduct;//res.query[0].remaining;


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
            
              }, function (error) {

          });
      }

      // Item List Arrays
      $scope.items = [];
      $scope.checked = [];


      // añade un item a lista de registros de salida
      $scope.addItem = function () {

          //editamos el regitro de stock en los inputs

          // $scope.updateInputQuote($scope.inputProduct.id,$scope.inputProduct.remaining);

          // se crea un array con los items necesarios para mostrar en el listado
          l("--inputProducts--");
          $scope.inputProduct;

          $scope.items.push({

            code:               $scope.productCode,
            name:               $scope.product_name,
            salida:             $scope.quoteExit,
            unidades:           $scope.productDetails.units_id,
            lote:               $scope.productDetails.lot,
            marca:              $scope.productDetails.marks_id,
            bodega:             $scope.storageName,
            userId:             $scope.selectedUser,
            observation:        $scope.outputs.observation,
            requestCode:        $scope.outputs.request_code,
            equal:              $scope.equal,
            storage_id:         $scope.storage_id,
            remaining:          $scope.inputProduct.remaining,
            product_details:    $scope.product_details_id,
            storage_ubication:  $scope.selectedExitStorage,
            transfer_id:        '',
            inputs_id:          $scope.storage_inputs_id,
            all:                $scope.inputProduct.all

          });

          // Clear input fields after push
            //$scope.inputProduct = "";
        //  $scope.selectedExitStorage = "";
        //  $scope.selectedInputStorage = "";
          $scope.quoteExit = "";
          $scope.selectedProduct = "";
          $scope.inputProduct.all = undefined;
          $scope.productCode = "";
          //$scope.productDetails = "";

      };

      // se elimina un item de la lista del array items
      // index es la pocision del objeto en el array
      $scope.removeItem = function(index,item){

        var salidaItem = parseInt(item.salida) + parseInt(item.equal);

        console.log('entro');

        console.log(salidaItem);

        $scope.items.splice(index, 1);

      }


      /**
       * se realiza el descuento de la cantidad disponible
       * @author Deicy Rojas <deirojas.1@gmail.com>
       * @date     2016-09-13
       * @datetime 2016-09-13T08:48:50-0500
       * @return   {[type]}                 [description]
       */
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



      // //se realiza el descuento de la cantidad disponible
      // $scope.discountAvailable = function(){

      //   //cantidad descontada 
      //   $scope.inputProduct.remaining = $scope.tempUnit;

      //   $scope.quoteExit;

      //   // console.log($scope.inputProduct.quant_input);

      //   // console.log($scope.quoteExit);

      //   $scope.equal = '';

      //   //si el valor en stock es mayor al de retiro se realiza el descuento de lo contrario se le asigna el valor del retiro el mismo valor del stock
        
      //   if($scope.inputProduct.remaining >= $scope.quoteExit){

      //     $scope.equal = $scope.inputProduct.remaining - $scope.quoteExit;

      //     $scope.inputProduct.remaining =  $scope.equal;

      //     console.log($scope.equal);

      //   }else{

      //     $scope.quoteExit = $scope.tempUnit;

      //     $scope.equal = $scope.inputProduct.remaining - $scope.quoteExit;

      //     $scope.inputProduct.remaining =  $scope.equal;

      //   }

      // }


      //funcion para añadir todos los outputs
      $scope.addTransfers = function(){
        l("--items--");
        l($scope.items);
        for (var i = 0; i < $scope.items.length; i++) {

        //listado de productos
        //asignamos la observacion para todos los items en el array
        $scope.items[i].observation = $scope.outputs.observation;

      }
      console.log('--items a transferir--');
      console.log($scope.items);

      $scope.updateInputQuote($scope.items);

        transferService.addTransfer({items:$scope.items},function(res){

          console.log(res);

          if(res){

             location.reload();

          }

        }, function(error){

            console.log(error);

        });

      } 

		
    	
}]);