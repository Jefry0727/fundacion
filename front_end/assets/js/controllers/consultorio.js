'use strict';

/* Controllers */

angular.module('app')
    .controller('consultorioCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'specialistService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, specialistService) {

    	$('#timepicker').timepicker();

    	$('#timepickerend').timepicker();

    	

    
	$scope.newException = {
		date: '',
		date_ini:'',
		date_end:'',
		description: ''
	};

	$scope.editException = {
		id:'',
		date: '',
		date_ini:'',
		date_end:'',
		description: ''
	};

	$scope.dropExeption= {};

	$scope.addNewException = function()
	{
			$scope.newException = {
				data: '',
				date_ini:'',
				date_end:'',
				description: ''
			};

	}

	$scope.showModalAddException = function(){

		$('.add-new-exception').modal('show');
	}

	$scope.hideModalAddException = function(){

		$('.add-new-exception').modal('hide');
	}

	$scope.showModarException = function(editException){
		
		$scope.editException = editException;

		$('.edit-new-exception').modal('show');
	}

	$scope.hideModaException = function(){

		$('.edit-new-exception').modal('hide');
	}

	$scope.saveException = function(){



		specialistService.saveSpecialistRestriction($scope.newException, function(res){

			console.log('retorno');
			console.log(res);

			if(res.success == true){

				$scope.addNewException();
				$scope.hideModalAddException();

			}

		});

	}

	$scope.editException = function(){

		specialistService.editSpecialistRestriction($scope.editException, function(res){

			console.log(res);

			if($success == true){

				$scope.hideModaException();
				$scope.pagesResultScheduleEspecialistRestriction(0);

			}

		});

	}
	

	$scope.currentPageScheduleEspecialistRestriction = 0;

	$scope.pageSizeScheduleEspecialistRestriction = 10;

	$scope.pagesResultScheduleEspecialistRestriction = function(page){

		 var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }


		specialistService.getSpecialistRestriction({offset :offset}, function(res){

			console.log(res);

			$scope.scheduleEspecialistRestrictionTotal = res.totalScheduleEspecialistRestriction;

			$scope.scheduleEspecialistRestrictions = res.scheduleEspecialistRestrictions;

			console.log($scope.scheduleEspecialistRestrictions); 

			}, function (error) {


		});

	}

	$scope.pagesResultScheduleEspecialistRestriction(0);


}]);
