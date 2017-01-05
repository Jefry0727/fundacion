'use strict';

/* Controllers */

angular.module('app')
    .controller(
        'searchAndCancelPaymentsAccounts', 
        [
            '$scope',
            '$state',
            '$rootScope', 
            '$localStorage',
            'ripsService'
            , function(
                $scope, 
                $state, 
                $rootScope, 
                $localStorage,
                ripsService) {


                    $scope.PaymentAccount = function(){
                        // lista de facturas en la cuenta de cobro
                        $scope.PaymentAccount.facturas = []; 

                        // consecutivo de la cuenta de cobro
                        $scope.PaymentAccount.paymentAccountConsec='';

                        var _this = this;


                        $scope.PaymentAccount.cancelConfirmation = function(){
                        
                            $('[name="resultado-consulta"]').hide(0);                  
                            $scope.message_modal=''
                            $('.anulation').modal('show');
                        
                        }

                        // metodo que cancela la cuenta de cobro
                        $scope.PaymentAccount.cancel = function(){
                            ripsService.cancelPaymentAccount(
                                {
                                    order_consec : $scope.PaymentAccount.paymentAccountConsec
                                },
                                function( success ){
                                    
                                    if( success.success ){
                                        $scope.message_modal='Se anuló correctamente';
                                        setTimeout(
                                            function(){
                                                
                                                $('.anulation').modal('hide');

                                            },
                                            1750
                                        );
                                    }
                                    else{
                                        $scope.message_modal='No se pudo anular';
                                    }
                                
                                },
                                function( error ){
                                    l(error);
                                }
                            );
                        }

                        // metodo que consulta la cuenta de cobro
                        $scope.PaymentAccount.searchPaymentAccount = function(){

                            ripsService.findPaymentAccount(
                                {
                                    order_consec : $scope.PaymentAccount.paymentAccountConsec
                                },
                                function( success ){
                                    
                                    if( success.success ){
                                        $('[name="no-resultado"]').hide();
                                        $('[name="resultado-consulta"]').show(0);
                                        $scope.resultado = success.paymentAccount;
                                    
                                    }
                                    else{
                                        $('[name="resultado-consulta"]').hide(0);
                                        $('[name="no-resultado"]').show();
                                        
                                        setTimeout(function(){
                                            $('[name="no-resultado"]').hide();
                                        }, 4000);
                                    }
                                
                                },
                                function( error ){
                                   
                                }
                            );

                        }
                    
                    }



                    $scope.PaymentAccount.prototype.constructor.call(this);

              }
        ]
    );