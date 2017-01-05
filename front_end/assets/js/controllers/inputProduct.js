'use strict';

/* Controllers */
angular.module('app')
.controller('inputProductCtrl', ['$scope', 
 '$state',
 '$rootScope',
 '$localStorage',
 '$location',
 '$timeout', 
 'ordersService',
 'productsService',
 'providersService', 
 'marksService',
 'invimaCodesService',
 'unitsService',
 'storageUbicationsService',
 'StorageInputsService',
 'farmaseuticFormService',
 'urls',
 function($scope, 
  $state, 
  $rootScope, 
  $localStorage, 
  $location, 
  $timeout, 
  ordersService,
  productsService,
  providersService,  
  marksService,
  invimaCodesService,
  unitsService,
  storageUbicationsService,
  StorageInputsService,
  farmaseuticFormService,
  urls) {

    /* PARA LA COMPATIBILIDAD CON CHROME */

    // object.watch
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

    /* ./PARA LA COMPATIBILIDAD CON CHROME */




      function Ingreso(){

        this.inputDate        = moment( new Date() ).format( "YYYY-MM-DD" );
        this.listaProductos   = [];
        this.page             = 0;
        this.product          = '';
        this.listaProveedores = new Array();
        this.provider         = new Object();
        this.storageUbication = new Object();
        this.listaBodegas     = new Array();
        this.listaMarcas      = new Array();
        this.unit             = new Object();
        this.listaUnidades    = new Array();
        this.mark             = new Object();
        this.tablaProductos   = new Array();
        this.invimaCode       = new Object();
        this.expiration_date  = moment( new Date() ).format( 'YYYY-MM-DD' );
        this.temp_store       = undefined;
        this.temperature      = undefined;
        this.subtotal_value   = 0;
        this.quant_input      = 0;
        this.single_value     = 0;
        this.iva              = 0;
        this.value            = 0;
        this.discount         = 0;
        this.order_code       = 0;
        this.observation      = '';
        this.product_details_id = '';
        this.bill_code        = '';
        var _this             = this;
        
      
        $('[name=fecha_vencimiento]').datepicker({
          format : 'yyyy-mm-dd'
        });

        $('[name=fecha_ingreso]').datepicker({
          format : 'yyyy-mm-dd'
        });
        
        

        // Obtiene la lista de los productos para el select
        this.obtenerProductos = function( page ){


          $.get(
            urls.BASE_API+"/products/getProducts.json",
            function(data, status){
              
              if( data.success ){
              
                _this.listaProductos = data.products;
              
              }

            }
          );

        }

        this.obtenerProductos();


        // Vigila el cambio de valor del productos
        this.watch('product', function( id, oldval, newval ){
          
          if( newval != undefined ){
            $('[name=cup]').val( newval.cup );
            $('[name=forma_farmaceutica]').val( newval.farmaseutic_form.name );
          }
          else{

            $('[name=cup]').val( '' );
            $('[name=forma_farmaceutica]').val( '' );

          }
          return newval;
        
         });


        // Obtiene la lista de los proveedores
        this.obtenerProveedores =  function(){
          l( 'obtenerProveedores();' );
          providersService.getProviders( function( success ){

            _this.listaProveedores = success.provider;

          }, 
          function( error ){

            l('obtenerProveedores()-Error');
            l( error );

          } );

        }
        this.obtenerProveedores();


        // Obtiene la lista de  bodegas
        this.obtenerBodegas = function(){

          storageUbicationsService.getAllStorage(

            function( success ){

              _this.listaBodegas = success.storage;

            },
            function( error ){
  
              l( 'obtenerBodegas()--error' );
              l( error );

            }

          );

        }

        this.obtenerBodegas();


        // Obtiene la lista de marcas
        this.obtenerMarcas = function(){

          marksService.getAllMarks(
            
            function( success ){

              _this.listaMarcas = success.mark;

            },
            function( error ){

              l( 'obtenerMarcas()-error' );
              l(error);

            }
          
          );

        }

        this.obtenerMarcas();

        // Obtiene la lista de las unidades de medida
        this.obtenerUnidades = function(){

          unitsService.getAllUnits(

            function( success ){

              _this.listaUnidades = success.units;

            },
            function( error ){

              l( 'obtenerUnidades()-error' );
              l( error );

            }

          );

        }
        this.obtenerUnidades();

        // Obtiene un codigo invima de un producto
        this.obtenerCodigosInvima = function(){

          invimaCodesService.getInvimaByProduc(
            {
              id : _this.product.id
            },
            function( success ){

              if( success.success ){
                _this.invimaCode = success.invimaCode[0];
              }
              else{

                _this.invimaCode = {};
                _this.invimaCode.id = false;

              }

            },
            function( error ){

              l( 'obtenerCodigosInvima()-error' );
              l( error );

            }
          );

        }


        // Obtiene la lista de los productos ya paginados
        var obtenerProductosPaginados = function( page ){
          
          $.get(
            urls.BASE_API+"/StorageInputs/productReasume/"+page+".json",
            function(data, status){

              if( data.success && data.List.length > 0 ){

                
                  _this.tablaProductos = data.List;

              }else{

                _this.page--;

              }

            }
          )

        }

        obtenerProductosPaginados();

        // Pagina los resultados 
        this.watch( 'page', function( id, oldval, newval ){
          
          if( newval >= 0 ){
            obtenerProductosPaginados( newval );
            return newval;
          }

        } );

        // Añade un codigo invima
        var adicionarInvimacode = function(){

          invimaCodesService.add(
            {
              code : _this.invimaCode.code
            },
            function( success ){

              _this.invimaCode = success.resultado;

            },
            function( error ){

            }

          );

        }

        var validarFormulario = function( name, longitud ){

          l( 'validarFormulario()' );

          var formulario =  document.forms[ name ] ;
          var valido = true;
          
          for( var index in formulario  ){


            if( ! isNaN( parseInt( index ) )  ){
      
              if( formulario[ index ].checkValidity() == false ){

                $( formulario[ index ] ).css( 'box-shadow', '0px 0px 3px red' );
                valido = false;

              }
              else{

                $( formulario[ index ] ).css( 'box-shadow', 'none' );

              }

            }
            else{

              break;
            }
    
          }



          return valido; 

        }

        // Inserta los datos en la tabla product_details
        var adicionarDetallesProducto = function(){
          l( 'adicionarDetallesProducto();' );
          var data = {
            expiration_date : _this.expiration_date,
            lot             : _this.lot,
            temperature     : _this.temperature,
            temp_store      : _this.temp_store,
            order_code      : _this.order_code,
            products_id      : _this.product.id,
            providers_id    : _this.provider.id,
            marks_id        : _this.mark,
            units_id        : _this.unit,
            invima_codes_id : _this.invimaCode.id,
            total           : $('[name=total]').val()
          };

          productsService.addProductDetails(
            data,
            function( success ){

              _this.product_details_id = success.productDetails.id;

            },
            function( error ){
              l('adicionarDetallesProducto()-error');
            }
          );


        }


        // Inserta en la tabla storage_inputs
        var adicionarIngresosBodega = function(){
          l( 'adicionarIngresosBodega()' );
          

          var data = {
            quant_input           : _this.quant_input,
            remaining             : _this.quant_input,
            observations          : _this.observation,
            single_value          : _this.single_value,
            value                 : _this.value,
            bill_code             : _this.bill_code,
            state                 : 1,
            inputDate             : _this.inputDate,
            iva                   : _this.iva,
            subtotal_value        : _this.subtotal_value,
            storage_ubications_id : _this.storageUbication,
            product_details_id    : _this.product.id,
            discount              : _this.discount   
          };

          StorageInputsService.addInputs(
            data,
            function( success ){
              $('#save-modal').modal('show');
              $('[name="person-name"]').html( $localStorage.person.first_name+" "+$localStorage.person.middle_name+" "+$localStorage.person.last_name+" "+$localStorage.person.last_name_two+" " );
              if( success.success ){

                $('[name="save-message""]').html( 'Se almacenó satisfactoriamente' );
                document.querySelector('[name="registro-producto"]').reset();

              }else{

                $('[name="save-message""]').html( 'No se almacenó la información' );

              }

              setTimeout(function(){

                $('#save-modal').modal('hide');

              },3500);

            },
            function( error ){
              l( 'adicionarIngresosBodega()-error' );
              l( error );

            }
          );

        }

        // Registra la entrada de un producto a una bodega
        this.registrar  = function(){
          
          if( validarFormulario('registro-producto') == true ){
            
            adicionarDetallesProducto();
            adicionarIngresosBodega();
            obtenerProductosPaginados( 0 );

          }
        }

        // Calcula el iva UNITARIO a partir del valor ingresado
        this.calculateIva = function(){
          l('IVA UNITARIO');
          if( _this.iva.indexOf('%') != -1  ){

            var newval = _this.iva.match(/\d/g);
            _this.iva = "0."+Math.abs( parseInt( newval.join("") ) );
            _this.iva = parseFloat( _this.iva );
            _this.iva = _this.single_value*_this.iva;

          }
          else{

            _this.iva = _this.iva / _this.quant_input;

          }

          _this.iva.toFixed( 4 );
          _this.value = (_this.iva * _this.quant_input) + ( _this.subtotal_value - _this.discount );
          

      }

    }
      
        
      $scope.Ingreso = new Ingreso();
  }
]);