'use strict';

/* Controllers */

angular.module('app')
    .controller('ripsReportCtrl', 
                [
                    '$scope', 
                    '$state',
                    '$rootScope',
                    '$localStorage',
                    '$location',
                    '$timeout', 
                    'specialistService', 
                    'ripsService', 
                    'urls', 
                    function(
                        $scope, 
                        $state, 
                        $rootScope, 
                        $localStorage, 
                        $location,
                        $timeout, 
                        specialistService, 
                        ripsService, 
                        urls) {

                            // PARA LA COMPATIBILIDAD ENTRE NAVEGADORES
                            if (!Object.prototype.watch) {
                                Object.defineProperty(
                                  Object.prototype,
                                  "watch", {
                                    enumerable: false,
                                    configurable: true,
                                    writable: false,
                                    value: function (prop, handler) {
                                      var old = this[prop];
                                      var cur = old;
                                      var getter = function () {
                                         return cur;
                                      };
                                      var setter = function (val) {
                                       old = cur;
                                       cur =
                                         handler.call(this,prop,old,val);
                                       return cur;
                                      };
                                  
                                      // can't watch constants
                                      if( newval(delete this[prop]) ){
                                       Object.defineProperty(this,prop,{
                                           get: getter,
                                           set: setter,
                                           enumerable: true,
                                           configurable: true
                                       });
                                      }
                                   }
                                });
                            }
                            // ./PARA LA COMPATIBILIDAD ENTRE NAVEGADORES


                            function Rips(){

                                this.numCuentaCobro = '';
                                var _this = this;

                                this.generateRips = function(){
                                    ripsService.generateRips(
                                        {
                                            payment_consec : this.numCuentaCobro
                                        },
                                        function( success ){

                                            window.location.href=urls.BASE_API+'/rips/downloadTxt/';                                            

                                        },
                                        function( error ){
                                         
                                            l( error );
                                        
                                        }
                                    );
                                }

                            }

                            $scope.Rips = new Rips();
                    }
                ]
);
