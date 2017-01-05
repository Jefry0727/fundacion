'use strict';

/* Controllers con este permite que la ventana pueda mostrar la informacion o el enviar la informacion por post pero debe
de existir un servicio en services, ademas debe de existir en el config.js el nombre del .controller(pruebaCtrl*/
//pueba.js que se debe crear en assets js controller en el front-end
angular.module('app')
    .controller('authorizationTranscriptionsCtrl', //nombre que se pone en le config
    	['$scope', 
    	'$state',
    	'$rootScope',
    	'$localStorage',
    	'$location',
    	'$timeout', 
    	'pruebaService',
        'ordersService',
        'authorizationTranscriptionsService',
        'resultsService',
        'specialistService',
        function(
          $scope, 
          $state, 
          $rootScope, 
          $localStorage, 
          $location, 
          $timeout, 
          pruebaService,
          ordersService,
          authorizationTranscriptionsService,
          resultsService,
          specialistService) {

$scope.itemsTranscription;//Variable para cargar los datos en tabla

$scope.specialistSelected = undefined;

$scope.Results = new Object();

$scope.specialists_id = undefined;

$scope.optionSelected; //radio Button

$scope.selectedCenter = undefined; //sede en que se va filtrar la informacion

$scope.summernote = undefined;

$scope.transcriptionsModal= undefined;

$scope.aux = 1;

$scope.role = $localStorage.person.first_name;

$scope.selectedDate = moment(new Date()).format('YYYY-MM-DD'); //fecha inicial en la vista
$scope.selectedDateEnd = moment(new Date()).format('YYYY-MM-DD');//fecha final en la vista

$('#timepicker').timepicker(); 

      /**
       * Funcion para definir el tamaño inicial del summernote
       * @type {Object}
       */
       $scope.summernote_options = {
           height: 200,
           toolbar: [
           ['edit',['undo','redo']],
           ['headline', ['style']],
           ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript']],
            // ['fontname', ['fontname']],
            ['textsize', ['fontsize']],
            ['alignment', ['ul', 'ol', 'paragraph']],  
            ['table', ['table']],
            ['view', ['fullscreen','codeview']],
            ],
            fontNames: ['Verdana'],
        }
    /**
     * reemplaza los <p>, <br/>  por un retorno de carro  (enter)
     */
     $("#summernote").code()
     .replace(/<\/p>/gi, "\n")
     .replace(/<br\/?>/gi, "\n")
     .replace(/<\/?[^>]+(>|$)/g, "");



     $scope.getCenters = function(){

      ordersService.getCenters(function(res){

        $scope.centers = res.center;


    }, function (error) {

    });

  }
// llama la funcion pra obtener las sedes. 
$scope.getCenters();


/**
 * [showSpecialists permite mostrar el select con los especialistas]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-09
 * @datetime 2016-12-09T10:26:22-0500
 * @return   {[type]}                 [description]
 */
 $scope.showSpecialists = function () {

    if($localStorage.role == 1){

        $('#especialistas').show();

    }
    else{

       $('#especialistas').hide();
   }

}

/**
 * [showButtonConfirmDeny Muestra los botones de 
 * confirma y rechazar orden, segun el usuario que este en sesion]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-09
 * @datetime 2016-12-09T12:11:35-0500
 * @return   {[type]}                 [description]
 */
 $scope.showButtonConfirmDeny = function () {

    if($localStorage.role != 1){

        $scope.optionAux = 1;

    }
    else{

        $scope.optionAux = 0;
        $scope.optionsAux = 1;

    }


}

$scope.showSpecialists();


/**
 * [getIdSpecailist Obtiene el id del especialista]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-09
 * @datetime 2016-12-09T11:14:34-0500
 * @param    {[type]}                 argument [description]
 * @return   {[type]}                          [description]
 */
 $scope.getIdSpecailist =function () {

   if($localStorage.role != 1){

    $scope.specialists_id = $scope.findSpecialist(); //debe ser el id del espacialista;
    //l($scope.specialists_id +" este mirar");
}
else{
    //l($scope.specialistSelected + ' mire este');

    $scope.specialists_id = $scope.specialistSelected != undefined ?  $scope.specialistSelected : '' ;

}
}

/**
 * [getResultsByState Función que llama todos los resultados de a cuerdo al estado que se envie por parametro]
 * 
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-06
 * @datetime 2016-12-06T13:50:33-0500
 * @param    {[type]}                 state [description]
 * @return   {[type]}                       [description]
 */
 $scope.getResultsByState= function(state){

    var offset = 1;

    //$scope.showButtonConfirmDeny();
    $scope.getIdSpecailist();

    var specialists_id =  $scope.specialists_id;

    

    if($scope.aux != 1){

        offset = $scope.Results.offset;

    }
    l($scope.selectedCenter);

    authorizationTranscriptionsService.getResultsState({dateIni:$scope.selectedDate,dateEnd: $scope.selectedDateEnd,
     center:$scope.selectedCenter, state, offset,specialists_id},function(res){

        if(res.success  && res.results.length > 0){

            $scope.Results.offset = res.offset;

            var data = res.results;

            var list = new Array();

            for(var i = 0; i < data.length; i++){

                var infoResults = data[i];

                var gender;

                if(infoResults._matchingData.People.gender == 1){

                    gender = 'Femenino';

                }
                else{

                    gender = 'Masculino';

                }

                var item = {

                    id:                 infoResults.id,

                    attentions_id:      infoResults.attentions_id,

                    content:            infoResults.content,

                    specialists_id:     specialists_id,

                    state:              infoResults.state,

                    complement:         infoResults.complement,

                    order:              infoResults._matchingData.Orders.order_consec,

                    identification:     infoResults._matchingData.People.identification,

                    name:               infoResults._matchingData.People.first_name
                    +" "+ infoResults._matchingData.People.middle_name
                    +" "+ infoResults._matchingData.People.last_name
                    +" "+ infoResults._matchingData.People.last_name_two,

                    first_name:         infoResults._matchingData.People.first_name,

                    middle_name:        infoResults._matchingData.People.middle_name,

                    last_name:          infoResults._matchingData.People.last_name,

                    last_name_two:      infoResults._matchingData.People.last_name_two,

                    birthdate:          moment(infoResults._matchingData.People.birthdate).format('YYYY-MM-DD'),

                    gender:             gender,

                    observartions:      infoResults._matchingData.Appointments.observations,

                    typeDoc:            infoResults._matchingData.DocumentTypes.type,

                    study:              infoResults._matchingData.Studies.cup+" "+infoResults._matchingData.Studies.name,

                    date:               moment(infoResults._matchingData.Attentions.date_time_ini).format('YYYY-MM-DD'),
                }
                list.push(item);
            }
            $scope.itemsTranscription = list;

        }else{
            $scope.Results.offset--;
            $scope.itemsTranscription = undefined;

        }

       // $scope.resultState=res.
   },function(error){

   });

}

/**
 * [loadValues Función que llama a la función getResultsByState()]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-06
 * @datetime 2016-12-06T13:52:16-0500
 * @return   {[type]}                 [description]
 */
 $scope.loadValues = function (aux) {

    if(aux == undefined){
        $scope.aux = 1;
    }else{
        $scope.aux = aux;
    }

    if($scope.optionSelected == 1 && $scope.selectedCenter != undefined ){

        $scope.getResultsByState(0);
        
    }

    if($scope.optionSelected == 2 && $scope.selectedCenter != undefined){
        $scope.getResultsByState(1);
    }

    if($scope.optionSelected == 3 && $scope.selectedCenter != undefined){
        $scope.getResultsByState(2);
    }

}

/**
 * [Captura el evento que se realice algun cambio en los radio buttons]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-06
 * @datetime 2016-12-06T13:53:42-0500
 * @param    {[type]}                 ){               $scope.loadValues();} [description]
 * @return   {[type]}                     [description]
 */
 $scope.$watch('optionSelected', function(){

  $scope.loadValues();
  $scope.showButtonConfirmDeny();


});

/**
 * [showModalEditTranscripcion Muestra la modal con la información de un paciente junto con su resultado]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-06
 * @datetime 2016-12-06T13:54:34-0500
 * @param    {[type]}                 item [description]
 * @return   {[type]}                      [description]
 */
 $scope.showModalEditTranscripcion = function (item, state) {



    $scope.transcriptionsModal = item;
    $scope.summernote = item.content;

    $scope.state = state;


    if(item.state == 1 || item.state == 2 || $localStorage.role == 1){

        $('[id="editar-confirmar"]').hide();

        $('[id="buttonDeny"]').hide();
    }

    if( $scope.state == 1){

        $('[id="editar-confirmar"]').show();

        $('[id="buttonDeny"]').hide();
        
    }else if($scope.state == 2){

        $('[id="buttonDeny"]').show();

        $('[id="editar-confirmar"]').hide();

    }

    $('.edit-transcription').modal('show');
}


// $('[id="confirm"]').click( function(){
//     l("The paragraph was clicked.");
// });

//$scope.showImpressionResult();

$scope.hideEditTranscripcion =  function(){

    $('.edit-transcription').modal('hide');
    $scope.transcriptionsModal = undefined;
    $scope.summernote = undefined;

    // $timeout(function() {

    //     $state.go('app.transcriptions');

    // }, 1000);
}

// $('[id="confirm"]').click(function () {
    
//     alert('hice algo');


// });

/**
 * [authorization Adiciona un nuevo registro autorizando o rechazando un resultado,
 *  colocando su estado en valor uno]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-06
 * @datetime 2016-12-06T15:50:06-0500
 * @param    {[type]}                 item [description]
 * @return   {[type]}                      [description]
 */
 $scope.authorization = function (items, state) {

    var item = undefined;

    var content = undefined;


    //condición para los botones de la modal,
    // puesto que existe botones dentro de la tabla
    if($scope.transcriptionsModal != undefined){

        l('modal');

        item = $scope.transcriptionsModal;

        content = $scope.summernote;

        if( $scope.state == 2){

            content = $scope.transcriptionsModal.content;

        }

        //state = 1;

    }else {

        item = items;

        content = item.content;

    }

    var result = {

        //id:             item.id,

        attentions_id:  item.attentions_id,

        content:        content,

        specialists_id: item.specialists_id,

        complement:     item.complement,

        state:           $scope.state
    }
    resultsService.add(result,function(res) {

     if(res.success){

        $scope.hideConfirmSave();

        $scope.loadValues();

        $('.save-authorization-success').modal('show');

        if($scope.transcriptionsModal != undefined){

            $scope.hideEditTranscripcion();
        }
        
    }

}, function (error) {

});

    //l(result);

}                   


$scope.$watch('Results.offset', function(  newval, oldval ){
    //l(newval);
//$scope.aux = 2;
if( newval >= 1 ){
    $scope.Results.offset = newval;
    $scope.loadValues(2);
    if( $scope.itemsTranscription!= undefined && $scope.itemsTranscription.length > 0 ){

        return newval;

    }else{
        $scope.Results.offset = oldval;
        return oldval;
    }

}else{
    return oldval;
}

});


   /**
     * funcion para obtener todos los specialista. 
     * @return {[type]} [description]
     */
     $scope.loadSpecialists = function (){

        specialistService.getAllSpecialist(function(res){

        // console.log(res.specialists);

        
        $scope.Specialists =(res.specialists);


        if(res.success && $scope.result !=undefined)
        {

            // console.log('Lista especialistas');
            // console.log($scope.Specialists);
            // console.log($scope.result);

            var id =  $scope.result.specialists_id;

            for (var i = $scope.Specialists.length - 1; i >= 0; i--) {

                if(  $scope.Specialists[i].id == id){ 

                    $scope.specialistSelected = $scope.Specialists[i];

                    $scope.changeSelectedSpecialist($scope.specialistSelected.id);

                    $scope.firmSpecilist($scope.specialistSelected.id);
                }
            }

        }

        //console.log( $scope.Specialists[0].users_id + " mirar este");

    }, function(error){

        console.log(error);

    });
    } 

    $scope.loadSpecialists();


    $scope.findSpecialist= function () {

        for(var i = 0;i < $scope.Specialists.length; i++){


            if($scope.Specialists[i].people_id == $localStorage.person.id){
            // l($scope.Specialists[i].people_id +' hola ' + $localStorage.person.id);
            // l($scope.Specialists[i]);

            return $scope.Specialists[i].id;
        }



    }
}


$scope.showConfirmSave = function () {
    l($scope.state +' estado');
    $('.confirm-save-ok').modal('show');

    if( $scope.state == 1){

        $scope.message = 'desea aurtorizar la transcripción?';

    }

    else{

        $scope.message = 'desea rechazar la transcripción?';

    }

}


/**
 * [hideImpressionResult Oculta la modal que pide 
 * la confirmación de guardar un nuevo resgistro para la transcripción]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-14
 * @datetime 2016-12-14T11:52:23-0500
 * @return   {[type]}                 [description]
 */
$scope.hideConfirmSave =  function(){

    $('.confirm-save-ok').modal('hide');

    $timeout(function() {

        //$state.go('app.transcriptions');

    }, 1000);
}

}]);