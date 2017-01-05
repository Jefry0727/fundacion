    'use strict';

/* Controllers */

angular.module('app')
    .controller('resultsProfileCtrl',
     ['$scope', 

     '$state',
     
     '$rootScope',
     
     '$localStorage',
     
     '$location',
     
     '$timeout', 
     
     'medicalOfficesService', 
    
     'resultsService',

     'patientsService',

     'specialistService',

     'resultsProfileService',

     'studiesSpecialistService',

 
    function($scope, 
     
     	$state, 
     
     	$rootScope, 
     
     	$localStorage, 
     
     	$location, 
     
     	$timeout, 
     
     	medicalOfficesService,

        resultsService,

        patientsService,

        specialistService,

        resultsProfileService,

        studiesSpecialistService
        ) 
{

    /**
     * Initializacion for tiempicker
     */
    $('#timepicker').timepicker();

    /** @type {[type]} [description] */
    $scope.date = moment(new Date()).format('YYYY-MM-DD');


    /**
     * [resultProfileM description]
     * @type {Object}
     */
    $scope.resultProfileM = {

        id:'',
        specialists_id:undefined,
        studies_id: undefined,
        content:'',
        title:'',
        created:'',
        modified:''
    };

    /** [resetResultProfile description] */
    $scope.resetResultProfile = function(){

        $scope.resultProfileM = {

        id:'',
        specialists_id:'',
        studies_id:'',
        content:'',
        title:'',
        created:'',
        modified:''
    };        

    }

    $scope.updateResultProfileM = {

        id:'',
        specialists_id:undefined,
        studies_id: undefined,
        content:'',
        title:'',
        created:'',
        modified:''

    };

    /** [listSpecialist description] 
    *Lista de los Especialistas
    */
    $scope.listSpecialist = function(){

        resultsProfileService.getAllSpecialist(function(res){

            if(res.success == true){

                $scope.allSpecialist = res.specialists;


                console.log($scope.allSpecialist);
            }

        });

    }
    

    /**Inicialización de la Funcion*/
    $scope.listSpecialist();

    /** [FiltroStudies description] 
    *Filtro de los estudios por cada especialista
    */
    $scope.FiltroStudies = function(){

        //console.log($scope.resultProfileM.specialists_id);

        if($scope.resultProfileM.specialists_id !=undefined){

            studiesSpecialistService.getAllBySpecialist({id:$scope.resultProfileM.specialists_id},function(res){
                if(res.success){
                    console.log(res);
                    $scope.studiesSpecialist = res.studyBySpecialist;
                    $scope.updateResultProfileM = undefined;
                }else
                {
                    $scope.studiesSpecialist = undefined;
                    $scope.resultProfileSpecialist = undefined;
                    $scope.updateResultProfileM = undefined;
                }
            },function(error){});
        }

        
        // if($scope.resultProfileM.specialists_id !=undefined){

        //     resultsProfileService.getAllStudies(function(res){
        //         if(res.success){
        //             console.log(res);
        //             $scope.studiesSpecialist = res.studies;
        //             $scope.updateResultProfileM = undefined;
        //         }else
        //         {
        //             $scope.studiesSpecialist = undefined;
        //             $scope.resultProfileSpecialist = undefined;
        //             $scope.updateResultProfileM = undefined;
        //         }
        //     },function(error){});
        // }


    }
    //Inicializacion del Metodo
   

    /** [filterResultProfiles description]
     * Metodo que permite filtrar los perfiles existentes de cada especialista y cada estudio
     */
    $scope.filterResultProfiles = function(){

        if( !isNaN( parseInt( $('[list="input-studies"]').val() ) ) ){
            
            for(var  item in $scope.studiesSpecialist ){
                
                if( $scope.studiesSpecialist[ item ].studies_id == $('[list="input-studies"]').val() ){

                    $scope.resultProfileM.studies_id = $('[list="input-studies"]').val();
                    $('[list="input-studies"]').val( $scope.studiesSpecialist[ item ].study.name );

                }
            
            }
            
        }


        console.log('Entro');
        console.log($scope.resultProfileM.specialists_id);
        console.log($scope.resultProfileM.studies_id);

        if($scope.resultProfileM.specialists_id != undefined && $scope.resultProfileM.studies_id != undefined){

        resultsProfileService.ListFilterResultProfile({specialists_id:$scope.resultProfileM.specialists_id, studies_id:$scope.resultProfileM.studies_id},function(res){

            console.log(res);

            if(res.success){

                $scope.resultProfileSpecialist = res.resultProfile;

                $scope.updateResultProfileM = undefined;

            }else{
                $scope.resultProfileSpecialist = undefined;
                
                $scope.updateResultProfileM = undefined;
            }

        });

        }

    }



    /**
     * [contentResultProfiles description]
     * @return {[type]} [description]
     * Obtiene el Contenido de un perfil seleccionado
     */
    $scope.contentResultProfiles = function(){

        console.log($scope.updateResultProfileM.id);

        if($scope.updateResultProfileM.id != undefined){

            resultsProfileService.getContent({id: $scope.updateResultProfileM.id},function(res){

            console.log(res);

            if(res.success == true){

                $scope.descriptionContent = res.resultProfileContent;

                console.log('look this');
                console.log($scope.descriptionContent);

                $scope.updateResultProfileM.content = $scope.descriptionContent.content; 

                 console.log($scope.updateResultProfileM.content);

                

            }

        });

        }

    }


    /**
     * [saveResultProfile description]
     * @return {[type]} [description]
     */
    $scope.saveResultProfile = function(){

        resultsProfileService.addResults($scope.resultProfileM, function(res){
            if(res.success == true){

                $scope.hideAddResultProfile();
                $scope.filterResultProfiles();

            }

        });

    }

    /**
     * Editar El contenido del perfil
     * [actResultProfile description]
     * @return {[type]} [description]
     */
    $scope.actResultProfile = function(){

        $scope.descriptionContent = $scope.updateResultProfileM;


        resultsProfileService.editResultPro($scope.descriptionContent, function(res){


            if(res.success == true){

                $scope.resetResultProfile();
                location.reload();


            }

        });

    }

    $scope.delResultProfile = function(){

    $scope.descriptionContent = $scope.updateResultProfileM;

    resultsProfileService.dropResultPro($scope.descriptionContent, function(res){

        if(res.success == true){

            $scope.hideDeleteResultProfile();
            $scope.filterResultProfiles();

        }

    });

    }
   

    /**
     * [showAddResultProfile description]
     * @return {[type]} [description]
     */
    $scope.showAddResultProfile = function(){

        $('.add-result-profile-title').modal('show');

    }
    /**
     * [hideAddResultProfile description]
     * @return {[type]} [description]
     */
    $scope.hideAddResultProfile = function(){

        $('.add-result-profile-title').modal('hide');

    }

    $scope.showDeleteResultProfile = function(){

        $('.delete-results-profiles').modal('show');

    }

    $scope.hideDeleteResultProfile = function(){

        $('.delete-results-profiles').modal('hide');

    }
  

    /** @type {Object} [description] */
    $scope.summernote_options = {
           height: 200,
           toolbar: [
            ['edit',['undo','redo']],
            ['headline', ['style']],
            ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript']],
            ['fontname', ['fontname']],
            ['textsize', ['fontsize']],
            ['alignment', ['ul', 'ol', 'paragraph']],  
            ['table', ['table']],
            ['view', ['fullscreen']],
        ],
         fontNames: ['Verdana'],
    }



        }
    ]
);