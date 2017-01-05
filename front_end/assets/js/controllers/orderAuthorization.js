'use strict';

/* Controllers */

angular.module('app')
    .controller('orderAuthorizationCtrl', [
    		'$scope', 
    		'$state',
    		'$localStorage',
    		'$location',
    		'$timeout',
			'ordersService', 
			'OrdersAuthorizationService',
			'urls',
    		function(
    			$scope, 
    			$state, 
    			$localStorage, 
    			$location, 
    			$timeout, 
    			ordersService,
    			OrdersAuthorizationService,
    			urls) {

    			// Objeto para enviar a la tabla de autorizaciones
    			$scope.order_authorization = {
    				observations : undefined,
    				state: undefined
    			}



	    			
    			// Obtiene las sedes
	    			$scope.getCenters = function(){
	 			
	    				ordersService.getCenters(
	    					function(res){
	    						l('--getCenters--');
	    						if( res.success ){
	    				
	    							$scope.centers = res.center;
	    						}

	    					
	    					},
	    					function(error){
	    						l('--getCenters--error');
	    						console.log(res);
	    					}

	    				);

	    			}
	 			
	 			$scope.getCenters();

	 			// ------------------------------------
	 			
	 			//  Inicia los calendarios
	 			$("[name=dateIni]").datepicker({ format: 'yyyy-mm-dd' });
	 			$("[name=dateEnd]").datepicker({ format: 'yyyy-mm-dd' });
	 			// Consulta las ordenes 

	 			$scope.getOrders = function(){

	 				if( $scope.validate() !== true ){
	 					$scope.campos = $scope.validate();
	 					$("#error").show(500);
	 					return;
	 				}
	 				$("#error").hide(500);

	 				$scope.order_authorization = new Object();
	 				
	 				ordersService.getOrderAuthorizations({
	 				
	 						dateIni: $scope.dateIni,
	 						dateEnd: $scope.dateEnd,
	 						centerId: $scope.center,
	 						authorized: $scope.optionSelected
	 					},
	 					function(res){
	 							
	 						if( res.success ){

	 							$scope.ordenes = res.ordenes;

	 							console.log($scope.ordenes);

	 						}else{

	 							console.log(res);
	 						
	 						}

	 					},	
	 					function(res){
	 						l('--getOrderAuthorizations--error');
	 						l(res);
	 					}
	 				);

	 			}
	 			// -----------------------------------------------
	 			
	 			// funcion para mostrar la orden
	 			$scope.showOrder = function(orden){

	 				$localStorage.order = orden.id;
	 				window.location.href = urls.BASE+"/#/app/agendamientoCita";
	 			
	 			}
	 			// ------------------------------------------------
	 			
	 			// funcion para cambiar el estado de una orden
	 			$scope.currentOrder;
	 			$scope.showModalChangeState = function(orden){
	 				
	 				$scope.currentOrder = orden;
	 				$('.change-state-order').modal('show');
	 				if( $scope.optionSelected != 1){
	 					$scope.order_authorization.state = orden.state;
	 					$scope.order_authorization.observations = orden.observations;
	 				}

	 			
	 			}
	 			// ------------------------------------------------
	 			

	 			//  Funcion para guardar la autorizacion (o no) de una orden
	 			$scope.saveState = function(){

	 				$scope.order_authorization.orders_id = $scope.currentOrder.id;
	 				$scope.order_authorization.users_id = $localStorage.user.id;

	 				// si esta pendiente la agrega a la tabla, de lo contrario edita un registro
	 				if($scope.optionSelected == 1){

		 				OrdersAuthorizationService.addAuthorized(
		 					$scope.order_authorization,
		 					
		 					function(res){
		 						if( res.success ){

		 							$('.change-state-order').modal('hide');
		 							$scope.order_authorization = new Object();
		 							$scope.getOrders();

		 						}
		 					},

		 					function(res){
		 						l(res);
		 					}
		 				);

		 			}
		 			else{
		 				$scope.order_authorization.authorization_id = $scope.currentOrder.authorization_id;
		 				OrdersAuthorizationService.editAuthorized(
		 					$scope.order_authorization,

		 					function(res){
		 						if( res.success ){

		 							$('.change-state-order').modal('hide');
		 							$scope.order_authorization = new Object();
		 							$scope.getOrders();

		 						}
		 					},

		 					function(res){
		 						l(res);
		 					}
		 				);
		 			}
	 			
	 			}
	 			// 	-----------------------------------------------
	    	
	    		// Validar los campos necesarios para la consulta de ordenes
	    		$scope.validate = function(){
	    			var campo = "";
	    			
	    			if( !$scope.dateIni ){
	    				campo += "Fecha de inicio, ";
	    			}

	    			if( !$scope.dateEnd ){
	    				campo += "Fecha final, ";
	    			}

	    			if( !$scope.center ){
	    				campo += "Sede ";
	    			}

	    			if( !$scope.optionSelected ){
	    				campo += ",Estado de orden";
	    			}
	    			
	    			if( campo != "" ){
	    				return campo;
	    			}
	    			else{
	    				return true;
	    			}

	    		}
	    	}
			
	]
);
