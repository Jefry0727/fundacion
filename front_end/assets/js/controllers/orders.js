'use strict';

/* Controllers */

angular.module('app')
    .controller('ordersCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'ordersService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, ordersService) {

    	$('#timepicker').timepicker();

    	/*
    	 *new Order Model
    	 */

    	$scope.newOrder = {

    		order_consec:''
    

    	};

        /**
         * Model Edit Order
         */

        $scope.editOrder = {

            id:0,
            order_consec:'',
            created:'',
            modified:'',
            order_details_id:'',
            users_id:'',
            order_states_id:''
           

        };

        /** 
         * Model Drop Order
         */


         $scope.dropNewOrder = {};

    	/**
    	 * Function add New Order
    	 */

    	$scope.addNewOrder = function(){

    		$scope.newOrder = {

    		order_consec:''

    	};

    	}

    	/**
    	 * Show modal add new order
    	 */
  
    	$scope.modalNewOrder = function()
    	{
    		$('.add-new-order').modal('show');
    	}

    	/**
    	 * Hide modal add new order
    	 */

    	$scope.modalnewOrder = function()
    	{
    		$('.add-new-order').modal('hide');

        
    	}

        /**
         * Modal Edit Order
         */
        
        $scope.showEditOrder = function(orderConsec){

            $scope.editOrder = orderConsec;

            console.log( $scope.editOrder);

            $('.edit-new-order').modal('show');
        }

        $scope.hideEditOrder =function(){

            $('.edit-new-order').modal('hide');

        }

        /**
         * Modal Drop Order
         */

        $scope.showDropOrder = function(dropNewOrder){

            $scope.dropNewOrder = dropNewOrder;

            $('.remove-new-order').modal('show');

        }

        $scope.hideDropOrder = function(){

            $('.remove-new-order').modal('hide');
        }

    	/**
    	 *  Function save new Order
    	 */

    	 $scope.saveNewOrder = function(){

    	 	ordersService.addOrder($scope.newOrder, function(res){

 
    	 		console.log(res);

    	 		if(res.success == true){

    	 			$scope.addNewOrder();

    	 			console.log($scope.addNewOrder);
    	 		}
    	 	});

    	 }


         /*
          *  Function Edit Order
          */

        $scope.updateNewOrder = function(){

            ordersService.updateOrder($scope.editOrder, function(res){

            if(res.success == true){

               $scope.hideEditOrder();
               $scope.pageResultsOrders(0);
            }

            });

        }

        /**
         * Function drop Order
         */
        
        $scope.dropOrder = function(){

            ordersService.dropOrder($scope.dropNewOrder, function(res){

                console.log(res);

                if(res.success == true){

                    $scope.pageResultsOrder(0);
                    $scope.hideDropOrder();
                }

            });

        }

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageOrder = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeOrder = 10;


            /**
         * Función que asigna los elementos a mostrar en la paginación actual
         * @param  {Int} page Numero de la pagina
         */
        $scope.pageResultsOrders = function(page){


                var offset = 0;

                if (page > 1) {

                    offset = (page - 1) * 10
                }

                ordersService.getOrder({offset: offset}, function(res){
            

                    console.log(res);                   

                    /**
                     * Número total de items
                     * @type {Int}
                     */
                    $scope.orderTotal = res.orderTota;

                    
                    $scope.orderConsecs = res.order_consec;    


                    console.log($scope.orderConsecs);    


                }, function (error) {
            
            });
           
        };


        $scope.pageResultsOrders(0);
    	
}]);