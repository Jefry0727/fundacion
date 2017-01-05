'use strict';

/* Controllers */

angular.module('app')
.controller('cashBoxCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'medicalOfficesService','paymentsService', 'urls',function($scope, $state, $rootScope, $localStorage, $location, $timeout, medicalOfficesService, paymentsService, urls) {


	$('#timepicker').timepicker();

	$scope.message = $localStorage.person.first_name;

	l($localStorage.person.first_name);

/**
 * [Date Format]
 * @type {[type]}
 */
 //$scope.date = moment(new Date()).format('YY-MM-DD');

/**
 * [queryModel model]
 * @type {Object}
 */
 $scope.queryModel = {

 	date: '',
 	id: ''
 }


 $scope.automaticRefresh = function() {

 	$timeout(function() {

		 //location.replace('http://www.gatolocostudios.com/sam_fundacion/front_end/#/app/home');

		}, 3000);

 }

 $scope.automaticRefresh();

/**
 * [updateQueryModel model]
 * @type {Object}
 */
 $scope.updateQueryModel = {

 	date: '',
 	id:$localStorage.role
 }

 $scope.persmission = $localStorage.role;



/**
 * [cashFact Model Dinero Total en Efectivo]
 * @type {Object}
 */
 $scope.cashFact = {

 	Total: 0

 }

/**
 * [user model]
 * @type {Object}
 */
 $scope.user = {

 	id:0,
 	username:'',
 	roles_id:'',

 }

/**
 * [updateUser model]
 * @type {Object}
 */
 $scope.updateUser = {

 	id:'',
 	username:'',
 	roles_id:'',
 }



/**
 * [generate description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-30
 * @datetime 2016-09-30T15:11:31-0500
 * @param    {[type]}                 user [Genera el reporte de cualquier Usuario eligido por el Administrador]
 * @return   {[type]}                      [description]
 */
 $scope.generate = function(user){


 	$scope.updateUser.id = $scope.user.id;

			//l($scope.updateUser.id);

			$scope.updateQueryModel.id = $localStorage.role;

			//l('id'+''+$scope.updateQueryModel.id)

			if($scope.updateQueryModel.id == 1 || $scope.updateQueryModel.id == 10){

				$scope.queryModel.id = $scope.updateUser.id;

				//l('nuevo id'+''+$scope.queryModel.id);


			}else{

				$scope.queryModel.id = $localStorage.role;
			}


		}

		$scope.generate();
/**
 * [getUserBills description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-30
 * @datetime 2016-09-30T15:12:47-0500
 * @return   {[type]}                 [Lista de Usuario de Facturacion]
 */
 $scope.getUserBills = function(){

 	paymentsService.userCashBox({id:$scope.queryModel.id}, function(res){

 		console.log(res);

 		if(res.success == true){

 			$scope.users = res.users;
 		}
 	});
 }

 $scope.getUserBills(0);

/**
 *	OBTIENE LOS COPAGOS EN EFECTIVO. 
 * [cashFacturacion description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T15:41:32-0500
 * @return   {[type]}                 [Valor de los Cobros en Efectivo por Copago]
 */
 $scope.cashFacturacion = function(){

 	paymentsService.getFacturaCopyCash({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.cashFact.Total = parseInt(res.query[0].Total);

 			if(isNaN($scope.cashFact.Total)){

 				$scope.cashFact.Total = 0;

 			}

 		}

 	});

 }

 $scope.cashFacturacion();

/**
 * [payDebit Modelo del pago en Tarjetas]
 * @type {Object}
 */
 $scope.payDebit = {

 	Total:0
 }

 $scope.payCredit = {

 	Total:0
 }

 $scope.totalsCardsCopyments = {

 	total:0
 }



/**
 * [copymentDebitCard description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T16:59:04-0500
 * @return   {[type]}                 [Valor de los Cobros por Tarjetas de Credito y/o Debito]
 */
 $scope.copymentDebitCard = function(){

 	paymentsService.getCopaymentDebitCard({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.payDebit.Total = parseInt(res.queryDebit[0].Total);

 			$scope.payCredit.Total = parseInt(res.queryCredit[0].Total);

 			$scope.totalsCardsCopyments.total = ($scope.payDebit.Total + $scope.payCredit.Total);


 			if(isNaN($scope.totalsCardsCopyments.total)){

 				$scope.totalsCardsCopyments.total = 0;


 			}

 		}

 	});

 }

 $scope.copymentDebitCard();

/**
 * [payCheck Modelo del pago en Cheques]
 * @type {Object}
 */
 $scope.payCheck = {

 	Total:0
 }

/**
 * [copyCheckSum description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T17:05:37-0500
 * @return   {[type]}                 [Valor de los Cobros en Cheques]
 */
 $scope.copyCheckSum = function(){

 	paymentsService.copaymentCheck({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.payCheck.Total = parseInt(res.query[0].Total);

 			if(isNaN($scope.payCheck.Total)){

 				$scope.payCheck.Total = 0;
 			}

 		}

 	});

 }

 $scope.copyCheckSum();

/**
 * [payBond Modelo del pago en bonos]
 * @type {Object}
 */
 $scope.payBond = {

 	Total:0
 }


/**
 * [copyBondSum description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T17:10:44-0500
 * @return   {[type]}                 [Valor de los Cobros en Bonos]
 */
 $scope.copyBondSum = function(){

 	paymentsService.copaymentBond({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.payBond.Total = parseInt(res.query[0].Total);

 			l(res.query[0].Total);

 			if( isNaN($scope.payBond.Total) ){

 				$scope.payBond.Total = 0;

 			}

 		}



 	});
 }

 $scope.copyBondSum();

/**
 * [payConsignment Modelo de Consignaciones]
 * @type {Object}
 */
 $scope.payConsignment = {

 	Total:0	
 }
/**
 * [copyComsigmmentSum description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T17:50:09-0500
 * @return   {[type]}                 [Valor de los Cobros en Consignaciones]
 */
 $scope.copyComsigmmentSum = function(){

 	paymentsService.copaymentConsignment({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.payConsignment.Total = parseInt(res.query[0].Total);


 			if(isNaN($scope.payConsignment.Total)){

 				$scope.payConsignment.Total = 0;
 			}

 		}

 	});

 }

 $scope.copyComsigmmentSum();

/**
 * [copymentsTotal Model Total Copayments]
 * @type {Object}
 */
 $scope.copymentsTotal = {

 	total:0
 }

/**
 * [allpaymentsCopyment description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-22
 * @datetime 2016-09-22T17:50:03-0500
 * @return   {[type]}                 [Valor total de cobros Copago]
 */

 $scope.allpaymentsCopyment = function(){

 	paymentsService.allCopyment({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.copymentsTotal.total = parseInt(res.sumCopyment[0].todo);

 			if(isNaN($scope.copymentsTotal.total))
 			{
 				$scope.copymentsTotal.total = 0;
 			}

 		}

 	}); 

 }

 $scope.allpaymentsCopyment();

	//Start Methos ManualBills
	//
	
	/**
	 * [copymentsBillCash Model Efectivo Factura]
	 * @type {Object}
	 */
	 $scope.copymentsBillCash = {

	 	Total: 0
	 }

	/**
	 * [cashManualBills description]
	 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
	 * @date     2016-09-22
	 * @datetime 2016-09-22T18:10:32-0500
	 * @return   {[type]}                 [Valor de los Cobros en Efectivo por Facturacion Manual]
	 */
	 $scope.cashManualBills = function(){

	 	paymentsService.paymentBillCash({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){


	 		if(res.success == true){


	 			$scope.copymentsBillCash.Total = parseInt(res.query[0].Total); 


	 			if(isNaN($scope.copymentsBillCash.Total)){

	 				$scope.copymentsBillCash.Total = 0;

	 			}
	 		}

	 	});

	 }

	 $scope.cashManualBills();

	/**
	 * [copymentsBillCards Modele de pagos por trajeta en factura]
	 * @type {Object}
	 */
	 $scope.copymentsBillCards = {

	 	Total: 0,

	 	TotalC:0
	 }


	 $scope.totalCardsBill = {

	 	total : 0
	 }

	/**
	 * [cardsManualBills description]
	 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
	 * @date     2016-09-22
	 * @datetime 2016-09-22T18:23:12-0500
	 * @return   {[type]}                 [Valor de los Cobros en Tarjetas por Facturacion Manual]
	 */
	 $scope.cardsManualBills = function(){

	 	paymentsService.paymentBillCards({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){


	 		if(res.success == true){

	 			$scope.copymentsBillCards.Total = parseInt(res.queryDebitBill[0].Total);

	 			$scope.copymentsBillCards.TotalC = parseInt(res.queryCreditBill[0].Total);

	 			$scope.totalCardsBill.total = ($scope.copymentsBillCards.Total + $scope.copymentsBillCards.TotalC);


	 			if(isNaN($scope.totalCardsBill.total) ){

	 				$scope.totalCardsBill.total = 0;

	 			}

	 		}

	 	});

	 }

	 $scope.cardsManualBills();

	/**
	 * [copymentsBillCheck Modelo de Cheques en pago por Factura]
	 * @type {Object}
	 */
	 $scope.copymentsBillCheck = {

	 	Total:0

	 }

	/**
	 * [checkManualBills description]
	 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
	 * @date     2016-09-22
	 * @datetime 2016-09-22T18:23:47-0500
	 * @return   {[type]}                 [Valor de los Cobros en cheques por Facturacion Manual]
	 */
	 $scope.checkManualBills = function(){

	 	paymentsService.paymentBillCheck({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){


	 		if(res.success == true){

	 			$scope.copymentsBillCheck.Total = parseInt(res.query[0].Total);

	 			if(isNaN($scope.copymentsBillCheck.Total)){

	 				$scope.copymentsBillCheck.Total = 0;

	 			}

	 		}

	 	});

	 }

	 $scope.checkManualBills();

	/**
	 * [copymentsBillBond Modelo de Bonos en pagos por Factura]
	 * @type {Object}
	 */
	 $scope.copymentsBillBond = {

	 	Total:0
	 }
	/**
	 * [checkManualBonds description]
	 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
	 * @date     2016-09-23
	 * @datetime 2016-09-23T08:18:52-0500
	 * @return   {[type]}                 [Valor de los Cobros en Bonos por Facturacion Manual]
	 */
	 $scope.checkManualBonds = function(){

	 	paymentsService.paymentBillBond({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

	 		if(res.success == true){

	 			$scope.copymentsBillBond.Total = parseInt(res.query[0].Total);


	 			if(isNaN($scope.copymentsBillBond.Total)){

	 				$scope.copymentsBillBond.Total = 0;

	 			}
	 		}

	 	});

	 }

	 $scope.checkManualBonds();

/**
 * [copymentsBillConsignment description]
 * @type {Object}
 */
 $scope.copymentsBillConsignment = {

 	Total:0
 }

/**
 * [consignmentManualBills description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T10:15:05-0500
 * @return   {[type]}                 [Valor de los Cobros en Consignaciones por Facturacion Manual]
 */
 $scope.consignmentManualBills = function(){

 	paymentsService.paymentBillConsignment({date: $scope.queryModel.date, id:$scope.queryModel.id},function(res){


 		if(res.success == true){

 			$scope.copymentsBillConsignment.Total = parseInt(res.query[0].Total);

 			if(isNaN($scope.copymentsBillConsignment.Total )){

 				$scope.copymentsBillConsignment.Total = 0;
 			}

 		}

 	});

 }

 $scope.consignmentManualBills();

 $scope.totalSaleBills = {

 	total:0

 }
/**
 * [allManualBills description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T10:14:53-0500
 * @return   {[type]}                 [Valor total de los Cobros en Facturacion Manual]
 */
 $scope.allManualBills = function(){

 	paymentsService.totalManualBills({date: $scope.queryModel.date, id:$scope.queryModel.id},function(res){


 		if(res.success == true){

 			$scope.totalSaleBills.total = parseInt(res.totalManualBills[0].total);


 			if(isNaN($scope.totalSaleBills.total)){

 				$scope.totalSaleBills.total = 0;

 			}

 		}

 	});

 }

 $scope.allManualBills();

/**
 * Totales Cuadre de Caja
 */

 $scope.cash = {
 	total: 0
 };

/**
 * [totalCash description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T10:44:32-0500
 * @return   {[type]}                 [Total Efectivo]
 */
 $scope.totalCash = function(){

 	paymentsService.onlyCash({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){


		//l($scope.cash);

		if(res.success == true){

			$scope.cash.total = parseInt(res.allTotalCash[0].total);



			if(isNaN($scope.cash.total)){

				$scope.cash.total = 0;
			}

		}

	});

 }

 $scope.totalCash();

/**
 * [allTotalCards Modelo Total de Efectivo]
 * @type {Object}
 */
 $scope.cards = {

 	total:0
 }

 $scope.cardsCredit = {

 	total: 0
 }

 $scope.cardsAllTotal = {

 	total:0
 }

/**
 * [totalCards description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T11:57:48-0500
 * @return   {[type]}                 [Total Tarjetas]
 */
 $scope.totalCards = function(){

 	paymentsService.onlyCards({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true ){

 			$scope.cards.total = parseInt(res.allTotalCardsDebit[0].total);

 			$scope.cardsCredit.total = parseInt(res.allTotalCardsCredit[0].total);

 			$scope.cardsAllTotal.total = ($scope.cards.total + $scope.cardsCredit.total);


 			if(isNaN($scope.cardsAllTotal.total)){

 				$scope.cardsAllTotal.total = 0;
 			}

 		} 

 	});
 }

 $scope.totalCards();

/**
 * [checks Modelo total de pagos en cheques]
 * @type {Object}
 */
 $scope.checks = {

 	total:0

 }

/**
 * [totalChecks description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T12:04:22-0500
 * @return   {[type]}                 [Total Cheques]
 */
 $scope.totalChecks = function(){

 	paymentsService.onlyChecks({date:$scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.checks.total = parseInt(res.allTotalChecks[0].total);

 			if(isNaN($scope.checks.total)){

 				$scope.checks.total = 0;
 			}
 		}

 	});
 }

 $scope.totalChecks();

/**
 * [bonds Modelo total de pagos en bonos]
 * @type {Object}
 */
 $scope.bonds = {

 	total: 0
 }
/**
 * [totalBonds description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T12:17:01-0500
 * @return   {[type]}                 [Total Cheques]
 */
 $scope.totalBonds = function(){

 	paymentsService.onlyBonds({date:$scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.bonds.total = parseInt(res.allTotalBonds[0].total);

 			if(isNaN($scope.bonds.total)){

 				$scope.bonds.total = 0;
 			}

 		}

 	});

 }

 $scope.totalBonds();

/**
 * [consignment Modelo total de pagos por Consignaciones]
 * @type {Object}
 */
 $scope.consignment = {

 	total:0
 }

/**
 * [totalConsigments description]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-09-23
 * @datetime 2016-09-23T14:46:00-0500
 * @return   {[type]}                 [Total de Consignaciones]
 */
 $scope.totalConsigments = function(){

 	paymentsService.onlyConsignment({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.consignment.total = parseInt(res.allTotalConsignment[0].total);

 			if(isNaN($scope.consignment.total)){

 				$scope.consignment.total = 0;
 			}

 		}

 	});

 }

 $scope.totalConsigments();

/**
 * [total Model Total]
 * @type {Object}
 */
 $scope.totalDay = {

 	total:0
 }

 $scope.totalPayment = function(){

 	paymentsService.total({date: $scope.queryModel.date, id:$scope.queryModel.id}, function(res){

 		if(res.success == true){

 			$scope.totalDay.total =parseInt(res.total[0].total);



 			if(isNaN($scope.totalDay.total)){

 				$scope.totalDay.total = 0;

 			}
 		}
 	});

 }

 $scope.totalPayment();

/**
 * Ticketcs Loogical Operation 
 */

 /** @type {Object} [Model for Cash] */
 $scope.ticketModel = {

 	v1:0,
 	v2:0,
 	v3:0,
 	v4:0,
 	v5:0,
 	v6:0,
 	v7:0,
 }

/**
 * [updateTicketModel Update Model for Cash]
 * @type {Object}
 */
 $scope.updateTicketModel = {

 	c1:'',
 	c2:'',
 	c3:'',
 	c4:'',
 	c5:'',
 	c6:'',
 	c7:'',

 }

/**
 * [coinsModel description]
 * @type {Object}
 */
 $scope.coinsModel = {

 	m1:0,
 	m2:0,
 	m3:0,
 	m4:0,
 	m5:0
 }

/**
 * [updateCoinsModel description]
 * @type {Object}
 */
 $scope.updateCoinsModel = {

 	m1:'',
 	m2:'',
 	m3:'',
 	m4:'',
 	m5:''

 }

/**
 * [updateTotal description]
 * @type {Object}
 */
 $scope.updateTotal ={

 	total:0,


 } 

/**
 * [totalTickets description]
 * @type {Object}
 */
 $scope.totalTickets = {

 	total:0
 }

 /** @type {Object} [description] */
 $scope.totalCoins = {

 	total:0
 }

/**
 * [diference description]
 * @type {Object}
 */
 $scope.diference = {

 	total:0
 }


 $scope.sumTotal = function(ticketModel, coinsModel, cash){

/**
 * [m1 Calcula ]
 * @type {[type]}
 */

 $scope.num1 = $scope.ticketModel.v1;

 if( $scope.num1 > 0 ){

 	$scope.updateTicketModel.c1 = ($scope.num1 * 100000);


 }else{

 	$scope.num1 = 0;

 	$scope.updateTicketModel.c1 = ($scope.num1 * 100000);		
 }

/**
 * [num2 description]
 * @type {[type]}
 */
 $scope.num2 = $scope.ticketModel.v2;
 
 if($scope.num2 > 0){

 	$scope.updateTicketModel.c2 = ($scope.num2 * 50000);


 }else{

 	$scope.num2 = 0;

 	$scope.updateTicketModel.c2 = ($scope.num2 * 50000);

 } 

/**
 * [num3 description]
 * @type {[type]}
 */
 $scope.num3 = $scope.ticketModel.v3;

 if($scope.num3 > 0){

 	$scope.updateTicketModel.c3 = ($scope.num3 * 20000);

 }else{

 	$scope.num3 = 0;

 	$scope.updateTicketModel.c3 = ($scope.num3 * 20000);

 }

/**
 * [num4 description]
 * @type {[type]}
 */
 $scope.num4 = $scope.ticketModel.v4;

 if($scope.num4 > 0){

 	$scope.updateTicketModel.c4 = ($scope.num4 * 10000);

 }else{

 	$scope.num4 = 0;

 	$scope.updateTicketModel.c4 = ($scope.num4 * 10000);	

 }

/**
 * [num5 description]
 * @type {[type]}
 */
 $scope.num5 = $scope.ticketModel.v5;

 if($scope.num5 > 0){

 	$scope.updateTicketModel.c5 = ($scope.num5 * 5000);

 }else{

 	$scope.num5 = 0;

 	$scope.updateTicketModel.c5 = ($scope.num5 * 5000);
 }

/**
 * [num6 description]
 * @type {[type]}
 */
 $scope.num6 = $scope.ticketModel.v6;

 if($scope.num6 > 0){

 	$scope.updateTicketModel.c6 =  ($scope.num6 * 2000);

 }else{

 	$scope.num6 = 0;

 	$scope.updateTicketModel.c6 =  ($scope.num6 * 2000);
 }

/**
 * [num7 description]
 * @type {[type]}
 */
 $scope.num7 = $scope.ticketModel.v7;

 if($scope.num7 > 0){

 	$scope.updateTicketModel.c7 = ($scope.num7 * 1000);

 }else{

 	$scope.num7 = 0;

 	$scope.updateTicketModel.c7 = ($scope.num7 * 1000);
 }

/**
 * [coin1 description]
 * @type {[type]}
 */
 $scope.coin1 = $scope.coinsModel.m1;


 if($scope.coin1 > 0){

 	$scope.updateCoinsModel.m1 = ($scope.coin1 * 1000);
 }else{

 	$scope.coin1 = 0;

 	$scope.updateCoinsModel.m1 = ($scope.coin1 * 1000);
 }

/**
 * [coin2 description]
 * @type {[type]}
 */
 $scope.coin2 = $scope.coinsModel.m2;

 if($scope.coin2 > 0){

 	$scope.updateCoinsModel.m2 = ($scope.coin2 * 500);

 }else{

 	$scope.coin2 = 0

 	$scope.updateCoinsModel.m2 = ($scope.coin2 * 500);
 }

/**
 * [coin3 description]
 * @type {[type]}
 */
 $scope.coin3 = $scope.coinsModel.m3;

 if($scope.coin3 > 0){

 	$scope.updateCoinsModel.m3 = ($scope.coin3 * 200);

 }else{

 	$scope.coin3 = 0;

 	$scope.updateCoinsModel.m3 = ($scope.coin3 * 200);

 }

/**
 * [coin4 description]
 * @type {[type]}
 */
 $scope.coin4 = $scope.coinsModel.m4;

 if($scope.coin4 > 0){

 	$scope.updateCoinsModel.m4 = ($scope.coin4 * 100);

 }else{

 	$scope.coin4 = 0;

 	$scope.updateCoinsModel.m4 = ($scope.coin4 * 100);

 }

/**
 * [coin5 description]
 * @type {[type]}
 */
 $scope.coin5 = $scope.coinsModel.m5;

 if($scope.coin5 > 0){

 	$scope.updateCoinsModel.m5 = ($scope.coin5 * 50);

 }else{

 	$scope.coin5 = 0;

 	$scope.updateCoinsModel.m5 = ($scope.coin5 * 50)
 }


/**
 * [total description]
 * @type {[type]}
 */
 $scope.updateTotal.total = ($scope.updateTicketModel.c1 + $scope.updateTicketModel.c2 + $scope.updateTicketModel.c3 +
 	$scope.updateTicketModel.c4 + $scope.updateTicketModel.c5 + $scope.updateTicketModel.c6 + 
 	$scope.updateTicketModel.c7 + $scope.updateCoinsModel.m1 + $scope.updateCoinsModel.m2 + $scope.updateCoinsModel.m3 +
 	$scope.updateCoinsModel.m4 + $scope.updateCoinsModel.m5);

/**
 * [total description]
 * @type {[type]}
 */
 $scope.totalTickets.total = ($scope.updateTicketModel.c1 + $scope.updateTicketModel.c2 + $scope.updateTicketModel.c3 +
 	$scope.updateTicketModel.c4 + $scope.updateTicketModel.c5 + $scope.updateTicketModel.c6 + 
 	$scope.updateTicketModel.c7);

/**
 * [total description]
 * @type {[type]}
 */
 $scope.totalCoins.total = ($scope.updateCoinsModel.m1 + $scope.updateCoinsModel.m2 + $scope.updateCoinsModel.m3 +
 	$scope.updateCoinsModel.m4 + $scope.updateCoinsModel.m5);


/**
 * [cosing description]
 * @type {[type]}
 */
 $scope.cosing = $scope.cash.total;

//l('trae'+' '+$scope.cosing);

/**
 * [total description]
 * @type {[type]}
 */
 $scope.diference.total = $scope.cosing;

/**
 * [total description]
 * @type {[type]}
 */
 $scope.diference.total = ($scope.cosing - $scope.updateTotal.total);


}

/**
 * [updateTotalsCardsCopyments trae el valor del los pago q se han realizado en tarjetas por copago]
 * @type {Object}
 */
 $scope.updateTotalsCardsCopyments = {

 	total:0
 }

/**
 * [updateTotalsCardsCopyments trae el valor del los pago q se han realizado en tarjetas por Factura]
 * @type {Object}
 */
 $scope.updateTotalCardsBill = {

 	total:0
 }
/**
 * [updateTotalsCardsCopyments trae el valor del los pago q se han realizado en todas las tarjetas]
 * @type {Object}
 */
 $scope.updateCardsAllTotal = {

 	total:0
 }

/**
 * [baseCash Modelo Cuadre de Caja]
 * @type {Object}
 */
 $scope.baseCash = {

 	total:0
 }

/**
 * [updateBaseCash Actuliza el modelo de cuadre de caja]
 * @type {Object}
 */
 $scope.updateBaseCash = {

 	total:0
 }


 $scope.updateCash = {

 	total:0
 }

/**
 * Generate Report
 */

 $scope.reportPayment = function(totalsCardsCopyments, totalCardsBill, cardsAllTotal,baseCash, cash){

 	$scope.updateTotalsCardsCopyments.total = $scope.totalsCardsCopyments.total;

 	$scope.updateTotalCardsBill.total = $scope.totalCardsBill.total;

 	$scope.updateCardsAllTotal.total = $scope.cardsAllTotal.total;

 	$scope.updateBaseCash.total = $scope.baseCash.total;

 	$scope.updateCash.total = $scope.cash.total;

 	for (var i = $scope.users.length - 1; i >= 0; i--) {
 		if($scope.users[i].id == $scope.user.id){

 			$scope.usuarios = $scope.users[i];
 		}

 	}



 	var payment = {

 		report_date: 			  $scope.queryModel.date,

 		report_user: 			  $scope.usuarios,

 		baseCash:                 $scope.updateBaseCash,

 		pritnt_user:              $localStorage.person.first_name + '  ' + $localStorage.person.last_name,

 		cashcopayment:            $scope.cashFact.Total,

 		totalsCardsCopyments:     $scope.updateTotalsCardsCopyments.total,

 		payCheckCopyment:         $scope.payCheck.Total,

 		payBondCopayment:         $scope.payBond.Total,

 		payConsignmentCopayment:  $scope.payConsignment.Total,

 		copymentsTotal:           $scope.copymentsTotal.total,


 		copymentsBillCash:        $scope.copymentsBillCash.Total,

 		totalCardsBill:           $scope.updateTotalCardsBill.total,

 		copymentsBillCheck:       $scope.copymentsBillCheck.Total,

 		copymentsBillBond:        $scope.copymentsBillBond.Total,

 		copymentsBillConsignment: $scope.copymentsBillConsignment.Total,

 		totalSaleBills:           $scope.totalSaleBills.total,



 		cash:                     $scope.cash.total,

 		cards:                    $scope.updateCardsAllTotal.total,

 		checks:                   $scope.checks.total,

 		bonds:                    $scope.bonds.total,

 		consignment:              $scope.consignment.total,

 		totalDay:                 $scope.totalDay.total,


 		numTicketModel:           $scope.ticketModel,

 		ticketModel:              $scope.updateTicketModel,


 		numCoinsModel:            $scope.coinsModel,

 		coinsModel:               $scope.updateCoinsModel,


 		updateTotal:              $scope.updateTotal.total,

 		diference:                $scope.diference.total,

 		totalAll:                 $scope.cash.total





 	}


 	$scope.updateCoinsModel


 	paymentsService.preResult(payment, function(res){

 		window.location.href = urls.BASE_API + '/Payments/downloadPrev';

 	});


 }


}]);