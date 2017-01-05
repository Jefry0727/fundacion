'use strict';

/* Controllers */

angular.module('app')
.controller('studiesTranscriptionsCtrl',
   ['$scope', 

   '$state',

   '$rootScope',

   '$localStorage',

   '$location',

   '$timeout', 

   'ordersService',

   'resultsProfileService',

   'specialistService',

   'resultsService',

   'urls',

   function($scope,

       $state, 

       $rootScope,

       $localStorage, 

       $location,

       $timeout,

       ordersService,

       resultsProfileService,

       specialistService,

       resultsService, 

       urls

       ){


       $scope.fileUrl = urls.BASE_API + '/webroot/files/PrevioResultProfile.pdf';

    /**
     * Bi-tads estudios de mamografias. para informe (4505)
     * @type {[type]}
     */
     $scope.biradSelected = undefined; 

     $('#timepicker').timepicker();

     $('#timepickerend').timepicker();

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

    /**
     * Obtiene los valores enviados desde transcriptions
     * @type {[type]}
     */
     $scope.order = $localStorage.order;
     l('mierda');
     console.log($scope.order);
     $scope.action = undefined;

     $scope.getAttention = function(){

        $scope.idAppoiment = $localStorage.order.appointment.id;

        //l('el id');
        console.log($scope.idAppoiment);

    }

    $scope.getAttention();

    /**
     * Specialista selecccionado
     * @type {[type]}
     */
     $scope.specialistSelected = '';
     $scope.Specialists ={}
    /**
     * Obtiene la infromacion de la Orden.
     * @type {Object}
     */
     $scope.appointment ={}
     $scope.people = {}
    /**
     * Modelo Results Profile.
     * @type {Object}
     */

     $scope.formatSelected ={

        id:'',
        specialists_id:'',
        studies_id:'',
        content: undefined,
        title:'',
        created:'',
        modified:''
    };

    $scope.updateFormatSelected = {

        id:'',
        specialists_id:'',
        studies_id:'',
        content: undefined,
        title:'',
        created:'',
        modified:''

    };

    /**
     * load values from the results
     */
     $scope.result = {}

     $scope.role = $localStorage.person.first_name;

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

            console.log('Lista especialistas');
            console.log($scope.Specialists);
            console.log($scope.result);

            var id =  $scope.result.specialists_id;


            for (var i = $scope.Specialists.length - 1; i >= 0; i--) {
                if(  $scope.Specialists[i].id == id){ 
                    $scope.specialistSelected = $scope.Specialists[i];

                    $scope.changeSelectedSpecialist($scope.specialistSelected.id);

                    $scope.firmSpecilist($scope.specialistSelected.id);
                }
            }

        }

        console.log(res);

    }, function(error){

        console.log(error);

    });
    } 

    $scope.loadSpecialists();


    $scope.changeSelectedSpecialist = function(){


         //getFirmSpecialist(specialistSelected)
         //console.log($scope.specialistSelected);
         if($scope.specialistSelected == undefined){
            $('[name=error-specialist]').show(500);
        }
        else{
            $('[name=error-specialist]').hide(500);
        }
        // console.log($scope.appointment.study.id);

        // console.log($scope.specialistSelected);
        
        if($scope.specialistSelected.id != undefined){


            resultsProfileService.getAllResultsProfile({idSpecialist:$scope.specialistSelected.id,idStudie:$scope.appointment.study.id},function(res){
                //l('--getAllResultsProfile--');
                //console.log(res);

                if(res.success == true){

                    $scope.resultsProfileSlect = res.resultProfile;

            //l('asi lo trajo'+' '+$scope.resultsProfileSlect);
        }else{

          $scope.resultsProfileSlect = undefined;

      }

  }, function(error){

    console.log(error);

});
        }
    }



    // $scope.pa = $localStorage.order.person.id;

    // l('id pa la foto'+'' +$scope.pa);

    /**
     * Obtiene el contenido de plantilla 
     */

     $scope.loadSelectProfile = function(){


        resultsProfileService.getContentResultP({idProfile: $scope.formatSelected.id },function(res){

            //l('respuesta del content'+' '+res);

            if(res.success == true){

                $scope.updateFormatSelected.content = res.resultProfile.content;

                $scope.summernote = $scope.updateFormatSelected.content;

                //l('valor del content'+' '+$scope.summernote);
            }else{

                $scope.updateFormatSelected.content = undefined;                

                $scope.summernote = $scope.updateFormatSelected.content;
            }

        });

    }



    $scope.loadResult = function(idAttention){

        if(idAttention != undefined){

            resultsService.getByAttention({id:idAttention},function(res){
                // console.log('Resultado');
                // console.log(res.result);

                $scope.result = res.result;

                $scope.summernote =  $scope.result.content;
                $scope.complement = $scope.result.complement;

                $scope.loadSpecialists();

                // for (var i = $scope.Specialists.length - 1; i >= 0; i--) {
                //     if(  $scope.Specialists[i].id == $scope.result.specialists_id){ 
                //         $scope.specialistSelected = $scope.Specialists[i];
                //     }
                // }
                

            }, function(error){

                console.log(error);

            });

        }
    }

// '1','Cedula de Ciudadanía','CC'
// '2','','CE'
// '3','','PA'
// '4','','RC'
// '5','','TI'
// '6','','AS'
// '7','','MS'
// '8','Número Único de Identificación','NU'


$scope.typeIdentity = [

{name:'No Registra', code:0},
{name:'Cedula de Ciudadanía', code:1},
{name:'Cedula de Extrajería', code:2},
{name:'Pasaporte', code:3},
{name:'Registro Civil', code:4},
{name:'Tarjeta de Identidad', code:5},
{name:'Adulto Sin Identificación', code:6},
{name:'Menor Sin Identificación', code:7},
{name:'Menor Sin Identificación', code:8}


]


$scope.loadOrder = function(){


    var data = $localStorage.order;


    l('date of loadOrder');

    l(data);

    
    $scope.appointment = data['appointment'];
    $scope.order = data['order'];
    $scope.action = data['tipo'];



    if($scope.appointment.study.id == 217 || $scope.appointment.study.id == 75){
        $scope.isMomogram = true;
    }else{
        $scope.isMomogram = false;
    }



    // l('el arreglo');

    // console.log($scope.typeIdentity);

    for( var i = 0; i < $scope.typeIdentity.length-1; i++){

        if( i == $scope.order.patient.person.document_types_id){

            $scope.typeDoc = $scope.typeIdentity[i].name;

            //console.log('doc'+' '+$scope.typeDoc);
        }

    }


        // muestra la informacion de la persona. 
        $scope.people = $scope.order.patient.person;

        $scope.sex = $scope.order.patient.person.gender;

        if( $scope.sex == 0){

           $scope.sex = 'Masculino';

       }else{

           $scope.sex = 'Femenino';

       }

       var info = new Array();

       info = ($scope.order.patient.person.birthdate).split("T");

      

       $scope.people.birthdate =  info[0]; 


      // l('fecha'+' '+$scope.people.britdate);

       $scope.attention =    $scope.appointment.attentions[0]; 

       $scope.attention.date_time_ini  = moment($scope.attention.date_time_ini).format('YYYY-MM-DD'); 



       if($scope.action >= "2" && $scope.action <= "5" && $scope.attention != undefined){

         $scope.loadResult($scope.attention.id);

     }
     else{

     }




 }

 $scope.loadOrder();

/**
 * Generar un resultado.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-10-18
 * @datetime 2016-10-18T14:39:59-0500
 * @return   {[type]}                 [description]
 */
 $scope.save= function(){

    if($scope.attention.id != undefined){
       // console.log($scope.result);

       $scope.result.attentions_id = $scope.attention.id;

       $scope.result.content = $scope.summernote;

       $scope.result.specialists_id = $scope.specialistSelected.id;

       $scope.result.complement = $scope.complement;

       $scope.result.state = 0;

       //console.log($scope.result);

       resultsService.add($scope.result,function(res){

           // console.log(res.success + 'este soy yo');

           if(res.success){
               //    console.log('estudy');
               //console.log($scope.appointment.study);

               if($scope.isMomogram)  {
                $scope.addBirads(res.result.id, true);
            }
            $scope.state = 2;
               // $state.go('app.transcriptions'); 
           }

       }, function(error){

        console.log(error);

    });

   }

}

$scope.editar = function(){

    if($scope.result.id != undefined){

        console.log($scope.result);

        $scope.result.content = $scope.summernote;

        $scope.result.specialists_id = $scope.specialistSelected.id;
        $scope.result.specialist = undefined;
        $scope.result.complement = $scope.complement;



        console.log($scope.result);

        resultsService.edit($scope.result,function(res){

            console.log(res);

            if(res.success){
                console.log('estudy');
                console.log($scope.appointment.study);
                if($scope.isMomogram){
                    $scope.addBirads(res.result.id, false);
                }
              // $state.go('app.transcriptions'); 
          }

      }, function(error){

        console.log(error);

    });

    }
}

/**
 * [getPicturePatient Obtiene la foto del paciente]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-10-12
 * @datetime 2016-10-12T16:22:25-0500
 * @return   {[type]}                 [description]
 */
 $scope.getPicturePatient = function(){

    l('pa la fo'+' '+$scope.people.id);

    ordersService.getPhotoPeople({id:$scope.people.id}, function(res){

        l('me trajo la res'+' '+res);

        if(res.success == true){

            $scope.pictute = res.picture.url;
        }


    });



}
$scope.getPicturePatient();

/**
 * [firmSpecilist Obtine la Firma del Especialista]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-10-14
 * @datetime 2016-10-14T14:03:37-0500
 * @param    {[type]}                 specialistSelected [description]
 * @return   {[type]}                                    [description]
 */
 $scope.firmSpecilist = function(specialistSelected){


    $scope.firmM = $scope.specialistSelected.id;

    l('get de change'+' '+$scope.firmM);

    specialistService.getSpecialistSignature({id: $scope.firmM}, function(res){


        if(res.success == true){

            $scope.firmSpecialist = res.picture.url;

            l('siendo tru'+' '+$scope.firmSpecialist);
        }
    });



}

/**
 * [showImpressionResult Opciones de la Modal]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-10-14
 * @datetime 2016-10-14T14:03:55-0500
 * @return   {[type]}                 [description]
 */
 $scope.showImpressionResult =  function(pre = false){

    if(pre){

        $scope.hideConfirmSave();

    }
    $('.impression-ok').modal('show');


}

/**
 * [goTranscriptions Redireccionamiento a transcriptipons]
 * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
 * @date     2016-10-14
 * @datetime 2016-10-14T14:04:39-0500
 * @return   {[type]}                 [description]
 */
 $scope.goTranscriptions = function(){

   $scope.preResultProfile($scope.specialistSelected);

    // $timeout(function() {

    //     $state.go('app.transcriptions');

    //     location.reload();



    // }, 5000);


}

//$scope.showImpressionResult();

$scope.hideImpressionResult =  function(){

    $('.impression-ok').modal('hide');

    $timeout(function() {

        $state.go('app.transcriptions');

    }, 1000);
}

/**
 * [back regresa a la pagina de transcripción]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-14
 * @datetime 2016-12-14T12:30:03-0500
 * @return   {[type]}                 [description]
 */
$scope.back = function () {

    $state.go('app.transcriptions');

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

$scope.showConfirmSave = function () {
    //l($scope.action +' el select o radio');
    $('.confirm-save-ok').modal('show');

    if($scope.action == 3 || $scope.action == 4){

        $scope.message = 'desea cambiar el estado de la transcripción a pendiente por aurtorizar?';

    }

    else{

        $scope.message = 'desea realizar una nueva actualización de la transcripción?';

    }

}

// Generate PDf
// 

/**
 * Generate Report
 */

 $scope.preResultProfile = function(specialistSelected, pre = false){


    if( $scope.action == 3 ){

    $scope.firmSpecilist($scope.specialistSelected);
    //l('My action is ' +$scope.action + ' Entre' + $scope.firmSpecilist + ' fimr');
    $scope.accion = true;

    }
    else{
        //l('entre al else');

        $scope.accion = false;

    }




    var results = {

        peopleName:         $scope.people,

        sex:                $scope.sex,

        order     :         $scope.order,

        appointment:        $scope.appointment,

        summernote:         $scope.summernote,

        specialistSelected: $scope.specialistSelected,

        picture:            $scope.pictute,

        firmSpecialist:     $scope.firmSpecialist,

        fSpecial:           $scope.fSpecial,

        validate:           $scope.accion,

       // firmSpecialist:     $scope.firmSpecialist,

       pre: pre

   }

   l(results.firmSpecialist + 'fima espec');


   resultsProfileService.preResult(results, function(res){
       window.location.href = urls.BASE_API + '/ResultProfiles/downloadPrev/'+results.pre+'/'+results.order.order_consec;

   });

   if(pre == false){

    $timeout(function() {

       $scope.hideImpressionResult();

   }, 2000);

}





}

$scope.addBirads = function(result,isNew){

    if(isNew){


        var birads ={
          birad: $scope.biradSelected,
          results_id: result
      }

      resultsService.addBirads(birads,function(res){
        if(res.success){
            console.log('INSERTO biradsAD');
            console.log(res.success);
        }
    },function(error){});
  }else{

  }
}

/**
 * [modifyComplement Cambia el valor de la variable complement a 0 que permitira habilitar el boton guardar]
 * @author Jefry Londoño <jjmb2789@gmail.com>
 * @date     2016-12-13
 * @datetime 2016-12-13T15:39:38-0500
 * @return   {[type]}                 [description]
 */
 $scope.modifyComplement = function () {
    l($scope.action);
    if($scope.action == 5){

        if($scope.complement == 0){

           $scope.result.complement = 0;

       }else{

        $scope.result.complement = 1;
    }
}



}


     // Final controlador
 }]);

