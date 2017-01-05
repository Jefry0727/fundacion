'use strict';

/* Controllers */

angular.module('app')
.controller('agendamientoCitaCtrl', [

 '$scope',

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout',

 'medicalOfficesService',

 'studiesService',

 'patientsService',

 'peopleService',

 'usersService',

 'urls',

 'departmentsService',

 'municipalitiesService',

 'ordersService',

 'clientsService',

 'ratesClientsService',

 'externalSpecialistsService',

 '$compile',

 'appointmentService',

 'uiCalendarConfig',

 'WizardHandler',

 'attentionPatientService',

 'BillsService',

 'specializationsService',

 'costCentersService',

 'OrderAppointmentsService',

 'suppliesService',

 'signatureService',

 'fileUpload',

 'ripsService',

 'BillDetailsService',

 'RateServicesService',

 'OrdersAuthorizationService',

 'attentionsService',

 'genderService',

 function(

  $scope, 

  $state, 

  $rootScope, 

  $localStorage, 

  $location, 

  $timeout, 

  medicalOfficesService, 

  studiesService,

  patientsService,

  peopleService,

  usersService,

  urls,

  departmentsService,

  municipalitiesService,

  ordersService,

  clientsService,

  ratesClientsService,

  externalSpecialistsService,

  $compile,

  appointmentService,

  uiCalendarConfig,

  WizardHandler,

  attentionPatientService,

  BillsService,

  specializationsService,

  costCentersService,

  OrderAppointmentsService,

  suppliesService,

  signatureService,

  fileUpload, 

  ripsService,

  BillDetailsService,

  RateServicesService,

  OrdersAuthorizationService,

  attentionsService,

  genderService

  ) {



  $scope.cancelValue = 234;
  $scope.validatePorcentage = 0;

  $scope.stateGenerateBill = false;

  $scope.payment = {};

  $scope.payment.credit = 0;

  $scope.factServices = {};

        /**
         * Nueva cita
         * @type {Object}
         */
         $scope.appointment = {

            /**
             * identificador de consultorio
             * @type {Number}
             */
             medical_offices_id      : undefined,

            /**
             * identificador de 
             * @type {Number}
             */
             order_details_id        : 12,


            /**
             * [studies_id description]
             * @type {Number}
             */
             studies_id              : 1,

            /**
             * Valor del estudio
             * @type {Number}
             */
             studies_value           : 10,

             /**
              * Si la cita es pedida presencial o por telefono
              * 1 presencial
              * 2 telefono
              * @type {Number}
              */
              type                    : 1,

             /**
              * Observaciones de la cita
              * @type {String}
              */
              observations            : '',

              // día en que se solicitó la cita
              expected_date           : true


            };

            $("[name=expected_date]").datepicker({format : 'yyyy-mm-dd'});

        /**
         * Fechas de la cita
         * @type {Object}
         */
         $scope.appointmentDates = {

            /**
             * Identificador de la cita
             * @type {Number}
             */
             appointments_id         :1,

            /**
             * estado de la cita, inicialmente 1: Reservada
             * @type {Number}
             */
             appointment_states_id   :1,

            /**
             * Fecha y hora de inicio de la cita
             * @type {String}
             */
             date_time_ini           :'2016-10-10 10:10:10',

            /**
             * Fecha y hora de finalizacion de la cita
             * @type {String}
             */
             date_time_end           :'2016-10-10 10:10:20',
           }







     /**
      * [gender description]
      * @type {Object}
      */
      $scope.gender = {
        id:"",
        gender:"",
        initials:""    
      };

      $scope.selectGender = undefined;


      $scope.newBillNumber = 'PREVIW-XXX';

      $scope.userData = $localStorage.person;

      $scope.edad;


      $scope.appointmentIdToSign = undefined;

      $scope.serviceToSign = undefined;

      $scope.services = new Array();

      $scope.canDoBill = true;

      $scope.numberAddedAppoinments = 0;



      function setCandoBill(){


        $("#cost-center").attr("disabled", "true");


        $scope.canDoBill = true;                        

        if($scope.order.id == 0 ){

                    /**
                     * desactivar facturar
                     */
                     $scope.canDoBill = true;                            
                     
                   }else{

                    for (var i = 0; i < $scope.services.length; i++) {

                      if($scope.services[i].asigned_state == undefined){

                        $scope.canDoBill = true;  

                        if( $scope.order.id ){

                          $scope.canDoBill = false;

                        }      

                        break;

                      }else{

                        /**
                         * Activar factura
                         * @type {Boolean}
                         */
                         $scope.canDoBill = false;

                         
                       }
                     } 
                   }


                   if($scope.order.id != undefined && $scope.order.id != 0){

                    ordersService.getNumberAppointmentOrder({orderId:$scope.order.id}, function(res){

                      $scope.numberAddedAppoinments = res.total;

                      if($scope.numberAddedAppoinments != $scope.services.length){



                        $scope.canDoBill = true;    

                        if($scope.order.id){

                          $scope.canDoBill=false;

                        } 



                      }else{
                        $scope.canDoBill = false;


                      }
                    }, function(error){
                      console.log(error);

                    });
                  }
                }

                var actualDate = new Date();

                $scope.orderDate = moment(actualDate).format('YYYY-MM-DD');     


      /**
       * Si se obtiene un Id en local storage se Obtiene su informacion
       * @author Deicy Rojas <deirojas.1@gmail.com>
       * @date     2016-10-07
       * @datetime 2016-10-07T08:16:21-0500
       * @return   {[type]}                 [description]
       */


        /**
         * @author Julián Andrés Muñoz Cardozo
         * 2016-08-05 14:30:00
         * Verficiacion: si una orden tiene una factura, a esta no se pueden agregar mas estudios
         * Bloquea el buscador de servicios
         */
        // $scope.orderHasBill = false;

        if($scope.orderId != undefined){

         $scope.doesOrderHasBill();

       }

        /**
         * [setPeople description]
         * @type {Object}
         */
         $scope.setPeople = {

          id: 0,
          document_types_id:"",
          identification:"",
          first_name: "",
          middle_name: "",
          last_name:"",
          last_name_two:"",
          birthdate: "",
          gender:"",
          address: "",
          phone: "",
          email: "",
          municipalities_id:""
        }

        /**
         * [resetSetPeople description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-10-04
         * @datetime 2016-10-04T11:33:15-0500
         * @return   {[type]}                 [description]
         */
         $scope.resetSetPeople = function(){

          $scope.setPeople = {

            id: 0,
            document_types_id:"",
            identification:"",
            first_name: "",
            middle_name: "",
            last_name:"",
            last_name_two:"",
            birthdate: "",
            gender:"",
            address: "",
            phone: "",
            email: "",
            municipalities_id:""
          }
        }

        /**
         * [resetSearchPeople description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-10-04
         * @datetime 2016-10-04T11:33:25-0500
         * @return   {[type]}                 [description]
         */
         $scope.resetSearchPeople = function(){

           $scope.searchPeople = {
            identification:""
          };
        }

        $scope.resetCalculateOrder = function(){


          $scope.order = {
            calculated_age :"",

          }

        }


        /**
         * [getNewPeople description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-10-04
         * @datetime 2016-10-04T11:33:32-0500
         * @param    {[type]}                 setPeople [description]
         * @return   {[type]}                           [description]
         */
         $scope.getNewPeople = function(setPeople){
          console.log('lector de cedulas proceso')
          $scope.setPeople = setPeople;
          $scope.searchPeople.identification  = parseInt($scope.searchPeople.identification);

          $scope.people.first_name            = $scope.setPeople.first_name;

          $scope.people.middle_name           = $scope.setPeople.middle_name;

          $scope.people.last_name             = $scope.setPeople.last_name;

          $scope.people.last_name_two         = $scope.setPeople.last_name_two;

          $scope.people.birthdate             =  moment($scope.setPeople.birthdate, "YYYY-MM-DD").format('YYYY-MM-DD');

          for (var i = $scope.gender.length - 1; i >= 0; i--) {

           if($scope.gender[i].id == $scope.setPeople.gender){

            $scope.selectGender  = $scope.gender[i];
            $scope.people.gender = $scope.selectGender.id;

          }
        }
            /**
             * Asingar tipo de documetno Cedula por defecto.
             * @type {Number}
             */
             $scope.selectedTypeId = 1;

             $scope.setSetSelectedTypeId(); 

             $scope.calculateAgeChange($scope.people.birthdate);

             $scope.hideIndetityCard();

             $scope.resetSetPeople(); 

             console.log($scope.people);
           }



           $scope.resetPeople = function(){

            $scope.people = {   

              id: 0,
              document_types_id:"",
              identification:"",
              first_name: "",
              middle_name: "",
              last_name:"",
              last_name_two:"",
              birthdate: "",
              gender:"",
              address: "",
              phone: "",
              email: "",
              municipalities_id:"",
              user_creation:"",
            }
          }

        /** 
         * Model Information for informacion demografica paciente.
         * @type {Object}
         */
         $scope.people = {   

          id: 0,
          document_types_id:"",
          identification:"",
          first_name: "",
          middle_name: "",
          last_name:"",
          last_name_two:"",
          birthdate: "",
          gender:"",
          address: "",
          phone: "",
          email: "",
          municipalities_id:"",
          user_creation:"",
        }


        $scope.patients;


        /**
         * Variable para almacenar el estudio actual para agendar o que ya esta agendado
         */
         $scope.study;


         /**
          * @author Julián Andrés Muñoz Cardozo
          * 
          * 2016-08-10 17:29:09
          * Modo del agendamiento de una cita si es agregar o aditar
          * true: agregado
          * false: edicion
          */
          $scope.appointmentAddEditMode;


          $scope.searchPeople = {
            identification:""
          };


          $scope.idPatients = "";

        /**
         * Model estructura necesario de un paciente. 
         * @type {Object}
         */
         $scope.patient = {

          users_id:"",
          people_id:"",
          zone_id:"",
          regimes_id:"",
          permanent_diagnostic:"",
          eps_id: "",
          affiliation_type: "",


        }

        /** @type {Object} Model To get List of departments to the dropdown */
        $scope.Departments={
          id:"",
          name:""
        }


         /**
          *  Departamento se seleccionado 
          */
          $scope.selectedDepatment;

        /**
         * Object to get  the list of municipalities
         * @type {Object}
         */
         $scope.Municipalities = {

          id:"",
          municipality:"",
          department_id:""
        }

         /**
          * Municipio seleccionado ¡
          */

          $scope.selectedMunicipalitie;

        /**
         * Struct to create a user for pacient. 
         * @type {Object}
         */
         $scope.newUser = {

          username:"",
          password:"wadsfd",
          roles_id: 7,
          people_id:"",

        }
        


        /**
         * Estructura maestro tipo de documento
         * @type {Object}
         */
         $scope.documentType = {
          id:"", 
          type:""
        }

        /**
         * Maestro regimenes
         */
         $scope.Regimes = {
          id:"", 
          regime:""
        }
        /**
         * Maestro tipos de ordenes
         * @type {Object}
         */
         $scope.Specializations = {
          id:"",
          type:""
        }
        $scope.ordenTypeSelect;
        /**
         * Maestro sedes 
         */
         $scope.centers = {
          id:"",
          name:""
        }

        /** 
         * Maestro Clientes 
         */
         $scope.Clients = {
          id:"",
          name:""
        }

        $scope.typeAfiliation=[
        {name:'COTIZANTE', code: 2},
        {name:'BENEFICIARIO', code: 1}
        ];


        /**
         * Maestro de Tarifas
         * @type {Object}
         */
        $scope.Rates;// = new Array();


        $scope.searchSpecialist = {
          names:""
        };

        $scope.showSpecialist = {

          id:"",
          name:""
        };

        $scope.showDiagnostic = {

          id:"",
          description:""
        };

        /**
         * [eps description]
         * @type {Object}
         */
         $scope.selectedEps = undefined;

         $scope.getEps = function(){

          patientsService.getAllEp(function(res){

            if(res.success == true){

              $scope.getAllEps = res.eps;

            }

          });
        }

        $scope.getEps();


        $scope.goBack =  function () {
          l( 'goBack()' );
          $scope.hideInvoice();

          $timeout(function() {

           window.history.back();
          //$scope.hasConfig = true;
          //$location.path('');
          //$location.path('/app/ordersList.html').search({key: firstLoad});
        }, 500);

        }


        // Actual servicio a edidar en factServices
        $scope.currentService = undefined;

        $scope.showContrastMedia = function(services,products, item){     

          // l("--showContrastMedia()--");
          
          item-=1;
          l(item);
          $scope.currentService = item;

          // l("--Todos los servicios--");
          l($scope.factServices[item]);


          $('.contrastMedia').modal('show');

          $scope.refService = services;

          // console.log("Contras MEdia");

          // console.log($scope.refService);
          // console.log($scope.refService.supplies.products_study.service.id);

          $scope.info = $scope.factServices;


          if($scope.products != undefined){

            appointmentService.getProductos({idStudy: $scope.info[0].service.id, idService: $scope.refService.supplies.products_study.service.id},function(res){

              console.log(res);

              if(res.success == true){

                $scope.productsService = res.products;
                console.log($scope.productsService);

              }

            });

          }


          if($scope.refService.index){

            if($scope.refService.supplies != null){

              //$scope.getSelectProducts();  
            }          

          }



        }

        $scope.hideContrastMedia = function(){

          $('.contrastMedia').modal('hide');
        }

        $scope.getSelectProducts = function(products, cantidadProduct, services){
          l('getSelectProducts()');
       // $scope.changeCant();
       if($scope.products != undefined){

        $scope.updateProducts = $scope.products;

        $scope.value = parseInt($scope.updateProducts.value);



        var cantidad = parseInt( $('#product_quantity').val() ) || 0;
        var valor = $scope.updateProducts.value;
        var costo = parseInt( $scope.updateProducts.value ) * parseInt( $('#product_quantity').val() );

        $scope.factServices[ $scope.currentService ].desc = $scope.updateProducts.name;
        $scope.factServices[ $scope.currentService ].cant = cantidad;
        $scope.factServices[ $scope.currentService ].valor = valor;
        $scope.factServices[ $scope.currentService ].cost=costo;

        l("cantidad ="+cantidad+" valor="+valor+" costo="+costo);
          $scope.doCalculateSubtotal(); // calcular subtotales

        }else{

          $scope.total = 0;
          $scope.value = 0;
            $scope.doCalculateSubtotal(); // calcular subtotales∫
          }

        }

        $scope.cantidadProduct = {

          value:1

        }

        $scope.updateCantidadProduct = {

          value:''
        }



        $scope.products = {

          id:'',
          cup:'',
          name:'',
          specializations_id:'',
          average_time:'',
          type:'',
          format_types_id:'',
          coments:'',
          studies_id:'',
          servicises_id:'',
          state:'',
          created:'',
          modified:'',
          required_product:'',
          services_id:'',
          products_id:'',
          value:'',
          section_id:'',
          farmaseutic_form_id:'',
          active_principle:''


        };

        $scope.updateProducts = {

          id:'',
          cup:'',
          name:'',
          specializations_id:'',
          average_time:'',
          type:'',
          format_types_id:'',
          coments:'',
          studies_id:'',
          servicises_id:'',
          state:'',
          created:'',
          modified:'',
          required_product:'',
          services_id:'',
          products_id:'',
          value:0,
          section_id:'',
          farmaseutic_form_id:'',
          active_principle:''


        };

        /**
         * Productos para Servicios
         */

         $scope.productsServices = function(factServices){
          l('productsServices()');
          $scope.info = $scope.factServices;

          appointmentService.getProductos({id: $scope.info[0].service.id},function(res){

            l('indicador');
            console.log(res);

            if(res.success == true){

              $scope.productsService = res.products;

              l('manera adecuad');

              console.log($scope.productsService);

            }

          });
        }



        /**
         * Maestro tipos de servicios. 
         * @type {Object}
         */
         $scope.ServiceTypes = {
          id:"",
          type:""
        }
        
        $scope.centers = [];
        
        $scope.clients = [];
        
        $scope.rates = [];
        
        $scope.serviceTypes = [];

         /**
         * Estructura maestro zonas
         * @type {Object}
         */
         $scope.Zones = undefined;

         $scope.selectedZone = undefined;

         $scope.selectedSpecialization = undefined;

         $scope.selectedCenter  = undefined;

         $scope.selectedClient  = undefined;

         $scope.selectedRate  = undefined;

         $scope.selectedServiceType  = undefined;

         $scope.selectedRegimes = undefined;

         $scope.selectedTypeId = undefined;



         
        /**
         * Detalles de la nueva orden
         * @type {Object}
         */
         $scope.order = {

            /**
             * Identificador
             * @type {Number}
             */
             id:0,

               /**
             * Validador
             * @type {String}
             */
             validator               :"",

            /**
             * Observaciones
             * @type {String}
             */
             observations            :'',

            /**
             * Edad Calculada
             * @type {String}
             */
             calculated_age          :"",



            /**
             * Subtotal
             * @type {Number}
             */
             subtotal                :0,

             

            /**
             * Total
             * @type {Number}
             */
             total                   :0,


            /**
             * Total a cancelar
             * @type {Number}
             */
             total_cancel: 0, 

            /**
             * Valor del copago
             * @type {Number}
             */
             copayment:0, 


            /**
             * Descuento
             * @type {Number}
             */
             discount                :0,
             
            /**
             * Donacion 
             * @type {Number}
             */
             donation                :0,



             particular_payout       :"",

            /**
             * Identificador de cliente
             * @type {Number}
             */
             
             clients_id              :"",

            /**
             * Identificador de tarifa
             * @type {Number}
             */
             rates_id                :"",

            /**
             * Identificador de usuario
             * @type {Number}
             */
             users_id                :1,

            /**
             * Identificador de paciente
             * @type {Number}
             */
             patients_id             :0,

            /**
             * Identificador especialista
             * @type {Number}
             */
             external_specialists_id :"",

            /**
             * Tipo de servicio
             * @type {Number}
             */
             service_type_id         :"",

            /**
             * Tipo de orden
             * @type {Number}
             */
             cost_centers_id          :"" ,

             /** 
              * sede
              */
              centers_id :"",

              bill_types_id: undefined,

              form_payment_id: 1,

              order_states_id: 1,

              cie_ten_codes_id: 12426,
              
              consultation_endings_id: 1,
              
              external_causes_id: 1


              
            };



            $scope.payment = {

              debit: 0,

              credit: 0,

              credit_card_number: 0,

              form_payments_id: 1,

              bill_types_id: 1,

              orders_id: 1

            };

         /**
           * inhabilita la tecla enter para el evento submit del formulario.
           * @type {event}
           */
           
           $('#formid').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
              e.preventDefault();
              return false;
            }
          });


         /**
        * Function to get sedes by id  
        */
        $scope.getSelectedCenters = function(id){

          ordersService.getSelectedCenters({id:id},function(res){

            $scope.centersSelected = res.center;


                // $scope.selectedCenter  = $scope.centers[0];
                
              }, function (error) {

              });

        }

        /**
        * Function to get all tipos de Orden 
        */
        $scope.getSelectedCostCenters = function(id){


          costCentersService.getSelectedCostCenters({id:id},function(res){


            $scope.SelectedSpecializations = res.costCenter;


          }, function (error) {
            console.log(error);

          });

        }

        /** Obtiene listado de tarifas segun el cliente seleccionado  */
        $scope.getSelectedRate =function(id){

                // $scope.order.clients_id.id;
                
                ratesClientsService.getSelectedRate({id:id}, function(res){

                  $scope.selectedRates = res.rate;

                  console.log('entro a rates');

                  console.log($scope.selectedRate);

                }, function (error) {

                  console.log(error);
                });
              }


          /**
           * Identificadores de las citas guardadas
           * @type {Array}
           */
           $scope.savedAppointmentsIds = new Array();


          /**
           * para validar y poder asignar un servicio a un paciente
           */
           $scope.canSetService = false;

              /**
          * Dirección donde se buscaran los servicios
          * @type {[type]}
          */
          $scope.urlSearchServices = urls.BASE_API + '/studies/queryStudies/';



        /**
         * eventos de cambio en seleccion para los detalles de la orden 
         */
         $scope.setSelectedSpecialization = function(){

          l("--setSelectedSpecialization--");
          console.log($scope.selectedSpecialization);


          $scope.urlSearchServices = urls.BASE_API + '/studies/queryStudies/'+$scope.selectedSpecialization+'/'+$scope.selectedClient+'/'+$scope.selectedRate+"/";
          console.log($scope.urlSearchServices);

        }




        $scope.setSelectedSpecialization();


        $scope.disableCostCenters = function(){
                // if($scope.services != undefined){
                //     if($scope.selectedSpecialization != undefined){
                //         $scope.disableCenter = true;
                //     }else{

                //         if($scope.orderId.cost_centers_id != undefined){
                //                   $scope.disableCenter = false;
                //              $scope.selectedSpecialization = $scope.orderId.cost_centers_id;
                //          }
                //      }
                //  }
              }


              $scope.$watch('selectedSpecialization', function(){

               $scope.disableCostCenters();

             });

              $scope.disableCostCenters();


          /**
           * Obtiene los generos.
           * @author Deicy Rojas <deirojas.1@gmail.com>
           * @date     2016-12-13
           * @datetime 2016-12-13T09:47:43-0500
           */
           $scope.getGender = function(){
             genderService.getGender(0,function(res){
              $scope.gender = res.gender;
              $scope.selectGender = undefined;
              console.log('----------------- resupesta  Genero ----------------');
              console.log(res);
            },function(error){

            });

           }
           $scope.getGender();

         /**
          * Get the list of departments for the  dropdown
          * @return {[type]} [description]
          */
          $scope.getDepartments = function(){

            departmentsService.get(function(res){

             $scope.Departments = res.departments;
             $scope.selectedDepatment = '';
             $scope.getMunicipalities();

           }, function(error){
            console.log(error);
          });
          }

        /**
         * function que selecciona un departamento por su indice para el dropdown
         */
         $scope.selectDeparment = function(index){

           $scope.selectedDepatment = $scope.Departments[index];

         }  

         /**
          * obtener la lista de municipios para un departamentos seleccionado. 
          * @param  {[type]} cityId [description]
          * @return {[type]}        [description]
          */
          $scope.getMunicipalities = function(cityId){

            municipalitiesService.getByDepartment({id:$scope.selectedDepatment.id}, function(res){

              $scope.Municipalities = res.municipalities;

              if(cityId === undefined){

                $scope.selectedMunicipalitie = $scope.Municipalities[0];

              }else{

                for (var i = 0; i < $scope.Municipalities.length; i++) {

                  if($scope.Municipalities[i].id == cityId){

                    $scope.selectedMunicipalitie = $scope.Municipalities[i];

                    break;
                  }          
                }
              }

            }, function(error){

              console.log(error);

            });

          }
         /**
          * Obtener el departamento al cual pertenece un  municipio
          * @return {[type]} [description]
          */
          $scope.getByMunicipality = function(){


             $scope.idCity = $scope.people.municipalities_id; // get the 
             
             municipalitiesService.getByMunicipality({id:$scope.idCity}, function(res){

              for (var i = 0; i < $scope.Departments.length; i++) {

                if($scope.Departments[i].id == res.municipalities[0].department_id){


                  $scope.selectDeparment(i); 

                  $scope.getMunicipalities($scope.idCity);

                  break;
                }

              }



            }, function(error){
              console.log(error);

            });
           }


           $scope.getDepartments();


    /**
     * evento de cambio de seleccion de ciudad
     */
     $scope.changeSelectedMunicipality = function(){

      $scope.people.municipalities_id = $scope.selectedMunicipalitie.id;


    }


    /**
     * Buscar un paciente de acuerdo a su numero de identificacion 
     */
     $scope.searchPatients = function(elm){

        /**
         * Julián Andrés Muñoz Cardozo
         * 2016-09-06 14:27:44
         * validacion de identificacion no vacia
         */
         if(typeof($scope.searchPeople.identification) == 'string' && $scope.searchPeople.identification != ''){

           var index = 0;
           while ($scope.searchPeople.identification[index] == '0') {
            index++;
          }

          $scope.searchPeople.identification = $scope.searchPeople.identification.substring(index);


          patientsService.searchPatients({id:$scope.searchPeople.identification},function(res){

                // console.log('entro');

                // console.log(res);

                /**
                 * Si se encuentra el paciente
                 */
                 if(res.success == true){

                  $scope.validateUser = 0;

                  $(elm).popover('hide');


                  console.log("ver patient...");

                  console.log(res.people);

                  $scope.people = res.people;

                  $scope.getPeoplePhoto();


                  $scope.canSetService = true;

                  if(res.people.patients.length > 0){




                    $scope.patient = res.people.patients[0];

                    $scope.selectedZone = $scope.patient.zone_id;

                    $scope.selectedRegimes = $scope.patient.regimes_id;

                    $scope.selectedTypeId = res.people.document_types_id;

                    $scope.selectedEps = $scope.patient.eps_id;

                    $scope.getByMunicipality();

                    $scope.error = '';

                       /**
                         * Asigna el Genero segun se traiga desde BD.
                         * @author Deicy Rojas <deirojas.1@gmail.com>
                         * @date     2016-12-13
                         * @datetime 2016-12-13T09:31:53-0500
                         */
                         for (var i = $scope.gender.length - 1; i >= 0; i--) {
                          if($scope.people.gender == $scope.gender[i].id)
                            $scope.selectGender  = $scope.gender[i];
                        }

                        /**
                         * para prueba
                         * @type {Number}
                         */
                         $scope.order.calculated_age = 1;


                         $scope.order.patients_id = $scope.patient.id;


                         $scope.calculateAgeChange($scope.people.birthdate);
                         
                       }

                     }else {

                      $scope.validateUser = 1;

                      if($scope.searchPeople.identification != null){

                       $scope.canSetService = false;

                       $scope.people.identification = $scope.searchPeople.identification;

                       $scope.error = 'PACIENTE NO ENCONTRADO.';

                       $scope.image_source = undefined;





                         // $scope.people = null;

                         // $scope.patient = null;



                            /** 
                             * Model Information for informacion demografica paciente.
                             * @type {Object}
                             */
                             $scope.people = {   

                              id:0,
                              document_types_id:  undefined,
                              identification:     "",
                              first_name:         "",
                              middle_name:        "",
                              last_name:          "",
                              last_name_two:      "",
                              birthdate:          "",
                              gender:             undefined,
                              address:            "",
                              phone:              "",
                              email:              "",
                              municipalities_id:  undefined,
                              user_creation: "",
                            }

                            /**
                             * Model estructura necesario de un paciente. 
                             * @type {Object}
                             */
                             $scope.patient = {

                              users_id:"",
                              people_id:"",
                              zone_id: undefined,
                              regimes_id: undefined,
                              permanent_diagnostic:"",
                              eps_id:undefined

                            }



                            $scope.selectedTypeId = null;

                            $scope.selectGender = null;

                            $scope.selectedZone = null;

                            $scope.selectedRegimes = null;

                            $scope.order.calculated_age = null;

                            $scope.selectedEps = null;


                          }

                        }

                      }, function (error) {

                      });

        // /**
        //     * Function to get the last added user
        //     */
        //     $scope.getPatients = function(){

        //         patientsService.getPatients(function(res){

        //             $scope.patients = res.patients;

        //             console.log('entro');

        //             console.log($scope.patients);
        
        //             }, function (error) {

        //         });

        //     }

                // $location.path("go" + patients.person.id);
                
              }                

            }



        /**
        * Function to get the last people
        */
        $scope.getLastPeople = function(){

          peopleService.getLastPeople(function(res){

            $scope.newUser.people_id = res.results.id;

          }, function (error) {

          });

        }
        

        /**
         * funcion para obtener todas las zonas, 
         */
         $scope.getZones = function(){

           patientsService.getZones(function(res){

             $scope.Zones = res.zones;  

             // console.log('entro a zonas'); 

             // console.log(res.zones);

           }, function (error) {

           });

         }

        // load all the zones
        $scope.getZones();


        /**
        * Function to get all document_types
        */
        $scope.getDocumentTypes = function(){

          patientsService.getDocumentTypes(function(res){

            $scope.documentTypes = res.documentTypes;
                // Default Option
                $scope.facitSelected = $scope.documentTypes;

                

              }, function (error) {

              });

        }


        // load all the documents types.
        $scope.getDocumentTypes();


        /**
        * Function to get all Regimenes 
        */
        $scope.getRegimes = function(){

          patientsService.getRegimes(function(res){

            $scope.Regimes = res.regimes;

              //  $scope.patient.regimes_id = $scope.Regimes[0];
              
            }, function (error) {

            });

        }


        // load all the Regimens types.
        $scope.getRegimes();


        /**
        * Function to get all  Centros de costos  
        */
        $scope.getCostCenters = function(){


          costCentersService.get(function(res){


                //$scope.selectedSpecialization = res.costCenter;


                $scope.Specializations = res.costCenter;


              }, function (error) {
                console.log(error);

              });

        }


        $scope.setSetSelectedTypeId = function (){

          $scope.people.document_types_id = $scope.selectedTypeId

          console.log($scope.people);
        }




        $scope.changeSelectedCenter = function(){

          $scope.order.centers_id = $scope.selectedCenter;

            //console.log($scope.order);

          }


          $scope.chageSelectedClient = function(){

            $scope.order.clients_id = $scope.selectedClient;

            //console.log($scope.order);
          }

          $scope.changeSelectedRate = function(){

            $scope.setSelectedSpecialization();
            $scope.order.rates_id = $scope.selectedRate;

            console.log('entro a rate');

            
            // $scope.clientId = $scope.selectedClient;

            var servicesIds = new Array();

            console.log(servicesIds);

            console.log($scope.services);

            for (var i = 0; i < $scope.services.length; i++) {

              if($scope.services[i].id != undefined){

                $scope.services[i].cost = 0;

                servicesIds.push($scope.services[i].id);


              }
            }


            if(servicesIds.length != 0 ){

              ratesClientsService.getNewStudiesValues({servicesIds:servicesIds,idRate:$scope.order.rates_id},function(res){


                for(var b =0; b<$scope.services.length; b++){
                  for (var i in res.rate ) {

                    if( $scope.services[ b ].id == res.rate[ i ].studies_id ){
                      $scope.services[ b ].cost=res.rate[ i ].value;
                    }

                  }
                }

              }, function (error) {

              });
            }
            

          } 

        /**
        * Function to get all sedes  
        */
        // $scope.getRateStudies = function(studie){

        //     $scope.order.rates_id = $scope.selectedRate;

        //     ratesClientsService.getRateStudies({idRate:$scope.selectedRate,idStudie:studie},function(res){

        //         $scope.c = res.rate[0].value;

        //         console.log($scope.valueTemp);

        //         // $scope.selectedCenter  = $scope.centers[0];
        
        //     }, function (error) {

        //     });

        // }       

        $scope.changeSelectedServiceType = function(){

          $scope.order.service_type_id = $scope.selectedServiceType;

          console.log($scope.order);
        }

        /**
         * Fin deteccion de eventos de selección para detalle de orden
         */


         /**
          * Funcion de deteccion de cambio de zona
          */
          $scope.changeSelectedZone = function(){


            $scope.patient.zone_id = $scope.selectedZone;

          }

         /**
          * Funcion que detecta el cambio de EPS
          * @return {[type]} [description]
          */
          $scope.changeSelectedEps = function(){

            $scope.patient.eps_id = $scope.selectedEps;


          }


         /**
          * Funcion de deteccion cambio de genero 
          * @return {[type]} [description]
          */
          $scope.changeSelectedGender = function(){
            console.log('---SELCCIONA EL GENERO ---------');
            console.log($scope.selectGender);
            $scope.people.gender = $scope.selectGender.id;

          }

        /**
         * Funcion que detecta el cambio de Regimen.
         */
         $scope.setSelectedRegimes = function(){

          $scope.patient.regimes_id = $scope.selectedRegimes;

        }


        /**
         * Funcion que detecta el cambio en el tipo de documento.
         */
         $scope.setSelectedTypeId = function(){

          $scope.people.document_types_id = $scope.selectedTypeId;

        }


        // load all the Regimens types.
        $scope.getCostCenters();


        /** fimcopm que obtiene maestro de servicios. */
        $scope.getServiceType =function(clientId){

          ordersService.getServiceType(function(res){


            $scope.serviceTypes = res.serviceTypes;

                // $scope.order.service_type_id =  $scope.ServiceTypes[0];

              }, function (error) {
                console.log(error);
              });
        }
        
        $scope.getServiceType();





         /**
        * Function to get all sedes  
        */
        $scope.getCenters = function(){

          ordersService.getCenters(function(res){


            $scope.centers = res.center;

                //$scope.selectedCenter  = $scope.centers[0].id;
                
              }, function (error) {

              });

        }


        // load all the Centers
        $scope.getCenters();


        $scope.selectedClientObj = undefined;

        $scope.getSelectedClientObj = function(){

          for (var i = 0; i < $scope.clients.length; i++) {


            if($scope.clients[i].id == $scope.selectedClient){

              $scope.selectedClientObj = $scope.clients[i];

            }

          }


        }



        /** Obtiene listado de tarifas segun el cliente seleccionado  */
        $scope.getRateByClient =function(){


          var clientId = $scope.selectedClient;

          $scope.getSelectedClientObj();

            // $scope.order.rates_id = $scope.selectedRate;

            /**
             * Obtenemos el nuevo cliente seleccionado
             */
             $scope.chageSelectedClient();

             if(clientId != undefined){

              console.log(clientId);

                // $scope.order.clients_id.id;
                
                ratesClientsService.getByClient({id:clientId}, function(res){

                  $scope.rates =  new Array();

                  for (var i = 0; i < res.rates.length; i++) {

                    var option = {id:res.rates[i].id,rate_id:res.rates[i].rate.id, rate_name:res.rates[i].rate.name};

                    $scope.rates.push(option);
                  }



                }, function (error) {
                  console.log(error);
                });
              }


            }


            /** Obtiene todos lo clientes HABILITADOS */

            $scope.getClients = function(){

              clientsService.getEnable(function(res){

                $scope.clients = res.clients;

               // $scope.getRateByClient($scope.order.clients_id.id);
               
               $scope.getRateByClient();

               
             }, function (error) {
              console.log(error);
            });
            }

            $scope.getClients();











            /** SEARCH EXTERNAL SPECIALIST*/


            $scope.searchSpecialist = function(){


              externalSpecialistsService.getSearchSpecialist({names:$scope.searchSpecialist.names},function(res){

                // console.log('entro a medico');

                // $scope.showSpecialist = res.result;

                console.log(res.result);

              }, function (error) {

              });

            // $location.path("/app/editPeople.html" + patients.person.id);
          }


        /**
        * Function to get the last added user
        */
        // $scope.getExternalSpecialist = function(){

        //     externalSpecialistsService.getExternalSpecialist({},function(res){

        //         $scope.externalSpecialists = res.externalSpecialists;

        //         // console.log('encontro especialista');

        //         // console.log($scope.externalSpecialists);

        //         $scope.external_specialists_id = $scope.externalSpecialists.id;             
        
        //         }, function (error) {

        //     });

        // }

        // $scope.getExternalSpecialist();




        /**
         * Funcionalidad de busqueda de los medicos externos
         */

         $scope.foundServiceExtSpe = undefined;

         /**
          * Arreglo con todos los medicos externos
          * @type {Array}
          */
          $scope.servicesExtSpe = new Array();

         /**
          * Dirección donde se buscaran los medicos
          * @type {[type]}
          */
          $scope.urlSearchServicesExtSpe = urls.BASE_API + '/ExternalSpecialists/querySpecialist/';


         /**
          * detection se seleccion de medico por enter o click 
          */
          $scope.$watch('foundServiceExtSpe', function() { 




            /**
             * Si el modelo no esta definido
             */
             if($scope.foundServiceExtSpe != undefined){

                /**
                 * agregamos el medico al arreglo de servicios
                 */
                 $scope.servicesExtSpe.push($scope.foundServiceExtSpe.originalObject);

                /**
                 * Se elimina el valor temporal
                 * @type {[type]}
                 */
                 $scope.foundServiceExtSpe = undefined;

                 $scope.showSpecialist = $scope.servicesExtSpe[0];

                /**
                 * limpiamos el valor del objeto
                 * @type {[type]}
                 */
                 $scope.$broadcast('angucomplete-alt');



               }

             }, true);






          

        /**
        * Funcionalidad de busqueda del diagnostico permanente angudiagnostic
        */

        $scope.foundServiceDiagnostic = undefined;

         /**
          * Arreglo con todos los diagnosticos permanentes
          * @type {Array}
          */
          $scope.servicesDiagnostic = new Array();

         /**
          * Dirección donde se buscaran los diagnosticos permanentes
          * @type {[type]}
          */
          $scope.urlSearchServicesDiagnostic = urls.BASE_API + '/CieTenCodes/queryDiagnostic/';


         /**
          * detection se seleccion de diagnosticos permanentes por enter o click 
          */
          $scope.$watch('foundServiceDiagnostic', function() { 




            /**
             * Si el modelo no esta definido
             */
             if($scope.foundServiceDiagnostic != undefined){

                /**
                 * agregamos el diagnostico permanente al arreglo de servicios
                 */
                 $scope.servicesDiagnostic.push($scope.foundServiceDiagnostic.originalObject);

                /**
                 * Se elimina el valor temporal
                 * @type {[type]}
                 */
                 $scope.foundServiceDiagnostic = undefined;

                 $scope.showDiagnostic = $scope.servicesDiagnostic[0];

                // se guarda el valor de la cadena en el objeto paciente del campo de diagnostico permanente para guardar en la bd
                $scope.patient.permanent_diagnostic = $scope.showDiagnostic.description;

                $scope.order.cie_ten_codes_id = $scope.showDiagnostic.id;

                

                

                /**
                 * limpiamos el valor del objeto
                 * @type {[type]}
                 */
                 $scope.$broadcast('angucomplete-alt');

               }

             }, true);


         /**
          * Función para editar el paciente
          */
          $scope.editOnlyPeople = function(){




            console.log($scope.people);


            /**
             * calling service to add a new people
             */
             peopleService.editPeoples($scope.people,function(res){


                    // $scope.getLastPeople();

                    if (res.success == true){




                      $scope.uploadPeoplePhoto();


                    }                 

                  }, function (error) {



                  });
           }


         /**
          * Función para editar el paciente
          */
          $scope.editPatients = function(){




            console.log($scope.people.patient.id);


            /**
             * calling service to add a new people
             */
             patientsService.editPatients($scope.people,function(res){


                    // $scope.getLastPeople();

                    if (res.success == true){




                      $scope.uploadPeoplePhoto();


                    }                 

                  }, function (error) {



                  });
           }


         /**
          * Función para editar el paciente
          */
          $scope.doEditPeople = function(){


            console.log("do edit people..");
            
            console.log($scope.people);
            delete( $scope.people.user_creation );

            /**
             * calling service to add a new people
             */
             peopleService.editPeoples($scope.people,function(res){

                    // $scope.getLastPeople();

                    if (res.success == true){

                      console.log('EDITO PERSONA');

                      $scope.uploadPeoplePhoto();
                      $scope.savePreOrderDetail();


                    }                 

                  }, function (error) {



                  });
           }




         /**
          * Guardar nuevos datos demograficos de paciente
          */
          $scope.addPeople = function(){

                /**
                 * Cambio de ciudad
                 */
                 $scope.changeSelectedMunicipality();

                 patientsService.addPeoples($scope.people,function(res){





                  if (res.success == true){

                    $scope.people.id = res.person.id;

                    $scope.patient.people_id = res.person.id;

                    $scope.newUser.people_id = res.person.id;

                    $scope.unique  = '';

                    $scope.addUser();

                  }else{


                        // $scope.uniqueEmail = res.errors.email.unique;

                        // $scope.uniqueIdentification = res.errors.identification.unique;

                        // console.log(res.errors);
                      }

                    }, function (error) {

                      l("--addPeoples--Errors");

                      l( error );

                    // $scope.unique = res.errors.email.unique;

                    // console.log($scope.unique);

                  });


               }



         /**
          * Guardar nuevos datos demograficos de paciente
          */
          $scope.addOnlyPeople = function(){

                /**
                 * Cambio de ciudad
                 */
                 $scope.changeSelectedMunicipality();

                 patientsService.addPeoples($scope.people,function(res){


                  if (res.success == true){

                    $scope.validateUser = 0;

                    $scope.people.id = res.person.id;

                    $scope.patient.people_id = res.person.id;

                    $scope.newUser.people_id = res.person.id;

                    $scope.unique  = '';

                    $scope.addOnlyUser();


                    $scope.uploadPeoplePhoto();
                    $(".save-patient-success").modal("show");


                  }else{

                    $scope.validateUser = 1;
                    $(".save-patient-fail").modal("show");

                        // $scope.uniqueEmail = res.errors.email.unique;

                        // $scope.uniqueIdentification = res.errors.identification.unique;

                        // console.log(res.errors);
                      }

                    }, function (error) {

                    // $scope.unique = res.errors.email.unique;

                    // console.log($scope.unique);

                  });


               } 

        /**
         * Function to add new user
         */

         $scope.addUser = function(){

          $scope.newUser.username = $scope.people.identification;


            /**
             * calling service to add a new user
             */
             usersService.addUsers($scope.newUser,function(res){

              if (res.success == true){

                   // console.log('entro users');

                   $scope.patient.users_id = res.person.id;

                   $scope.patient.people_id = res.person.people_id;

               //     console.log($scope.people.users_id);

               $scope.addPatient();

             }else{

              console.log('error'); 

              console.log(res.errors);

              console.log(res.errors.email);
            }

          }, function (error) {


            console.log(res);

          });

           }


        /**
         * Function to add new user
         */

         $scope.addOnlyUser = function(){

          $scope.newUser.username = $scope.people.identification;

          console.log($scope.newUser);
            /**
             * calling service to add a new user
             */
             usersService.addUsers($scope.newUser,function(res){

              if (res.success == true){

                   // console.log('entro users');

                   $scope.patient.users_id = res.person.id;

                   $scope.patient.people_id = res.person.people_id;

               //     console.log($scope.people.users_id);

               $scope.addOnlyPatient();

             }else{

              console.log('error'); 

              console.log(res.errors);

              console.log(res.errors.email);
            }

            console.log(res);


          }, function (error) {


            console.log(res);

          });

           }

        /**
         * Function to add new patients
         */

         $scope.addOnlyPatient = function(){

            // console.log('entro pacientes');

            // console.log($scope.people);

            // /**
            //  * patient...
            //  */
            // console.log($scope.patient);

            /**
             * calling service to add a new patients
             */
             

             if($scope.patient.permanent_diagnostic == ''){
              $scope.patient.permanent_diagnostic = "NO APLICA";
            }
            
            patientsService.addPatients($scope.patient,function(res){

                // console.log('registro patients');

                // console.log(res);

                if(res.success == true){

                  $scope.validateUser = 0;

                  $scope.order.patients_id = res.patient.id;

                  $scope.patient.id = res.patient.id;


                }else{
                //  alert("No se pudo guardar el paciente\nverifique que los datos esten completos y\nbien diligenciados");

                $scope.validateUser = 1;

              }

            }, function (error) {


              console.log(res);

            });

          }


        /**
         * Function to add new patients
         */

         $scope.addPatient = function(){

            // console.log('entro pacientes');

            // console.log($scope.people);

            // /**
            //  * patient...
            //  */
            // console.log($scope.patient);

            /**
             * calling service to add a new patients
             */
             

             if($scope.patient.permanent_diagnostic == ''){
              $scope.patient.permanent_diagnostic = "NO APLICA";
            }
            

            patientsService.addPatients($scope.patient,function(res){

                // console.log('registro patients');

                // console.log(res);

                if(res.success == true){

                  $scope.order.patients_id = res.patient.id;

                  $scope.patient.id = res.patient.id;

                  $(".save-patient-success").modal('show');
                  setTimeout(
                    function(){
                      $(".save-patient-success").modal('hide');
                    },
                    3000
                    );


                  $scope.savePreOrderDetail();



                }else{
                  $(".save-patient-fail").modal('show');
                  setTimeout(
                    function(){
                      $(".save-patient-fail").modal('hide');
                    },
                    4000
                    );

                }

              }, function (error) {


                console.log(res);

              });

          }





          $scope.calculateAgeChange = function(date){

                //l('como llega date a la funcion'+' '+date);
                
                $scope.order.calculated_age = calculateAge(date);



              }



              var calculateAge = function( date ){

                var ahora = new Date();
                var edad = moment( date ).diff( ahora, "years", true );
                /* Carlos Felipe Aguirre Taborda 2016-11-22 11:07:32
                   retorna los años del paciente segun la fecha de nacimiento 
                   */
                   edad = Math.abs( edad );
                   edad = edad.toString().substring(0, 4);
                   return edad;
                 }

//$scope.calculateAge($scope.fecha);


        /**
         * Buscar una cita
         */
         $scope.getAppointment = function(id){

          appointmentService.getAppointment({id:id},function(res){




          }, function(error){

            console.log(error);

          });

        }

        /**
         * Función que elimina una cita
         * @param  {[type]} id [description]
         * @return {[type]}    [description]
         */
        //  $scope.deleteAppointment = function(id){

        //     appointmentService.deleteAppointment({id:id},function(res){

        //         console.log(res);


        //     }, function(error){

        //         console.log(error);

        //     });

        // }



        /**
         * Funcionalidad de busqueda de los servicios
         */

         $scope.foundService = undefined;

         /**
          * Arreglo con todos los servicios encontrado
          * @type {Array}
          */
          $scope.services = new Array();


          /**
           * funcion que verifica si ya esta agregado un servicio
           * @param  Int  serviceId Identificador del servicio
           * @return Boolean true si esta agregado, false de lo contrario
           */
           $scope.isAddedService = function(serviceId){


            for (var i = 0; i < $scope.services.length; i++) {

              if($scope.services[i].id == serviceId){

                return true;


              } 
            }

            return false;

          }






         /**
          * detection se seleccion de servicio por enter o click 
          */
          $scope.$watch('foundService', function() { 


            /**
             * Si el modelo esta definido
             */
             if($scope.foundService != undefined){


                    /**
                     * se envia el id del estudio
                     */
                    // $scope.getRateStudies($scope.foundService.originalObject.id);

                    /**
                     * Verificación: si no esta asignado se agrega
                     */
                     if($scope.isAddedService($scope.foundService.originalObject.id) == false){

                      $scope.order.rates_id = $scope.selectedRate;

                            /**
                             * Verif$scopeicación: asigna un costo
                             */

                             ratesClientsService.getRateStudies({idRate:$scope.selectedRate,idStudie:$scope.foundService.originalObject.id},function(res){

                              if(res.success == false){

                                $scope.foundService.originalObject.cost =  0;
                              }else{
                                $scope.foundService.originalObject.cost = res.rate[0].value;
                              }




                              $scope.foundService.originalObject.asigned_time = '';



                                /**
                                * agregamos el servicio al arreglo de servicios
                                */

                                $scope.services.push($scope.foundService.originalObject);


                                /**
                                * Se elimina el valor temporal
                                * @type {[type]}
                                */
                                $scope.foundService = undefined;

                                //setCandoBill();

                                /**
                                * limpiamos el valor del objeto
                                * @type {[type]}
                                */
                                
                                $scope.$broadcast('angucomplete-alt:clearInput', 'services_finder');

                                // $scope.selectedCenter  = $scope.centers[0];
                                // 
                                
                                setCandoBill();
                                
                              }, function (error) {

                              });
                           }
                     // $scope.$broadcast('angucomplete-alt:clearInput');

                   }


                 }, true);


        /**
         * tooltip solution
         */
         jQuery(function($) {
          $(document).tooltip({
            selector: '[data-toggle="tooltip"]'
          });
        });



        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * 2016-08-08 17:00:00
         * Eliminacion del servicio del arreglo de servicios
         */ 
         $scope.dropServiceFromServices = function(service){

          for (var i = 0; i < $scope.services.length; i++) {

            if($scope.services[i].id == service.id){

              $scope.services.splice(i, 1);

            }
          }

            // Habilita el dropdown de centro de costos sí todos los estudios se eliminarón

            if($scope.services.length == 0 || $scope.services == undefined){
              $("#cost-center").removeAttr("disabled");
            }
            
            if(service.appointments_id != null){

              for (var i = 0; i < $scope.savedAppointmentsIds.length; i++) {

                if($scope.savedAppointmentsIds[i] == service.appointments_id){

                  $scope.savedAppointmentsIds.splice(i, 1);

                }

              }

            }

          } 

        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * 2016-08-09 08:12:12
         * Elimina un id de una cita del arreglo de citas
         */
         $scope.dropFromAppointmentIds = function(appointmentId){

          if(appointmentId != null){

            for (var i = 0; i < $scope.savedAppointmentsIds.length; i++) {

              if($scope.savedAppointmentsIds[i] == appointmentId){

                $scope.savedAppointmentsIds.splice(i, 1);

              }

            }

          }

        }


         /**
          * @author Julián Andrés Muñoz Cardozo
          * 
          * 2016-08-08 16:40:00
          * Función para eliminar un servicio
          */
          $scope.dropService = function(service){

            /**
             * Si el identificador de la cita existe
             */
             
             
             if(service.appointments_id != undefined)
             {

                /**
                 * consultamos si la cita esta relacionada a la orden, si lo esta, 
                 * se procede a eliminarse dicha relación 
                 */
                 OrderAppointmentsService.getOrderAppoinment(service,function(res){

                  if(res.success == true){

                        /**
                         * mostrar modal de confirmacion para la cancelacion de la cita
                         */
                         $scope.showModalDropConfirmation(res.getAppointments,service);

                       }else{

                        /**
                         * borrar cita de la base de datos 
                         */
                         $scope.deleteAppointment(service.appointments_id,service);
                         
                        /**
                         * eliminacion del servicio del arreglo de servicios
                         */
                         $scope.dropServiceFromServices(service);

                        // canDoBill();

                      }

                    }, function(error){

                      console.log(error);

                    });

            /**
             * Si no existe el identificador de la cita
             */ 
           }else{

                /**
                 * eliminacion del servicio del arreglo de servicios
                 */
                 $scope.dropServiceFromServices(service);                
               }
             }

        /**
         * Muestra Modal con la cita a acancelar.
         */
         $scope.showModalDropConfirmation = function(getAppointments,service){

          $scope.cancelAppointment = service;

          console.log('mostro modal');

          console.log($scope.cancelAppointment);

          $scope.getAppointments = getAppointments;

          $('.delete-confirmation').modal('show');

        }


/**
 * Funcion para cancelar cita. 
 * @return {[type]} [description]
 */
 $scope.cancelAppointments = function(){


    // console.log('entro a cancel');

    // console.log($scope.cancelAppointment);

    // console.log($scope.getAppointments);

    var service = $scope.cancelAppointment.id;

    var appointment = {
      appointments_id:  $scope.getAppointments.appointments_id,
      date_time_ini:moment($scope.getAppointments.date_time_ini).format('YYYY-MM-DD hh:mm:ss'),
      date_time_end: moment($scope.getAppointments.date_time_end).format('YYYY-MM-DD hh:mm:ss'),
      appointment_states_id: 4
    }

    console.log(appointment);

    appointmentService.cancelAppointmentDates(appointment,function(res){

      console.log('entro al cancel:');

      console.log(res);

      if(res.success){
        $("#cost-center").removeAttr("disabled");

        for (var i = 0; i < $scope.services.length; i++) {


          if($scope.services[i].id == $scope.cancelAppointment.id){

            $scope.services[i].asigned_state = { 
              id:4, 
              state: 'CANCELADA'
            };

          }
        }

        $scope.cancelAppointment = undefined;

        $scope.comentCancelAppointment(res.appointmentDates.appointments_id);

        $('.delete-confirmation').modal('hide');

            // canDoBill();
          }

        }, function (error) {
          console.log('--cancelAppointmentDates--');
          console.log(error);

        });

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

   $('.delete-confirmation').modal('hide');

 }

}, function (error) {

});
}


/**
 * Oculta la modal si ya no se va  a cancelar la cita.
 * @return {[type]} [description]
 */
 $scope.hideModalDropConfirmation = function(){

  $('.delete-confirmation').modal('hide');
  $scope.cancelAppointment = undefined;

}





    //   $scope.doNewOrderDetail = function(){





    // }



    

    

      // $scope.study = {

      //   id: 1,
      //   cup: '901',
      //   name: 'Ecografia Convencional Ecografia Convencional',
      //   average_time: 20,
      //   specializations_id:3,

      // }; 


         // var date = new Date();
         
         $scope.minTime = '06:00:00';

         $scope.maxTime = '24:00:00';




         $scope.appointmentInCalendar = false;


      /**
       * Fecha seleccionada
       * @type String
       */
       $scope.selectedDateAvailable = '';


       /* event source that pulls from google.com */

       /* event source that contains custom events on the scope */
    // $scope.events = [
    //          {title: 'All Day Event',start: new Date(y, m, 1)},

             //   {title: 'GL', start: '2016-05-12T14:30:00', end: '2016-05-12T15:00:00',
          //       // className: ['openSesame']
          //   },
       // ];

       /* event source that calls a function on every view switch */
    // $scope.eventsF = function (start, end, timezone, callback) {
    //   var s = new Date(start).getTime() / 1000;
    //   var e = new Date(end).getTime() / 1000;
    //   var m = new Date(start).getMonth();
    //   var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
    //   callback(events);
    // };

    // $scope.calEventsExt = {
    //    color: '#f00',
    //    textColor: 'yellow',
    //    events: [ 
    //       {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
    //       {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},

    //     ]
    // };
    // 
    
    /* alert on eventClick */
    $scope.alertOnEventClick = function( date, jsEvent, view){
      $scope.alertMessage = (date.title + ' was clicked ');
    };

    /* alert on Drop */
    $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
     $scope.alertMessage = ('Event Droped to make dayDelta ' + delta);
   };

   /* alert on Resize */
   $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
     $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
   };

   /* add and removes an event source of choice */
   $scope.addRemoveEventSource = function(sources,source) {
    var canAdd = 0;
    angular.forEach(sources,function(value, key){
      if(sources[key] === source){
        sources.splice(key,1);
        canAdd = 1;
      }
    });
    if(canAdd === 0){
      sources.push(source);
    }
  };



  /* remove event */
  $scope.remove = function(index) {
    $scope.events.splice(index,1);
  };


  /* Change View */
  $scope.changeView = function(view,calendar) {
    uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
  };


  /* Change View */
  $scope.renderCalender = function(calendar) {
    if(uiCalendarConfig.calendars[calendar]){
      uiCalendarConfig.calendars[calendar].fullCalendar('render');
    }
  };


  /* Render Tooltip */
  $scope.eventRender = function( event, element ) {
   if(event.observation == ""){
     event.observation = "No tiene";
   }
   element.attr("title", event.observation);



 };

 /* config object */
 $scope.uiConfig = {

   calendar: {

     defaultView: 'agendaDay',

               // defaultDate: '2016-05-12',

               slotDuration: '00:05:00',

               snapDuration: '00:05:00',

               minTime: $scope.minTime,

               maxTime: $scope.maxTime,

               // eventOverlap: false,

               eventDurationEditable: true,

               height: 430,

               editable: true,

               dragScroll: true,

               header: false,

               eventClick: $scope.alertOnEventClick,

               eventDrop: function (event, dayDelta, minuteDelta, delta, revertFunc, jsEvent, ui, view) {

                 console.log("datos, final event");

                   // revertFunc();

                   console.log(dayDelta);

                   console.log(minuteDelta);

                   console.log(delta);

                 },

                 eventResize: function (event, delta, revertFunc, jsEvent, ui, view) {
                   console.log("--Event--");
                   console.log(event);
                   console.log("--delta--");
                   console.log(delta);
                   console.log("--revertFunc--");
                   console.log(revertFunc);
                   console.log("--jsEvent--");
                   console.log(jsEvent);
                   console.log("--ui--");
                   console.log(ui);
                   console.log("--view--");
                   console.log(view);
                 },

               // Funcion que añade el appoinment al horarion
               // con un solo click
               // Carlos Felipe Aguirre Taborda 2016-11-08 16:07:25

               dayClick: function (date, jsEvent, view) {

                 $scope.selectedDateAvailable = $('#dateAvailablePicker').datepicker('getFormattedDate');

                 if ($scope.appointmentInCalendar) {
                   alert("Ya ese ha agendado este evento\ndebe quitarlo primero");
                   return;
                 }
                 if (!$scope.selectedDateAvailable) {
                   alert("Debe seleccionar una fecha");
                   return;
                 }

                 if (!$scope.selectedMedicalOffice) {
                   alert("Debe seleccionar un consultorio");
                   return;
                 }


                 $scope.timeIni = date.format("h:mm A");
                 $scope.addAppointment();

               },
               eventRender: $scope.eventRender,

               eventOverlap: function(stillEvent, movingEvent) {
                return false;
              }

            }

          };


    // $scope.changeTo = 'Spanish';

    $scope.changeLang = function() {

      $scope.uiConfig.calendar.dayNames = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
      $scope.uiConfig.calendar.dayNamesShort = ["Dom", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
      
      $scope.uiConfig.calendar.monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
      'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

      // $scope.changeTo = 'Spanish';

    };


  // Cambiar intervalos de tiempo en el calendario de manera dinamica
  // Carlos Felipe Aguirre Taborda 2016-10-29
  
  $scope.changeInterval = function(){
    var interval = $scope.slotDuration;
    l("--changeInterval--");
    l(interval);

    $scope.uiConfig.calendar.slotDuration = interval;
  }




  $scope.changeLang();

  $scope.events =[];

  /* event sources array*/

  $scope.events;

  $scope.eventSources = [$scope.events];

    // $scope.eventSources[0].splice(0, $scope.eventSources[0].length);

    // [$scope.events, $scope.eventSource, $scope.eventsF];
    
    // $scope.eventSources2 = [$scope.calEventsExt, $scope.eventsF, $scope.events];



    /**
     * Obtener las Citas asignadas para la fecha seleccionada
     */
     $scope.getDateAgenda = function(idMedical,dateString){

        // $scope.events = new Array();

        
        /**
         * Solucion para duplicados
         */
         for (var i = $scope.events.length - 1; i >= 0; i--) {

          $scope.events.splice(i, 1);


        }

        console.log("show events at remove");

        console.log($scope.events);

       /**
        * asignar valores
        */
        appointmentService.getAppointmentsDay({dateDay:dateString,idMedical:idMedical},function(res){

          console.log('Ver que tiene res antes de el error   res.appointments[0]');

          console.log(res);

       /**
        * id de la cita actual para guardar
        */
     // $scope.getAppointmentId = res.appointments[0].appointments_id;

            // 


          /**
           * Evento para marcar el medio dia
           */
           $scope.events.push({
            start: dateString + 'T12:00:00',
            end: dateString + 'T14:00:00',
            rendering: 'background',
            overlap: true,
              // cls: 'open', // optional
              // color: '#777777', // optional
              // background: '#eeeeff' // optional

            });

       /**
        * Evento para marcar el final del dia
        */
        $scope.events.push({
          start: dateString + 'T18:00:00',
          end: dateString + 'T23:59:59',
          rendering: 'background',
          overlap: true,
              // cls: 'open', // optional
              // color: '#777777', // optional
              // background: '#eeeeff' // optional

            });

        
        /**
         * Citas del dia seleccionado
         * @type Array
         */
         var appointments = res.appointments;

         $scope.patientquantity = appointments.length;

         for (var i = 0; i < appointments.length; i++) {

          console.log('citas que se muestran en el calendario ');
          console.log(appointments);


          var evento = {

            title: 'Para: '+appointments[i].identification +' - '+appointments[i].name +' - ' +appointments[i].appointment.study.name + ' Agendado por : ' + appointments[i].user.person.first_name +' '+  appointments[i].user.person.last_name,

            start: appointments[i].date_time_ini,

            end: appointments[i].date_time_end,
            editable: false,

            observation: appointments[i].appointment.observations,

                // className: ['openSesame']
                
                // startEditable: true, 

                /**
                 * Identificador de la cita de la bd appointmentDates
                 * @type Int
                 */
                 id: appointments[i].id,

                 overlap: false

               };

               $scope.events.push(evento);

             }


           }, function(error){

        //console.log(error);

      });



      }



      /* add custom event*/
    // $scope.addEvent = function() {
    //   $scope.events.push({
    //     title: 'Open Sesame',
    //     start: new Date(y, m, 28),
    //     end: new Date(y, m, 29),
    //     className: ['openSesame']
    //   });
    // };


        // $scope.addAppointment();

        // $('#setTimeExample').timepicker();
        //   $('#setTimeButton').on('click', function (){
        //       $('#setTimeExample').timepicker('setTime', new Date());
        //   });

        $scope.timeIni = '';


        console.log($scope.timeIni);


        $('#timepicker').timepicker({

          defaultTime: 'current',
          minuteStep: 5,
          secondStep: 5 
        });


        $('#timepicker').prop( "disabled", true );


        function ConvertTimeformat(format, str) {

          var time = str;

          var hours = Number(time.match(/^(\d+)/)[1]);

          var minutes = Number(time.match(/:(\d+)/)[1]);

          var AMPM = time.match(/\s(.*)$/)[1];

          if (AMPM == "PM" && hours < 12){
            hours = hours + 12;
          }

          if (AMPM == "AM" && hours == 12){

            hours = hours - 12;

          }

          var sHours = hours.toString();

          var sMinutes = minutes.toString();

          if (hours < 10) {

            sHours = "0" + sHours;

          };

          if (minutes < 10) {

            sMinutes = "0" + sMinutes;

          };


          return sHours + ":" + sMinutes;

        }







        $scope.availableMedicalOffices = undefined;

        $scope.selectedMedicalOffice = undefined;


      /**
       * Funcion que obtiene los consultorios disponibles para un servicio
       */
       $scope.getMedicalOfficesByService = function(){

          /**
           * Función que obtiene los consultorios que tienen un servicio asociado
           */
           appointmentService.getMedicalOfficesByService({studyId:$scope.study.id},function(res){


            var medicalOffices = res.medicaOffices;

            $scope.availableMedicalOffices = new Array();


                  /**
                   * Opcion predeterminada
                   */
                   $scope.availableMedicalOffices.push({

                    id    :0, 
                    
                    code  :'',  

                    name  :'Seleccione Un Consultorio',

                  });


                   var indexSelected = 0; 

                  /**
                   * Formateo de opciones de consultorio
                   */
                   for (var i = 0; i < medicalOffices.length; i++) {

                    $scope.availableMedicalOffices.push({

                      id    :medicalOffices[i].MedicalOffices.id, 

                      code  :medicalOffices[i].MedicalOffices.code,  

                      name  :medicalOffices[i].MedicalOffices.name,

                    });

                    /**
                     * Si el consultorio es igual al seleccionado de la cita para editar
                     * se selecciona por defecto esa cita
                     */
                     if($scope.study.medical_offices_id == medicalOffices[i].MedicalOffices.id){

                      console.log("cons....");

                      indexSelected = i + 1;

                    }     

                  }

                  console.log("ver:::");

                  console.log();

                  console.log($scope.availableMedicalOffices);

                  $scope.selectedMedicalOffice = $scope.availableMedicalOffices[indexSelected];

                  // console.log($scope.study.medical_offices_id);

                  // console.log($scope.availableMedicalOffices);

                  /**
                   * si no esta definido el consultorio para un servicio (no se ha agendado cita)
                   */
                  // if($scope.study.medical_offices_id == undefined){

                  //       $scope.selectedMedicalOffice = $scope.availableMedicalOffices[index];

                  // }else{

                  //       $scope.selectedMedicalOffice = $scope.availableMedicalOffices[0];
                  // }

                  $scope.changeSelectedMedicalOffice();


                }, function(error){

                 console.log(error);

               });


         }


    /**
     * objeto de seleccion de fecha para las citas
     */
     var dateAvailablePicker = $('#dateAvailablePicker');

     dateAvailablePicker.datepicker({

      format: 'yyyy-mm-dd',
      
    });


      /**
       * deteccion del evento de cambio de la seleccion de fecha
       */
       $('#dateAvailablePicker').on("changeDate", function() {

         $scope.selectedDateAvailable = $('#dateAvailablePicker').datepicker('getFormattedDate');          


        /**
         * Si la fecha no esta vacia - (tipo String)
         */

         if($scope.selectedDateAvailable != ''){

          var medicalOfficeId = $scope.selectedMedicalOffice.id;

          $('.calendar-container').removeClass('no-display');

          uiCalendarConfig.calendars['myCalendar'].fullCalendar('gotoDate',$scope.selectedDateAvailable);

          console.log($scope.selectedDateAvailable);

          $scope.getDateAgenda(medicalOfficeId,$scope.selectedDateAvailable);

          $('.btn-refresh-date-day-agenda').prop( "disabled", false );

          $( "#btn-save-appointment" ).prop( "disabled", false );

          $('.info-add-agenda').addClass('no-display');

          $('#timepicker').prop( "disabled", false );    

        }else{

          $( "#btn-save-appointment" ).prop( "disabled", true );

          $('.calendar-container').addClass('no-display');

          $('.info-add-agenda').removeClass('no-display');

          $('#timepicker').prop( "disabled", true );

          $('.btn-refresh-date-day-agenda').prop( "disabled", true );

        }


      });


      /**
       * Detección de cambio de consultorio para restringir el calendario entre las fechas permitidas
       */
       $scope.changeSelectedMedicalOffice = function(){

        var medicalOfficeId = $scope.selectedMedicalOffice.id;


        if(medicalOfficeId != 0){

          appointmentService.getAvailableDatesRangeByMedicalOffice({medicalOfficeId: medicalOfficeId},function(res){

            console.log(res);


            if(res.success){

              $('#dateAvailablePicker').datepicker("setStartDate", res.dateIni);

              $('#dateAvailablePicker').datepicker("setEndDate", res.dateEnd);

            }

          }, function(error){

            console.log(error);

          });

        }else{



          var dateIniDis = moment(new Date()).format('YYYY-MM-DD');    

          var dateEndDis = moment(new Date());    

          dateEndDis = dateEndDis.subtract(1, "days");

          dateEndDis = dateEndDis.format('YYYY-MM-DD');

          $('#dateAvailablePicker').datepicker("setStartDate", dateIniDis);

          $('#dateAvailablePicker').datepicker("setEndDate", dateEndDis);

        }


        $('#timepicker').prop( "disabled", true );

      }





      /**
       * Mostrar agenda
       */
       $scope.showModalAgenda = function(service){

        if(service.expected_date != undefined || service.expected_date != null){

          $scope.appointment.expected_date = service.expected_date.substring(0,10);
          $("[name=expected_date]").val($scope.appointment.expected_date);

        }
        

        $scope.study = service;

        console.log(service.asigned_state);


        if(service.appointmentInfo != undefined){

          console.log("info cita..");

          $scope.appointment.type = parseInt(service.appointmentInfo.type); 

          if(service.expected_date != undefined || service.expected_date != null){
            $("[name=expected_date]").val(service.expected_date.substring(0,10));
          }


          $scope.appointment.observations  = service.appointmentInfo.observations;

                /**
                 * fix para two way data binding
                 */
                 document.getElementById("orderObservations").value = service.appointmentInfo.observations;

               }else{

                /**
                 * Si no hay cita
                 */
                 $scope.appointment.type = 1; 
                 
                 $scope.appointment.observations = '';

               }          



               console.log("estudio seleccionado agenda");

               if( service.asigned_state == undefined || service.asigned_state.id == 1 || service.asigned_state.id == 2){

                            /**
             * Si esta definida una fecha de cita para el servicio actual
             */
             if($scope.study.appointmentdDateId != undefined){

              $scope.appointmentAddEditMode = false;

              $scope.appointmentInCalendar = true;

              $scope.getMedicalOfficesByService();

              var appoitmentAsignedDate = $scope.study.asigned_time;

              appoitmentAsignedDate = appoitmentAsignedDate.split(" ");

              appoitmentAsignedDate = appoitmentAsignedDate[0];

              console.log(appoitmentAsignedDate);

              $('.calendar-container').removeClass('no-display');

              $('.info-add-agenda').addClass('no-display');

              $('.btn-refresh-date-day-agenda').prop( "disabled", false );

                /**
                 * el calendario debe esperar a ser cargado para poder cargarle datos 
                 */
                 $timeout(function () {                 


                  uiCalendarConfig.calendars['myCalendar'].fullCalendar('gotoDate', appoitmentAsignedDate);


                  console.log("ver_id_consultorio----");

                  if($scope.study.medical_offices_id != undefined){

                    $scope.getDateAgenda($scope.study.medical_offices_id, appoitmentAsignedDate);

                  }

                }, 1000);

               }else{

                console.log("works?");

                console.log($scope.appointmentAddEditMode);

                $scope.appointmentAddEditMode = true;

                $scope.appointmentInCalendar = false;


                $scope.getMedicalOfficesByService();
              }            






              $('.agenda').modal('show');




            }


          }

      /**
       * cita actual para confirmar
       * @type Object
       */
       $scope.currentConfirmAppointment = undefined;

       /**
       * Mostrar agenda
       */
       $scope.showModalConfirm = function(service){

        // 
        
        $scope.currentConfirmAppointment = service;
        
        
        if(service.asigned_state.id == 1 || service.asigned_state.id == 2){



          $('.confirm').modal('show');

        }


      }

      //**
         // * Function to show the add role modal
         // */
         $scope.hideModalConfirm = function(){

          $('.confirm').modal('hide');
        }



      /**
       * Función para agregar un evento en el calendario 
       */
       $scope.addAppointment = function(){



        /**
        * Cita actual para guardar
        */
        $scope.getAppointmentId;

        // console.log('entro a la validaicon de la agenda');

        // console.log($scope.getAppointmentId);

        /**
        * Conversion de la seleccion de hora a formato de 24 horas
        * @type String
        */
        var selectedDateTime =  ConvertTimeformat("24", $scope.timeIni);

        l("--Hora de agendado de cita--");
        l($scope.selectedDateAvailable);
        l($scope.timeIni);

        /**
        * Fecha y hora seleccionada
        * @type String
        */
        selectedDateTime = $scope.selectedDateAvailable + ' '+selectedDateTime+':00';

        /**
        * Nueva fecha
        * @type {Date}
        */
        var d2 = new Date (selectedDateTime);

        /**
        * Formateo de la fecha y hora inicial seleccionada
        * @type String
        */
        var iniDate = moment(d2).format('YYYY-MM-DDTHH:mm:ss');


        var medicalOfficeId = $scope.selectedMedicalOffice.id;

        /**
        * aumento de tiempo determinado por la duracion del estudio
        */

        d2.setMinutes(d2.getMinutes() + $scope.study.average_time);

        /**
        * Formateo de la fecha y hora final seleccionado con el tiempo adicionado
        * @type String
        */
        var endDate = moment(d2).format('YYYY-MM-DDTHH:mm:ss'); 

        // Carlos Felipe Aguirre
        // cambia el rango de tiempo de un estudio si es necesario
        
        l("--Events--");
        l($scope.events);
        var fecha_evento = new Date(endDate);

        for(var i = 0; i < $scope.events.length; i++){

          var event_date_ini = new Date( $scope.events[i].start );
          var event_date_end = new Date( $scope.events[i].end   );
          

          if(event_date_ini.getTime() < fecha_evento.getTime() && event_date_end.getTime() > fecha_evento.getTime() ){

            var minutes = prompt("¿Desea reducir el tiempo del estudio\npara agendarlo en ese espacio de tiempo?\nInserte el número de minutos para el estudio", "5");

            if(minutes != null && minutes != ""){

              endDate = moment(event_date_ini);
              endDate = endDate.format("YYYY-MM-DD HH:mm:ss");
              //d2.setMinutes(d2.getMinutes() - 10);

              var minutes = prompt("Inserte el número de minutos para el estudio", "5");
              minutes = ( parseInt( minutes ) != NaN )? parseInt( minutes ) : null ;

              if(minutes <= d2.getMinutes() ){
                d2.setMinutes(minutes);
              }
              else{
                alert("El número de minutos es mayor al que es posible agendar");
              }


            }
          }

        }


        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * 2016-08-09 16:16:11
         * Formateando el valor de fecha que se enviara para consultar si hay un espacio disponible para la cita
         * @type String
         */
         console.log("++"+d2);


         var date_time_ini_check = moment(d2).format('YYYY-MM-DD HH:mm:ss');

         console.log("++"+date_time_ini_check);

        /**
         * Consulta para validar la nueva cita que se desea agregar
         */
         appointmentService.getValidationAppointment({idOffice:medicalOfficeId,idAppoinment:$scope.getAppointmentId,date_time_ini:date_time_ini_check,date_time_end:endDate},function(res){

          console.log(res);

          if(res.success){

            $scope.message = "";

                    // $scope.eventSources[0].splice(0, $scope.eventSources[0].length);
                    
                    /**
                     * Si el evento es agredado
                     */
                     if($scope.appointmentAddEditMode == true){

                       /**
                        * Se agrega el evento al calendario
                        */
                        $scope.events.push({

                            /**
                            * Titulo
                            */
                            title: $scope.study.cup + " - " + $scope.study.name,

                            /**
                            * Fecha y hora inicio
                            */
                            start: iniDate,

                            /**
                            * Fecha y hora fin
                            */

                            end: endDate,

                            color: 'rgb(108, 135, 161)',
                            
                            // className: ['openSesame']

                            /**
                            * funcionalidad de edicion de evento habilitada
                            * @type {Boolean}
                            */
                            // startEditable: true, 

                          });

                      }else{

                       /**
                        * si el evento es para ser editado, definimos su identificador obtenido previamente
                        */
                        $scope.events.push({

                            /**
                            * Titulo
                            */
                            title: $scope.study.cup + " - " + $scope.study.name,

                            /**
                            * Fecha y hora inicio
                            */
                            start: iniDate,

                            /**
                            * Fecha y hora fin
                            */

                            end: endDate,
                            
                            // className: ['openSesame']

                            /**
                            * funcionalidad de edicion de evento habilitada
                            * @type {Boolean}
                            */
                            // startEditable: true, 

                            /**
                             * identificador de la cita
                             * @type {[type]}
                             */
                             id: $scope.study.appointmentdDateId
                           });
                      }



                    /**
                    * se define que el evento esta en el calendario
                    * @type {Boolean}
                    */
                    $scope.appointmentInCalendar = true;



                  }else{

                   $scope.message =  res.message;

                 }

               }, function(error){

                console.log(error);

              });
       }








      /**
       * Funcion para obtener la cita actual
       */
       $scope.getAddedAppointment = function(){


        var calendarEvents = uiCalendarConfig.calendars['myCalendar'].fullCalendar('clientEvents'); 
        
        for (var i = 0; i < calendarEvents.length; i++) {

          if(calendarEvents[i].rendering == undefined || calendarEvents[i].rendering != 'background'){


            /**
             * Si esta en modo de agregado obtenemos el evento que no tiene un identificador definido de appointmentDates
             */

             if($scope.appointmentAddEditMode == true){


              if(calendarEvents[i].id == undefined){


                calendarEvents[i].date_time_ini = calendarEvents[i].start.format('YYYY-MM-DD HH:mm:ss');

                calendarEvents[i].date_time_end = calendarEvents[i].end.format('YYYY-MM-DD HH:mm:ss');

                return {

                  event : calendarEvents[i],
                  index : i
                };     

                break;
              }


            }else{


                /**
                 * Si esta en modo de edicion obtenemos el evento que tiene un identificador 
                 * definido de appointmentDates que es igual al del estudio actual
                 */
                 if(calendarEvents[i].id == $scope.study.appointmentdDateId){


                  calendarEvents[i].date_time_ini = calendarEvents[i].start.format('YYYY-MM-DD HH:mm:ss');

                  calendarEvents[i].date_time_end = calendarEvents[i].end.format('YYYY-MM-DD HH:mm:ss');


                  return {

                    event : calendarEvents[i],
                    index : i
                  };     

                  break;
                }


              }             


            }


          }

          return false;

        };    


        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * 2016-08-09 10:00:00
         * Funcion que actualiza los eventos de la agenda del dia seleccionado
         */
         $scope.refreshDateDayAgenda = function(){

          $scope.selectedDateAvailable = $('#dateAvailablePicker').datepicker('getFormattedDate');  

          console.log($scope.selectedDateAvailable);

          var medicalOfficeId = $scope.selectedMedicalOffice.id;

            // $scope.selectedDateAvailable
            $scope.getDateAgenda(medicalOfficeId, $scope.selectedDateAvailable);

            // console.log("is this??");

          }


        /**
         * Actualizar la cita Actual
         * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
         * @date     2016-09-12
         * @datetime 2016-09-12T16:26:18-0500
         * @return   {[type]}                 [description]
         */
         $scope.updateAppointment = function(){


          if($scope.study.appointments_id != undefined){


            $scope.appointment.id = $scope.study.appointments_id;

            $scope.appointment.medical_offices_id = $scope.selectedMedicalOffice.id;

            delete $scope.appointment.studies_id;
            // l($scope.appointment.id +' id appointment J');
            // l($scope.appointment.studies_id);

            l("--updateAppointment--  ");
            // l($scope.appointment);

            appointmentService.updateAppointment($scope.appointment, function(res){

              console.log(res);

              // l('entro a update');
              // l(res);

            },function(error){

              console.log(error);

            });

          }


        }


        

      /**
       * @author Julián Andrés Muñoz Cardozo
       *  
       * Guardar la cita
       */
       $scope.doSaveAppointment = function(){
        // Verifica que se use el campo de la fecha en que se queria la cita @Carlos Aguirre
        var date_expected = $("[name=expected_date]").val();
        var pttrDate = /[0-9]{4}-[0-9]{2}-[0-9]{2}/g;

        if( !pttrDate.test(date_expected) ){

          $(".date_expected").show(500);

          $("[name=expected_date]").focus();

          return false;
        }
        
        $(".date_expected").hide(500);

        // Ya se verifico que se usara


        l('primera parte');

        l($scope.services);

        l($scope.appointment);
        /**
         * Actualizamos la cita actual
         */

         if($scope.study.appointments_id != undefined){
          // l('entro a sentencia if doSaveAppointment');
          // l($scope.appointment);

          $scope.updateAppointment();

        }




        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * Eventos del Calendario
         * @type Array
         */
         var calendarEvents = uiCalendarConfig.calendars['myCalendar'].fullCalendar('clientEvents'); 

         console.log("object dates");
         
        /**
         * @author Julián Andrés Muñoz Cardozo
         * 
         * 2016-08-09 10:32:25
         * eventos con la hora y fecha actual para ser actualizados
         * @type {Array}
         */
         var eventsToUpdate = new Array();
         

         for (var i = 0; i < calendarEvents.length; i++) {

          if(calendarEvents[i].rendering == undefined || calendarEvents[i].rendering != 'background' && calendarEvents[i].id != undefined){


                    /**
                     * Si hay definida una cita para editar
                     */
                     if($scope.study.appointmentdDateId != undefined && $scope.study.appointmentdDateId == calendarEvents[i].id){


                      eventsToUpdate.push({

                        id:     calendarEvents[i].id, 

                        start:  calendarEvents[i].start.format('YYYY-MM-DD HH:mm:ss'), 

                        end:    calendarEvents[i].end.format('YYYY-MM-DD HH:mm:ss'),                    

                        checkForEdition: true 
                      });


                    }else{

                        /**
                         * @author Julián Andrés Muñoz Cardozo
                         * 
                         * 2016-08-12 14:24:44
                         * se pregunta solo por la citas que tienen un identificador definido 
                         * la que no lo tiene es nueva
                         */
                         if(calendarEvents[i].id != undefined){

                            /**
                             * Si no hay definida una cita para editar
                             */
                             eventsToUpdate.push({

                              id:     calendarEvents[i].id, 

                              start:  calendarEvents[i].start.format('YYYY-MM-DD HH:mm:ss'), 

                              end:    calendarEvents[i].end.format('YYYY-MM-DD HH:mm:ss')

                            });
                           }    
                         }

                       }            
                     }
              /*
             * Actualizacion de los eventos de las citas
             */
             appointmentService.updateAppointmentDates({ eventsToUpdate: eventsToUpdate, medicalOfficeId: $scope.selectedMedicalOffice.id }, function (res) {


               console.log("editada ??");

               console.log(res);

               if (res.success) {
                 $(".agenda").modal('hide');
               }

             /**
              * se edito la cita actual
              */
              if (res.editedAppointment.id != undefined) {


               console.log("editada...");

               console.log(res);

               $scope.study.appointmentdDateId = res.editedAppointment.id;

               $scope.study.asigned_time = res.editedAppointment.date_time_ini;

             }

             /**
              * Actualizacion de nueva cita o cita a editar .. ?
              */

              var appointment = $scope.getAddedAppointment();


              console.log("appointment added ... ");

              console.log(appointment);

              console.log($scope.events);

              console.log("appointment added ... ");

             /**
              * si hay una cita y el modo de agendamiento es agregado
              */
              if (appointment != false && $scope.appointmentAddEditMode == true) {

                 /**
                  * Asignación del identificador del estudio
                  * @type {[type]}
                  */
                  $scope.appointment.studies_id = $scope.study.id;

                 /**
                  * Asignacion de consultorio
                  */

                  l('Asignacion de consultorio');
                 // l($scope.selectedMedicalOffice.id);

                 $scope.appointment.medical_offices_id = $scope.selectedMedicalOffice.id;

                 $scope.appointment.studies_value = 0;

                 /**
                  * Guardado de la cita
                  */
                  appointmentService.saveAppointment($scope.appointment, function (res) {


                   console.log("res save date");

                   console.log(res);


                   if (res.success) {


                         /**
                          * identificador de la cita
                          * @type Int
                          */
                          var appointmentId = res.appointment.id;

                         /**
                          * Agregado del identificador de la cita al arreglo de identificadores
                          */
                          $scope.savedAppointmentsIds.push(appointmentId);

                          console.log("appointment ids..");

                          console.log($scope.savedAppointmentsIds);

                          console.log("end appointment ids..");

                         /**
                          * Asignacion del identificador de la cita
                          * @type {[type]}
                          */
                          $scope.appointmentDates.appointments_id = appointmentId;

                          $scope.services.medicalOffices = res.appointment.med

                          l('Asignacion del identificador de la cita');

                          l( $scope.services.medicalOffices);

                          $scope.study.appointmentInfo = {

                           type: $scope.appointment.type,
                           observations: $scope.appointment.observations
                         };



                         /**
                          * Formateo de las fechas de la cita, se quita la T indicadora de tiempo ya que no es necesaria
                          */
                          $scope.appointmentDates.date_time_ini = appointment.event.date_time_ini;

                          $scope.appointmentDates.date_time_end = appointment.event.date_time_end;

                         /**
                          * Guardado de las fechas de la cita 
                          */
                          appointmentService.saveAppointmentDates($scope.appointmentDates, function (res) {


                           console.log("fechas");

                           console.log(res);

                           if (res.success == true) {


                                 /**
                                  * @author Julián Andrés Muñoz Cardozo
                                  * 
                                  * 2016-08-09 17:11:13
                                  * asignacion del identificador de las fechas de la cita asignada
                                  */
                                  $scope.study.appointmentdDateId = res.appointmentDates.id;

                                 /**
                                  * identificador de la cita
                                  * 2016-08-09 17:11:42
                                  */
                                  $scope.study.appointments_id = appointmentId;
                                  
                                 /**
                                  * Tiempo asignado 
                                  * @type String
                                  */
                                  $scope.study.asigned_time =res.appointmentDates.date_time_ini;

                                  l(res.appointmentDates.date_time_ini);

                                  $scope.study.medicalOfficeName = $scope.selectedMedicalOffice.name;



                                 /**
                                  * Asignacion del estado de la cita: Asignada
                                  * @type {Object}
                                  */
                                  $scope.study.asigned_state = {
                                   id: 1,
                                   state: 'ASIGNADA'
                                 };


                                 // $scope.study.asigned_time = $scope.study.asigned_time.substring(0, $scope.study.asigned_time.indexOf('-'));

                                 $('.agenda').modal('hide');

                                 console.log("servicios ver");

                                 console.log($scope.services);

                                 $('.agenda').on('hidden.bs.modal', function () {

                                   $(this).find("input,textarea,select").val('').end();

                                 });

                                 $scope.timeIni = '';

                                 $scope.appointmentInCalendar = false;

                                 $("#btn-save-appointment").prop("disabled", true);

                                 $('.calendar-container').addClass('no-display');

                                 $scope.removeAppointment();

                               } else {

                                 console.log(res.message);

                               }

                             /**
                              * Guardar los productos  o servicios adicionales realacionados..
                              */

                              console.log('Entro a appointment supplies ' + appointmentId);



                              suppliesService.addAppointmentsSupplies({ id: appointmentId }, function (res) {

                               setCandoBill();

                               if (res.success) {

                                 console.log("Save productos necesarios ");
                                 console.log(res);

                               } else {
                                 console.log('Error save productos ');
                               }

                             }, function (error) {
                               console.log(error);
                             });


                            }, function (error) {
                             console.log(error);
                           });




                        } else {
                         console.log('Error no guardo y no appointment id');
                       }

                     }, function (error) {

                       console.log(error);

                     });

} else {



                 /**
                  * recarga de las citas asignadas
                  */
                  $scope.refreshDateDayAgenda();

                }






              }, function (error) {

               console.log(error);

             });





}


      /**
       * Funcion para quitar una cita graficamente del los eventos cargados del dia seleccionado
       */
       $scope.removeAppointment = function(){

        $scope.selectedMedicalOffice = "";


        console.log('entro al remove');
        
        var currentAppointment = $scope.getAddedAppointment();


        console.log(currentAppointment);

        $scope.events.splice(currentAppointment.index,1);
        
        $scope.appointmentInCalendar = false;   

      }


        /**
         * Buscar una cita
         */
         $scope.getAppointment = function(id){

          appointmentService.getAppointment({id:id},function(res){

            console.log(res);


          }, function(error){

            console.log(error);

          });

        }


        


        /**
         * Buscar una cita por el estado para confirmar
         */
         $scope.confirmAppointment = function(){

            /**
             * Identificador de la cita
             * @type Int
             */

             var id = $scope.currentConfirmAppointment.appointments_id;

             appointmentService.getAppointmentDates({id:id},function(res){

              console.log(res);

              if(res.success){
            //Permite cambiar el estado de la cita sin tener que recargar la pàgina            
            for(var i= 0 ; i< $scope.services.length; i++ ){
              if($scope.services[i].appointments_id == id){
                $scope.services[i].asigned_state.id=3;
                $scope.services[i].asigned_state.state="Confirmada";
              }

            }
            $('.confirm').modal('hide');


          }
        }, function(error){
          console.log('--confirmAppointment--');
          console.log(error);
          return false;
        });   
           }


        /**
         * Función que elimina una cita
         */
         
         $scope.deleteAppointment = function(id,service){

          appointmentService.deleteAppointment({id:id},function(res){

            console.log(res);

            $scope.removeAppointment();


          }, function(error){

            console.log(error);

          });

        }




  /**
   * End appointments functions
   */


   /**
    * Deteccion de evento de teclado para la tecla enter para el campo de busqueda de identificación
    */
    $scope.enterPressed = function($event){

      if($event != undefined && $event != null){
        var keyCode = $event.which || $event.keyCode;

        if (keyCode === 13) {

                /**
                 * Buscar el paciente
                 */
                 $scope.searchPatients();
               }
             }

           }


   /**
    * @author Julián Andrés Muñoz Cardozo
    * 2016-09-07 16:57:28
    * funcionalidad archivos de la orden
    */

    /**
     * Archivo de foto para el paciente
     */
     $scope.photoPeople;

    /**
     * Arreglo de arvhivos de una orden
     * @type {Array}
     */
     $scope.myFiles = [];

    /**
     * Archivos guardados para mostrar 
     * @type {Array}
     */
     $scope.savedFiles = [];


    /**
     * Subir Archivos
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T14:56:50-0500
     * @return   {[type]}                 [description]
     */
     $scope.uploadFiles = function(){

      var files = $scope.myFiles;
      console.log('GUARDAR ARCHIVOS ');

        /**
         * @author Julián Andrés Muñoz Cardozo
         * 2016-09-07 16:57:28
         * si la orden esta definida
         */
         if($scope.order.id != 0 && $scope.order.id != undefined){

          fileUpload.uploadOrderFiles({orderId: $scope.order.id }, files, function(res){

            console.log(res);

            $scope.myFiles = [];

            $scope.savedFiles = res.savedFiles;

          }, function (error) {
          });

        }

      };


    /**
     * obtener archivos de la orden
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T14:56:42-0500
     * @return   {[type]}                 [description]
     */
     $scope.getOrderFiles = function(){

      console.log("Obtiene order files");

      ordersService.getOrderFiles({orderId: $scope.order.id }, function(res){

        $scope.savedFiles = res.savedFiles;
        console.log($scope.savedFiles);

      });
    }




    /**
     * Eliminar archivo de una orden
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T14:56:35-0500
     * @param    {[type]}                 resourceId [description]
     * @return   {[type]}                            [description]
     */
     $scope.dropFile = function(resourceId){

      ordersService.dropOrderFile({resourceId:resourceId, orderId: $scope.order.id}, function(res){

        $scope.getOrderFiles();       

      });

    }
    

   /**
    * evento para dar click a la entrada de archivos
    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
    * @date     2016-09-13
    * @datetime 2016-09-13T14:56:27-0500
    * @return   {[type]}                 [description]
    */
    $scope.triggerClickUpload = function(){

      angular.element(document.querySelector('#uploadFilesInput')).click();

    }


    /**
     * Funcion para Subir la foto del paciente
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T14:56:14-0500
     * @return   {[type]}                 [description]
     */
     $scope.uploadPeoplePhoto = function(){


        /**
         * Si hay algun archivo para enviar
         */
         var typeOfFile = typeof $scope.photoPeople;  
         
         if(typeOfFile != 'undefined'){

           var file = $scope.photoPeople;

           fileUpload.uploadPhotoPatient({peopleId: $scope.people.id }, file, function(res){

            console.log(res);



          }, function (error) {

          });

         }


       };



    /**
     * Julián Andrés Muñoz Cardozo
     * 2016-09-07 16:13:22
     * Obtener foto de perfil de un usuario
     */

     $scope.getPeoplePhoto = function(){

      if($scope.people.id != undefined){
            //peopleId
            ordersService.getPhotoPeople({id: $scope.people.id }, function(res){


              if(res.success == true){

                console.log("photoPeople...");

                $scope.image_source = res.picture.url;

              }else{


                console.log("photoPeople...");

                $scope.image_source = undefined;

              }



            }, function (error) {

            });

          }  

        };

    /**
     * obtener foto de archivo
     */
     $scope.getPeoplePhoto();


   /**
    * Evento para la carga de la foto de perfil
    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
    * @date     2016-09-13
    * @datetime 2016-09-13T14:57:51-0500
    * @return   {[type]}                 [description]
    */
    $scope.triggerClickUploadPhoto = function(){

      angular.element(document.querySelector('#uploadPhotoPatient')).click();

    }

   /**
    * vista previa de archivos
    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
    * @date     2016-09-13
    * @datetime 2016-09-13T14:58:01-0500
    * @param    {[type]}                 element [description]
    */
    $scope.setFile = function(element) {

      $scope.currentFile = element.files[0];
      
      var reader = new FileReader();

      reader.onload = function(event) {

        $scope.image_source = event.target.result
        
        $scope.$apply()

      }

      // when the file is read it triggers the onload event above.
      reader.readAsDataURL(element.files[0]);
      
    }

    /**
     * error en codigo cie 10
     * @type {Boolean}
     */
     $scope.cieTenCodeError = false;

   /**
    * Guardado de la nueva orden
    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
    * @date     2016-09-13
    * @datetime 2016-09-13T14:58:12-0500
    * @return   {[type]}                 [description]
    */
    $scope.saveOrder = function(){


        /**
         * reseteamos el error de codigo cie 10
         * @type {Boolean}
         */
         $scope.cieTenCodeError = false;
         console.log('ingreso a guardar una orden ');
         console.log($scope.orderHasBill);
         // if(!$scope.orderHasBill){
          console.log('INGRESO GUARDAR ORDEN HAY FACTURA '+ $scope.orderHasBill);

          $scope.order.cost_centers_id = $scope.selectedSpecialization;

        /**
         * Edicion o agregado de la orden, el lado del servidor se encarga de editar o agregar sea el caso
         * @author Julián Andrés Muñoz Cardozo
         * 2016-08-09 08:07:21
         */
         ordersService.saveOrder($scope.order,function(res){

          $('[ng-click="doSaveOrder()"]').prop('disabled', false);
          console.log("order saved?");

          console.log(res);

          if( res.success ){
            $scope.canDoBill = false;
            setCandoBill();
              //$scope.order.bill_types_id = res.order.bill_types_id;
            }

                /**
                 * Si hay errores
                 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                 */
                 if(res.errors != undefined){


                  console.log("errores");

                    /**
                     * Si hay error en el codigo cie 10
                     */
                     if(res.errors.cie_ten_codes_id != undefined){


                      console.log("errores ..... ");

                      $scope.cieTenCodeError = true;

                    }
                  }


                  console.log("order saved? end");

                /**
                 * Si se guardo o se edito
                 */
                 if(res.success == true){

                  console.log("guardo orden");

                  $("button[title=Confirmar]:disabled").removeAttr('disabled');

                  $scope.order.id = res.order.id;

                    /*
                     * Guardar la relacion de detalle de orden con la/s citas
                     */ 
                     appointmentService.saveOrderAppointment({order_details_id: $scope.order.id,appointments_ids:$scope.savedAppointmentsIds},function(res){

                      console.log("res saved order details appointments");

                      if(res.success == true){

                        $scope.numberAddedAppoinments = res.total;

                            /**
                             * Reseteo del arreglo de identificadores de nuevas citas agregadas
                             * @author Julián Andrés Muñoz Cardozo
                             * 2016-08-09 08:17:22
                             * @type {Array}
                             */
                             $scope.savedAppointmentsIds = new Array();

                            /**
                             * Archivos de la orden
                             * @type {[type]}
                             */
                             var files = $scope.myFiles;

                             /**
                              * Si hay archivos para enviar
                              * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                              * @date     2016-09-13
                              * @datetime 2016-09-13T14:54:08-0500
                              * @param    {[type]}                 files.length >             0 [description]
                              * @return   {[type]}                              [description]
                              */
                              
                              if(files.length > 0){

                               fileUpload.uploadOrderFiles({orderId: $scope.order.id }, files, function(res){

                                $scope.myFiles = [];

                                    /**
                                     * mostrar modal con informacion al usuario 
                                     */
                                     $scope.showSaveOrder();

                                     setCandoBill();

                                     $scope.savedFiles = res.savedFiles;

                                   }, function (error) {

                                   });

                             }else{
                                /**
                                     * mostrar modal con informacion al usuario 
                                     */
                                     $scope.showSaveOrder();
                                   }                       

                                 }


                               }, function(error){

                                 console.log(error);

                               });

                   }
                   else{
                    console.log('No Guardo Nada De Orden');
                    $('[ng-click="doSaveOrder()"]').prop('disabled', false);
                  }


                }, function(error){

                 console.log(error);
                 $('[ng-click="doSaveOrder()"]').prop('disabled', false);

               });

// }else{
//      /**
//      * mostrar modal con informacion al usuario 
//      * */
//      console.log('YA HAY UNA FACTURACION ??? '+ $scope.orderHasBill); 
//    //  $scope.showSaveOrder();
//     }
}

$scope.savePreOrderDetail = function(){


        /**
         * Nuevo nombre de especialista 
         */
         var newSpecialistName = document.getElementById("specialists_value").value;

        /**
         * Si se ha encontrado el especialista
         */
         if($scope.foundServiceExtSpe != undefined){


          $scope.order.external_specialists_id = $scope.foundServiceExtSpe.originalObject.id;

          console.log('savePreOrderDetail');
          $scope.saveOrder();

            /** 
             * Si no se encuentra el especialista
             */
           }else{


            if(newSpecialistName == ''){

                /**
                 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                 * correccion ya que estaba en mayusculas y no es bueno mostrarlo para el usuario
                 * 2016-09-16 15:30:25
                 */
                // $scope.errorSpecialist = 'DEBE INGRESAR UN ESPECIALISTA.';

                $scope.errorSpecialist = 'Debe ingresar un especialista';

              }else{

                $scope.errorSpecialist = '';
                /**
                 * Guardado del especialista cuando no se ha encontrado
                 */
                 externalSpecialistsService.addSpecialist({name:newSpecialistName},function(res){


                  if (res.success == true){

                    $scope.order.external_specialists_id = res.specialist.id;

                    $scope.saveOrder();

                  }else{

                    console.log('error');
                  }

                }, function (error) {

                  console.log(error);

                });


               }




             }

           }



           $scope.savePatient = function(){



           }



/**
 *                                                      INICIO MODULO DE FACTURACION 
 * Cambio en facturacion
 * @type {Object}
 */

        /**
         * Calcular el valor de a cuerdo a la cantidad ingresada.
         * @param  {[type]} item [description]
         * @return {[type]}      [description]
         */
         $scope.changeCant = function(item){

           l( 'changeCant()' );
        // console.log('res ITEM ENVIADO A EDICION');
        // console.log(item.supplies != null);

        // if(item.supplies != null){

          var index = item.index;
          item.cost = item.valor * item.cant;
          if( item.supplies != null ){
            item.supplies.quantity = item.cant;
            item.supplies.cost = item.cost;


                 // $scope.factServices[index] = item;
                //  suppliesService.editAppointmentsSupplies({id:item.supplies.id,quantity:item.supplies.quantity,cost:item.supplies.cost},function(res){
                //   if(res.success){ 
                //   }
                // });
              }else{

               // item.supplies = new Object();
               // item.supplies.quantity = item.cant;
               // item.supplies.cost = item.cost;

             }
             $scope.doCalculateSubtotal();


           }
/**
 * Muestra por en pantalla los items a facturar 
 * @param {[type]} items    [description]
 * @param {[type]} services [description]
 */
 function addItems (items, services){

   l('addItems()');
   l( $scope.factServices );

   var studies = $scope.factServices;

   var allItemsFact = new Array();
   var cont  = 0;

   for (var i = studies.length - 1; i >= 0; i--) {

    studies[i];
    cont++;
    studies[i].index = cont;
    studies[ i ].isService = false;
    allItemsFact.push(studies[i]);

    for (var j = items.length - 1; j >= 0; j--) {


      if(studies[i].service.appointments_id == items[j].supplies.appointments_id){
       cont++;
       items[j].index = cont;
       items[ j ].isService = true;

       allItemsFact.push(Object.assign({},  items[j]));

     }
     else{}

   }
}

console.log( 'ITEMS' );
l( $scope.factServices );
$scope.factServices = allItemsFact;

$scope.doCalculateSubtotal(); // calcular subtotales


}



function itemsBillsServices(items){
  l( 'itemsBillsServices()' );
  var itemBills = new Array();
        // obtiene los productos asociados y el total real consumido.
        // appointmentService.getByIdAppointmentsSupplies({idAppointment:$scope.services[i].appointments_id},function(res){
          var count = 0;
          suppliesService.getByIdAppointmentsSupplies({idAppointment:items, rates_id: $scope.selectedRate},function(res){

             // console.log("get  productos necesarios ");

             // console.log(res);

             if( res.success){
              var product = res.appointmentsSupply;
        //        console.log('Todos los productos necesarios');
        //      console.log(product);

        for (var j = product.length - 1; j >= 0; j--) {
          product[j];
          var cont = false;
          count +=1;



          var detail = new Array();
          detail['id'] = product[ j ].products_study.product.id;
          detail['index'] = count;
          detail['ref'] = product[j].products_study.product.cup;
          detail['desc'] = product[j].products_study.product.name;


          if( !product[j].products_study.service.type  || product[j].products_study.service.type == ""){
            detail['type2'] = "0";
          }
          else{
            detail['type2'] = product[j].products_study.service.type;
          }


          detail['cant'] = product[j].quantity;
          detail['valor'] =  product[j].products_study.product.value;
          if(product[j].cost != 0){
            detail['cost'] = product[j].cost;

          }else{
            detail['cost'] = product[j].products_study.product.value * product[j].quantity;
            cont= true;
          }
            detail['type'] = true; // producto
            detail['service'] = null;
            detail['supplies'] = product[j];
            detail = Object.assign({}, detail);




            
            var existe;
            if(itemBills[0]){

              for(var i =0; i < itemBills.length; i++ ){

                if( itemBills[i].ref == detail['ref']) {

                  existe = true;

                }

              }

            }

            if(!existe){

              itemBills.push(detail);

              if(cont){
                $scope.changeCant(detail);
              }

            }

            
          }

        }


        addItems(itemBills, items);


      }, function(error){

       console.log(error);

     });

        }


    /**
     * Obtiene la lista de estudios para mostrar en detalles facturacion
     * @return {[type]} [description]
     */
     $scope.detailsBills = function(){
       l('detailsBills()');
       var itemBills = new Array();
       var count = 0;
       var ids = new Array();

       var existe;
       var b;
       for (var i = $scope.services.length - 1; i >= 0; i--) {
        count +=1;


        if($scope.services[i].asigned_state != undefined && $scope.services[i].asigned_state.id != 4){


          var detail = new Array();

                // adicionar Studio a items de facturacion..
                detail['id']  =  $scope.services[i].id;    
                detail['index'] = count;
                detail['ref'] = $scope.services[i].cup;
                detail['desc'] = $scope.services[i].name;
                detail['cant'] = 1;
                detail['valor'] = $scope.services[i].cost;
                detail['cost'] = $scope.services[i].cost;
                detail['type'] = false; // studio
                detail['service'] = $scope.services[i];
                detail['supplies'] = null;
                
                detail = Object.assign({}, detail);
                
                if(itemBills[0]  ){
                  for(b=0 ; b < itemBills.length; b++){
                    if(itemBills[b].ref == detail['ref']){
                      existe =true;
                    }
                  }
                }

                if(!existe){

                  itemBills.push(detail);
                  ids.push($scope.services[i].appointments_id);

                }
                
              }

              itemsBillsServices(ids);

              $scope.factServices  = itemBills;

              console.log('entro a calcular subtotal ');

              $scope.doCalculateSubtotal();                

            }

          }


/**
 * [validateForms description]
 * @author Jefry Jhonatan Londoño
 * @date     2016-11-28
 * @datetime 2016-11-28T15:44:40-0500
 * Este metodo valida los campos antes de realizar un guardar
 * @return   {[type]}                 
 * 
 */
 $scope.validateForms = function(){

  l($scope.appointmentDates.appointments_id + ' info en services');

  l($scope.services);

  l($scope.services.length);

  if($scope.services.length > 0){

   // l('entro por que '+ $scope.services.length + $scope.services[0].asigned_time);

   for (var i = 0; i < $scope.services.length; i++) {

    if($scope.services[i].asigned_time == ""){

      return 'Agendado';

    }

  }

    //return 'Agendado';

  }




  if( !$scope.people.first_name ){
    return "Nombre";
  }


  if( !$scope.people.last_name ){
    return "Apellido";
  }

  if( !$scope.selectedTypeId ){
    return "Tipo de Documento";
  }

  if( !$scope.selectGender && !$('[ng-model=selectGender]').val() ){
    return "Género";
  }


  if( !$scope.people.birthdate){
    return "Fecha de nacimiento";
  }

  if( !$scope.order.calculated_age){
    return "Edad";
  }

  if( !$scope.people.phone ){
    return "Teléfono";
  }

  if( !$scope.selectedDepatment ){
    return "Departamento";
  }

  if( !$scope.selectedMunicipalitie ){
    return "Municipio";
  }

  if( !$scope.selectedZone ){
    return "Zona";
  }

  if( !$scope.selectedDepatment ){
    return "Departamento";
  }

  if( !$scope.people.address ){
    return "Dirección";
  }

  if( !$scope.selectedRegimes ){
    return "Régimen";
  }

  if( !$scope.selectedEps ){
    return "EPS";
  }

  if( !$scope.patient.affiliation_type ){
    return "Tipo de afiliación";
  }

  if( !$('#_value').val() ){
    return "Diagnóstico";
  }

  if( !$scope.selectedSpecialization ){
    return "Centro de Costos";
  }

  if( !$scope.orderDate ){
    return "Fecha";
  }

  if( !$scope.selectedCenter ){
    return "Sede";
  }

  if( !$scope.selectedClient ){
    return "Cliente";
  }

  if( !$scope.selectedRate ){
    return "Tarifa";
  }

  if( !$scope.selectedServiceType ){
    return "Tipo de servicio";
  }

  if( !$('#specialists_value').val() ){

    var algo = $('#specialists_value').val();
    l('entro ' + algo );
    return "Especialista";
  }

  if( !$scope.order.consultation_endings_id ){
    return "Finalidad";
  }

  if ($scope.services.length == 0) {

    return "Asignar Servicios";

  }

 // if ($scope.services.asigned_time) {}

 return true;


}

/**
 * [validateFormsOnlyPeople description]
 * @author Jefry Jhonatan Londoño
 * @date     2016-11-28
 * @datetime 2016-11-28T16:20:06-0500
 * @return   true si los campos requeridos estan dilegenciados
 * Valida que los campos del formulario que son requeridos sean 
 * validados antes de proceder a guardar o modificar
 */
 $scope.validateFormsOnlyPeople = function(){


  if( !$scope.people.first_name ){
    return "Nombre";
  }


  if( !$scope.people.last_name ){
    return "Apellido";
  }

  if( !$scope.selectedTypeId ){
    return "Tipo de Documento";
  }

  if( !$scope.selectGender && !$('[ng-model=selectGender]').val() ){
    return "Género";
  }


  if( !$scope.people.birthdate){
    return "Fecha de nacimiento";
  }

  if( !$scope.order.calculated_age){
    return "Edad";
  }

  if( !$scope.people.phone ){
    return "Teléfono";
  }

  if( !$scope.selectedDepatment ){
    return "Departamento";
  }

  if( !$scope.selectedMunicipalitie ){
    return "Municipio";
  }

  if( !$scope.selectedZone ){
    return "Zona";
  }

  if( !$scope.selectedDepatment ){
    return "Departamento";
  }

  if( !$scope.people.address ){
    return "Dirección";
  }

  if( !$scope.selectedRegimes ){
    return "Régimen";
  }

  if( !$scope.selectedEps ){
    return "EPS";
  }

  if( !$scope.patient.affiliation_type ){
    return "Tipo de afiliación";
  }



  return true;


}


// [{"id":37,"cup":"870004","name":"RADIOGRAFIA DE SILLA TURCA",
// "specializations_id":1,"average_time":5,"type":"0","format_types_id":4,
// "coments":"","radiation_dose":0,"instructives":[],"studies_informed_consents":[],

// "specialization":
// {"id":1,"specialization":"RADIOLOGÍA GENERAL DE CRÁNEO","created":null,
// "modified":null,"code":"87.0.0","cost_centers_id":5,

// "cost_center":
// {"id":5,"name":"RAYOS X",
// "code":"1005","business_units_id":1}

// },

// "products":[],"cost":35280,
// "asigned_time":"2016-12-29 11:10:00 a.m.",
// "appointmentInfo":{"type":1,"observations":""},"appointmentdDateId":12203,
// "appointments_id":6653,"asigned_state":{"id":1,"state":"ASIGNADA"}}] 



   /**
    * Funcion que guarda la orden 
    */
    $scope.doSaveOrder = function(){

        // desabilita el boton mientras se procesa el almacenamiento de la orden
        //$('[ng-click="doSaveOrder()"]').prop('disabled', true);

        var validado = $scope.validateForms();
        if( validado !== true ){

          $scope.error_message = "El campo "+validado+" no se ha ingresado";
          $('#error_message').show(500);
          return;
        }
        $('#error_message').hide(500);


        /**
         * Asignacion de identificacion del campo de busqueda
         * @type Int
         */
         
         $scope.people.identification = $scope.searchPeople.identification;

         $scope.changeSelectedCenter();

         console.log($scope.people);
         
         
            //si el usuario no es un paciente y ya esta registrado 
            if($scope.patient == undefined){
            //se encarga de guardarlo en la tabla paciente
            
            if($scope.people.patients.length == 0 && $scope.people.patients.id != 0){

              $scope.patient.people_id = $scope.people.id;
              $scope.patient.users_id = $scope.people.users[0].id;



              $scope.addOnlyPatient();
            }   
          }

            /**
             * Si el paciente no existe
             */        

             if($scope.people.id == 0){

                /**
                 * Agregado de paciente
                 */
                 $scope.addPeople();


               }else{


                $scope.doEditPeople();

                /**
                 * cuando se encuentra el paciente - Edicion del paciente
                 */
                 
               }



             }

    /**
     * Funcion que guarda solo el paciente
     */
     $scope.saveOnlyPatient = function(){

      var validado = $scope.validateFormsOnlyPeople();
      if( validado !== true ){
          //l("entro aca--");
          //l(validado);
          $scope.error_message = "El campo "+validado+" no se ha ingresado";
          $('#error_message').show(500);
          return;
        }
        $('#error_message').hide(500);

        /**
         * Asignacion de identificacion del campo de busqueda
         * @type Int
         */
         $scope.people.identification = $scope.searchPeople.identification;

        //si el usuario no es un paciente y ya esta registrado 
        //se encarga de guardarlo en la tabla paciente
        console.log($scope.people);
        
        if( $scope.people.patients != undefined && $scope.people.patients.length == 0 && $scope.people.patients.id != 0){

          $scope.patient.people_id = $scope.people.id;
          $scope.patient.users_id = $scope.people.users[0].id;

          console.log('--0');

          l('entra a añadir');

          $scope.addOnlyPatient();

        }else{

          // $scope.patient.people_id = $scope.people.id;
          // $scope.patient.users_id = $scope.people.users[0].id;
          l('entra a añadir nuevamente');
          //$scope.addOnlyPatient();

        }
        
            /**
             * Si el paciente no existe
             */
             

             if($scope.people.id == 0){

                /**
                 * Agregado de paciente
                 */
                 
                 $scope.addOnlyPeople();

               }else{

                /**
                 * cuando se encuentra el paciente - Edicion del paciente
                 */
                 
                 $scope.editOnlyPeople();

               }
             }


    /**
       * [selectedDate description]
       * @type {[type]}
       */
       $scope.selectedDate = moment(new Date()).format('YYYY-MM-DD, HH:mm:ss');

      /**
       * Instance timePicker
       */
       $('#timepicker').timepicker();



     /**
      * [getBillTypes description]
      * @return {[type]} [description]
      */
      $scope.getBillTypes = function(){

        attentionPatientService.getBilltypes(function(res){

          $scope.billTypes = res.billTypes;

          if($scope.order.bill_types_id !=undefined){



            $scope.payment.bill_types_id = $scope.order.bill_types_id;

          }else{
                    //$scope.order.bill_types_id =1;
                    $scope.payment.bill_types_id == ""; 
                  }

                });

      }

      $scope.getBillTypes();

     //$scope.selectBillPay = undefined;

     /** [getFormPay description] */
     $scope.getFormPay = function(){

      attentionPatientService.getFormPayments(function(res){


        $scope.formTypes = res.formPayment;
        
        $scope.payment.form_payments_id = 1;

      });

    }

     //console.log();

     $scope.getFormPay();

     $scope.subTotal = 0;


     /**
      * Función que calcula el subtotal de la factura
      */
      $scope.doCalculateSubtotal = function(){

        l("doCalculateSubtotal");
        l($scope.factServices);
        $scope.subTotal = 0;

        for (var i = 0; i < $scope.factServices.length; i++) {
          console.log('Calcular costo');
          if( !$scope.factServices[i] ){
            continue;
          } 
          $scope.subTotal += $scope.factServices[i].cost;
        }

        $scope.calculateTotalCopay();



      }


    // Obtiene los detalles de la factura en caso de 
    // que la orden ya la posea
    // Carlos Felipe Aguirre Taborda 2016-11-05

    $scope.getBillDetails = function(){

      l( 'getBillDetails' );

      BillDetailsService.getBillDetails(

        {orderConsec: $scope.order.order_consec},

        function(res){

         if( res.success ){

          l('datos factura ');

          l(res.respuesta);

          for( var index in res.respuesta ){

            res.respuesta[ index ].index = parseInt( index  ) + 1;              

          }

          $scope.factServices = res.respuesta;

        }
        
      },
      function(res){

        l("error getBillDetails");
        l(res);

      }
      );

    }


    //  Verifica si la orden necesita authorización y
    //  si es así verifica que ya este autorizada para
    //  facturarla
    //  Carlos Felipe Aguirre Taborda 2016-11-11 09:11:25

    $scope.getAuthorization = function(){
      l('getAuthorization()');
      l($scope.selectedRates);
      if($scope.selectedRates.require_authorization != 1  ){

        $scope.authorized = true;
        
      }

      OrdersAuthorizationService.isAuthorized(
        {"orders_id" : $scope.orderId.id},

        function(res){

          if( res.result ){

            $scope.authorized = true;

          }else{
            $scope.authorized = false;
          }
          
        },
        function(res){

          l("--isAuthorized--error");
          l(res);
          
        }
        );

      if( !$scope.authorized ){
        $scope.authorized = false;
      }


    }




    
    /** [showInvoice description] */

    $scope.showInvoice = function(){


        /**
         * Valida si ya se tiene una facturacion para esta orden.
         */
         $scope.doesOrderHasBill();
        // validar si si funciona
        // Deicy R


        
        $scope.getAuthorization();

        if( !$scope.authorized ){
          $('.not-authorized').modal('show');
          return;
        }





        if( $scope.orderHasBill ){

          $scope.getBillDetails();
          
          $scope.doCalculateSubtotal();
          
          $('.bill-patient').modal('show');
          
          return;
        }

        /**
         * Calculo de subtotal
         */
         $scope.doCalculateSubtotal();

        /**
         * Calculo Total del copago primera vez
         */
         $scope.calculateTotalCopay();
         
         


            //-------------------------- validar cambio modelo facturacion   ------------------------------------------------
            $scope.detailsBills();
            
            $('.bill-patient').modal('show');
            $scope.$apply();


          }

     /**
      * [hideInvoice description]
      * @return {[type]} [description]
      */
      $scope.hideInvoice = function(){

        $('.bill-patient').modal('hide');

      }

      $scope.selectedDateExpire = moment(new Date()).format('YYYY-MM-DD');

      $(document).ready(function() {
        $('#myFormWizard').bootstrapWizard({
          onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            // If it's the last tab then hide the last button and show the finish instead
            if ($current >= $total) {
              $('#myFormWizard').find('.pager .next').hide();
              $('#myFormWizard').find('.pager .finish').show();
              $('#myFormWizard').find('.pager .finish').removeClass('disabled');
            } else {
              $('#myFormWizard').find('.pager .next').show();
              $('#myFormWizard').find('.pager .finish').hide();
            }

            var li = navigation.find('li.active');

            var btnNext = $('#myFormWizard').find('.pager .next').find('button');
            var btnPrev = $('#myFormWizard').find('.pager .previous').find('button');

            // remove fontAwesome icon classes
            function removeIcons(btn) {
              btn.removeClass(function(index, css) {
                return (css.match(/(^|\s)fa-\S+/g) || []).join(' ');
              });
            }

            if ($current > 1 && $current < $total) {

              var nextIcon = li.next().find('.fa');
              var nextIconClass = nextIcon.attr('class').match(/fa-[\w-]*/).join();

              removeIcons(btnNext);
              btnNext.addClass(nextIconClass + ' btn-animated from-left fa');

              var prevIcon = li.prev().find('.fa');
              var prevIconClass = prevIcon.attr('class').match(/fa-[\w-]*/).join();

              removeIcons(btnPrev);
              btnPrev.addClass(prevIconClass + ' btn-animated from-left fa');
            } else if ($current == 1) {
                // remove classes needed for button animations from previous button
                btnPrev.removeClass('btn-animated from-left fa');
                removeIcons(btnPrev);
              } else {
                // remove classes needed for button animations from next button
                btnNext.removeClass('btn-animated from-left fa');
                removeIcons(btnNext);
              }
            }
          });
      });


//--------------------------------- alerts and modal for input orders or days orders ------------------------------------

/** [showSaveOrder description] */
$scope.showSaveOrder = function(){

  $('.save-Order-Options').modal('show');

}

    /**
     * Ir a Ordenes
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-12
     * @datetime 2016-09-12T16:59:26-0500
     * @return   {[type]}                 [description]
     */
     $scope.goToOrderList = function(){


      $('.save-Order-Options').modal('hide');

      $timeout(function () {

        $state.go('app.ordersList');

      }, 500);

    }

    /**
     * [resetGoToAngend description]
     * @return {[type]} [description]
     */
     $scope.resetGoToAngend = function(){


      $localStorage.order = undefined;

      location.reload();



    }

    $scope.reloadAgendamiento = function(){


      $localStorage.order = undefined;

      location.reload();

    }


//--------------------------------- alerts and modal for input orders or days orders ---------------------------------------------

    /**
     * Valor a cancelar
     * @type {Number}
     */
     
   //  $scope.cancelValue = 0;
   
     /**
      * Valor del descuento
      * @type {Number}
      */
    // $scope.tempDiscount = 0;
    
     /**
      * Valor de la donacion.
      * @type {Number}
      */
    // $scope.tempDonation = 0;

     /**
      * Calcular descuento a realizar.
      * @param  {[type]} percent [description]
      * @return {[type]}         [description]
      */
      $scope.calculateDiscountCancelValue = function(percent){

        if(percent != undefined){

          $scope.order.discount = (($scope.cancelTotal /100) * percent);

          $scope.tempDiscount = $scope.order.discount;

        }else{   
         $scope.order.discount = $scope.tempDiscount;
       }

      //  $scope.cancelValue = $scope.cancelTotal - $scope.order.discount - $scope.order.donation; 
      $scope.calculateRemainingBalance();

    }



     /**
      * Validar  Descuento
      * @return {[type]} [description]
      */
      $scope.doCalnculateDiscountCancel = function(){

        if($scope.tempDiscount != undefined){

          var text = $scope.tempDiscount + '';

          var numb = $scope.validatePercent(text);


          if(numb != undefined)
          {  

            $scope.calculateDiscountCancelValue(numb);

          }else{

            $scope.calculateDiscountCancelValue();
          }

        }

        else{

          $scope.calculateDiscountCancelValue(0);

        }

      }
    /**
     * Validar Donacion
     * @return {[type]} [description]
     */
     $scope.doCalnculateDonationCancel = function(){

      l($scope.tempDonation);

      if($scope.tempDonation != undefined){

        var text = $scope.tempDonation + '';

        var numb = $scope.validatePercent(text);

        if(numb != undefined)
        {  

          $scope.calculateDonationCancelValue(numb);
          

        }else{

          $scope.calculateDonationCancelValue();

        }

      }

      else{

        $scope.calculateDonationCancelValue(0);

      }

    }


    /**
      * Calcular Donacion a realizar.
      * @param  {[type]} percent [description]
      * @return {[type]}         [description]
      */
      $scope.calculateDonationCancelValue = function(percent){

        if(percent != undefined){

          $scope.order.donation = (($scope.cancelTotal /100) * percent);



          $scope.tempDonation  = $scope.order.donation;


        }else{ 

         $scope.order.donation = $scope.tempDonation;

       }

        // $scope.cancelValue = $scope.cancelTotal - $scope.order.discount - $scope.order.donation; 
        
        $scope.calculateRemainingBalance();


      }




      $scope.doCalculateTotalCopay = function(){



        l($scope.cancelTotal + " total j");

        if($scope.cancelTotal != undefined){

          var text = $scope.cancelTotal + '';

          var numb = $scope.validatePercent(text);

          if(numb != undefined)
          {  

            $scope.calculateTotalCopayValue(numb);

          }else{

            $scope.calculateTotalCopayValue();
          }

        }

        else{

          $scope.calculateTotalCopayValue(0);

        }

      }



    /**
     * [calculateTotalCopayValue description]
     * @author Jefry Londoño <jjmb2789@gmail.com>
     * @date     2016-12-28
     * @datetime 2016-12-28T14:39:10-0500
     * @param    {[type]}                 percent [description]
     * @return   {[type]}                         [description]
     */
     $scope.calculateTotalCopayValue = function(percent){

      if(percent != undefined){

        $scope.order.total = parseFloat(($scope.subTotal /100) * percent).toFixed(0);

        l('subtotal: '+$scope.subTotal);
        l('porcentaje: '+percent);
        l('total: '+ (($scope.subTotal /100) * percent));

        $scope.cancelTotal  = $scope.order.total;


      }
       //  else{   

       // }

        // $scope.cancelValue = $scope.cancelTotal - $scope.order.discount - $scope.order.donation; 
        
       // $scope.calculateRemainingBalance();
       $scope.calculateTotalCopay();

     }







     $scope.calculateTotalCopay = function(){

        // tipo de pago 1 = copago
        $('#error_message_bills').hide(500);
        
        if($scope.payment.bill_types_id == 1){

          var aux = parseInt($scope.subTotal) - parseInt($scope.cancelTotal);

          if(aux >= 0 ){

            $scope.order.total =  aux;

            $scope.payment.debit =  $scope.cancelValue;

            $scope.calculateRemainingBalance();


          }else{


            $scope.error_message_bills = "El campo Valor a Cancelar registra un valor mayor al SubTotal";
            $('#error_message_bills').show(500);

            $scope.validatePorcentage = 1;
            return;

          }



          if(isNaN($scope.cancelValue)){

            l($scope.cancelValue +' estado cancelValue');

            $scope.validatePorcentage = 1;

            l($scope.validatePorcentage);

          }else{

            $scope.validatePorcentage = 0;

          }

          

        }else{

          $scope.payment.debit =  $scope.cancelValue;

          $scope.order.total =  0;

          $scope.calculateRemainingBalance();


        }

        
      }


      /**
      * Calcular Saldos con descuento
      * @return {[type]} [description]
      */
      $scope.calculateRemainingBalance = function(){
        //$scope.order.total = $scope.subtotal;

        $('#error_message_bills').hide(500);

        $scope.cancelValue = $scope.cancelTotal - $scope.order.discount - $scope.order.donation; 

        if($scope.cancelValue < 0){

          var validado = '';

          if($scope.order.donation > $scope.cancelTotal){

            validado = 'Total Donación';

          }

          if($scope.order.discount > $scope.cancelTotal ){

           validado = 'Total Descuento';

         }

         $scope.error_message_bills = "El campo "+ validado + " registra un valor mayor al Valor a Cancelar";

         $('#error_message_bills').show(500);

         $scope.validatePorcentage = 1;
         return;

       }else{

        $scope.validatePorcentage = 0;

      }


      if(isNaN($scope.cancelValue)){

        l($scope.cancelValue +' estado cancelValue');

        $scope.validatePorcentage = 1;

        $scope.error_message_bills = "El porcentaje ingresado a Cancelar registra un valor mayor al SubTotal";

        $('#error_message_bills').show(500);

      }else{

        $scope.validatePorcentage = 0;

      }



        // 2 particular..  // 1 copago 
        if($scope.payment.bill_types_id ==1){

          $scope.payment.debit = $scope.cancelTotal - $scope.order.discount - $scope.order.donation;

          $scope.order.total_cancel =  parseInt( $scope.cancelValue );
            // console.log('Ingeso asigno valor copago '+ $scope.cancelTotal);
            $scope.order.copayment = $scope.cancelTotal;

            $scope.payment.credit = 0; 


          }else{ 

            if($scope.payment.bill_types_id ==2){

              $scope.payment.debit = $scope.cancelValue;

              $scope.payment.credit = $scope.subTotal - $scope.order.discount - $scope.order.donation - $scope.cancelValue;

              $scope.order.total_cancel =  parseInt($scope.cancelValue);

              $scope.order.copayment = 0;

               // console.log('Ingeso asigno valor copago en O '+ $scope.cancelTotal);
             }
           }

         } 



 /**
     * [validatePercent Cálcula el valor del porcentaje, además valida que el porcentaje no sea mayor al 100%]
     * @author Jefry Londoño <jjmb2789@gmail.com>
     * @date     2016-12-28
     * @datetime 2016-12-28T12:13:16-0500
     * @param    {[type]}                 text [description]
     * @return   {[type]}                      [description]
     */
     $scope.validatePercent = function (text) {

       if(text.indexOf('%') != -1)
       {

        console.log('ingesa a calular porcentaje');

        var numb = text.match(/\d\.{0,9}/g);

        l(numb);

        numb = numb.join("");

        l('estado despues del join');
        l(numb);

        if(numb <= 100){

          return numb = parseFloat(numb);

        }



      }

    }


      /**
       * [calcular Pendiente por implementar, 
       * con esta función podemos cambiar el formato 
       * de un numero y colocarle los unidades de miles, decenas, centenas etc]
       * @author Jefry Londoño <jjmb2789@gmail.com>
       * @date     2016-12-28
       * @datetime 2016-12-28T09:52:14-0500
       * @param    {[type]}                 argument [description]
       * @return   {[type]}                          [description]
       */
       $scope.calcular = function (argument) {

        // l('entro a calcular');
        // if($scope.cancelTotal != undefined){

        //     //clearing left side zeros
        //     while ($scope.cancelTotal.charAt(0) == '0') {

        //       $scope.cancelTotal = $scope.cancelTotal.substr(1);
        //     }

        //     $scope.cancelTotal = $scope.cancelTotal.replace(/[^\d.\',']/g, '');

        //     l($scope.cancelTotal);


        //     var point = $scope.cancelTotal.indexOf(".");

        //     l(point);

        //     if (point >= 0) {

        //       $scope.cancelTotal = $scope.cancelTotal.slice(0, point + 3);

        //     }

        //     var decimalSplit = $scope.cancelTotal.split(".");
        //     var intPart = decimalSplit[0];
        //     var decPart = decimalSplit[1];

        //         intPart = intPart.replace(/[^\d]/g, '');
        //         if (intPart.length > 3) {
        //           var intDiv = Math.floor(intPart.length / 3);
        //           while (intDiv > 0) {
        //             var lastComma = intPart.indexOf(",");
        //             if (lastComma < 0) {
        //               lastComma = intPart.length;
        //             }

        //             if (lastComma - 3 > 0) {
        //               intPart = intPart.slice(lastComma - 3, 0, ",");
        //             }
        //             intDiv--;
        //           }
        //         }

        //         if (decPart === undefined) {
        //           decPart = "";
        //         }
        //         else {
        //           decPart = "." + decPart;
        //         }
        //         var res = intPart + decPart;

        //         l('Respuesta');
        //         l(res);

        //         $scope.$apply(function() {$scope.cancelTotal = res});


        //       }





      }





    /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('tempDiscount', function() { 

        if(!$scope.orderHasBill){

          $scope.doCalnculateDiscountCancel();

        }
      });

      /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('tempDonation', function() { 

       if(!$scope.orderHasBill){


        $scope.doCalnculateDonationCancel();

      }

    });


    /**
      * deteccion de cambio de total de valor a cancelar para igualarlo a copago 
      */
      $scope.$watch('cancelTotal', function() { 

        l(!$scope.orderHasBill);

        //$scope.calcular();

        if(!$scope.orderHasBill){

           // $scope.doCalnculateDiscountCancel();

           $scope.doCalculateTotalCopay(); 
         }
       });



     /**
      * deteccion de cambio total a cancelar para asignarlo al total de copago
      */
      $scope.$watch('cancelValue', function() { 
        //2 Particular  - 1 Copago
        if($scope.payment.bill_types_id == 1){
         //console.log('Entro y modifico COPAGO'+   $scope.payment.debit);

         $scope.payment.debit = $scope.cancelValue;

       }
       else{

        // console.log('Entro y modifico - FACTURACION - '+   $scope.payment.debit);
        $scope.payment.debit =  $scope.cancelValue;
        
        
        
      }
    });




      /**
       * Detecta el cambio en el tipo de pago.
       * @author Deicy Rojas <deirojas.1@gmail.com>
       * @date     2016-10-07
       * @datetime 2016-10-07T12:01:19-0500 */
       $scope.$watch('order.bill_types_id', function() { 

        $scope.payment.bill_types_id = $scope.order.bill_types_id;

        if($scope.payment.bill_types_id == 2){
          $scope.cancelTotal = $scope.subTotal;
          $scope.typePayment = true;

        }else{
          $scope.typePayment = false;
        }

      });


      /**
       * [identifyTypes identifyTypes]
       * @type {Array}
       */
       $scope.identifyTypes = [

       {name:'NA', code:0},
       {name:'CC', code:1},
       {name:'CE', code:2},
       {name:'PA', code:3},
       {name:'RC', code:4},
       {name:'TI', code:5},
       {name:'AS', code:6},
       {name:'MS', code:7},
       {name:'MS', code:8}

       ];

      /**
       * [usertype UserType]
       * @type {Array}
       */
       $scope.usertype = [

       {name:"Contributivo",code:0},
       {name:'Subsidiado',code:1},
       {name:'Vinculado',code:2},
       {name:'Particular',code:3},
       {name:'Otro',code:4}

       ];


       $scope.pruebaRip = function(people, order){






       }




//------------------------------------------------------------------ PREVISUALIZACION DE FACTURA -------------------------------------------------
        /* Funcion para descargar facturacion
         * @author Deicy Rojas <deirojas.1@gmail.com>
         * @date     2016-10-04
         * @datetime 2016-10-04T14:36:10-0500
         * @return   {[type]}                 [description]
         */
         $scope.generateAnyBill = function ($billInfo, $bill_type) {
          console.log(' generateAnyBill() ');
          console.log($billInfo);

          $timeout(function(){

            BillsService.generateBill($billInfo, function (res) {

              l('ultima');

              window.location.href = urls.BASE_API + '/Bills/downloadPrev/' + $billInfo.order.order_consec + '/' + res.message;
              var aus = true;
              

              l(aus);
              return aus;
            });

          }, 3000);
        }



        function toObject(arr) {
          var rv = {};
          for (var i = 0; i < arr.length; ++i)
            rv[i] = arr[i];
          return rv;
        }

        $scope.getBillDates = function(isPrev){

          console.log('INGESO A BILL DATES'); 
        /**
         * Datos de la factura
         * @type Object
         */
         var billInfo = {

          patient:        $scope.people,

          order:          $scope.order,

          services:       $scope.factServices,

          payment:        $scope.payment,

          clients:        $scope.selectedClientObj,

          costCenter:     $scope.SelectedSpecializations,

          plan:           $scope.selectedRates,

          billNumber:     $scope.newBillNumber,

          isPrev:         isPrev,

          regimes:        $scope.selectedRegimes,

          affiliation_type: $scope.patient.affiliation_type,

          city           : $scope.selectedMunicipalitie

        }

        l('si lo trae'+' '+billInfo);

        $scope.add = billInfo;

        if(billInfo.order.copayment == undefined){
          billInfo.order.copayment = 0;
        }

        return billInfo; 


      }

      $scope.getBillDates();


     /**
     * Funcion que genera la factura en previo o en 
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T08:59:22-0500
     * @param    {Boolean}                isPrev [description]
     * @return   {[type]}                        [description]
     */
     $scope.generateBill = function(isPrev, first= false){       
       l( 'generateBill()' );
       if(first){
        $scope.orderHasBill = true;
      }

      var billInfo =  $scope.getBillDates(isPrev);
      billInfo.first = first;

      if($scope.code){
        $scope.order.ips_code = $scope.code;
      }

      $scope.order.donationValue = $scope.order.donation; 

      $scope.order.discountValue = $scope.order.discount; 

      $scope.order.subtotal = $scope.subTotal;

      billInfo.patient.gender = $scope.selectGender.gender;
      
      billInfo.patient.municipality = $scope.people.municipality;
        /**
         * Determinar si es una unica factura o son varias.
         * @type {[type]}
         */
         var initialPaymentType = $scope.order.bill_types_id; 

        /**
         * Si el tipo de pago es coopago se generan los dos
         * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
         * @date     2016-09-15
         * @datetime 2016-09-15T17:08:52-0500
         * @param    {[type]}                 initialPaymentType [description]
         * @return   {[type]}                                    [description]
         */
         console.log('INGRESA GENRERAR FACTURA '+ isPrev + ' '+ initialPaymentType + ' '+ $scope.orderHasBill);

         if(initialPaymentType == 1){

          if(!isPrev && $scope.orderHasBill){
            /**
             * Obtiene la factura para este numero de orden.
             * @author Deicy Rojas <deirojas.1@gmail.com>
             * @date     2016-10-04
             */
             BillsService.getBillByOrder({id : $scope.order.id},function(res){

              if(res.success){

                if(billInfo.order.copayment != "0"){

                        // Se Genera Primera Factura
                        if(res.bills.length >= 2){

                          billInfo.billNumber = res.bills[1].bill_number; 
                          billInfo.billId     = res.bills[0].id;

                          console.log('NUMERO DE FACTURA ' + res.bills[1].bill_number);

                          console.log(billInfo.billNumber);

                          $scope.generateAnyBill(billInfo,1);
                        }
                        $timeout(function () {
                                // se genera segunda factura. 

                                console.log('NUMERO DE FACTURA ' + res.bills[0].bill_number);

                                billInfo.billNumber = res.bills[0].bill_number; 

                                billInfo.billId     = res.bills[1].id;

                                billInfo.payment.bill_types_id = 2;

                                $scope.generateAnyBill(billInfo,2);

                              }, 5000);

                      }else{
                       billInfo.billNumber = res.bills[0].bill_number; 
                       billInfo.billId = res.bills[0].id;

                       $scope.generateAnyBill(billInfo,1);
                     }
                   }
                 },function(error){

                 });
           }else{
            /**
             * Si copago mayor a 0 se generan dos facturas.
             * @author Deicy Rojas <deirojas.1@gmail.com>
             * @date     2016-10-04
             */
             if(billInfo.order.copayment != "0"){

                    // Se Genera Primera Factura
                    $scope.generateAnyBill(billInfo,1);

                    $timeout(function () {
                        // se genera segunda factura. 
                        billInfo.payment.bill_types_id = 2;

                        $scope.generateAnyBill(billInfo,1);
                      }, 3000);
                  }else{
                    billInfo.billNumber = res.bills[0].bill_number; 
                    billInfo.billId = res.bills[0].id;
                    $scope.generateAnyBill(billInfo,1);
                  }
                }
              }else if(initialPaymentType == 2){

        /**
         * Si el tipo de pago es factura se genera solo una 
         * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
         * @date     2016-09-15
         * @datetime 2016-09-15T17:09:20-0500
         * @param    {[type]}                 initialPaymentType [description]
         * @return   {[type]}                                    [description]
         */
         if(!isPrev && $scope.orderHasBill){
            /**
             * Obtiene la factura para este numero de orden.
             * @author Deicy Rojas <deirojas.1@gmail.com>
             * @date     2016-10-04
             */
             BillsService.getBillByOrder({id:$scope.order.id},function(res){
              if(res.success){
                console.log('NUEMRO FACTURA');
                console.log(res.bills);

                billInfo.billNumber = res.bills[0].bill_number; 
                billInfo.billId = res.bills[0].id;

                var aus = $scope.generateAnyBill(billInfo,2);

              return aus;

              }

            },function(error){});

           }else{

            var aus = $scope.generateAnyBill(billInfo,2);
            l('aus uno mas');
            l(aus);
           return aus;

          }


          return true;


        }

       //  $timeout(function(){

       //   $scope.stateGenerateBill = true;
       //   return true;

       // }, 1000);

        

      }


      $scope.consultationsEnding = undefined;

      $scope.endings = function(){


        ordersService.consultatiosEndings(function(res){

          l('consultations'+' '+res);

          if(res.success == true){

            $scope.consultationsEndings = res.consultationEndings;


          }

        });

      }

      $scope.endings();

      $scope.generateAP = function(order, factServices, people){




      }

  /**
   * Funcion para generar Guardar contabilizacion de la orden
   * @author Deicy Rojas <deirojas.1@gmail.com>
   * @date     2016-11-17
   * @datetime 2016-11-17T12:27:26-0500
   * @return   {[type]}                 [description]
   */
   $scope.generateAcount = function(ids){
    console.log('FACUTACION GENERADA');
    
    console.log(ids);

    if(ids[0] == 1){

    }



  }




  $scope.doesOrderHasBill = function(){


    if($scope.order.id != undefined && $scope.order.id != 0 ){

     ordersService.orderHasBill({orderId : $scope.order.id}, function(res){

      if(res.order > 0){

        $scope.orderHasBill = true;

        l('estado del bill');

        l($scope.orderHasBill);

      }else{

        $scope.orderHasBill = false;
      }

    });

   }else{

    $scope.orderHasBill = false;
  }
  // console.log('Exite Facturacion '+$scope.orderHasBill);

}

$scope.doesOrderHasBill();


$scope.$watch('order.id', function(){

  if($scope.order.id != undefined && $scope.order.id != 0){

    setCandoBill();            
  }


});



     /**
      * Guardado de la factura y almacenamiento de RIP
      * @return {[type]} [description]
      */
      $scope.saveBill = function (people, order, factServices) {

        var state;

        $( '[name="genera-factura"]' ).prop( 'disabled', true );
        $('.stateProgress').modal('show');


        //return;

        $scope.peopleRip = $scope.people;

        $scope.orderRip = $scope.order;

    /**
     * Tipo de Identificación
     */

     $scope.selectIdentity = $scope.peopleRip.document_types_id;

     for (var i = 0; i <= $scope.identifyTypes.length; i++) {

      if (i == $scope.selectIdentity) {

        $scope.typeI = $scope.identifyTypes[i].name;

      }

    }


    /*
     * Tipo de Usuario
     */

     $scope.userType = $scope.selectedRegimes;
     l("--UserType--");
     l($scope.userType);

     for (var i = 0; i < $scope.usertype.length; i++) {

      if (i == $scope.userType) {
            //console.log(i);
            $scope.tempType = $scope.usertype[i].code;

          }

        }
    /**
     * Asignar el Genero en Rips.
     * @type {[type]}
     */
     for (var i = $scope.gender.length - 1; i >= 0; i--) {
      if ($scope.gender[i].id == $scope.people.gender)
        $scope.peopleRip.gender = $scope.gender[i].initials;
    }


    /**
     * Zona de Residencia
     */

     if ($scope.people.patients[0].zone_id == 1) {

      $scope.peopleRip.patients[0].zone_id = 'U';

    } else {

      $scope.peopleRip.patients[0].zone_id = 'R';

    }

    /**
     * Unidad de edad
     */

     var cadena = $scope.orderRip.calculated_age,
     separador = ".",
     arregloDeEdad = cadena.split(separador);

    //l('edad'+' '+arregloDeEdad);

    if (arregloDeEdad[0] != 0) {

      $scope.selectAge = arregloDeEdad[0];

      $scope.ageClient = 1;

        // l('edad almacenada'+' '+$scope.selectAge);

        // l('sii'+' '+$scope.ageClient);

      } else if (arregloDeEdad[1] != 0) {


        $scope.selectAge = arregloDeEdad[1];

        $scope.ageClient = 1;

        // l('edad almacenada'+' '+$scope.selectAge);


      } else if (arregloDeEdad[2] != 0) {

        $scope.selectAge = arregloDeEdad[2];

        $scope.ageClient = 3;

        // l('edad almacenada'+' '+$scope.selectAge);

      }
    //console.log(arregloDeEdad);


    //l('mi People'+' '+$scope.peopleRips);

    $scope.ripUserM = {

      id: '',
      tipo: $scope.typeI,
      identificacion: $scope.peopleRip.identification,
      cod_ars: '',
      tipo_usuario: $scope.tempType,
      apellido1: $scope.peopleRip.last_name,
      apellido2: $scope.peopleRip.last_name_two,
      nombre1: $scope.peopleRip.first_name,
      nombre2: $scope.peopleRip.middle_name,
      edad: $scope.selectAge,
      edad_unidad: $scope.ageClient,
      sexo: $scope.peopleRip.gender,
      cod_depto: $scope.selectedDepatment.divipola,
      cod_municipio: $scope.peopleRip.municipalities_id,
      zona: $scope.peopleRip.patients[0].zone_id,
      fecha: moment($scope.orderRip.created).format('YYYY-MM-DD HH:mm:ss'),
      entidad: $scope.selectedClient,
      state: 1,
      orderConsectuiva: $scope.orderRip.order_consec

    }

    ripsService.saveRipsUser($scope.ripUserM, function (res) {

        //l('guardo para rips'+' '+res);

        if (res.success == true) {

            //l('correcto almacenamiento');
          }


        });



    //console.log('Copayment ' + $scope.copayment);
    if ($scope.copayment == undefined) {

      $scope.copayment = 0;

    }

    var orderChanges = {

      id: $scope.order.id,

      total: $scope.order.total,

      donation: parseInt($scope.order.donation),

      discount: parseInt($scope.order.discount),

      subtotal: parseInt($scope.subTotal),

      total_cancel: parseInt($scope.cancelValue),

      copayment: parseInt($scope.cancelTotal),

      center: $scope.order.centers_id,

      bill_types_id: $scope.order.bill_types_id,

      clients_id: $scope.order.clients_id,

      rates_id: $scope.order.rates_id

    }

    $scope.payment.orders_id = $scope.order.id;

    console.log(orderChanges);

    /**
    * Edicion o agregado de la orden, el lado del servidor se encarga de editar o agregar sea el caso
    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
    */
    BillsService.saveBill({ order: orderChanges, payment: $scope.payment }, function (res) {

      console.log("guardada?");

      if (res.success) {

        $scope.orderHasBill = true;

        $scope.generateAcount(res.toAccount);

            // $scope.newBillNumber = res.newBill.bill_number;  
            $timeout(function(){

              var aus = $scope.generateBill(false, true);

              l('aus');

              l(aus);

              if(aus){

                l('get in: change state');

                l($scope.stateGenerateBill);

                $timeout(function(){

                  $(".stateProgress").modal('hide');

                },3000);

    //     aux = false;

  }

}, 2000);

          }

        });

    $timeout(function () {

      ripsService.billNumber({ id: $scope.order.id }, function (res) {

        if (res.success == true) {

          $scope.unicNumber = res.processFiles;

          //console.log($scope.unicNumber);
        }


      });

    }, 4000);

    //$('[name="genera-factura"]').prop('disabled',false);
    $scope.orderAP = $scope.order;

    $scope.infoAP = $scope.factServices;

    $scope.personAP = $scope.people;

    if ($scope.order.center.id == 1) {

      $scope.code = '630010001801';

    } else {

      $scope.code = '630010001804';
    }

    for (var i = 0; i <= $scope.identifyTypes.length; i++) {

      if (i == $scope.people.document_types_id) {

        $scope.typeIdentity = $scope.identifyTypes[i].name

        console.log('my edentity' + ' ' + $scope.typeIdentity);

      }

    }



    $timeout(function () {

      $scope.unicNumber

      $scope.processFiles = {

        id: '',
        num_factura: $scope.unicNumber[0].Bills.bill_number,
        cod_ips: $scope.code,
        tip_identificacion: $scope.typeIdentity,
        identificacion: $scope.personAP.identification,
        fec_procedimiento: moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
        num_autorizacion: $scope.orderAP.order_consec,
        cod_procedimiento: $scope.infoAP[0].service.cup,
        ambito: 1,
        finalidad: $scope.orderAP.consultation_endings_id,
        persona_atiende: 1,
        dx_prin: $scope.orderAP.cie_ten_code.code,
        dx_relacionado: $scope.infoAP.dx_relacionado,
        complicacion: '',
        forma: '',
        precio: $scope.infoAP[0].cost,
        entidad: $scope.orderAP.clients_id,
        state: 0,


      }

      ripsService.saveRipsProcess($scope.processFiles, function (res) {

            //l('200 ok');

            if (res.success == true) {

                //(l('se almacena el RP');

              }

            });

    }, 5000);

    l('state $scope.stateGenerateBill');

    l('cargue pues');

    l($scope.stateGenerateBill);

    var aux = true;

    // while(aux){
    // 
    // $timeout(function(){

  //    if(state == true){

  //     l('get in: change state');

  //     l($scope.stateGenerateBill);

  //     $timeout(function(){

  //       $(".stateProgress").modal('hide');

  //     },3000);

  //   //     aux = false;

  // }

// }, 10000);



    // }

    

  }



  var signatureContainer;



  $scope.resetSignature = function(){

    signatureContainer.jSignature("reset"); 

  }


  $scope.loadSignatureCanvas = function(){

    if(signatureContainer == undefined){

      setTimeout(function(){ 

        signatureContainer = $("#signature").jSignature(); 

        $scope.resetSignature();

      }, 1000);

    }else{

      $scope.resetSignature();
    }


  }



  $scope.saveSignature = function(){


    var datapair = signatureContainer.jSignature("getData", "image/svg+xml"); 

            // $scope.imageSVG = "data:" + datapair[0] + "," + datapair[1];

            $scope.imageSVG = datapair[1];

            signatureService.saveSignature({content:$scope.imageSVG, appointments_id: $scope.appointmentIdToSign}, function(res){

              console.log(res);

              $scope.serviceToSign.signedConsent = true;

              $('.open-sign').modal('hide');


            }, function (error) {

            });      

          }




          $scope.openSign = function(service){

            $scope.serviceToSign = service;

            $scope.appointmentIdToSign = service.appointments_id;

            $('.open-sign').modal('show');

            $scope.loadSignatureCanvas();
          }


          $scope.downloadInstructive = function(instructives){

            if(instructives.length > 0){

                /**
                 * primer instructivo
                 */
                 window.open(instructives[0].url);

               }


             }



        /**
         * Show Modal for Read Identity Card
         */
         
         $scope.showIndetityCard = function(){

          $('.identity-card').modal('show');

          document.getElementById("focusIdentity").focus();

          $scope.resetSearchPeople();

          $scope.resetPeople();

          $scope.resetCalculateOrder();

            // $localStorage.order = undefined;

            // location.reload();

            //  $scope.showIndetityCard();

            
          }


        /**
         * Hide Modal for Read Identity Card
         */
         
         $scope.hideIndetityCard = function(setPeople){


          $('.identity-card').modal('hide');
        }


        

        /**
         * Busca una orden segun su Id enviado.
         * @author Deicy Rojas <deirojas.1@gmail.com>
         * @date     2016-10-07
         * @datetime 2016-10-07T08:28:14-0500
         */
         if($localStorage.order != undefined){
          console.log('EXITE UNA ORDEN ID '+$localStorage.order);

          ordersService.getOrderById({id:$localStorage.order},function(res){

            if(res.success){

              $scope.orderId  = res.order;

              $("[ng-model='searchPeople.identification']").prop("disabled", true);

                    // encontro una orden    
                          /**
                     * funcion que actualiza los datos de la orden, paciente y demas
                     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                     * @date     2016-09-12
                     * @datetime 2016-09-12T17:23:03-0500
                     * @param    {[type]}                 $scope.orderId !             [description]
                     * @return   {[type]}                                [description]
                     */
                   //  console.log('entro a order');

                   $scope.order = $scope.orderId;

                   $scope.people  = $scope.orderId.patient.person;

                   $scope.people.birthdate = moment($scope.orderId.patient.person.birthdate).format('YYYY-MM-DD');

                   $scope.searchPeople.identification  = $scope.orderId.patient.person.identification;

                   $scope.searchPatients();

                   $scope.patient        = $scope.orderId.patient;
                     /*
                        Seleccionar genero
                        */
                        for (var i = $scope.gender.length - 1; i >= 0; i--) {


                         if($scope.orderId.patient.person.gender == $scope.gender[i].id){
                          $scope.selectGender   = $scope.gender[i];
                        }
                      }



                      $scope.selectedTypeId = $scope.orderId.patient.person.document_types_id;

                      $scope.selectedZone   = $scope.orderId.patient.zone_id;

                      $scope.selectedRegimes = $scope.orderId.patient.regimes_id;

                      $scope.selectedEps = $scope.orderId.patient.eps_id;

                      $scope.selectedServiceType = $scope.orderId.service_type_id;

                      $scope.selectedCenter = $scope.orderId.centers_id;

                      $scope.getSelectedCenters($scope.selectedCenter);

                      $scope.selectedSpecialization = $scope.orderId.cost_centers_id;

                      $scope.order.consultation_endings_id = $scope.orderId.consultation_endings_id;


                      $scope.getSelectedCostCenters($scope.selectedSpecialization);

                    /**
                         * Seleccion de centro de costo
                         */
                         $scope.setSelectedSpecialization();

                         $scope.selectedClient = $scope.orderId.clients_id;
                         
                         $scope.getSelectedClientObj();

                         $scope.getRateByClient();
                         $scope.selectedRate = $scope.orderId.rates_id;

                         $scope.getSelectedRate($scope.selectedRate);

                         $scope.specialist = $scope.orderId.external_specialist.name;

                         $scope.order.external_specialists_id = $scope.orderId.external_specialist.id;

                         $scope.order.cie_ten_codes_id = $scope.orderId.cie_ten_codes_id;

                         $scope.permanent_diagnostic = $scope.orderId.cie_ten_code.code+' '+$scope.orderId.cie_ten_code.description;




            //obtiene todos los servicios para una orden.
            ordersService.getAllAppoinments({id: $scope.order.id},function(res){


                /**
                 * obtencion de los estudios de una cita
                 */
                 for (var i = 0; i < res.appointments.length; i++) {

                    /**
                     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                     * formateo para la informacion de la cita
                     * observaciones y tipo
                     */    
                     res.appointments[i].study.appointmentInfo = { 

                      observations    :res.appointments[i].observations, 
                      type            :res.appointments[i].type
                    };

                    res.appointments[i].study.medical_offices_id = res.appointments[i].medical_offices_id;

                    res.appointments[i].study.asigned_time = res.appointments[i]._matchingData.AppointmentDates.date_time_ini;
                    
                    res.appointments[i].study.appointments_id = res.appointments[i]._matchingData.AppointmentDates.appointments_id;


                    res.appointments[i].study.asigned_state = res.appointments[i]._matchingData.AppointmentStates;

                    res.appointments[i].study.expected_date = res.appointments[i].expected_date;

                    res.appointments[i].study.medicalOfficeName = res.appointments[i].medical_office.name;

                    /**
                     * Asignacion del identificador de la fecha de la cita
                     * @type Int
                     */
                     res.appointments[i].study.appointmentdDateId = res.appointments[i]._matchingData.AppointmentDates.id;

                    //si el servicio no tiene un costo
                    if(res.appointments[i].study.cost == undefined){

                      res.appointments[i].study.cost = 0;

                    }
                    
                    $scope.services.push(res.appointments[i].study);
                    
                  }

                  setCandoBill();

                // console.log($scope.services);

                $scope.changeSelectedRate();

                // console.log("carga de estudios agendados");

                // console.log(res);

              });

             /**
             * Asignar los valores facturados
             */             

            // // obtiene el valor a cancelar inicial. 
            // if($scope.orderId.copayment !=  null){

            //     $scope.payment.bill_types_id = 1; // copago
            //     $scope.cancelTotal =$scope.orderId.copayment;

            // }else{

            //     $scope.payment.bill_types_id = 2; // particular

            // }
            

            $scope.doesOrderHasBill();

            //selecciona el tipo de pago segun la orden.    
            $scope.payment.bill_types_id = $scope.orderId.bill_types_id;
            
            //console.log('tipo de pago '+ $scope.orderId.bill_types_id);
            
            // Asigan subtotal 
            $scope.subTotal = $scope.orderId.subTotal;
            //Asingna valor copago
            $scope.cancelTotal = $scope.orderId.copayment;
            //Asing valor donacion
            $scope.tempDonation = $scope.orderId.donation;
            //Asigna valor descuento.
            $scope.tempDiscount = $scope.orderId.discount;
            
            //Carga arvhivos 
            
            $scope.getOrderFiles();

          }

        },function(error){});
}




// funciones de anesteciologo 
$scope.addAnesthesia = function(){
  l( 'addAnesthesia()' );
  console.log($scope.selectedRate);

  RateServicesService.getAnesthesiaItem(
  {
    rates_id : $scope.selectedRate
  },
  function(res){
    res.res.index = $scope.factServices.length + 1;
    $scope.factServices.push(res.res);
    $scope.doCalculateSubtotal();

  },
  function(res){

  }
  );
}

$scope.removeAnesthesia = function( service ){

  $scope.factServices.splice(service.index - 1 );
  $scope.doCalculateSubtotal();
  console.log( $scope.factServices );

}

/*
  Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
  Fecha: 2016-11-24 11:49:48
  Tipo de retorno:  void
  Descripción: esta funcion imprime un sticker cuando el appointment está confirmado
  */

  $scope.printSticker = function( element ){

    console.log( $scope.order );
    console.log( element );

    var attentions ={ date_time_ini: element.asigned_time } ;

    var study = element;

    for(var item in $scope.clients){

      if( $scope.clients[ item ].id == $scope.order.clients_id ){

       var client = $scope.clients[ item ];

     }

   }

   attentionsService.printSticker({
    order  : $scope.order,
    person : $scope.order.patient.person,
    client : client,
    study  : study,
    external_specialist : '',
    attentions : attentions
  },
  function( res ){

   if( res.success ){

     var fileName = res.storedFileName.storedFileName;
     window.location.href = ( urls.BASE_API + '/OrderAppointments/downloadPrev/' + fileName );

   }

 },
 function( res ){
   console.log( res );
 });

 }


/* Carlos Felipe Aguirre Taborda 2016-12-01 10:45:05
   Firma digital
   */
	/*
	
	Carlos Felipe Aguirre Taborda
	2016-10-20 10:49:20

	Funciones para registrar la firma, solo funciona en 
	Chrome y Firefox
	
	Se debe haber instalado el software de la tableta
	primero, la extención SigPlusExtLite en el navegador 
	que se este utilizando.

	Chrome
		www.topazsystems.com/Software/SigPlusExtLite.exe

		extención
		https:/chrome.google.com/webstore/detail/Topaz-SigPlusExtLite- back/dhcpobccjkdnmibckgpejmbpmpembgco

	Firefox
		www.topazsystems.com/Software/SigPlusExtLite.exe
		(Instalar y reiniciar firefox)

	Test Page
		https://www.sigplusweb.com/sign_chrome_ff_SigPlusExtLite.html

	
   */


	// Inicia la captura de la firma
	$scope.StartSign = function (){      


		// Obtiene el objeto canvas en donde se pondra la firma
   var canvasObj = document.querySelector("#signature canvas");

	    // Limpia el campo de la firma
      canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);

		//Obtiene el alto y el ancho de el campo (Para mandarselo a la tableta y a partir de ello crear la imagen de la firma)
		imgWidth = canvasObj.width;
		imgHeight = canvasObj.height;

		//Grupo de datos que seran enviados a la tableta (imageFormat: 1 = jpeg, 2 = png )
		var message = { "firstName": "", "lastName": "", "eMail": "", "location": "", "imageFormat": 2, "imageX": imgWidth, "imageY": imgHeight, "imageTransparency": false, "imageScaling": false, "maxUpScalePercent": 0.0, "rawDataFormat": "ENC", "minSigPoints": 25 };

		//Añade un evento al DOM para que pueda recibir los mensajes de la tableta
		document.addEventListener('SignResponse', SignResponse, false);
		
		//  Vuelve el grupo de datos que seran enviados a la tableta a tipo String
		var messageData = JSON.stringify(message);

		// Crea un elemento en el DOM y en un atributo pone las opciones  
		var element = document.createElement("MyExtensionDataElement");
		element.setAttribute("messageAttribute", messageData);
		document.documentElement.appendChild(element);

		// Crea un evento en el DOM
		var evt = document.createEvent("Events");
		evt.initEvent("SignStartEvent", true, false);	

		// Envia el evento			
		element.dispatchEvent(evt);		
  }

  function SignResponse(event){	

		// Cuando la respuesta es recibida obtiene los valores que se recibieron y los
		// convierte de nuevo a formato JSON
		
		var str = event.target.getAttribute("msgAttribute");
		var obj = JSON.parse(str);
		SetValues(obj, imgWidth, imgHeight);
	}

	
	// Establece los valores en el campo del canvas
	function SetValues(objResponse, imageWidth, imageHeight){

    var obj = JSON.parse(JSON.stringify(objResponse));

        //	Obtiene de nuevo el canvas donde se pondra la firma
        var ctx	 = document.querySelector("#signature > canvas").getContext('2d');

	    //Si hay algun error entonces lo muestra
     if (obj.errorMsg != null && obj.errorMsg!="" && obj.errorMsg!="undefined"){
      console.log("--Error capturando firma--");
      console.log(obj.errorMsg);
    }
    else{
      if (obj.isSigned){

                    // Crea un objeto de tipo imagen
                    var img = new Image();

					//  Cuando está listo lo pone dentro del área de canvas
					img.onload = function (){
						
						ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
					}
					// Pone el atributo src="" especificando que la imagen esta codificada en base64 
					img.src = "data:image/png;base64," + obj.imageData;
        }
      }
    }
    
    function ClearFormData(){
      document.getElementById('SignBtn').disabled = false;
    }





            /**
             * websocket connection
             */

             /**
              * ip del websocket debe dejarse asi
              * @type {String}
              //   */
            //   var host = "localhost";

            //   /**
            //    * Puerto para el websocket
            //    * @type {Number}
            //    */
            //    var port = 8888;


            //   /**
            //    * creacion del websocket con ReconnectingWebSocket 
            //    * para que intente reconectarse si se desconecta por algun motivo
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:11:20-0500
            //    * @param    {[type]}                 type    [description]
            //    * @param    {[type]}                 data){                             return type +""+ delimiter + data.trim( [description]
            //    * @return   {[type]}                         [description]
            //    */
            //    var ws = new ReconnectingWebSocket("ws://" + host + ":" + port, null, {
            //      automaticOpen: true,
            //      maxReconnectAttempts: 5,

            //    });
            
            //    ws.debug = true;
            
            //    ws.timeoutInterval = 3000;

            //   /**
            //    * delimitador definido para compartir 
            //    * @type String
            //    */
            //    var delimiter = "--";
            
            //   /**
            //    * Función que formatea el mensaje de envio
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T16:18:08-0500
            //    * @param    {[type]}                 type tipo de acción
            //    * @param    {[type]}                 data mensaje a enviar
            //    * @return   {[type]}                      [description]
            //    */
            //    function formatMessage(type, data){
            //     data = "" + data;
            //     return type +""+ delimiter + data.trim();
            // }  

            //   /**
            //    * Obtiene el tipo de acción
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:04:02-0500
            //    * @param    {[type]}                 message [description]
            //    * @return   {[type]}                         [description]
            //    */
            //    function getType(message){

            //     var data = message.split(delimiter);
            
            //     return parseInt(data[0]); 
            // }


            //   /**
            //    * Función que devuelve el mensaje 
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:07:57-0500
            //    * @param    {[type]}                 message [description]
            //    * @return   {[type]}                         [description]
            //    */
            //    function getData(message){

            //     var data = message.split(delimiter);
            
            //     return data[1]; 
            // }
            

            //   /*
            //    * Cuando se abre la conexion del websocket
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:08:57-0500
            //    * @return   {[type]}                 [description]
            // */
            //    ws.onopen = function(){


            //         // Web Socket is connected, send data using send()
            //         // ws.send("Enviando mensaje");
            //         // alert("Message is sent...");
            //     };

            //   /**
            //    * Cuando se recive un mensaje del servidor
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:09:24-0500
            //    * @param    {[type]}                 evt [description]
            //    * @return   {[type]}                     [description]
            //    */
            //    ws.onmessage = function (evt) 
            //    { 

            //     var received_msg = evt.data;
            
            //     var typeMessage = getType(received_msg);
            
            //     switch(typeMessage){

            //         case 2:

            //             /**
            //              * type of action 2: is for identify
            //              */
            
            //              $scope.searchPeople.identification = getData(received_msg);

            //              $scope.searchPatients();

            //              break;
            //          }


            //      };

            //  /**
            //   * Cuando se cierra la conexión
            //   * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //   * @date     2016-09-22
            //   * @datetime 2016-09-22T17:09:42-0500
            //   * @return   {[type]}                 [description]
            //   */
            //   ws.onclose = function(){ 


            //   };

            // // angular.module('controlador') - 
            
            // /**
            //  * funcion que manda un usuario con su people id para guardar su huella
            //  * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //  * @date     2016-09-22
            //  * @datetime 2016-09-22T17:09:54-0500
            //  * @return   {[type]}                 [description]
            //  */
            //  $scope.sendPeopleId = function(){

            //     // send type of action and people id
            //     /**
            //      * type of action 1: is for enrollment
            //      */

            //     ws.send(formatMessage(1, $scope.people.id));

            //  }

            //   /**
            //    * Si hay un error se llama este evento
            //    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
            //    * @date     2016-09-22
            //    * @datetime 2016-09-22T17:10:27-0500
            //    * @param    {[type]}                 event [description]
            //    * @return   {[type]}                       [description]
            //    */
            //    ws.onerror=function(event){

            //    }



   // Final controlador
   // 
   $scope.pruebas = function () {

    l(($scope.prueba));

  }



}]);


    /**
     * validación popover
     */
     angular.module('app')
     .directive('validateAttachedFormElement', function() {
      return {
        restrict: 'A',
        require: '?ngModel',
        link: function(scope, elm, attr, ctrl) {
          if (!ctrl) {
            return;
          }



          elm.on('blur', function() {
            if (ctrl.$invalid && !ctrl.$pristine) {
              $(elm).popover('show');
              console.log(elm);
            } else {
              $(elm).popover('hide');
            }
          });

          elm.closest('form').on('submit', function() {
            if (ctrl.$invalid) {
              $(elm).popover('show');
            } else {
              $(elm).popover('hide');
            }
          });

        }
      };

    });
