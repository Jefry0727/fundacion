'use strict';

/* Controllers */

angular.module('app')
    .controller('newProviderCtrl', ['$scope', 
        '$state',
        '$rootScope',
        '$localStorage',
        '$location',
        '$timeout', 
        'ordersService',
        'productsService',
        'providersService', 
      'marksService',
        function($scope, 
            $state, 
            $rootScope, 
            $localStorage, 
            $location, 
            $timeout, 
            ordersService,
            productsService,
            providersService,
        marksService) {

        $('#timepicker').timepicker();

      $scope.date = moment(new Date()).format('YYYY-MM-DD');


      /**
       * [provider description]
       * @type {Object}
       */
      $scope.provider = {

        'id':0,
        'code':'',
        'nit':'',
        'name':'',
        'phone':'',
        'phone_two':'',
        'address':'',
        'email':'',
        'contact':'',
        'state':1
      };

      /**
       * [resetProvider description]
       * @return {[type]} [description]
       */
      $scope.resetProvider = function(){

        $scope.provider = {

        'id':0,
        'code':'',
        'nit':'',
        'name':'',
        'phone':'',
        'phone_two':'',
        'address':'',
        'email':'',
        'contact':'',
        'state':1
        };
      }

       /**
         * [updateProvider description]
         * @type {Object}
         */
        $scope.updateProvider = {

            'id':0,
            'code':'',
            'nit':'',
            'name':'',
            'phone':'',
            'phone_two':'',
            'address':'',
            'email':'',
            'contact':'',
            'state':1
        };


         /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageNewProvider = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeNewProvider = 10;

        /**
         * [getProviders description]
         * @param  {[type]} page [description]
         * @return {[type]}      [description]
         * 
         */
       $scope.getProviders = function(page){

              var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

           providersService.allProviders({offset : offset},function(res){

            console.log(res)

            if(res.success == true){

              $scope.total = res.total;

              $scope.providers = res.providers;

            }
                              
                }, function (error) {
                    console.log(error);
            });

        }

        //Inicialización de la función
        $scope.getProviders(0);

        /** @type {Array} [description] */
        $scope.state = [

          {name:'Habilitado', code:1},
          {name:'Inhabiitado', code:0}

        ];

        /**
         * [stateAct description]
         * @param  {[type]} provider [description]
         * @return {[type]}          [description]
         */
        $scope.stateAct = function(provider)
        {

          $scope.updateProvider = provider;

          if($scope.updateProvider.state == 1){

            $scope.updateProvider.state = 0;

          }else{

            $scope.updateProvider.state = 1;

          }

          providersService.editProviders($scope.updateProvider, function(res){

            if(res.success == true){

              $scope.hideEditProvider();
              $scope.getProviders();

            }

          });

        }

        /**
         * [newProvider description]
         * @return {[type]} [description]
         */
        $scope.newProvider = function(){

          providersService.addProviders($scope.provider, function(res){


            if(res.success == true){

              $scope.resetProvider();
              $scope.getProviders();

              $state.go('app.newProvider');
              location.reload();

            }

          });

        }

        /** [editProvider description] */
        $scope.editProvider = function(){

          providersService.editProviders($scope.updateProvider, function(res){


            if(res.success == true){

              $scope.hideEditProvider();

              $scope.getProviders();

            }

          });

        }

        /**
         * [modalEditProvider description]
         * @param  {[type]} provider [description]
         * @return {[type]}          [description]
         */
        $scope.showEditProvider = function(provider){

          $scope.updateProvider = provider;

          $('.modal-edit-provider').modal('show');

        }

        /**
         * [hideEditProvider description]
         * @return {[type]} [description]
         */
        $scope.hideEditProvider = function(){

          $('.modal-edit-provider').modal('hide');

        }
       
}]);