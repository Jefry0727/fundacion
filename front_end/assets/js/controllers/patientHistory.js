'use strict';

/* Controllers */

angular.module('app')
    .controller('patientHistory', [
    		'$scope', 
    		'$state',
    		'$localStorage',
    		'$location',
    		'$timeout',
			'peopleService', 
			'OrdersAuthorizationService',
			'urls',
            'appointmentService',
    		function(
    			$scope, 
    			$state, 
    			$localStorage, 
    			$location, 
    			$timeout, 
    			peopleService,
    			OrdersAuthorizationService,
    			urls,
                appointmentService
                ) {

                    /* Carlos Felipe Aguirre Taborda 
                       Esta parte de codigo es para hacer este SCRIPT compatible con chrome
                    */
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

                    /*-------------------FIN COMPATIBLE-----------------------*/ 


                    /* Carlos Felipe Aguirre Taborda 2016-11-22 16:35:43
                       Objeto paciente encargado de los metodos de este controlador
                       -------------    Inicio Objeto Paciente ------------------
                    */
                    $scope.Patient = function( peopleService ){
                            // Declaracion de las variables necesarias
                            this.identification = undefined;
                            this.persona = new Object(); 
                            var _this = this;
                            $scope.Patient.prototype.offset=1;


                            // Vigila el cambio de el valor de la identification
                            $scope.watch(
                                'identification',
                                function(id, oldval, newval){
                                    

                                        

                                        _this.identification = newval ;
                                        console.log( _this );
                                        return newval ;
                                    

                                }
                            );

                            // Vigila si ya hay una persona


                            // Consulta los datos demograficos del paciente
                            $scope.Patient.getPeople = function(){
                                
                                peopleService.getPeopleByIdentification(
                                    {
                                        identification: _this.identification
                                    },
                                    function( res ){

                                        if( res.success ){

                                                _this.persona = res.persona;
                                                $scope.persona = _this.persona;
                                                


                                        }
                    

                                    },
                                    function( res ){

                                        console.log( "--getPeople--Error" );
                                        console.log( res );

                                    }
                                );
                            
                            }

                            // Cuando halla una persona consultada entonces llama a la funcion que consulta los appoinments relacionados
                            _this.watch(
                                'persona',
                                function( id, oldval, newval ){
                                    
                                   getAppointments();
                                    
                                    return newval;

                                }

                            );
                            // Obtiene los appoinments del paciente segun su numero de documento
                            var getAppointments = function(){
                                

                                appointmentService.getAppointmentsByIdentification(
                                    {
                                        identification : _this.identification,
                                        offset : _this.offset
                                    },
                                    function( res ){

                                        if( res.success && res.appointments.length > 0 ){
                                            _this.offset = _this.offset;
                                            $scope.appointments = res.appointments;

                                        }
                                        else{
                                            $scope.Patient.offset--;
                                        }

                                    },
                                    function( res ){

                                        console.log( res );

                                    }
                                );

                            }
                            // Redirige a agendamiento cita y allí carga la orden
                            $scope.Patient.showOrder = function( orderId ){
                                
                                $localStorage.order = orderId;
                                window.location.href= urls.BASE + "/#/app/agendamientoCita";
                            
                            }

                            $scope.Patient.watch('offset', function( id, oldval, newval ){
                               
                                if( newval >= 1 ){
                                    _this.offset = newval;
                                    getAppointments();
                                    console.log($scope.appointments);
                                    if( $scope.appointments.length > 0 ){
                                        
                                        return newval;

                                    }else{
                                        _this.offset = oldval;
                                        return oldval;
                                    }
                                    
                                }else{
                                    return oldval;
                                }

                            });
                    };
                    /*----------------- final del objeto paciente ------------------- */
                    var paciente = new $scope.Patient( peopleService );
                    
                    
            }
    ]
);