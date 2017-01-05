/* ============================================================
 * File: main.js
 * Main Controller to set global scope variables. 
 * ============================================================ */

 angular.module('app')
 .controller('AppCtrl', ['$scope', 
  '$rootScope', 
  '$state', 
  'urls', 
  '$location',
  '$timeout', 
  'permissionsService', 
  '$localStorage', 
  function($scope, 
    $rootScope, 
    $state, 
    urls, 
    $location,
    $timeout,
    permissionsService, 
    $localStorage) {

        // App globals
        $scope.app = {
          name: 'Fund. Alejandro Londoño',
          description: 'Sofware Administrativo Medico',
          layout: {
            menuPin: false,
            menuBehind: false,
                // font:'assets/css/monserat-font.css',
                theme: 'pages/css/pages.css',

              },
              //author: 'Revox'
              author: 'Gato Loco Stuidos'
            }


        /**
         * Julián Andrés Muñoz Cardozo
         * 2016-09-0715:23:16
         * Obtencion del rol autenticado
         */
         $scope.role =   $localStorage.role;


        // console.log('entro a rol'); 

        // console.log($scope.role);

        // Checks if the given state is the current state
        // $scope.is = function(name) {
        //     return $state.is(name);
        // }

        // Checks if the given state/child states are present
        // $scope.includes = function(name) {
        //     return $state.includes(name);
        // }

        // Broadcasts a message to pgSearch directive to toggle search overlay
        // $scope.linkSubMenu = function(subPermissions) {

        //     // console.log('entro subpermisos');
        //     // console.log(subPermissions);

        //     if(subPermissions.action == ''){

        //         $state.go('app.home');
        //         $('.menu-modal').modal('hide');

        //     }else{


        //         $state.go('app.'+subPermissions.action);
        //         $('.menu-modal').modal('hide');


        //     }

        
        // }

        $scope.showSearchOverlay = function() {

          $scope.$broadcast('toggleSearchOverlay', {
            show: true
          });

        }

         /**
         * All permissions available
         */
         $scope.permissions;


         $rootScope.getPermissions = function(){


           $scope.role =  $localStorage.role;



            /**
             * calling service to get all permissions
             */
             permissionsService.getPermissions(function(res){

                    // // console.log('ingreso');

                    $scope.permissions = res.results;

                    // // console.log($scope.permissions[0]);

                    $scope.temp = $scope.permissions[0].name;

                    // // console.log(res.results);


                    $scope.getAllPermissionsMenu($scope.permissions[0]);



                  }, function (error) {

                       // console.log(error);

                     });  

           }


           if($scope.role != undefined){


            $scope.getPermissions();


          }        

        /**
         * logout cuando no hay un token de sesion
         * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
         * @date     2016-09-09
         * @datetime 2016-09-09T16:43:10-0500
         * @param    {[type]}                 $localStorage.token [description]
         * @return   {[type]}                                     [description]
         */
         if($localStorage.token == undefined ){


          $localStorage.$reset();

           /**
             * redirect 
             */
             $location.path('auth/login');

           }


        /**
         * subPermisos
         */
         $scope.subPermissions;

         $scope.getAllPermissionsMenu = function(permission) {


            /**
             * calling service to get all permissions
             */

            // $scope.permissions = permission;

            // // console.log($scope.permissions);  

            if($scope.role != ''){

                // // console.log('entro');

                permissionsService.getAllPermissionsMenu({id:permission.id, idRole:$scope.role},function(res){

                  $scope.subPermissions = res.results;

                  if($scope.temp != permission.name){

                    $scope.navClass = "";

                  }

                    // // console.log($scope.subPermissions);

                  }, function (error) {

                  });  

              }      


            }

       /**
        * Mostrar la modal del menu
        * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
        * @date     2016-09-09
        * @datetime 2016-09-09T16:43:49-0500
        * @return   {[type]}                 [description]
        */
        $scope.showModalMenu = function() {

         $scope.transformPermissions(true);
         $scope.showModalAviableOfficeService2();
          //  $('.menu-modal').modal('show');
     

        }



        $scope.navClass = function (page) {
          var currentRoute = $scope.permissions[0].name;
            // // console.log('entro al nav');
            // // console.log(currentRoute);
            return page === currentRoute ? 'actives' : '';
          };


        /**
         * Logout Function
         * @return {[type]} [description]
         */
         $scope.logout = function(){

            /**
             * Drop localstorage session token
             */
           // delete $localStorage.token;

           $localStorage.$reset()

            /**
             * redirect 
             */
             $location.path('auth/login');

           }

        /**
         * Get user info from localstorage
         * @return {[type]} [description]
         */
         $scope.getUserFromLs = function(){

          $scope.user = $localStorage.user;
          $scope.person = $localStorage.person;
        }


        $scope.getUserFromLs();


        //          ------------------------     INICIO NUEVA MODAL -------------------


       /**
        * Modal List Available Service Office
        */

        $scope.newException = {
          date: '',
          date_ini:'',
          date_end:'',
          description: ''
        };


/**
 * modal option 2
 *
 */

 $scope.showModalAviableOfficeService2 = function(){

  $('.list-available-office-service2').css('width', '100%');
        // $('.list-available-office-service').css('margin', '100px auto 100px auto');
        $('.list-available-office-service2').modal('show');

      }

      $scope.hideModalAviableOfficeService = function(){


        $('.list-available-office-service2').modal('hide');


      }  


      $scope.goToState = function(state){



        $scope.hideModalAviableOfficeService();

        $timeout(function () {

          $state.go('app.' + state);


        }, 200);

      }




      $scope.allPermissions = undefined;         

      $scope.menuPermissions = new Array();

      $scope.transformPermissions = function(){


            // $scope.menuPermissions = ;
            if( $scope.allPermissions != undefined){

              for (var i = 0; i < $scope.allPermissions.length; i++) {


                $scope.menuPermissions[$scope.allPermissions[i].permission.permission_identifier] = $scope.allPermissions[i].childPermissions;

              }

              l($scope.menuPermissions);
            }
          }
          /**
           * Validar que si exista un login antes de iniciar seccion
           * @author Deicy Rojas <deirojas.1@gmail.com>
           * @date     2016-09-27
           * @datetime 2016-09-27T18:01:16-0500
           * @param    {[type]}                 $localStorage.user !             [description]
           * @return   {[type]}                                    [description]
           */
          if($localStorage.user != undefined){

            permissionsService.getAllPermissions({roleId: $localStorage.user.roles_id}, function(res){

               $scope.allPermissions = res.completePermissions;

               $scope.transformPermissions();
            


           });
          }


        }]);



angular.module('app')
    /*
        Use this directive together with ng-include to include a 
        template file by replacing the placeholder element
        */

        .directive('includeReplace', function() {
          return {
            require: 'ngInclude',
            restrict: 'A',
            link: function(scope, el, attrs) {
              el.replaceWith(el.children());
            }
          };
        })