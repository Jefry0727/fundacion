'use strict';

/* Controllers */

angular.module('app')
.controller('resultImpressionCtrl',
 ['$scope', 

 '$state',

 '$rootScope',

 '$localStorage',

 '$location',

 '$timeout',
 
 'urls', 

 'medicalOfficesService', 

 'resultsService',

 'patientsService',

 'specialistService',

 'printControlsService',

 'ordersService',

 'lendPlatesService',

 function($scope, 

  $state, 

  $rootScope, 

  $localStorage, 

  $location, 

  $timeout, 

  urls,

  medicalOfficesService,

  resultsService,

  patientsService,

  specialistService,

  printControlsService,

  ordersService,

  lendPlatesService

  ){


  $scope.InfoResultado = 'Resultados';
  $scope.Results = undefined;
  $scope.showPeople = false;

  $scope.dataPatient = function(people) {

    console.log(people);
    
  }

  function getGender(id){

    var genero = 'Masculino';
    if(id == '1'){
      genero = 'Femenino';
    }
    return genero;
  }

  $scope.formatHead = function() {

    var optionselect = $scope.results.tipo;

    switch(optionselect){

      case 'Persona':
      
      $scope.InfoResultado = 'Resultado Paciente';

      var data = $localStorage.result.patient;
      
      l('..data..');
      l($localStorage.people);

      $scope.showPeople = true;
      l('--1--');
      $scope.people ={
        identification: data.identification,
        names: data.first_name+ ' '+ data.middle_name,
        lastNames: data.last_name +' '+ data.last_name_two,
        genero:getGender(data.gender)
      }

      if($scope.people.identification == undefined){

        $scope.people ={
          identification: $localStorage.people.identification,
          names: $localStorage.people.first_name+ ' '+ $localStorage.people.middle_name,
          lastNames: $localStorage.people.last_name +' '+ $localStorage.people.last_name_two,
          genero:getGender($localStorage.people.gender)
        };
      }

       break;

       case 'Orden':

       $scope.InfoResultado = 'Resultado Orden';
      // OBTENER EL PACIENTE PARA LA ORDEN.
      l('si pasa por acà');
      patientsService.getPatientById({id:$localStorage.result.patient.patient_id},function(res){
        if(res.success){
          console.log('Consulta de paciente');
          console.log(res.patient.person);
          
          var data = res.patient.person;

          $scope.showPeople = true;
          
          $scope.people ={
            identification: data.identification,
            names: data.first_name+ ' '+ data.middle_name,
            lastNames: data.last_name +' '+ data.last_name_two,
            genero:getGender(data.gender)
          }
          
        //  $scope.results.patient = $scope.people;
        
      }





    },function(error){
      l('--getatientById--error');
      l(error);
    });

      break;
    }



  }

  Array.prototype.unique=function(a){
    return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });



    // Formatear resultados por persona.
    $scope.formatData = function(){
      var resultItems = $scope.results.result;      
      
      var order = [];

          // Obtiene lista de ordenes
          for (var i = resultItems.length - 1; i >= 0; i--) {
           order.push(resultItems[i].order_code);
         }
        // Obtiene las ordenes unicas
        order =  order.unique();

         // Lista de resultados.
         var newResults = [];
         
         for (var i = order.length - 1; i >= 0; i--) {

          var orderItem = [];

          for (var j = resultItems.length - 1; j >= 0; j--) {

            if(resultItems[j].order_code == order[i]){
              orderItem.push(resultItems[j]);
            }
          }

          var orderData ={
            order_code:order[i],
            resultItems:orderItem,
          }

          newResults.push(orderData);   
        }
        $scope.Results = newResults;

        console.log(newResults);

      }

    /**
     * Obtiene la informacion del local storage. 
     * @return {[type]} [description]
     */
     $scope.loadDAta =  function(){

      $scope.results = $localStorage.result;

      var resultItems = $scope.results.result;      
      
      var order = [];

          // Obtiene lista de ordenes
          for (var i = resultItems.length - 1; i >= 0; i--) {
           order.push(resultItems[i].order_code);
         }
        // Obtiene las ordenes unicas
        order =  order.unique();

         // Lista de resultados.
         var newResults = [];
         
         for (var i = order.length - 1; i >= 0; i--) {

          var orderItem = [];

          for (var j = resultItems.length - 1; j >= 0; j--) {

            if(resultItems[j].order_code == order[i]){

              resultItems[j].prints = getNumberOfPrints(resultItems[j]);

              console.log(resultItems[j]);

              orderItem.push(resultItems[j]);


            }
          }

          var orderData ={
            order_code:order[i],
            resultItems:orderItem,
          }

          newResults.push(orderData);   
        }
        $scope.Results = newResults;

        console.log(newResults);



        switch($localStorage.result.tipo){

        // SI EL MODELOO ES RESULTADO POR PERSONA.
        case 'Persona':
        $scope.formatHead();
        $scope.formatData();
        break;

        case 'Orden':

        $scope.formatHead();
        $scope.formatData();
        
        break;

      }

    }

    $scope.loadDAta();


     /**
     * obtener firma
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-09
     * @datetime 2016-09-09T11:09:44-0500
     * @return   {[type]}                 [description]
     */
     $scope.getSignature = function(){

      if($scope.specialist != undefined){

        specialistService.getSpecialistSignature({id: $scope.specialist.id }, function(res){

          console.log(res);

          if(res.success == true){

            console.log("signature...");

            $scope.signature = res.picture.url;

          }else{


            console.log("signature...");

            $scope.signature = undefined;

          }



        }, function (error) {

        });

      }  

    };

  
    $scope.getPicturePatient = function(){

       $scope.patient = $localStorage.result.patient.id;

      ordersService.getPhotoPeople({id: $scope.patient}, function(res){

        if(res.success == true){

          $scope.photoPeople = res.picture.url;

        }else{

          $scope.photoPeople = undefined;

        }

      });

    }

    $scope.getPicturePatient();

  
 $scope.photoPeople = undefined; 

 $scope.signature = undefined;
 /**
  * Obtiene la firma del specialsita si esta existe. 
  * @author Deicy Rojas <deirojas.1@gmail.com>
  * @date     2016-09-27
  * @datetime 2016-09-27T17:41:05-0500
  * @param    {[type]}                 result [description]
  * @param    {[type]}                 type   [description]
  */
 $scope.Previsualizar = function(result,type){

  if(type == '1'){

    var specialist;
    specialistService.getSpecialistById({id:result.result_specialist_code},function(res){
      if(res){
        specialist = res.specialists;
        //obtiene firma specialista
        
        specialistService.getSpecialistSignature({id: specialist.id }, function(res){
          if(res.success){
            $scope.signature = res.picture.url;
          }
          console.log(specialist);
          
          specialist['signature'] = $scope.signature;
          
          var previResults = {
            result: result,
            people: $scope.people,
            specialsita: specialist,

            peoplePhoto :  $scope.photoPeople
          }   

          console.log(previResults);
          
          resultsService.prevResult(previResults,function(res){

            $scope.printControls(previResults.result.result_code,previResults.result.claim);
            
            previResults.result.prints += 1;
            
            //$timeout(function(){ $scope.callAtTimeout(); }, 1000);

            window.location.href = urls.BASE_API + '/Results/downloadPrev/'+previResults.result.order_code;


          }, function (error) {

          });
          // fin previsualizar

        });

      }
    },function(error){});

  }
  if(type == '2'){
   var specialist;

   specialistService.getSpecialistById({id:result.result_specialist_code},function(res){
    l('--getSpecialistById--');
    l(res);
    if(res){

      specialist = res.specialists;
      
      specialistService.getSpecialistSignature({id: specialist.id }, function(res){
        l('--getSpecialistSignature--');
        l(res);
        if(res.success){
          $scope.signature = res.picture.url;
        }
        console.log(specialist);
        
        specialist['signature'] = $scope.signature;
        
        specialist['signature'] = $scope.signature;

        var previResults = {
          result: result,
          people: $scope.people,
          specialsita: specialist,

          peoplePhoto :  $scope.photoPeople
        }   

        console.log(previResults);
        resultsService.prevResult(previResults,function(res){


          $scope.printControls(previResults.result.result_code,previResults.result.claim);
          previResults.result.prints = 1;

          console.log(previResults.result.result_code);

          var data = previResults.result.result_code;

          $timeout(function(){ window.location.href = urls.BASE_API + '/Results/downloadPrev/'+data;} , 10000);



        //  window.location.href = urls.BASE_API + '/Results/downloadPrev/'+previResults.result.result_code;

      });
      },function(error){
        l('--getSpecialistSignature--error');
        l(error);
      });

    }

  },function(error){
    l('--getSpecialistSignature--error');
    l(error);

  });

 }

 if(type == 3){
  console.log(result);
  lendPlatesService.getLendPlatesById({attentions_id:result.attentions_id}, function(res){
    console.log(res);

    if(res.success){

      var previResults = {
        result: result,
        people: $scope.people,
        lendPlates: res.lend_plate,
         peoplePhoto :  $scope.photoPeople
      }   

      console.log(previResults);

    }
  }, function(res){});
}
}


$scope.PrevisualizarOrder = function(order){
   l('--PrevisualizarOrder--');
   l(order);
   for (var i = order.resultItems.length - 1; i >= 0; i--) {
    console.log('varias');
    $scope.Previsualizar(order.resultItems[i],2);      
  }
}

function getNumberOfPrints(result){

  printControlsService.getPrintNumber({id:result.result_code},function(res){
    if(res.success){

      result.prints = res.number;
    }else{

      result.prints = 0;
    }
  },function(error){
  });

}

$scope.printControls = function(idResult,txtClaim){

  // id, claim, created, modified, results_id, users_id
  // 
  var prints = {
    id:'',
    claim:txtClaim,
    results_id:idResult
  }
  l('--printControls--');
  l(prints);
  printControlsService.addPrintControl(prints,function(res){
    l('--printControls--');
    l(res);
  },function(error){
    l('--printControls--error');
    l(error);
  });


}

}]);
