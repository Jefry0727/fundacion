'use strict';

/* Controllers */

angular.module('app')
.controller('searchResultsCtrl',
   ['$scope', 

   '$state',

   '$rootScope',

   '$localStorage',

   '$location',

   '$timeout', 

   'urls',

   'medicalOfficesService', 

   'resultsService',

   'patientsService',

   'clientsService',

   function($scope, 

      $state, 

      $rootScope, 

      $localStorage, 

      $location, 

      $timeout, 
      
      urls,
      
      medicalOfficesService,

      resultsService,

      patientsService,

      clientsService){


      /**
       * Resetea local storage cuando se abre la pagina 
       * @type {[type]}
       */
      $localStorage.result = undefined;


      $scope.startDate = moment(new Date()).format('DD-MM-YY');

      $scope.endDate = moment(new Date()).format('DD-MM-YY');

      $scope.resultM = {

          id:'',
          attentions_id:'',
          created:'',
          modified:'',
          content:'',
          specialists_id:''

      };

     
        $scope.formatData = function(data) {
            // body...
        }

        // campos.
        // Numero documento
        $scope.docPatient = undefined; 
        // Numero Orden
        $scope.orderCode = undefined;
        // Nombres y apellidos
        $scope.peopleName = undefined;
        

        //opcion 4 Clientes 
        $scope.Clients;
        // Opcion 4 cliente seleccionado
        $scope.selectedClient = undefined;
         // fecha Final
        $scope.endDate = undefined;
        // fecha inicio
        $scope.startDate = undefined;



//-------------- START BUSCAR POR NOMBRE -------------------------------------------------------------------------

  
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
        $scope.urlSearchServicesDiagnostic = urls.BASE_API + '/Patients/searchPatientByName/';




         /**
          * detection se seleccion de diagnosticos permanentes por enter o click 
          */
         $scope.$watch('foundServiceDiagnostic', function() { 


            /**
             * Si el modelo no esta definido
             */
            console.log("______________________");
            console.log($scope.servicesDiagnostic);
            if($scope.foundServiceDiagnostic != undefined){
            

                /**
                 * agregamos el diagnostico permanente al arreglo de servicios
                 */
                $scope.servicesDiagnostic.push($scope.foundServiceDiagnostic.originalObject);

                /**
                 * Se elimina el valor temporal
                 * @type {[type]}
                 */
                console.log($scope.servicesDiagnostic);
   
                $scope.foundServiceDiagnostic = undefined;

                $scope.showDiagnostic = $scope.servicesDiagnostic[0];


                // se guarda el valor de la cadena en el objeto paciente del campo de diagnostico permanente para guardar en la bd
                $scope.peopleName = $scope.servicesDiagnostic;

                //  $scope.order.cie_ten_codes_id = $scope.showDiagnostic.id;
                /**
                 * limpiamos el valor del objeto
                 * @type {[type]}
                 */
                $scope.$broadcast('angucomplete-alt');

            }


        }, true);





        
//-------------- START OPTION SELECT ---------------------------------------------------------------------------------------
    
    $scope.notFound = function(){
      console.log('no se encontro resultado ');
      
    }    
        /**
         * Funcion para buscar resultado segun caso seleccionado
         * @author Deicy Rojas <deirojas.1@gmail.com>
         * @date     2016-09-27
         * @datetime 2016-09-27T16:53:11-0500
         * @return   {[type]}                 [description]
         */
        $scope.searchResult = function(){
        

         var data = { 
            tipo:'',
            patient:'',
            result :''
        };

        switch($scope.optionSelected){

                 // Option = 1 -> numero de documento
                 case '1': 
                 console.log('documento '+ $scope.docPatient);

                    //Obtiene el Id del paciente para buscar los resultados disponibles.
                    patientsService.searchPatients({id:$scope.docPatient},function(res){

                        if(res.success){ 

                            var id = res.people.patients[0].id;
                            console.log('--paso por acá');
                            $localStorage.people = res.people;

                                resultsService.ordersResults({id:id,type:'1'},function(res){
                                console.log("--resultado--");
                                console.log(res);

                                if(res.success){

                                    data ={ 
                                      tipo:'Persona',
                                      patient:res.query[0],
                                      result :res.query,
                                      lend_plates: res.query[0].lend_plates
                                  };
                                  $localStorage.result =  data;
                                  $state.go('app.resultImpression'); 
                                  $("#message_error").html("");

                              }else{
                                $("#message_error").html("No se han encontrado resultados para este paciente<br/>el paciente tiene placas prestadas");
                                $scope.notFound();
                              }
                          },function(error){console.log(error);});

                        }
                        else{
                           $("#message_error").html("No se han encontrado resultados para este paciente"); 
                        }
                    },function(error){console.log(error);});

                    break;

                // Option = 2 -> numero de orden. 
                case '2':
                console.log('Numero de Orden '+$scope.order);

                    // Obtiene los resultados para un numero de orden.
                    console.log($scope.orderCode);
                    
                    resultsService.ordersResults({id:$scope.orderCode,type:'2'},function(res){
                        l('buscar por numero de orden');
                        l(res);
                        if(res.success){
                          data ={ 
                              tipo:'Orden',
                              patient:res.query[0],
                              result :res.query,
                              lend_plates: res.query[0].lend_plates
                          };


                          $localStorage.result =  data;
                          $state.go('app.resultImpression'); 


                          $("#message_error").html("");

                      }
                      else{
                         $("#message_error").html("No se han encontrado resultados para este paciente");

                         $scope.notFound();

                      }
                  },function(error){console.log(error);
                  });

                break;


                // Option 3 -> Nombres y apellidos
                case '3':
                console.log('entro en caso 3');
                console.log($scope.peopleName);
                console.log($scope.peopleName[0]._matchingData.Patients.id);

                 //Busca lista de resultados para el paciente.
                 var idPatient = $scope.peopleName[0]._matchingData.Patients.id;

                 resultsService.ordersResults({id:idPatient,type:'1'},function(res){
                    console.log("Nombres");
                    console.log(res);
                    if(res.success ){

                      console.log(res);
                    

                        data ={ 
                          tipo: 'Persona',
                          patient:$scope.peopleName[0],
                          result :res.query,
                          lend_plates: res.query[0].lend_plates
                      };
                      $localStorage.result =  data;
                      l('lo q trae el local'+' '+$localStorage.result);
                      $state.go('app.resultImpression'); 
                      $("#message_error").html("")

                  }else{
                      $("#message_error").html("No se han encontrado resultados para este paciente");
                      $scope.notFound();
                  }
              
                  },function(error){console.log(error);
                  });
            
             break;


             case '4':
              // opcion 4 paquete de resultados para el cliente. 
                 $scope.selectedClient;
                 $scope.endDate;
                 $scope.startDate;

                 if($scope.selectedClient != undefined && $scope.endDate != undefined && $scope.startDate != undefined){

                  console.log($scope.selectedClient);

                 }


             break;

             default:
             console.log('No se reconoce accion'+ $scope.optionSelected);
             break;
         }


     }

// END OPTION SELECT ---------------------------------------------------------------------------------------
     $scope.optionSelected ;
        /**
         * detecta el cambio en la opcion seleccionada.
         */
         $scope.$watch('optionSelected',function(){

            switch($scope.optionSelected){
               
                 case '4':

                 // Obtiene la informacion de los clientes. 
                    clientsService.getEnable(function(res){

                      $scope.clients = res.clients;

                    }, function (error) {
                        console.log(error);
                    });

                 break;
                 default:
                 console.log('Default '+$scope.optionSelected);
             }

         });

         $scope.Previsualizar = function(result){

            resultsService.prevResult({result:result},function(res){

                window.location.href = urls.BASE_API + '/result/downloadPrev';

            });

        }


        $scope.clearLocalStorage = function(){
          $localStorage.result = undefined;
          $localStorage.people = undefined;
          $localStorage.order = undefined;
        }
        $scope.clearLocalStorage();



    }]);
