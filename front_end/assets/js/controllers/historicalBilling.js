'use strict';

/* Controllers */

angular.module('app')
    .controller('historicalBillingCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'medicalOfficesService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, medicalOfficesService) {


   	$scope.selectedDate = moment(new Date()).format('YYYY-MM-DD');
   	$scope.selectedDateEnd = moment(new Date()).format('YYYY-MM-DD');

      /**
       * Instance timePicker
       */
      $('#timepicker').timepicker();  

  	 $scope.sortType     = 'name'; // set the default sort type
	  $scope.sortReverse  = false;  // set the default sort order
	  $scope.searchFish   = '';     // set the default search/filter term
	  
	  // create the list of sushi rolls 
	  $scope.sushi = [
	    { name: '728935', fish: 'Cali', date: '2016-04-28', total:'47000', tFac:'1', user:'lord' },
	    { name: '84906869', fish: 'Medellin', date: '2015-07-07', total:'47000', tFac:'1', user:'lord' },
	    { name: '94095', fish: 'Bogota', date: '2016-06-30', total:'47000', tFac:'2', user:'lord'},
	    { name: '789435', fish: 'Armenia', date: '2016-07-13', total:'47000', tFac:'3', user:'lord' }
	  ];

       
   
}]);

