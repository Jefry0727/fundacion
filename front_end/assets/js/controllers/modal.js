'use strict';

/* Controllers */

angular.module('app')
    .controller('modalCtrl', ['$scope', '$state','$rootScope','$localStorage','$location','$timeout', 'medicalOfficesService','WizardHandler','permissionsService',  function($scope, $state, $rootScope, $localStorage, $location, $timeout, medicalOfficesService, WizardHandler, permissionsService) {

       $scope.mensaje = "Agendamiento de Citas";
    /**
     * Paginate Modal
     */

    $(document).ready(function() {
        $('#myFormWizard').bootstrapWizard({
            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index + 1;

                // If it's the last tab then hide the last button and show the finish instead
                if ($current >= $total) {
                    $('#myFormWizard').find('.pager .next').hide();
                    $('#myFormWizard').find('.pager .finish').show();
                    $('#myFormWizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#myFormWizard').find('.pager .next').show();
                    $('#myFormWizard').find('.pager .finish').hide();
                }

                var li = navigation.find('li.active');

                var btnNext = $('#myFormWizard').find('.pager .next').find('button');
                var btnPrev = $('#myFormWizard').find('.pager .previous').find('button');

                // remove fontAwesome icon classes
                function removeIcons(btn) {
                    btn.removeClass(function(index, css) {
                        return (css.match(/(^|\s)fa-\S+/g) || []).join(' ');
                    });
                }

                if ($current > 1 && $current < $total) {

                    var nextIcon = li.next().find('.fa');
                    var nextIconClass = nextIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnNext);
                    btnNext.addClass(nextIconClass + ' btn-animated from-left fa');

                    var prevIcon = li.prev().find('.fa');
                    var prevIconClass = prevIcon.attr('class').match(/fa-[\w-]*/).join();

                    removeIcons(btnPrev);
                    btnPrev.addClass(prevIconClass + ' btn-animated from-left fa');
                } else if ($current == 1) {
                    // remove classes needed for button animations from previous button
                    btnPrev.removeClass('btn-animated from-left fa');
                    removeIcons(btnPrev);
                } else {
                    // remove classes needed for button animations from next button
                    btnNext.removeClass('btn-animated from-left fa');
                    removeIcons(btnNext);
                }
            }
        });
    });


        //  $scope.finished = function() {
        //     alert("Wizard finished :)");
        // }

        // $scope.logStep = function() {
        //     console.log("Step continued");
        // }

        // $scope.goBack = function() {
        //     WizardHandler.wizard().goTo(0);
        // }
        
        // $scope.getCurrentStep = function(){
        //     return WizardHandler.wizard().currentStepNumber();
        // }
        // $scope.goToStep = function(step){
        //     WizardHandler.wizard().goTo(step);
        // }


       /**
        * Modal List Available Service Office
        */
       
        $scope.newException = {
    date: '',
    date_ini:'',
    date_end:'',
    description: ''
  };

       $scope.showModalAviableOfficeService = function(){

        $('.list-available-office-service').css('width', '100%');
        // $('.list-available-office-service').css('margin', '100px auto 100px auto');
        $('.list-available-office-service').modal('show');

       }

       $scope.hideModalAviableOfficeService = function(){

        $('.list-available-office-service').modal('hide');

       }

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


        }, 1000);
 

        // if($state.go('app.agendamientoCita')){

        //   if(location.reload('app.agendamientoCita')){

        //      $scope.hideModalAviableOfficeService();
        //   }

         
        // }

       }

       // $scope.goToConfig = function(){

       //  if($state.go('app.medicalOffices')){

       //    if(window.location.reload('app.medicalOffices')){

       //      $scope.hideModalAviableOfficeService();

       //    }

       //  }

       // }
       // 
  
        $scope.allPermissions = undefined;         

        $scope.menuPermissions = new Array();

        $scope.transformPermissions = function(){


            // $scope.menuPermissions = ;
           
            for (var i = 0; i < $scope.allPermissions.length; i++) {
              
                
                $scope.menuPermissions[$scope.allPermissions[i].permission.permission_identifier] = $scope.allPermissions[i].childPermissions;
            
            }
              

            l($scope.menuPermissions);
          
        }


        permissionsService.getAllPermissions({roleId: $localStorage.user.roles_id}, function(res){




           $scope.allPermissions = res.completePermissions;


          

           $scope.transformPermissions();



        });








      
       // l("ver....");


       // l($scope.getParentModel("agenda"));

   

    



//    x().then(function(done) {
//   console.log(done); // --> 'done!'
// });
   
    







}]);