/* ============================================================
 * File: config.js
 * Configure routing
 * ============================================================ */

angular.module('app')
    

    // .constant('urls', {
    //         // Api REST URL
        

    //         BASE_API: 'http://www.samfundacion.com/back_end',
    //         BASE: ' http://www.samfundacion.com/front_end',


    //         // BASE_API: 'http://191.101.230.132/back_end',
    //         // BASE: 'http://191.101.230.132/front_end',
             
        
    //         // BASE_API: 'http://localhost/back_end',
    //         // BASE: 'http://localhost/front_end',
    // })
    
     .constant('urls', {
            // Api REST URL
             BASE_API: 'http://localhost/sam_fundacion/back_end',
             BASE: 'http://localhost/sam_fundacion/front_end',
            // BASE_API: 'http://localhost/sam_fundacion/back_end',    
    
            // BASE_API: 'http://localhost/sam_fundacion/back_end',
            // BASE: 'http://localhost/sam_fundacion/front_end',
           

    })

    
    .config(['$stateProvider', '$urlRouterProvider', '$httpProvider','$ocLazyLoadProvider',

        function($stateProvider, $urlRouterProvider, $httpProvider, $ocLazyLoadProvider) {
            $urlRouterProvider
                .otherwise('/app/home');

            $stateProvider
                
                .state('app', {
                    abstract: true,
                    url: "/app",
                    templateUrl: "tpl/app.html"
                })

                .state('app.dashboard', {
                    url: "/home",
                    templateUrl: "tpl/home.html",
                    controller: 'HomeCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'wizard',
                                    'bootstrapWizar',
                                    'timepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/home.js'
                                    ]);
                                });
                        }]
                    }
                })
                /**
                 * 
                 */
                .state('app.roles', {
                    url: "/roles",
                    templateUrl: "tpl/roles/roles.html",
                    controller: 'RolesCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/roles.js'
                                    ]);
                                });
                        }]
                    }
                })

                // Busqeuda de resultados
                .state('app.searchResults', {
                    url: "/searchResults",
                    templateUrl: "tpl/results/searchResults.html",
                    controller: 'searchResultsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'angucomplete',
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/searchResults.js'
                                    ]);
                                });
                        }]
                    }
                })

                 // Busqeuda de resultados este permite mostrar la vista
                .state('app.prueba', {
                    url: "/prueba",
                    templateUrl: "tpl/prueba/prueba.html",
                    controller: 'pruebaCtrl', //controlador que tiene la vista
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'angucomplete',
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/prueba.js'
                                    ]);
                                });
                        }]
                    }
                })

                  // Busqeuda de resultados este permite mostrar la vista
                .state('app.pruebaUsuario', {
                    url: "/pruebaUsuario",
                    templateUrl: "tpl/pruebaUsuario/pruebaUsuario.html",
                    controller: 'pruebaUsuarioCtrl', //controlador que tiene la vista
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'angucomplete',
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/pruebaUsuario.js'
                                    ]);
                                });
                        }]
                    }
                })
                /* Carlos Felipe Aguirre Taborda 2016-11-22 14:39:43
                   Modulo para consultar el hostorial de ordenes del pacientes
                */
                .state('app.patientHistory',{
                        url :        '/patientHistory',
                        templateUrl: 'tpl/patientHistory/patientHistory.html',
                        controller:  'patientHistory',
                        resolve:     {
                            deps:    [
                                '$ocLazyLoad',
                                function( $ocLazyLoad ){

                                    return $ocLazyLoad.load(

                                        [
                                            'moment',
                                            'datepicker'
                                        ],
                                        {
                                            
                                            insertBefore: '#lazyload_placeholder'
                                
                                        }

                                    ).then(
                                        function(){
                                            return $ocLazyLoad.load([
                                                'assets/js/controllers/patientHistory.js',
                                                'assets/css/w3.css'
                                            ]);
                                        }
                                    );

                                }
                            ]
                        }
                   }

                )

                //Cuentas de Cobro
                .state('app.paymentsAccounts', {
                    url: "/paymentsAccounts",
                    templateUrl: "tpl/paymentsAccounts/paymentsAccounts.html",
                    controller: 'paymentsAccountsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/paymentsAccounts.js',
                                        'assets/css/w3.css',
                                        'assets/css/printPaymentAccounts.css'
                                    ]);
                                });
                        }]
                    }
                })

                // Cancelacion y busqueda de cuentas de cobro
                .state('app.searchAndCancelPaymentsAccounts', {
                    url: "/searchAndCancelPaymentsAccounts",
                    templateUrl: "tpl/paymentsAccounts/readAndCancelPaymentAccounts.html",
                    controller: 'searchAndCancelPaymentsAccounts',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/searchAndCancelPaymentsAccounts.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })



                //Agenda Disponible
                .state('app.availabilityCalendar', {
                    url: "/availabilityCalendar",
                    templateUrl: "tpl/calendar/availabilityCalendar.html",
                    controller: 'availabilityCalendarCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'angucomplete',
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                    'fullCalendarUiAngular'

                                   
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/availabilityCalendar.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.ripsReport', {
                    url: "/ripsReport",
                    templateUrl: "tpl/ripsReport/ripsReport.html",
                    controller: 'ripsReportCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */

                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/ripsReport.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })


                // Control Impresiones Resultados.
                  .state('app.resultImpression', {
                    url: "/resultImpression",
                    templateUrl: "tpl/results/resultImpression.html",
                    controller: 'resultImpressionCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                    'summernote'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/resultImpression.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.manualBills', {
                    url: "/manualBills",
                    templateUrl: "tpl/manualBills/manualBills.html",
                    controller: 'manualBillsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                    'summernote',    
                                    'angucomplete'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/manualBills.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.cashBox', {
                    url: "/cashBox",
                    templateUrl: "tpl/cashBox/cashBox.html",
                    controller: 'cashBoxCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                    'summernote',    
                                    'angucomplete'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/cashBox.js'
                                    ]);
                                });
                        }]
                    }
                })

                  .state('app.billsList', {
                    url: "/billsList",
                    templateUrl: "tpl/manualBills/bills.html",
                    controller: 'billsListCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',   
                                    'angucomplete',
                                   'validation',
                                   'fullCalendarUiAngular'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/billsList.js'
                                    ]);
                                });
                        }]
                    }
                })
            
            .state('app.billsReports', {
                    url: "/billsReports",
                    templateUrl: "tpl/billsReports/billsReports.html",
                    controller: 'billReportsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',   
                                    'angucomplete',
                                   'validation',
                                   'fullCalendarUiAngular'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/billReports.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })
                .state('app.resultsProfile', {
                    url: "/resultsProfile",
                    templateUrl: "tpl/results/resultsProfile.html",
                    controller: 'resultsProfileCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                    'summernote'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/resultsProfile.js'
                                    ]);
                                });
                        }]
                    }
                })


                /**
                 * Pacientes a Atender
                 * configuracion de pacientes a atender
                 */
                 .state('app.healthProfessional', {
                    url: "/healthProfessional",
                    templateUrl: "tpl/healthProfessional/healthProfessional.html",
                    controller: 'healthProfessionalCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'moment',
                                    'validation'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/healthProfessional.js'
                                    ]);
                                });
                        }]
                    }
                })

                 .state('app.attentionPatient', {
                    url: "/attentionPatient",
                    templateUrl: "tpl/attentionPatient/attentionPatient.html",
                    controller: 'attentionPatientCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker',
                                     'summernote'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/attentionPatient.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.orderAuthorization', {
                    url: "/orderAuthorization",
                    templateUrl: "tpl/orderAuthorization/orderAuthorization.html",
                    controller: 'orderAuthorizationCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */

                                    'moment',
                                    'datepicker',
                                    
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/orderAuthorization.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.inputProduct', {
                    url: "/inputProduct",
                    templateUrl: "tpl/inventory/inputProduct.html",
                    controller: 'inputProductCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/inputProduct.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })

                 .state('app.newProduct', {
                    url: "/newProduct",
                    templateUrl: "tpl/inventory/newProduct.html",
                    controller: 'newProductCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/newProduct.js'
                                    ]);
                                });
                        }]
                    }
                })

                 .state('app.newProvider', {
                    url: "/newProvider",
                    templateUrl: "tpl/inventory/newProvider.html",
                    controller: 'newProviderCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/newProvider.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.exitProduct', {
                    url: "/exitProduct",
                    templateUrl: "tpl/inventory/exitProduct.html",
                    controller: 'exitProductCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/exitProduct.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.moveProduct', {
                    url: "/moveProduct",
                    templateUrl: "tpl/inventory/moveProduct.html",
                    controller: 'moveProductCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/moveProduct.js'
                                    ]);
                                });
                        }]
                    }
                })

                 .state('app.historicalBilling', {
                    url: "/historicalBilling",
                    templateUrl: "tpl/historicalBilling/historicalBilling.html",
                    controller: 'historicalBillingCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                    
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/historicalBilling.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.users', {
                    url: "/users",
                    templateUrl: "tpl/users/users.html",
                    controller: 'UsersCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                   'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/users.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.patients', {
                    url: "/patients",
                    templateUrl: "tpl/patients/patients.html",
                    controller: 'PatientsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'datepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/patients.js'
                                    ]);
                                });
                        }]
                    }
                })

            

                .state('app.specialist', {
                    url: "/specialist",
                    templateUrl: "tpl/specialists/specialist.html",
                    controller: 'SpecialistCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'datepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/specialist.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.orders', {
                    url: "/orders",
                    templateUrl: "tpl/orders/orders.html",
                    controller: 'ordersCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/orders.js'
                                    ]);
                                });
                        }]
                    }
                })
               

                .state('app.attentionStudies', {
                    url: "/attentionStudies",
                    templateUrl: "tpl/attentionStudies/attentionStudies.html",
                    controller: 'attentionStudiesCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                   'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/attentionStudies.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.people', {
                    url: "/people",
                    templateUrl: "tpl/people/people.html",
                    controller: 'PeopleCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/people.js'
                                    ]);
                             });
                        }]
                    }
                })

                .state('app.editPeople', {
                    url: "/editPeople",
                    templateUrl: "tpl/people/editPeople.html",
                    controller: 'PeopleCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   'datepicker'
                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/people.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.viewPatients', {
                    url: "/viewPatients",
                    templateUrl: "tpl/patients/viewPatients.html",
                    controller: 'PatientsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/patients.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.editSpecialist', {
                    url: "/editSpecialist",
                    templateUrl: "tpl/specialists/editSpecialist.html",
                    controller: 'SpecialistCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                   'moment',
                                   'datepicker'
                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/specialist.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.specialists', {
                    url: "/specialists",
                    templateUrl: "tpl/specialists/specialists.html",
                    controller: 'SpecialistCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/specialist.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.listUser', {
                    url: "/listUser",
                    templateUrl: "tpl/users/listUser.html",
                    controller: 'UsersCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/users.js'
                                    ]);
                                });
                        }]
                    }
                })



                  .state('app.availablePeriods', {
                    url: "/availablePeriods",
                    templateUrl: "tpl/availablePeriods/availablePeriods.html",
                    controller: 'availablePeriodsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/availablePeriods.js'
                                    ]);
                                });
                        }]
                    }
                })


                /*
                Config Clients
                */

                .state('app.clients', {
                    url: "/clients",
                    templateUrl: "tpl/clients/clients.html",
                    controller: 'clientsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                   'moment',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'fullCalendarUiAngular'

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/clients.js'
                                    ]);
                                });
                        }]
                    }
                })



                /**
                 * Asocieate studies whit specialist.
                 * @param  {[type]} $ocLazyLoad) {                                       return $ocLazyLoad.load([                                                                    ], {                                    insertBefore: '#lazyload_placeholder'                                })                                .then(function() {                                    return $ocLazyLoad.load([                                        'assets/js/controllers/clients.js'                                    ]);                                });                        }]                    }                } [description]
                 * @return {[type]}              [description]
                 */
                .state('app.professionalProfile', {
                    url: "/professionalProfile",
                    templateUrl: "tpl/specialists/professionalProfile.html",
                    controller: 'professionalProfileCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/professionalProfile.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.permissions', {
                    url: "/permissions",
                    templateUrl: "tpl/permissions/permissions.html",
                    controller: 'PermissionsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/permissions.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.medicalOffices', {
                    url: "/medicalOffices",
                    templateUrl: "tpl/medicalOffices/medicalOffices.html",
                    controller: 'MedicalOfficesCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([

                                    // 'jsSignature'
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/medicalOffices.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.medicalOfficeProfile', {
                    url: "/medicalOfficeProfile",
                    templateUrl: "tpl/medicalOffices/medicalOfficeProfile.html",
                    controller: 'MedicalOfficesCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                        'moment',
                                        'datepicker',
                                        'timepicker',
                                        'daterangepicker'

                                    // 'jsSignature'
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/medicalOffices.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.medicalOfficesListPeriod', {
                    url: "/medicalOfficesListPeriod",
                    templateUrl: "tpl/medicalOfficesListPeriod/medicalOfficesListPeriod.html",
                    controller: 'medicalOfficesListPeriodCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/medicalOfficesListPeriod.js'
                                    ]);
                                });
                        }]
                    }
                })



                .state('app.scheduleIntervals', {
                    url: "/scheduleIntervals",
                    templateUrl: "tpl/scheduleIntervals/scheduleIntervals.html",
                    controller: 'scheduleIntervalsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   
                                   'datepicker',

                                   'daterangepicker',

                                   'timepicker',

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/scheduleIntervals.js'
                                    ]);
                                });
                        }]
                    }
                })




                .state('app.schedule', {
                    url: "/schedule",
                    templateUrl: "tpl/schedule/schedule.html",
                    controller: 'ScheduleCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'datepicker',
                                  
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/schedule.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.agendamientoCita', {
                    url: "/agendamientoCita",
                    templateUrl: "tpl/agendamientoCita/agendamientoCita.html",
                    controller: 'agendamientoCitaCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   /**
                                    * libreria para la reconexion de websockets
                                    */
                                   'reconnecting-websocket',
                                   'moment',
                                   'angucomplete',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'fullCalendarUiAngular',
                                   'wizard',
                                   'bootstrapWizar',
                                   'tree',
                                   'jsSignature',
                                   'agendamiento'
                                   


                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/agendamientoCita.js'
                                    ]);
                                });
                        }]
                    }
                })



                .state('app.ordersList', {
                    url: "/ordersList",
                    templateUrl: "tpl/ordersList/ordersList.html",
                    controller: 'ordersListCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'fullCalendarUiAngular'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/ordersList.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.modal', {
                    url: "/modal",
                    templateUrl: "tpl/modal/modal.html",
                    controller: 'modalCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'wizard',
                                    'bootstrapWizar',
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/modal.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.modalAgenda', {
                    url: "/modalAgenda",
                    templateUrl: "tpl/modalAgenda/modalAgenda.html",
                    controller: 'modalAgendaCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'fullCalendar'
                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/modalAgenda.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.calendar', {
                    url: "/calendar",
                    templateUrl: "tpl/calendar/calendar.html",
                    controller: 'calendarCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   'datepicker',
                                   'timepicker',
                                   'fullCalendarUiAngular'

                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/calendar.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.consultorio', {
                    url: "/consultorio",
                    templateUrl: "tpl/consultorio/consultorio.html",
                    controller: 'consultorioCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'tree',
                                    'moment',
                                    'datepicker',
                                    'timepicker'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/consultorio.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.seccion', {
                    url: "/seccion",
                    templateUrl: "tpl/seccion/seccion.html",
                    controller: 'seccionCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/seccion.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.disponibilidad', {
                    url: "/disponibilidad",
                    templateUrl: "tpl/disponibilidad/disponibilidad.html",
                    controller: 'disponibilidadCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                    'calendario'

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/disponibilidad.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.fullCalendar', {
                    url: "/fullCalendar",
                    templateUrl: "tpl/fullCalendar/fullCalendar.html",
                    controller: 'fullCalendarCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'moment',
                                   'fullCalendar'

                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/fullCalendar.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.signature', {
                    url: "/signature",
                    templateUrl: "tpl/signature/signature.html",
                    controller: 'SignatureCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   // 'datepicker',
                                  
                                   'jsSignature',

                                   
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/signature.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.externalSpecialist', {
                    url: "/externalSpecialist",
                    templateUrl: "tpl/externalSpecialist/externalSpecialist.html",
                    controller: 'externalSpecialistCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   // 'datepicker',
                                    'angucomplete',
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/externalSpecialist.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.studyTranscription', {
                    url: "/studyTranscription",
                    templateUrl: "tpl/transcriptions/studiesTranscriptions.html",
                    controller: 'studiesTranscriptionsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   
                                   'moment',
                                   'datepicker',
                                   'timepicker',
                                   'summernote'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/studiesTranscriptions.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.transcriptions', {
                    url: "/transcriptions",
                    templateUrl: "tpl/transcriptions/transcriptions.html",
                    controller: 'transcriptionsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                 
                                   'moment',
                                   'datepicker',
                                   'timepicker'
                                  // 'fullCalendarUiAngular'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/transcriptions.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.attentionStudy', {
                    url: "/attentionStudy",
                    templateUrl: "tpl/attention/attentionStudy.html",
                    controller: 'attentionStudyCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   // 'datepicker',
                                   'angucomplete',
                                   'validation',
                                   'moment',
                                   'datepicker',
                                   'timepicker',
                                   'wizard',
                                   'bootstrapWizar',
                                   'tree'
                                  
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/attentionStudy.js'
                                    ]);
                                });
                        }]
                    }
                })


                .state('app.informs', {
                    url: "/informs",
                    templateUrl: "tpl/informs/informs.html",
                    controller: 'informsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                 
                                   'moment',
                                   'datepicker',
                                   'timepicker'
                                  // 'fullCalendarUiAngular'
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/informs.js'
                                    ]);
                                });
                        }]
                    }
                })



                .state('app.agendamientoConfirmar', {
                    url: "/agendamientoConfirmar",
                    templateUrl: "tpl/agendamientoCita/agendamientoConfirmar.html",
                    controller: 'agendamientoConfirmarCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'angucomplete',
                                   'moment',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'fullCalendarUiAngular'


                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/agendamientoConfirmar.js'
                                    ]);
                                });
                        }]
                    }
                })

                .state('app.authorizationTranscriptions', {
                    url: "/authorizationTranscriptions",
                    templateUrl: "tpl/transcriptions/authorizationTranscriptions.html",
                    controller: 'authorizationTranscriptionsCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                   'angucomplete',
                                   'moment',
                                   'datepicker',
                                   'validation',
                                   'timepicker',
                                   'summernote'


                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/authorizationTranscriptions.js',
                                        'assets/css/w3.css'
                                    ]);
                                });
                        }]
                    }
                })

                /**
                 * Autentication States
                 */
               .state('auth', {
                    url: '/auth',
                    template: '<div class="full-height" ui-view></div>'
                })
                .state('auth.login', {
                    url: '/login',
                    templateUrl: 'tpl/auth/login.html',
                    controller: 'AuthCtrl',
                    resolve: {
                        deps: ['$ocLazyLoad', function($ocLazyLoad) {
                            return $ocLazyLoad.load([
                                    /* 
                                        Load any ocLazyLoad module here
                                        ex: 'wysihtml5'
                                        Open config.lazyload.js for available modules
                                    */
                                ], {
                                    insertBefore: '#lazyload_placeholder'
                                })
                                .then(function() {
                                    return $ocLazyLoad.load([
                                        'assets/js/controllers/auth.js'
                                    ]);
                                });
                        }]
                    }
                });


                /**
                 * Configuration to check and send access token for each request
                 */
                $httpProvider.interceptors.push(['$q', '$location', '$localStorage','$rootScope', function ($q, $location, $localStorage,$rootScope) {
                
                $httpProvider.defaults.headers.post['Accept'] = 'application/json';
                $httpProvider.defaults.headers.post['Content-Type'] = 'application/json';
                $httpProvider.defaults.headers.post = {"Content-Type": "application/json;charset=utf-8"};
                //$httpProvider.defaults.useXDomain = true;
                //delete $httpProvider.defaults.headers.common['X-Requested-With'];

                return {
                    'request': function (config) {
                        config.headers = config.headers || {};
                        if ($localStorage.token) {
                            //config.headers.Authorization = 'Bearer ' + $localStorage.token;
                            //
                            
                            /**
                             * authgl auth header, glbearer identifier of token
                             * @type String
                             */
                            config.headers.authgl = 'glbearer ' + $localStorage.token;
                        
                        }
                        return config;
                    },                    
                    'responseError': function (response) {

                        //authorization errors
                        if (response.status === 401 || response.status === 403 || response.status === 500) {
                            
                            console.log("error");
                           
                           // delete $localStorage.token;
                           
                            $localStorage.$reset()
                           
                            $location.path('auth/login');
                        }
                        return $q.reject(response);
                    }
                };
            }]);




       // .state('app.dashboard', {
       //              url: "/home",
       //              templateUrl: "tpl/home.html",
       //              controller: 'HomeCtrl',
       //              resolve: {
       //                  deps: ['$ocLazyLoad', function($ocLazyLoad) {
       //                      return $ocLazyLoad.load([
                                     
       //                                  Load any ocLazyLoad module here
       //                                  ex: 'wysihtml5'
       //                                  Open config.lazyload.js for available modules
                                    
       //                          ], {
       //                              insertBefore: '#lazyload_placeholder'
       //                          })
       //                          .then(function() {
       //                              return $ocLazyLoad.load([
       //                                  'assets/js/controllers/home.js'
       //                              ]);
       //                          });
       //                  }]
       //              }
       //          });




        }
    ]);