



(function () {
    'use strict';


        // angular.module('app')
        
        // .factory('Auth', ['$http', '$localStorage', 'urls', function ($http, $localStorage, urls) {
        //     function urlBase64Decode(str) {
        //         var output = str.replace('-', '+').replace('_', '/');
        //         switch (output.length % 4) {
        //             case 0:
        //                 break;
        //             case 2:
        //                 output += '==';
        //                 break;
        //             case 3:
        //                 output += '=';
        //                 break;
        //             default:
        //                 throw 'Illegal base64url string!';
        //         }
        //         return window.atob(output);
        //     }

        //     function getClaimsFromToken() {
        //         var token = $localStorage.token;
        //         var user = {};
        //         if (typeof token !== 'undefined') {
        //             var encoded = token.split('.')[1];
        //             user = JSON.parse(urlBase64Decode(encoded));
        //         }
        //         return user;
        //     }

        //     var tokenClaims = getClaimsFromToken();

        //     return {

        //         signin: function (data, success, error) {
        //             $http.post(urls.BASE_API + '/users/token.json', data).success(success).error(error)
        //         },
        //         logout: function (success) {
        //             tokenClaims = {};
        //             delete $localStorage.token;
        //             success();
        //         },
        //         getTokenClaims: function () {
        //             return tokenClaims;
        //         },
        //         getUsers: function (success, error) {
        //             $http.get(urls.BASE_API + '/users/index.json').success(success).error(error)
        //         }
        //     };


        // }
        // ]);
        
        /**
         * Funciones prara generar archivos en excel.
         */
         angular.module('app')
         .factory('excelServices', ['$http', 'urls', function ($http, urls) {

            return {

                gexcel: function (success, error) {

                    $http.get(urls.BASE_API + '/ExcelGenerator/gexcel.json').success(success).error(error)
                },
                generateExcel: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ExcelGenerator/generateExcel.json',data).success(success).error(error)
                },

                generateExcelTemplate: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ExcelGenerator/generateExcelTemplate.json',data).success(success).error(error)
                },
                
                generateResolutions: function(data, success, error){
                    $http.post(urls.BASE_API + '/Resolutions/resolution4505.json',data).success(success).error(error)
                }

            };
        }
        ]);

         angular.module('app')
         .factory('pruebaService', ['$http', 'urls', function ($http, urls) {

            return {

                getAllUsers: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Users/getUserAll.json',data).success(success).error(error)
                },
                getAll: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Users/getAll.json',data).success(success).error(error)
                                            //controlador, nombre del metodo
                },

                                    };
                                }
                                ]);

         
        /**
         * Autorizacion de ordene 
         */
         angular.module('app')
         .factory('OrdersAuthorizationService', ['$http', 'urls', function ($http, urls) {

            return {

                isAuthorized: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrdersAuthorization/isAuthorized.json',data).success(success).error(error)
                },
                addAuthorized: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrdersAuthorization/add.json',data).success(success).error(error)
                },
                editAuthorized: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrdersAuthorization/edit.json',data).success(success).error(error)
                },

            };
        }
        ]);


         angular.module('app')
         .factory('usersService', ['$http', 'urls', function ($http, urls) {

            return {
                getUsers: function (data, success, error) {
                    $http.post(urls.BASE_API + '/users/getUsers.json',data).success(success).error(error)
                },

                editUser: function (data, success, error) {
                    $http.post(urls.BASE_API + '/users/editUser.json',data).success(success).error(error)
                },
                editUserPeop: function (data, success, error) {
                    $http.post(urls.BASE_API + '/users/editUser.json',data).success(success).error(error)
                },
                register: function(data, success, error) {
                    $http.post(urls.BASE_API + '/users/register.json',data).success(success).error(error)
                },
                getUsersLocation: function(user_id, success, error) {
                    $http.post(urls.BASE_API + '/users/getUsersLocations/'+user_id+'.json').success(success).error(error)
                },
                updateUserLocation: function(user, success, error) {
                    $http.post(urls.BASE_API + '/users/updateUserLocation.json',user).success(success).error(error)
                },
                desactivatedUsers: function(data, success, error) {
                    $http.post(urls.BASE_API + '/users/desactivatedUsers.json',data).success(success).error(error)
                },

                activatedUsers: function(data, success, error) {
                    $http.post(urls.BASE_API + '/users/activatedUsers.json',data).success(success).error(error)
                },

                addUsers: function(data, success, error) {
                    $http.post(urls.BASE_API + '/users/addUsers.json',data).success(success).error(error)
                },

                getUsersInventory: function(success, error) {
                    $http.get(urls.BASE_API + '/users/getUsersInventory.json').success(success).error(error)
                },
                editUserPe: function(data, success, error) {
                    $http.post(urls.BASE_API + '/people/editUserPeople.json',data).success(success).error(error)
                },
                deleteUserPe: function(data, success, error) {
                    $http.post(urls.BASE_API + '/people/deleteUserPeople.json',data).success(success).error(error)
                },

                listAllUsers: function(data, success, error) {
                    $http.post(urls.BASE_API + '/users/getAll.json',data).success(success).error(error)
                },
                getDocumentTypes:function(success, error) {
                    $http.get(urls.BASE_API + '/people/getTypeDocument.json').success(success).error(error)
                },
                getAllRoles:function(success, error) {
                    $http.get(urls.BASE_API + '/roles/getRoles.json').success(success).error(error)
                },
                getUserById: function(data,success,error){
                    $http.post(urls.BASE_API +'/Users/getUserById.json',data).success(success).error(error)
                },
            };
        }
        ]);
         

         angular.module('app')
         .factory('rolesService', ['$http', 'urls', function ($http, urls) {

            return {

                getRoles: function (success, error) {

                    $http.get(urls.BASE_API + '/roles/index.json').success(success).error(error)
                    
                },

                addRole: function (data, success, error) {
                    $http.post(urls.BASE_API + '/roles/add.json',data).success(success).error(error)
                },
                updateRole: function (data, success, error) {
                    $http.post(urls.BASE_API + '/roles/edit.json',data).success(success).error(error)
                },

                deleteRoles: function (data, success, error) {
                    $http.post(urls.BASE_API + '/roles/delete.json',data).success(success).error(error)
                },

            };
        }
        ]);

         angular.module('app')
         .factory('paymentsAccountsService', ['$http', 'urls', function ($http, urls) {

            return {

                getCenters: function (success, error) {
                    $http.get(urls.BASE_API + '/HabilitationCode/getCenter.json').success(success).error(error)
                },
                clients: function (success, error) {
                    $http.get(urls.BASE_API + '/Clients/get.json').success(success).error(error)
                },
                getRatesClients: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RatesClients/ratesClients.json',data).success(success).error(error)
                },
                // getRatesClients: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/RatesClients/ratesClients.json',data).success(success).error(error)
                // },

                // deleteRoles: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/roles/delete.json',data).success(success).error(error)
                // },

            };
        }
        ]);

         angular.module('app')
         .factory('ripsService', ['$http', 'urls', function ($http, urls) {

            return {

                getClients: function (success, error) {

                    $http.get(urls.BASE_API + '/clients/get.json').success(success).error(error)
                    
                },
                //RipsUsers
                getRipsUser: function (data, success, error) {
                    $http.post(urls.BASE_API + '/rips/genTxt.json', data).success(success).error(error)
                },
                saveRipsUser: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipUsuarios/addUserRip.json', data).success(success).error(error)
                },
                generateUS: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipUsuarios/informationRipUser.json', data).success(success).error(error)
                },
                //Rips Processs
                billNumber: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrdersBills/getNumberBill.json', data).success(success).error(error)
                },
                saveRipsProcess: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipProcedimientos/addRipsProcess.json', data).success(success).error(error)
                },
                generateAP: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipProcedimientos/getRipProcess.json', data).success(success).error(error)
                },
                //  
                generateAM: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipMedicamentos/generateAM.json', data).success(success).error(error)
                },
                //Rips Query Files
                saveRipsQueryFiles: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipConsultas/addRipQueryFiles.json', data).success(success).error(error)
                },
                generateFQ: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RipConsultas/getRipArchivoConsulta.json', data).success(success).error(error)
                },
                setRipProperties: function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/setRipProperties.json", data ).success( success ).error( error );
                },
                generatePaymentAccount: function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/generatePaymentAccount.json", data ).success( success ).error( error );
                },
                saveAccount : function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/saveAccount.json", data ).success( success ).error( error );
                },
                cancelPaymentAccount : function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/cancelPaymentAccount.json", data ).success( success ).error( error );
                },
                findPaymentAccount : function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/findPaymentAccount.json", data ).success( success ).error( error );
                },
                generateRips : function( data, success, error ){
                    $http.post( urls.BASE_API + "/rips/generateRips.json", data ).success( success ).error( error );
                },

            };
        }
        ]);

         angular.module('app')
         .factory('paymentsService', ['$http', 'urls', function ($http, urls) {

            return {

                savePayment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentCash.json',data).success(success).error(error)
                },


                // getRoles: function (success, error) {

                //     $http.get(urls.BASE_API + '/roles/index.json').success(success).error(error)
                
                // },
                //All methods Copayment
                getFacturaCopyCash: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentCash.json',data).success(success).error(error)
                },
                getCopaymentDebitCard: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentCards.json',data).success(success).error(error)
                },
                copaymentCheck: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentCheck.json',data).success(success).error(error)
                },
                copaymentBond: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentBond.json',data).success(success).error(error)
                },
                copaymentConsignment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getCopaymentConsignment.json',data).success(success).error(error)
                },
                allCopyment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/sumAllCopyment.json',data).success(success).error(error)
                },
                //All methods manualBills
                paymentBillCash: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getPaymentBillCash.json',data).success(success).error(error)
                },
                paymentBillCards: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getPaymentBillCards.json',data).success(success).error(error)
                },
                paymentBillCheck: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getPaymentBillCheck.json',data).success(success).error(error)
                },
                paymentBillBond: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getPaymentBillBond.json',data).success(success).error(error)
                },
                paymentBillConsignment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/getPaymentBillConsign.json',data).success(success).error(error)
                },
                totalManualBills: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalBills.json',data).success(success).error(error)
                },
                //Totals
                onlyCash: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalOnlyCash.json',data).success(success).error(error)
                },
                onlyCards: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalOnlyCards.json',data).success(success).error(error)
                },
                onlyChecks: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalOnlyChecks.json',data).success(success).error(error)
                },
                onlyBonds: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalOnlyBonds.json',data).success(success).error(error)
                },
                onlyConsignment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/totalOnlyConsignment.json',data).success(success).error(error)
                },
                total: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/allTotal.json',data).success(success).error(error)
                },
                preResult: function (data, success, error) {
                    $http.post(urls.BASE_API + '/payments/prePayments.json',data).success(success).error(error)
                },
                userCashBox: function (data, success, error) {
                    $http.post(urls.BASE_API + '/users/getUserCashBox.json',data).success(success).error(error)
                },

            };
        }
        ]);


angular.module('app')
.factory('BillDetailsService', ['$http', 'urls', function ($http, urls) {
    return {
        getBillDetails: function (data, success, error) {
            $http.post(urls.BASE_API + '/BillDetails/getBillDetails.json',data).success(success).error(error)
        },
        getBillDetailsByBillId: function(data,success,error){
            $http.post(urls.BASE_API+ '/BillDetails/getBillDetailsByBillId.json',data).success(success).error(error)
        },
    };
}]);


angular.module('app')
.factory('RateServicesService', ['$http', 'urls', function ($http, urls) {
    return {
        getAnesthesiaItem: function (data, success, error) {
            $http.post(urls.BASE_API + '/RateServices/getAnesthesiaItem.json',data).success(success).error(error)
        },  
    };
}]);




angular.module('app')
.factory('productsService', ['$http', 'urls', function ($http, urls) {

    return {
        allProducts : function(data,success,error){
           $http.post(urls.BASE_API + '/Products/allProducts.json',data).success(success).error(error)
       },
       addProduct : function(data,success,error){
           $http.post(urls.BASE_API + '/Products/add.json',data).success(success).error(error)
       },
       editProduct : function(data,success,error){
           $http.post(urls.BASE_API + '/Products/edit.json',data).success(success).error(error)
       },
       getAllSections: function (success, error) {
        $http.get(urls.BASE_API + '/Section/getSection.json').success(success).error(error)
    },
    
                // esta no la muevan
                getAllProducts: function (success, error) {
                    $http.get(urls.BASE_API + '/Products/getProducts.json').success(success).error(error)
                },

                getAllProductsDetails: function (success, error) {
                    $http.get(urls.BASE_API + '/ProductDetails/getAllProductsDetails.json').success(success).error(error)
                },
                // adiciona detalles de productos.
                addProductDetails : function(data,success,error){
                   $http.post(urls.BASE_API + '/ProductDetails/addProductDetails.json',data).success(success).error(error)
               },
                // valida si existe un detalle de producto antes de adicionarlo.
                existProduct : function(data,success,error){
                   $http.post(urls.BASE_API + '/ProductDetails/existProduct.json',data).success(success).error(error)
               },

               getDetailsByProduct: function (data,success, error) {
                $http.post(urls.BASE_API + '/ProductDetails/getDetailsByProduct.json',data).success(success).error(error)
            },


        };
    }
    ]);


angular.module('app')
.factory('providersService', ['$http', 'urls', function ($http, urls) {

    return {
                // Obtener todos con paginacion..
                allProviders: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Providers/allProviders.json',data).success(success).error(error)
                }, 
                addProviders: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Providers/add.json',data).success(success).error(error)
                },
                editProviders: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Providers/edit.json',data).success(success).error(error)
                },              
                //Obtener todos sin paginacion.
                getProviders: function ( success, error) {
                    $http.get(urls.BASE_API + '/Providers/getAllProviders.json').success(success).error(error)
                },
            };
        }
        ]);

angular.module('app')
.factory('permissionsService', ['$http', 'urls', function ($http, urls) {

    return {
        getAllPermissions: function (data, success, error) {
            $http.post(urls.BASE_API + '/permissions/getAllPermissions.json',data).success(success).error(error)
        },
        updatePermissionRole: function (data, success, error) {
            $http.post(urls.BASE_API + '/permissions/updatePermissionRole.json',data).success(success).error(error)
        },

        getAllPermissionsMenu: function (data,success, error) {
            $http.post(urls.BASE_API + '/permissions/getAllPermissionsMenu.json',data).success(success).error(error)
        },

        getPermissions: function (success, error) {
            $http.get(urls.BASE_API + '/permissions/getPermissions.json').success(success).error(error)
        },


    };
}
]);


angular.module('app')

.factory('specialistsAvailablesService', ['$http', 'urls', function ($http, urls) {

    return {
        add: function (data, success, error) {
            $http.post(urls.BASE_API + '/SpecialistsAvailables/add.json',data).success(success).error(error)
        },
    };

}
]);




angular.module('app')

.factory('resultsProfileService', ['$http', 'urls', function ($http, urls) {

    return {
        getAllResultsProfile: function (data, success, error) {
            $http.post(urls.BASE_API + '/resultProfiles/getAllResultsProfile.json',data).success(success).error(error)
        },
        studiesFilter: function (data, success, error) {
            $http.post(urls.BASE_API + '/studiesSpecialists/getFilter.json',data).success(success).error(error)
        },
                //Lista de los Especialista
                getAllSpecialist: function (success, error) {
                    $http.get(urls.BASE_API + '/specialists/getSpecialistResult.json').success(success).error(error)
                },
                getAllStudies: function (data, success, error) {
                    $http.get(urls.BASE_API + '/studies/get.json', data).success(success).error(error)
                },
                //Agregar un perfil al Especialista y Studio Seleccionadop
                addResults: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/addResultProfile.json',data).success(success).error(error)
                },
                //Filtra lo Estudios pertenecientes a cada Especialista
                ListFilterStudies: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/getAllStudies.json',data).success(success).error(error)
                },
               //Filtra Los Perfiles de los resultados por cada Especilista y por cada Estudio
               ListFilterResultProfile: function (data, success, error) {
                $http.post(urls.BASE_API + '/resultProfiles/getResultProfile.json',data).success(success).error(error)
            },
                //Obtine la descripcion del ResultProfile
                getContent: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/getContentStudies.json',data).success(success).error(error)
                },
                //Edita el Perfil que pertenece al Medico y el Estudio seleccionado 
                editResultPro: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/editResultProfile.json',data).success(success).error(error)
                },
                dropResultPro: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/deleteResultProfile.json',data).success(success).error(error)
                },
                getContentResultP: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/getContentUpdate.json',data).success(success).error(error)
                },
                preResult: function (data, success, error) {
                    $http.post(urls.BASE_API + '/resultProfiles/preResultProfile.json',data).success(success).error(error)
                },
            };

        }

        ]);
angular.module('app')

.factory('resultsService', ['$http', 'urls', function ($http, urls) {

    return {
                //Obtiene un resultado segun una atencion.
                getByAttention: function (data, success, error) {
                    $http.post(urls.BASE_API + '/results/getByAttention.json',data).success(success).error(error)
                },
                edit: function (data, success, error) {
                    $http.post(urls.BASE_API + '/results/edit.json',data).success(success).error(error)
                },
                add: function (data, success, error) {
                    $http.post(urls.BASE_API + '/results/add.json',data).success(success).error(error)
                },
                // Busca los resultados para un paciente.
                getResultByPerson:  function (data, success, error) {
                    $http.post(urls.BASE_API + '/results/getResultByPerson.json',data).success(success).error(error)
                },

                ordersResults: function (data, success, error) {
                    $http.post(urls.BASE_API + '/orders/ordersResults.json',data).success(success).error(error)
                },
                prevResult: function (data, success, error) {
                    $http.post(urls.BASE_API + '/results/prevResult.json',data).success(success).error(error)
                },

                addBirads: function(data, success,error){
                    $http.post(urls.BASE_API + '/Birads/add.json',data).success(success).error(error)
                    
                }
                
                
            };
        }

        ]);





angular.module('app')
.factory('medicalOfficesService', ['$http', 'urls', function ($http, urls) {

    return {
        getOfficeMedical: function (success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/getMedicalOffice.json').success(success).error(error)
        },
        getMedicalOffices: function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/getPaginMedicalOffices.json',data).success(success).error(error)
        },
        addMedicalOffice: function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/add.json',data).success(success).error(error)
        },
        editMedicalOffice: function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/edit.json',data).success(success).error(error)
        },
        dropMedicalOffice: function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/delete.json',data).success(success).error(error)
        },
        setState: function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/setState.json',data).success(success).error(error)
        },
        getMedicalByCenter:function (data, success, error) {
            $http.post(urls.BASE_API + '/MedicalOffices/getMedicalByCenter.json',data).success(success).error(error)
        },
        
    };
}
]);

angular.module('app')
.factory('ordersService', ['$http', 'urls', function ($http, urls) {

    return {
                /**
                 * Obtiene toda la informacion de la orden segun su Id
                 * @author Deicy Rojas 
                 * @date     2016-10-07
                 */
                 
                 getOrder: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getOrderConsec.json',data).success(success).error(error)
                },
                // addOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/addOrder.json',data).success(success).error(error)
                // },
                updateOrder: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/editOrder.json',data).success(success).error(error)
                },
                dropOrder: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/deleteOrder.json',data).success(success).error(error)
                },
                // setOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/setState.json',data).success(success).error(error)
                // },
                
                getOrderFiles: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Orders/getOrderFiles.json', data).success(success).error(error)
             },
             dropOrderFile: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Orders/dropOrderFile.json', data).success(success).error(error)
             },

             getPhotoPeople: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Orders/getPhotoPeople.json', data).success(success).error(error)
             },


             saveOrder: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Orders/saveOrder.json', data).success(success).error(error)
             },

             orderHasBill: function (data, success, error) {
                 $http.post(urls.BASE_API + '/Bills/orderHasBill.json', data).success(success).error(error)
             },

             getNumberAppointmentOrder: function (data, success, error) {
                $http.post(urls.BASE_API + '/Orders/getNumberAppointmentOrder.json',data).success(success).error(error)
            },                

                /** 
                Obtiene listado de tipos de ordenes. */
                getOrderType: function ( success, error) {
                 $http.get(urls.BASE_API + '/OrderTypes/get.json').success(success).error(error)
             },
             getCenters: function ( success, error) {
                $http.get(urls.BASE_API + '/Centers/get.json').success(success).error(error)
            },
            getSelectedCenters: function (data,success, error) {
                $http.post(urls.BASE_API + '/Centers/getSelectedCenters.json',data).success(success).error(error)
            },
                  /**
                  * Obtiene el listado de tipos de servicios   */
                  getServiceType: function ( success, error) {
                    $http.get(urls.BASE_API + '/ServiceTypes/get.json').success(success).error(error)
                },

                getAttentionAppoinmentsByDay: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Appointments/getAttentionAppoinmentsByDay.json', data).success(success).error(error)
                },

                getUnconfAppointmentsDay: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Appointments/getUnconfAppointmentsDay.json', data).success(success).error(error)
                },
                getConfrimAppoinmentsByDay: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Appointments/getConfrimAppoinmentsByDay.json', data).success(success).error(error)
                },
                getAllAppoinments  : function (data, success, error) {
                    $http.post(urls.BASE_API + '/Appointments/getAllAppoinments.json', data).success(success).error(error)
                },
                getWithoutPayment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getWithoutPayment.json',data).success(success).error(error)
                },
                getWithoutResult :function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getWithoutResult.json',data).success(success).error(error)
                },

                getWhitResult :function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getWhitResult.json',data).success(success).error(error)
                },
                getByAppointment:function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getByAppointment.json',data).success(success).error(error)
                },
                
                getWithPayment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getWithPayment.json',data).success(success).error(error)
                },
                /**
                 * [getLendPlatesResult Obtiene las atenciones que tienen placas prestadas sin resultado..]
                 * @author Deicy Rojas <deirojas.1@gmail.com>
                 */
                 getLendPlatesResult:function (data, success, error) {
                    $http.post(urls.BASE_API + '/Orders/getLendPlatesResult.json',data).success(success).error(error)
                },
                getOrderById: function(data, success,error){
                    $http.post(urls.BASE_API +'/Orders/getOrderById.json',data).success(success).error(error)
                },
                consultatiosEndings: function(success,error){
                    $http.post(urls.BASE_API +'/ConsultationEndings/getConsultatiosEndings.json').success(success).error(error)
                },

                getOrderAuthorizations: function(data,success,error){
                    $http.post(urls.BASE_API +'/Orders/getOrderAuthorizations.json',data).success(success).error(error)
                },


                getSalesByClient: function(data,success,error){
                    $http.post(urls.BASE_API +'/payments/getSalesByClient.json',data).success(success).error(error)
                },
                
                
            };
            
        }
        ]);
/**
                 * Obtiene los Generos.
                 * @author Deicy Rojas <deirojas.1@gmail.com>
                 * @date     2016-12-13
                 * @datetime 2016-12-13T09:44:03-0500
                 */
                 angular.module('app')
                 .factory('genderService', ['$http', 'urls', function ($http, urls) {

                    return {

                        getGender: function(data,success,error){
                            $http.post(urls.BASE_API + '/Gender/getAllGener.json',data).success(success).error(error)
                        },
                        
                    };
                }
                ]);




                 angular.module('app')
                 .factory('attentionConsultationsService', ['$http', 'urls', function ($http, urls) {

                    return {
                        getConsult: function (data, success, error) {
                            $http.post(urls.BASE_API + '/AttentionConsultations/getAttentionConsultations.json',data).success(success).error(error)
                        },
                // addOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/addOrder.json',data).success(success).error(error)
                // },
                // updateOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/editOrder.json',data).success(success).error(error)
                // },
                // dropOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/deleteOrder.json',data).success(success).error(error)
                // },
                // setOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/setState.json',data).success(success).error(error)
                // },
                
            };
        }
        ]);

                 angular.module('app')
                 .factory('avaibilityCalendarService', ['$http', 'urls', function ($http, urls) {

                    return {

                        avaibilityCalendar: function (data, success, error) {
                            $http.post(urls.BASE_API + '/AppointmentDates/getAvaibilityCalendar.json',data).success(success).error(error)
                        },
                        getSelectCenter: function (success, error) {
                            $http.post(urls.BASE_API + '/Centers/get.json').success(success).error(error)
                        },
                        getMedicalOffice: function (data, success, error) {
                            $http.post(urls.BASE_API + '/MedicalOffices/getMedicalByCenter.json',data).success(success).error(error)
                        },
                // dropOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/deleteOrder.json',data).success(success).error(error)
                // },
                // setOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/setState.json',data).success(success).error(error)
                // },
                
            };
        }
        ]);

                 angular.module('app')
                 .factory('attentionPatientService', ['$http', 'urls', function ($http, urls) {

                    return {
                        getBilltypes: function (success, error) {
                            $http.post(urls.BASE_API + '/BillTypes/getBilltypes.json').success(success).error(error)
                        },
                        getFormPayments: function (success, error) {
                            $http.post(urls.BASE_API + '/FormPayments/getFormPayments.json').success(success).error(error)
                        },
                // addOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/addOrder.json',data).success(success).error(error)
                // },
                // updateOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/editOrder.json',data).success(success).error(error)
                // },
                // dropOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/deleteOrder.json',data).success(success).error(error)
                // },
                // setOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/setState.json',data).success(success).error(error)
                // },
                
            };
        }
        ]);


                 angular.module('app')
                 .factory('attentionsService', ['$http', 'urls', function ($http, urls) {

                    return {
                        asignedAppointments: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/asignedAppointments.json',data).success(success).error(error)
                        },
                        appointmentForAttention: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/appointmentForAttention.json',data).success(success).error(error)
                        },
                        attendedAppointments: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/attendedAppointments.json',data).success(success).error(error)
                        },

                        addAttention: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/addAttention.json',data).success(success).error(error)
                        },

                        editAttention: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/editAttention.json',data).success(success).error(error)
                        },

                        editAttentionLend: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/editAttentionLend.json',data).success(success).error(error)
                        },
                        updateLendPlateState: function (data, success, error) {
                            $http.post(urls.BASE_API + '/Attentions/updateLendPlateState.json',data).success(success).error(error)
                        },
                        printSticker: function(data, success, error){
                            $http.post(urls.BASE_API + '/Attentions/printSticker.json',data).success(success).error(error)
                        },
                        getAttentionsByAppointmentId: function(data, success, error){
                            $http.post(urls.BASE_API + '/Attentions/getAttentionsByAppointmentId.json',data).success(success).error(error)
                        },
                        
                    };
                    
                }   
                ]);

                 angular.module('app')
                 .factory('attentionStudiesService', ['$http', 'urls', function ($http, urls) {

                    return {
                        getConsult: function (data, success, error) {
                            $http.post(urls.BASE_API + '/AttentionStudies/getAttentionStudies.json',data).success(success).error(error)
                        },
                // addOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/addOrder.json',data).success(success).error(error)
                // },
                // updateOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/editOrder.json',data).success(success).error(error)
                // },
                // dropOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/deleteOrder.json',data).success(success).error(error)
                // },
                // setOrder: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/Orders/setState.json',data).success(success).error(error)
                // },
                
            };
        }
        ]);


                 angular.module('app')
                 .factory('ScheduleIntervalsService', ['$http', 'urls', function ($http, urls) {

                    return {
                        get: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleIntervals/get.json',data).success(success).error(error)
                        },
                        
                        add: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleIntervals/add.json',data).success(success).error(error)
                        },
                        
                        edit: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleIntervals/edit.json',data).success(success).error(error)
                        },
                        
                        delete: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleIntervals/delete.json',data).success(success).error(error)
                        },

                        


                    };
                }
                ]);

                 
                 angular.module('app')
                 .factory('authorizationTranscriptionsService', ['$http', 'urls', function ($http, urls) {

                    return {

                       getResultsState: function (data, success, error) {
                        $http.post(urls.BASE_API + '/AuthorizationTranscriptions/getResultsByState.json',data).success(success).error(error)
                    },

                    


                };
            }
            ]);


                 angular.module('app')
                 .factory('patientsService', ['$http', 'urls', function ($http, urls) {

                    return {
                        getUsers: function (success, error) {
                            $http.get(urls.BASE_API + '/patients/index.json').success(success).error(error)
                        },

                        editUser: function (data, success, error) {
                            $http.post(urls.BASE_API + '/patients/edit.json',data).success(success).error(error)
                        },

                        register: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/register.json',data).success(success).error(error)
                        },

                        editPatients: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/editPatients.json',data).success(success).error(error)
                        },

                        addPatients: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/addPatients.json',data).success(success).error(error)
                        },

                        updateUserLocation: function(user, success, error) {
                            $http.post(urls.BASE_API + '/patients/updateUserLocation.json',user).success(success).error(error)
                        },

                        getUsersLocation: function(user_id, success, error) {
                            $http.post(urls.BASE_API + '/patients/getUsersLocations/'+user_id+'.json').success(success).error(error)
                        },

                        getDocumentTypes: function (success, error) {
                            $http.get(urls.BASE_API + '/documentTypes/index.json').success(success).error(error)
                        },

                        getPatients: function (success, error) {
                            $http.get(urls.BASE_API + '/patients/index.json').success(success).error(error)
                        },

                        addPeoples: function(data, success, error) {
                            $http.post(urls.BASE_API + '/people/addPeople.json',data).success(success).error(error)
                        },

                        searchPatients: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/searchPatients.json',data).success(success).error(error)
                        },
                        getZones:function (success, error) {
                            $http.get(urls.BASE_API + '/Zones/index.json').success(success).error(error)
                        },
                        getRegimes:function (success, error) {
                            $http.get(urls.BASE_API + '/Regimes/index.json').success(success).error(error)
                        },
                        getAllEp:function (success, error) {
                            $http.get(urls.BASE_API + '/Eps/getAllEps.json').success(success).error(error)
                        },
                        getPatientById: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/getPatientById.json',data).success(success).error(error)
                        },

                        getallPatients: function(data, success, error) {
                            $http.post(urls.BASE_API + '/patients/getallPatients.json',data).success(success).error(error)
                        },
                        
                    };
                }
                
                ]);



                 angular.module('app')
                 .factory('peopleService', ['$http', 'urls', function ($http, urls) {

                    return {

                        getRoles: function (success, error) {
                            $http.get(urls.BASE_API + '/roles/index.json').success(success).error(error)
                        },

                        addRole: function (data, success, error) {
                            $http.post(urls.BASE_API + '/people/add.json',data).success(success).error(error)
                        },
                        updateRole: function (data, success, error) {
                            $http.post(urls.BASE_API + '/people/edit.json',data).success(success).error(error)
                        },

                        deleteRoles: function (data, success, error) {
                            $http.post(urls.BASE_API + '/people/delete.json',data).success(success).error(error)
                        },

                        getPeoples: function (data, success, error) {
                            $http.post(urls.BASE_API + '/people/getPeoples.json',data).success(success).error(error)
                        },

                        editPeoples: function (data, success, error) {
                            $http.post(urls.BASE_API + '/people/edit.json',data).success(success).error(error)
                        },

                        addPeoples: function(data, success, error) {
                            $http.post(urls.BASE_API + '/people/addPeople.json',data).success(success).error(error)
                        },

                        getLastPeople: function(success, error) {
                            $http.post(urls.BASE_API + '/people/getLastPeople.json').success(success).error(error)
                        },
                        searchPeople:function(data,success, error) {
                            $http.post(urls.BASE_API + '/people/searchPeople.json',data).success(success).error(error)
                        },
                        addUserPeo:function(data,success, error) {
                            $http.post(urls.BASE_API + '/people/addUserPeople.json',data).success(success).error(error)
                        },
                        getPeopleByIdentification : function(data,success, error) {
                            $http.post(urls.BASE_API + '/people/getPeopleByIdentification.json',data).success(success).error(error)
                        },
                        searchUsersByName: function(data,success, error) {
                            $http.post(urls.BASE_API + '/people/searchUsersByName.json',data).success(success).error(error)
                        },
                        

                    };
                }
                ]);


                 angular.module('app')
                 .factory('specialistService', ['$http', 'urls', function ($http, urls) {

                    return {
                        addSpecialist: function (data, success, error) {
                            $http.post(urls.BASE_API + '/specialists/addSpecialist.json',data).success(success).error(error)
                        },
                        
                        getSpecialistRestriction: function (data,success, error) {
                            $http.post(urls.BASE_API + '/ScheduleEspecialistRestrictions/getScheduleEspecialistRestriction.json',data).success(success).error(error)
                        },

                        getSpecialist: function (success, error) {
                            $http.post(urls.BASE_API + '/specialists/index.json').success(success).error(error)
                        },

                        saveSpecialistRestriction: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleEspecialistRestrictions/add.json',data).success(success).error(error)
                        },

                        editSpecialistRestriction: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleEspecialistRestrictions/edit.json',data).success(success).error(error)
                        },

                        dropSpecialistRestriction: function (data, success, error) {
                            $http.post(urls.BASE_API + '/ScheduleEspecialistRestrictions/delete.json',data).success(success).error(error)
                        },
                        getAllSpecialist :function (success, error) {
                            $http.post(urls.BASE_API + '/specialists/getAllSpecialist.json').success(success).error(error)
                        },
                        getSpecialistById: function(data,success,error){
                            $http.post(urls.BASE_API +'/Specialists/getSpecialistById.json',data).success(success).error(error)
                        },
                        getByUser:function(success,error){
                           $http.get(urls.BASE_API +'/Specialists/getByUser.json').success(success).error(error)
                       },
                       getPagSpecialist: function (data,success, error) {
                        $http.post(urls.BASE_API + '/specialists/getPagSpecialist.json',data).success(success).error(error)
                    },
                    getSpecialistSignature : function(data,success,error){
                       $http.post(urls.BASE_API + '/specialists/getSpecialistSignature.json',data).success(success).error(error)

                   },



               };
           }
           ]);


    /**
     * App, Clients. 
     */
     angular.module('app')
     .factory('clientsService', ['$http', 'urls', function ($http, urls) {

        return {
            getAll: function (data, success, error) {
                $http.post(urls.BASE_API + '/clients/getByPagination.json',data).success(success).error(error)
            },
            add: function (data, success, error) {
                $http.post(urls.BASE_API + '/clients/add.json',data).success(success).error(error)
            },
            edit: function (data, success, error) {
                $http.post(urls.BASE_API + '/clients/edit.json',data).success(success).error(error)
            },
            get: function (success, error) {
                $http.get(urls.BASE_API + '/clients/get.json').success(success).error(error)
            },
            getEnable: function (success, error) {
                $http.get(urls.BASE_API + '/clients/getEnable.json').success(success).error(error)
            },
            getClientSelected: function (data,success, error) {
                $http.post(urls.BASE_API + '/clients/getClientSelected.json',data).success(success).error(error)
            },
            getBusinesTerminos: function (success, error) {
                $http.get(urls.BASE_API + '/ClientBusiness/getBusinesTerm.json').success(success).error(error)
            },
            getClientBusines: function (data,success, error) {
                $http.post(urls.BASE_API + '/ClientBusiness/getClientsBusiness.json',data).success(success).error(error)
            },
            addClientBusines: function (data,success, error) {
                $http.post(urls.BASE_API + '/ClientBusiness/addClientBusiness.json',data).success(success).error(error)
            },
            getALlClient: function (success, error) {
                $http.get(urls.BASE_API + '/ClientBusiness/getALlClients.json').success(success).error(error)
            },
            getClientCont: function (success, error) {
                $http.post(urls.BASE_API + '/ClientContacts/getClientContact.json').success(success).error(error)
            },

            clientContactTyp: function (success, error) {
                $http.get(urls.BASE_API + '/ClientContacts/clientsContactTypes.json').success(success).error(error)
            },
            addContactClient: function (data, success, error) {
                $http.post(urls.BASE_API + '/ClientContacts/addContact.json', data).success(success).error(error)
            },
            editClientBusiness:function (data, success, error) {
                $http.post(urls.BASE_API + '/ClientBusiness/edit.json', data).success(success).error(error)
            },
            customerBusiness:function (data, success, error) {
                $http.post(urls.BASE_API + '/ClientBusiness/getCustomerBusiness.json', data).success(success).error(error)
            },

        };
    }
    ]);



        /** 
         * Obtiene las tarifas que pertenecena un cliente. 
         */
         angular.module('app')
         .factory('ratesClientsService', ['$http', 'urls', function ($http, urls) {

            return {
                getByClient: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RatesClients/getByClient.json',data).success(success).error(error)
                },

                getRate: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RateStudies/getRate.json',data).success(success).error(error)
                },

                getSelectedRate: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Rates/getSelectedRate.json',data).success(success).error(error)
                },

                getRateStudies: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RateStudies/getRateStudies.json',data).success(success).error(error)
                },

                getNewStudiesValues: function (data, success, error) {
                    $http.post(urls.BASE_API + '/RateStudies/getNewStudiesValues.json',data).success(success).error(error)
                },

            };
        }
        ]);


         angular.module('app')
         .factory('sheduleSpecialistsService', ['$http', 'urls', function($http, urls){
            return {
                add: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ScheduleSpecialists/add.json',data).success(success).error(error)
                },
            };
        }]);

         

        /**
     * App, Clients. 
     */
     angular.module('app')
     .factory('externalSpecialistsService', ['$http', 'urls', function ($http, urls) {

        return {
            getSearchSpecialist: function (data, success, error) {
                $http.post(urls.BASE_API + '/ExternalSpecialists/searchExternalSpecialist.json',data).success(success).error(error)
            },

            getExternalSpecialist: function (data,success, error) {
                $http.post(urls.BASE_API + '/ExternalSpecialists/getExternalSpecialist.json',data).success(success).error(error)
            },

            addSpecialist: function (data,success, error) {
                $http.post(urls.BASE_API + '/ExternalSpecialists/add.json',data).success(success).error(error)
            },
                // delete: function (data, success, error) {
                //     $http.post(urls.BASE_API + '/clients/delete.json',data).success(success).error(error)
                // },
                getExternalSpecialistById: function(data,success, error) {
                    $http.post(urls.BASE_API + '/ExternalSpecialists/view.json',data).success(success).error(error)
                },
            };
        }
        ]);
     
        /**
        * App Get Departments
        */
        angular.module('app')
        .factory('departmentsService', ['$http', 'urls', function ($http, urls) {

            return {
                get: function (success, error) {
                    $http.get(urls.BASE_API + '/departments/get.json').success(success).error(error)
                },
                        // add: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/departments/add.json',data).success(success).error(error)
                        // },
                        // edit: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/departments/edit.json',data).success(success).error(error)
                        // },
                        // delete: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/departments/delete.json',data).success(success).error(error)
                        // },
                    };
                }
                ]);
        /**
        * App Get Cities or municipalities. 
        */
        angular.module('app')
        .factory('municipalitiesService', ['$http', 'urls', function ($http, urls) {

            return {
                getByDepartment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/municipalities/getByDepartment.json',data).success(success).error(error)
                },
                getByMunicipality: function (data, success, error) {
                    $http.post(urls.BASE_API + '/municipalities/getByMunicipality.json',data).success(success).error(error)
                },
                        // add: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/municipalities/add.json',data).success(success).error(error)
                        // },
                        // edit: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/municipalities/edit.json',data).success(success).error(error)
                        // },
                        // delete: function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/municipalities/delete.json',data).success(success).error(error)
                        // },
                        
                        
                    };
                }
                ]);
        /** asignation the profecional services */
        angular.module('app')
        .factory('studiesSpecialistService', ['$http', 'urls', function ($http, urls) {

            return {
                getAllBySpecialist:function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/getAllBySpecialist.json',data).success(success).error(error)
                },
                getFilterStudies:function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/getFilterStudies.json',data).success(success).error(error)
                },
                addAll: function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/addAll.json',data).success(success).error(error)
                },
                get: function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/get.json',data).success(success).error(error)
                },
                add: function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/add.json',data).success(success).error(error)
                },
                
                edit: function (data, success, error) {
                    $http.post(urls.BASE_API + '/studiesSpecialists/edit.json',data).success(success).error(error)
                },
                delete: function (data, success, error) {
                   $http.post(urls.BASE_API + '/studiesSpecialists/delete.json',data).success(success).error(error)
               },
           };
       }
       ]);
                /** 
                 * Get all the specializations
                 */
                 angular.module('app')
                 .factory('specializationsService', ['$http', 'urls', function ($http, urls) {

                    return {
                        get: function (data,success, error) {
                            $http.post(urls.BASE_API + '/specializations/get.json',data).success(success).error(error)
                        },
                        getSpecializationsById: function (data,success, error) {
                            $http.post(urls.BASE_API + '/specializations/getSpecializationsById.json',data).success(success).error(error)
                        },
                        getSpecializations: function (success, error) {
                            $http.post(urls.BASE_API + '/specializations/getAllSpecializations.json').success(success).error(error)
                        },
                    };
                }

                ]);

       /** 
                 * Get all the specializations
                 */
                 angular.module('app')
                 .factory('costCentersService', ['$http', 'urls', function ($http, urls) {

                    return {
                        get: function (success, error) {
                            $http.get(urls.BASE_API + '/costCenters/get.json').success(success).error(error)
                        },
                        getSelectedCostCenters: function (data,success, error) {
                            $http.post(urls.BASE_API + '/costCenters/getSelectedCostCenters.json',data).success(success).error(error)
                        },
                    };
                }

                ]);
                 
                 

      /** 
        * Get all CODIGOS DE INVIMA
        */
        angular.module('app')
        .factory('invimaCodesService', ['$http', 'urls', function ($http, urls) {

            return {

                getInvimaCodes: function (data, success, error) {
                    $http.post(urls.BASE_API + '/InvimaCodes/getInvimaCodes.json',data).success(success).error(error)
                },
                getInvimaByProduc: function(data, success, error) {
                    $http.post(urls.BASE_API + '/InvimaCodes/getInvimaByProduc.json',data).success(success).error(error)
                },
                add : function(data, success, error){
                    $http.post(urls.BASE_API + '/InvimaCodes/add.json',data).success(success).error(error)
                }
        

        };
    }
    ]);



        /** 
         * Get all about the Marks
         */
         angular.module('app')
         .factory('marksService', ['$http', 'urls', function ($http, urls) {

            return {
                getAllMarks: function (success, error) {
                    $http.get(urls.BASE_API + '/Marks/getAllMarks.json').success(success).error(error)
                },
            };
        }

        ]);


        /** 
         * Get all about the Farmaseutic Forms
         */
         angular.module('app')
         .factory('farmaseuticFormService', ['$http', 'urls', function ($http, urls) {
            return {
                getAll: function (success, error) {
                    $http.get(urls.BASE_API + '/FarmaseuticForm/getAllFarmaseuticForm.json').success(success).error(error)
                },
            };
        }
        ]);

                 /** 
         * Get all about the Units
         */
         angular.module('app')
         .factory('unitsService', ['$http', 'urls', function ($http, urls) {

            return {
                getAllUnits: function (success, error) {
                    $http.get(urls.BASE_API + '/Units/getAllUnits.json').success(success).error(error)
                },
            };
        }

        ]);
         


         
                /** 
         * Get all about the Units
         */
         angular.module('app')
         .factory('storageUbicationsService', ['$http', 'urls', function ($http, urls) {

            return {
                getAllStorage: function (success, error) {
                    $http.get(urls.BASE_API + '/StorageUbications/getAllStorage.json').success(success).error(error)
                },

                getStoragesByCenter: function (data, success, error) {
                    $http.post(urls.BASE_API + '/StorageUbications/getStoragesByCenter.json',data).success(success).error(error)
                },

            };
        }

        ]);


             /** 
         * Get all about the Units
         */
         angular.module('app')
         .factory('StorageInputsService', ['$http', 'urls', function ($http, urls) {

            return {
                        //obtiene todos  los productos que se encuentran en una bodega.
                        getAllStorageInputs: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/getAllStorageInputs.json',data).success(success).error(error)
                        },

                        getStorageProduct: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/getStorageProduct.json',data).success(success).error(error)
                        },

                        updateInputQuote: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/updateInputQuote.json',data).success(success).error(error)
                        },

                        addInputs: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/addInputs.json',data).success(success).error(error)
                        },
                        getInputProduct: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/getInputProduct.json',data).success(success).error(error)
                        },
                        
                        getAllInputs: function (data,success, error) {
                            $http.post(urls.BASE_API + '/StorageInputs/getAllInputs.json',data).success(success).error(error)
                        },

                        productReasume: function(data,success, error) {
                            $http.get(urls.BASE_API + '/StorageInputs/productReasume.json',data).success(success).error(error)
                        },
                    };
                }

                ]);

         //         /** 
         // * Get all Inventarios
         // */
         // angular.module('app')
         //        .factory('inventoryService', ['$http', 'urls', function ($http, urls) {

         //            return {

         //             };
         //        }

         //  ]);


         angular.module('app')
         .factory('studiesService', ['$http', 'urls', function ($http, urls) {

           return {
               get: function (success, error) {
                   $http.get(urls.BASE_API + '/studies/get.json').success(success).error(error)
               },
               getBySpecialization: function (data, success, error) {
                $http.post(urls.BASE_API + '/studies/getBySpecialization.json',data).success(success).error(error)
            },

            queryStudies: function (data, success, error) {
                $http.post(urls.BASE_API + '/studies/queryStudies.json',data).success(success).error(error)
            },

                         // add: function (data, success, error) {
                         //     $http.post(urls.BASE_API + '/departments/add.json',data).success(success).error(error)
                         // },
                         // edit: function (data, success, error) {
                         //     $http.post(urls.BASE_API + '/departments/edit.json',data).success(success).error(error)
                        // },
                         // delete: function (data, success, error) {
                         //     $http.post(urls.BASE_API + '/departments/delete.json',data).success(success).error(error)
                         // },
                     };
                 }
                 ]);



        /**
         * Servicio para crear una nueva orden
         */
         angular.module('app')
         .factory('appointmentService', ['$http', 'urls', function ($http, urls) {

           return {
               saveAppointment: function (data, success, error) {
                   $http.post(urls.BASE_API + '/Appointments/saveAppointment.json', data).success(success).error(error)
               },

               saveAppointmentDates: function (data, success, error) {
                   $http.post(urls.BASE_API + '/AppointmentDates/saveAppointmentDates.json', data).success(success).error(error)
               },

               cancelAppointmentDates: function (data, success, error) {
                   $http.post(urls.BASE_API + '/AppointmentDates/cancelAppointmentDates.json', data).success(success).error(error)
               },

               getAppointment: function (data, success, error) {
                   $http.post(urls.BASE_API + '/Appointments/getAppointment.json', data).success(success).error(error)
               },

               deleteAppointment: function (data, success, error) {
                   $http.post(urls.BASE_API + '/Appointments/deleteAppointment.json', data).success(success).error(error)
               },

               getAppointmentsDay: function (data, success, error) {
                   $http.post(urls.BASE_API + '/AppointmentStates/getAppointmentsDay.json', data).success(success).error(error)
               },

               getMedicalOfficesByService: function (data, success, error) {
                   $http.post(urls.BASE_API + '/Appointments/getMedicalOfficesByService.json', data).success(success).error(error)
               },

               getAvailableDatesRangeByMedicalOffice: function (data, success, error) {
                   $http.post(urls.BASE_API + '/Appointments/getAvailableDatesRangeByMedicalOffice.json', data).success(success).error(error)
               },
                         //  PRUEBA OBTENER CITAS PARA EL DIA
                         
                         getAllAppoinmentsByDay: function (data, success, error) {
                           $http.post(urls.BASE_API + '/Appointments/getAllAppoinmentsByDay.json', data).success(success).error(error)
                       },

                       getAppointmentDates: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentDates/getAppointmentDates.json', data).success(success).error(error)
                       },

                       cancelAppointment: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentDates/cancelAppointment.json', data).success(success).error(error)
                       },
                       cancelReasons:function (data, success, error) {
                           $http.post(urls.BASE_API + '/CancelReasons/cancelReasons.json', data).success(success).error(error)
                       },

                       saveOrderAppointment:function (data, success, error) {
                           $http.post(urls.BASE_API + '/Orders/saveOrderAppointment.json', data).success(success).error(error)
                       },

                       getValidationAppointment: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentDates/getValidationAppointment.json', data).success(success).error(error)
                       },

                       updateAppointmentDates: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentDates/updateAppointmentDates.json', data).success(success).error(error)
                       },

                       saveAttention:  function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentDates/saveAttention.json',data).success(success).error(error)
                       },
                       getRatesClients:  function (data, success, error) {
                           $http.post(urls.BASE_API + '/Clients/getPlanForUser.json',data).success(success).error(error)
                       },
                       updateAppointment: function (data, success, error) {
                           $http.post(urls.BASE_API + '/Appointments/updateAppointment.json',data).success(success).error(error)
                       },
                       getProductos: function (data, success, error) {
                           $http.post(urls.BASE_API + '/Studies/getServicesProducts.json', data).success(success).error(error)
                       },
                       getAttentionsRipsUs: function (data, success, error) {
                           $http.post(urls.BASE_API + '/Appointments/attentions.json', data).success(success).error(error)
                       },
                       getAppointmentsByIdentification: function( data, success, error ){

                        $http.post( urls.BASE_API + '/Appointments/getAppointmentsByIdentification.json' , data).success( success ).error( error );

                    }, 


                };
            }
            ]);

        /**
         * Servicio crear los supplies-> productos utilizados en un studio 
         */
         angular.module('app')
         .factory('suppliesService', ['$http', 'urls', function ($http, urls) {

           return {

               addAppointmentsSupplies: function (data, success, error) {
                   $http.post(urls.BASE_API + '/AppointmentsSupplies/add.json', data).success(success).error(error)
               }, 
                         // obtiene todos los productos para un appointment seleccionado.
                         getByIdAppointmentsSupplies: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentsSupplies/getById.json', data).success(success).error(error)
                       },
                       editAppointmentsSupplies: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentsSupplies/edit.json', data).success(success).error(error)
                       }, 
                       getSuppliesByIdAppointment: function (data, success, error) {
                           $http.post(urls.BASE_API + '/AppointmentsSupplies/getByOneId.json', data).success(success).error(error)
                       },

                   };
               }
               ]);


  /**
         * Servicio crear los registro de las plantillas de control
         */
         angular.module('app')
         .factory('controlFormatsService', ['$http', 'urls', function ($http, urls) {

           return {

               saveControlFormats: function (data, success, error) {
                   $http.post(urls.BASE_API + '/ControlFormats/save.json', data).success(success).error(error)
               }, 


           };
       }
       ]);


         angular.module('app')
         .factory('studiesMedicalOffices', ['$http', 'urls', function ($http, urls) {

            return {

                        // getAllBySpecialist:function (data, success, error) {
                        //     $http.post(urls.BASE_API + '/studiesSpecialists/getAllBySpecialist.json',data).success(success).error(error)
                        // },
                        
                        getMedicalOfficesServicesBySpecialization: function (data, success, error) {
                            $http.post(urls.BASE_API + '/StudiesMedicalOffices/getMedicalOfficesServicesBySpecialization.json',data).success(success).error(error)
                        },

                        /**
                         * Funcion que obtiene las especializaciones relacionadas a los servicios de un especialista
                         */
                         getSpecializations: function (data, success, error) {
                            $http.post(urls.BASE_API + '/StudiesMedicalOffices/getMedicalOfficesSpecializations.json',data).success(success).error(error)
                        },

                        /**
                         * Funcion que asigna los estudios seleccionados a un consultorio
                         */
                         addAll: function (data, success, error) {
                            $http.post(urls.BASE_API + '/StudiesMedicalOffices/addAll.json',data).success(success).error(error)
                        },

                        getMedicalOfficesServices:function (data, success, error) {
                            $http.post(urls.BASE_API + '/StudiesMedicalOffices/getMedicalOfficesServices.json',data).success(success).error(error)
                        },

                        get: function (data, success, error) {
                            $http.post(urls.BASE_API + '/studiesSpecialists/get.json',data).success(success).error(error)
                        },
                        add: function (data, success, error) {
                            $http.post(urls.BASE_API + '/studiesSpecialists/add.json',data).success(success).error(error)
                        },
                        
                        edit: function (data, success, error) {
                            $http.post(urls.BASE_API + '/studiesSpecialists/edit.json',data).success(success).error(error)
                        },
                        delete: function (data, success, error) {
                           $http.post(urls.BASE_API + '/studiesSpecialists/delete.json',data).success(success).error(error)
                       },



                   };

               }
               ]);


         angular.module('app')
         .factory('BillsService', ['$http', 'urls', function ($http, urls) {

            return {
                generateBill: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Bills/generateBill.json',data).success(success).error(error)
                },
                saveBill: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Bills/saveBill.json',data).success(success).error(error)
                },
                saveManualBill: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ManualBills/saveBill.json',data).success(success).error(error)
                },

                saveManualBillProduct: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ManualBillsProducts/saveProduct.json',data).success(success).error(error)
                },
                getBills: function(data,success,error){
                    $http.post(urls.BASE_API + '/Bills/getBillsByDate.json',data).success(success).error(error)
                },
                getBillByOrder: function(data,success,error){
                    $http.post(urls.BASE_API + '/Bills/getBillByOrder.json',data).success(success).error(error)
                },
                generateBillDetailReport: function(data,success,error){
                    $http.post(urls.BASE_API + '/Bills/generateBillDetailReport.json',data).success(success).error(error)
                },
                /**
                 * Anular una Factura.
                 * @author Deicy Rojas <deirojas.1@gmail.com>
                 * @date     2016-12-07
                 * @datetime 2016-12-07T16:44:39-0500
                 */
                 cancelBill: function(data,success,error){
                    $http.post(urls.BASE_API + '/CancelBills/cancelBill.json',data).success(success).error(error)
                },
                getCancelReazons: function(data,success,error){
                   $http.post(urls.BASE_API + '/CancelBills/getCancelReazons.json',data).success(success).error(error)
               },
               /**
                * Obtiene lista de facturas de una misma orden.
                * @author Deicy Rojas <deirojas.1@gmail.com>
                * @date     2016-12-19
                * @datetime 2016-12-19T14:41:57-0500
              
                */
                getAllOrderBills: function(data,success,error){
                    $http.post(urls.BASE_API + '/Bills/getAllOrderBills.json',data).success(success).error(error)
                },

            };
        }
        ]);

         angular.module('app')
         .factory('saleNoteService', ['$http', 'urls', function ($http, urls) {

            return {
               /**
                 * Nota de Venta de una Factura.
                 * @author Deicy Rojas <deirojas.1@gmail.com>
                 * @date     2016-12-07
                 * @datetime 2016-12-07T16:44:58-0500
                 */
                 saleNoteBills: function(data,success,error){
                    $http.post(urls.BASE_API + '/SaleNotes/saleNoteBills.json',data).success(success).error(error)
                },
                getSaleNotesReazons: function(data,success,error){
                   $http.post(urls.BASE_API + '/SaleNotes/getSaleNotesReazons.json',data).success(success).error(error)
               },

           };
       }
       ]);



         angular.module('app')
         .factory('signatureService', ['$http', 'urls', function ($http, urls) {

            return {
                saveSignature: function (data, success, error) {
                    $http.post(urls.BASE_API + '/ScheduleIntervals/saveSignature.json',data).success(success).error(error)
                }
                
            };
        }
        ]);


         angular.module('app')
         .factory('mammogramService', ['$http', 'urls', function ($http, urls) {

            return {
                addMammogram: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Mammogram/add.json',data).success(success).error(error)
                }
                
            };
        }
        ]);


         angular.module('app')
         .factory('cardiologyEkgService', ['$http', 'urls', function ($http, urls) {

            return {
                addCardiologyEkg: function (data, success, error) {
                    $http.post(urls.BASE_API + '/CardiologyEkg/addCardiologyEkg.json',data).success(success).error(error)
                }
                
            };
        }
        ]);


         angular.module('app')
         .factory('CardiologyErgometryService', ['$http', 'urls', function ($http, urls) {

            return {
                addCardiologyErgo: function (data, success, error) {
                    $http.post(urls.BASE_API + '/CardiologyErgometry/addCardiologyErgo.json',data).success(success).error(error)
                }
                
            };
        }
        ]);

         angular.module('app')
         .factory('tacsService', ['$http', 'urls', function ($http, urls) {

            return {
                addTacs: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Tacs/addTacs.json',data).success(success).error(error)
                }
                
            };
        }
        ]);

         angular.module('app')
         .factory('cardiologyMonitoringService', ['$http', 'urls', function ($http, urls) {

            return {
                addCardiologyMonitoring: function (data, success, error) {
                    $http.post(urls.BASE_API + '/CardiologyMonitoring/addCardiologyMonitoring.json',data).success(success).error(error)
                }
                
            };
        }
        ]);


         angular.module('app')
         .factory('nuclearService', ['$http', 'urls', function ($http, urls) {

            return {
                addNuclear: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Nuclear/addNuclear.json',data).success(success).error(error)
                }
                
            };
        }
        ]);


         angular.module('app')
         .factory('specialistRoleService', ['$http', 'urls', function ($http, urls) {

            return {
                getSpecialistRole: function (data, success, error) {
                    $http.post(urls.BASE_API + '/SpecialistRole/getSpecialistRole.json',data).success(success).error(error)
                }
                
            };
        }
        ]);

         angular.module('app')
         .factory('xrayService', ['$http', 'urls', function ($http, urls) {

            return {
                addXray: function (data, success, error) {
                    $http.post(urls.BASE_API + '/XRays/addXray.json',data).success(success).error(error)
                }
                
            };
        }
        ]);

         angular.module('app')
         .factory('CardiologyConsultarionEcoService', ['$http', 'urls', function ($http, urls) {

            return {
                addCardologyConsul: function (data, success, error) {
                    $http.post(urls.BASE_API + '/CardiologyConsultarionEco/addCardologyConsul.json',data).success(success).error(error)
                }
                
            };
        }
        ]);

         angular.module('app')
         .factory('OrderAppointmentsService', ['$http', 'urls', function ($http, urls) {

            return {
                getOrderAppoinment: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrderAppointments/getOrderAppoinment.json',data).success(success).error(error)
                },
                printSticker: function (data, success, error) {
                    $http.post(urls.BASE_API + '/OrderAppointments/printSticker.json',data).success(success).error(error)
                },
                


                
            };
        }
        ]);


         angular.module('app')
         .factory('outputsService', ['$http', 'urls', function ($http, urls) {

            return {
                addOutputs: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Outputs/addOutputs.json',data).success(success).error(error)
                }

                
            };
        }
        ]);

         angular.module('app')
         .factory('transferService', ['$http', 'urls', function ($http, urls) {

            return {
                addTransfer: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Transfers/addTransfer.json',data).success(success).error(error)
                },

                
            };
        }
        ]);

         angular.module('app')
         .factory('printControlsService', ['$http', 'urls', function ($http, urls) {

            return {
                addPrintControl: function (data, success, error) {
                    $http.post(urls.BASE_API + '/PrintControls/addPrintControl.json',data).success(success).error(error)
                },
                getPrintNumber: function (data, success, error) {
                    $http.post(urls.BASE_API + '/PrintControls/getPrintNumber.json',data).success(success).error(error)
                },
                
            };
        }
        ]);

         
         angular.module('app')
         .factory('lendPlatesService', ['$http', 'urls', function ($http, urls) {

            return {
                addLend: function (data, success, error) {
                    $http.post(urls.BASE_API + '/LendPlates/addLend.json',data).success(success).error(error)
                },
                getLendPlatesById: function (data, success, error) {
                    $http.post(urls.BASE_API + '/LendPlates/getLendPlatesById.json',data).success(success).error(error)
                },

                
            };
        }
        ]);

        /**
         * Ingreso de Registros para interfaz contable.
         * Deicy R.
         */
         angular.module('app')
         .factory('accountService', ['$http', 'urls', function ($http, urls) {

            return {
                addFE: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Account/addFE.json',data).success(success).error(error)
                },
                addFV: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Account/addFV.json',data).success(success).error(error)
                },

                addAccountManual: function (data, success, error) {
                    $http.post(urls.BASE_API + '/Account/addAccountManual.json',data).success(success).error(error)
                }, 
            };
        }
        ]);




         angular.module('app')
         .factory('pruebaUsuarioService', ['$http', 'urls', function ($http, urls) {

            return {
             saveUserPrueba: function (data, success, error) {
                $http.post(urls.BASE_API + '/PruebaUsuario/add.json',data).success(success).error(error)
            },

            
        };
    }
    ]);

         



         angular.module('app')
         .factory('fileUpload', ['$http','urls', function ($http, urls) {



            return {

                /**
                 * Subir archivo
                 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                 * @date     2016-09-13
                 * @datetime 2016-09-13T15:02:41-0500
                 * @param    {[type]}                 file    [description]
                 * @param    {[type]}                 success [description]
                 * @param    {[type]}                 error   [description]
                 * @return   {[type]}                         [description]
                 */
                 uploadFile: function (file, success, error) {

                    var fd = new FormData();
                    
                    fd.append('file', file);

                    $http.post(urls.BASE_API + '/ScheduleIntervals/saveFile.json',fd, {

                        transformRequest: angular.identity,
                        
                        headers: {'Content-Type': undefined}
                        
                    }
                    ).success(success).error(error)
                },

                /**
                 * Subir foto de paciente
                 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                 * @date     2016-09-13
                 * @datetime 2016-09-13T15:02:30-0500
                 * @param    {[type]}                 data    [description]
                 * @param    {[type]}                 file    [description]
                 * @param    {[type]}                 success [description]
                 * @param    {[type]}                 error   [description]
                 * @return   {[type]}                         [description]
                 */
                 uploadPhotoPatient: function (data, file, success, error) {

                    var fd = new FormData();
                    
                    fd.append('file', file);

                    fd.append('data', JSON.stringify(data));

                    $http.post(urls.BASE_API + '/Orders/savePhotoPeople.json',fd, {

                        transformRequest: angular.identity,
                        
                        headers: {'Content-Type': undefined}
                        
                    }
                    ).success(success).error(error)
                },

                   /**
                    * Subir archivos a orden
                    * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                    * @date     2016-09-13
                    * @datetime 2016-09-13T15:02:20-0500
                    * @param    {[type]}                 data    [description]
                    * @param    {[type]}                 files   [description]
                    * @param    {[type]}                 success [description]
                    * @param    {[type]}                 error   [description]
                    * @return   {[type]}                         [description]
                    */
                    uploadOrderFiles: function (data, files, success, error) {

                        var fd = new FormData();
                        
                        for (var i = 0; i < files.length; i++) {


                            fd.append('files[]', files[i]['_file']);
                        }


                        fd.append('data', JSON.stringify(data));

                        $http.post(urls.BASE_API + '/Orders/saveFiles.json',fd, {

                            transformRequest: angular.identity,
                            
                            headers: {'Content-Type': undefined}
                            
                        }
                        ).success(success).error(error)
                    },

                    
                }
                
            }]);


         angular.module('app')
         .factory('fileUploadSignature', ['$http','urls', function ($http, urls) {

            return {

                /**
                 * Subir firma de especialista
                 * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
                 * @date     2016-09-13
                 * @datetime 2016-09-13T15:02:59-0500
                 * @param    {[type]}                 file    [description]
                 * @param    {[type]}                 data    [description]
                 * @param    {[type]}                 success [description]
                 * @param    {[type]}                 error   [description]
                 * @return   {[type]}                         [description]
                 */
                 uploadFileSignature: function (file,data,success,error) {

                    var fd = new FormData();
                    
                    fd.append('file', file);

                    // for (var key in specialist) {
                    //     fd.append('specialist', key);
                    // }
                    
                    
                    fd.append('id', data);

                    $http.post(urls.BASE_API + '/Specialists/saveFileSignature.json',fd, {

                        transformRequest: angular.identity,
                        
                        headers: {'Content-Type': undefined}
                        
                    }
                    ).success(success).error(error)
                },

                
                
            }
            
        }]);


         angular.module('app')
         .factory('Auth', ['$http', '$localStorage', 'urls', function ($http, $localStorage, urls) {
            function urlBase64Decode(str) {
                var output = str.replace('-', '+').replace('_', '/');
                switch (output.length % 4) {
                    case 0:
                    break;
                    case 2:
                    output += '==';
                    break;
                    case 3:
                    output += '=';
                    break;
                    default:
                    throw 'Illegal base64url string!';
                }
                return window.atob(output);
            }

            function getClaimsFromToken() {

                var token = $localStorage.token;

                var user = {};

                if (token != undefined) {

                    var encoded = token.split('.')[1];

                    user = JSON.parse(urlBase64Decode(encoded));

                }

                return user;

            }



            return {

                signin: function (data, success, error) {
                    $http.post(urls.BASE_API + '/users/token.json', data).success(success).error(error)
                },

                logout: function (success) {
                    tokenClaims = {};

                    //delete $localStorage.token;
                    
                    $localStorage.$reset();

                    

                    //aqui va el reset all localStore
                },

                getTokenClaims: function () {
                    return getClaimsFromToken();
                },
            };


        }
        ]);






     })();











