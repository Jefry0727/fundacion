'use strict';

/* Controllers */

angular.module('app')
    .controller('scheduleIntervalsCtrl', ['$scope','$state','$rootScope', '$localStorage', 'ScheduleIntervalsService', 'fileUpload', function($scope, $state, $rootScope, $localStorage, ScheduleIntervalsService, fileUpload) {


    $scope.tiempo = new Date();

    $('#timepicker').timepicker();

    /**
     * DateRange
     * @type {String}
     */
    $scope.dateRange = {date:[{startDate: null, endDate: null}]};


    $scope.dateRangeEdit = {date:[{startDate: null, endDate: null}]};

    /**
     * Medical Office to set period Date intervals
     * @type Object
     */
    $scope.medicalOffice = $localStorage.medicalOffice;


    /**
     * Object model for add
     * @type {Object}
     */
    $scope.new = {
        date_ini: '',
        date_end: '',
        medical_offices_id: $scope.medicalOffice.id,
    };    


    /**
     * reset add moddel
     */
    $scope.resetNew = function(){

        $scope.new = {
            date_ini: '',
            date_end: '',
            medical_offices_id: $scope.medicalOffice.id,
        };    

    }    

    /**
     * Object model to edit
     * @type {Object}
     */
    $scope.edit = {
        id: 0,
        date_ini: '',
        date_end: '',
    };    


    /**
     * Object model to drop
     * @type {Object}
     */
    $scope.toDrop = {};


    /**
     * Show modal add function
     */
    $scope.showModalAdd = function(){

        $('.add-schedule-interval').modal('show');
    }


    /**
     * Hide modal add function
     */
    $scope.hideModalAdd = function(){

        $('.add-schedule-interval').modal('hide');
    }


    /**
     * show modal edit function
     */
    $scope.showModalEdit = function(edit){

        $scope.edit = edit;

        $scope.dateRangeEdit.date.startDate = $scope.edit.date_ini;

        $scope.dateRangeEdit.date.endDate = $scope.edit.date_end;

        $('.edit-schedule-interval').modal('show');
    }

    /**
     * hide modal edit function
     */
    $scope.hideModalEdit = function(){

        $('.edit-schedule-interval').modal('hide');
    }


    /**
     * show modal delete function
     */
    $scope.showModalDelete = function(medicalOfficeToDrop){

        $scope.toDrop = medicalOfficeToDrop;

        $('.delete-schedule-interval').modal('show');
    }




    /**
     * hide modal delete function
     */
    $scope.hideModalDelete = function(){

        $('.delete-schedule-interval').modal('hide');

    }


    /**
     * Function that updates date values to add model
     */
    $scope.setDates = function(){

        $scope.new.date_ini = $scope.dateRange.date.startDate.format('YYYY-MM-DD');

        $scope.new.date_end = $scope.dateRange.date.endDate.format('YYYY-MM-DD');


    }



    /**
     * Function that updates date values to edit model
     */
    $scope.setDatesEdit = function(){

        $scope.edit.date_ini = $scope.dateRangeEdit.date.startDate.format('YYYY-MM-DD');

        $scope.edit.date_end = $scope.dateRangeEdit.date.endDate.format('YYYY-MM-DD');

    }


    /**
     * add function
     */
    $scope.add = function(){

        $scope.setDates();

        ScheduleIntervalsService.add($scope.new, function(res){
        
            if(res.success == true){

                $scope.resetNew();
  
                $scope.hideModalAdd();
  
                $scope.pageResults(0);
  
            }

            }, function (error) {
        
        });

    }

    /**
     * edit function
     */    
    $scope.doEdit = function(){


        $scope.setDatesEdit();
        
        ScheduleIntervalsService.edit($scope.edit, function(res){

                    if(res.success == true){

                        $scope.hideModalEdit();
                        $scope.pageResults(0);
                    }

            }, function (error) {
        
        });
    }

    /**
     * delete function
     */
    $scope.delete = function(){

        ScheduleIntervalsService.delete({id: $scope.toDrop.id}, function(res){

                    if(res.success == true){

                        $scope.hideModalDelete();

                        $scope.pageResults(0);
                    
                    }

            }, function (error) {
        
        });

    }





    $scope.scheduleIntervals;
    /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentPage = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSize = 10;


    /**
     * Function to page results
     * @param Int page page number
     */
    $scope.pageResults = function(page){


            var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

            ScheduleIntervalsService.get({offset: offset, medicalOfficeId: $scope.medicalOffice.id}, function(res){
        

                console.log(res);                   

                /**
                 * Número total de items
                 * @type {Int}
                 */
                $scope.total = res.total;

                
                $scope.scheduleIntervals = res.scheduleIntervals;    




            }, function (error) {
        
        });


    
    };

    /**
     * Call pageResults first time
     */
    $scope.pageResults(0);

    $scope.goToSchedule = function (scheduleInterval) {

        $localStorage.scheduleInterval = scheduleInterval;



        $state.go('app.schedule');

    };    


    $scope.myFile;

    $scope.uploadFile = function(){
    
        var file = $scope.myFile;
    

        fileUpload.uploadFile(file, function(res){
        


            console.log(res);


            }, function (error) {
        
        });

    
    };


}]);










