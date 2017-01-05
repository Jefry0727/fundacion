'use strict';

/* Controllers */

angular.module('app')
    .controller('SignatureCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'signatureService', function($scope, $state, $rootScope, $localStorage, $location, $timeout, signatureService) {




var signatureContainer;

setTimeout(function(){ 

    signatureContainer = $("#signature").jSignature(); 

}, 3000);
    



$scope.saveSignature = function(){

    var datapair = signatureContainer.jSignature("getData", "image/svg+xml"); 

    // $scope.imageSVG = "data:" + datapair[0] + "," + datapair[1];

    $scope.imageSVG = datapair[1];


    signatureService.saveSignature({content:$scope.imageSVG, consentId:1}, function(res){

        console.log(res);


    }, function (error) {

    });      



}


$scope.resetSignature = function(){

    signatureContainer.jSignature("reset"); 

}

$scope.resetSignature = function(){
    
    signatureContainer.jSignature("reset"); 

}


    $scope.openSign = function(){
        $('.open-sign').modal('show');
    }


$scope.openSign();




}]);
















