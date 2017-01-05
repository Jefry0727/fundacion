'use strict';

/* Controllers */

angular.module('app')
    .controller('newProductCtrl', ['$scope', 
    	'$state',
    	'$rootScope',
    	'$localStorage',
    	'$location',
    	'$timeout', 
    	'ordersService',
    	'productsService',
    	'providersService', 
      'marksService',
      'farmaseuticFormService',
    	function($scope, 
    		$state, 
    		$rootScope, 
    		$localStorage, 
    		$location, 
    		$timeout, 
    		ordersService,
    		productsService,
    		providersService,
        marksService,
        farmaseuticFormService) {


    /**
     * Fucntion Timepicker
     */
    $('#timepicker').timepicker();

    /**
     * [date description]
     * @type {[type]}
     */
    $scope.date = moment(new Date()).format('YYYY-MM-DD');

    /**
     * [productM description]
     * @type {Object}
     */
    $scope.productM = {

      id:'',
      cup:'',
      name:'',
      value:'',
      section_id:'',
      created:'',
      modified:'',
      state:'',
      farmaseutic_form_id:'',
      active_principle:''

    };

    /**
     * [resetProductM description]
     * @return {[type]} [description]
     */
    $scope.resetProductM = function(){

      $scope.productM = {

      id:'',
      cup:'',
      name:'',
      value:'',
      section_id:'',
      created:'',
      modified:'',
      state:'',
      farmaseutic_form_id:'',
      active_principle:''

    };

    }

    $scope.updateProduct = {

      id:'',
      cup:'',
      name:'',
      value:'',
      section_id:'',
      created:'',
      modified:'',
      state:'',
      farmaseutic_form_id:'',
      active_principle:''

    };

     /**
     * pagina actual
     * @type {Number}
     */
    $scope.currentPageNewProduct = 0;
    
    /**
     * Tamaño de la pagina
     * @type {Number}
     */
    $scope.pageSizeNewProduct = 10;

    /** [pageResultsNewProduct description] */
    $scope.pageResultsNewProduct = function(page){

     var offset = 0;

        if (page > 1) {

            offset = (page - 1) * 10
        }

        productsService.allProducts({offset: offset}, function(res){

          console.log(res);

          if(res.success == true){

          $scope.total = res.total; 

          $scope.products = res.products;           

          }

        });

   }

     $scope.pageResultsNewProduct(0);
  	


    /**
     * [getSections description]
     * @return {[type]} [description]
     */
    $scope.getSections = function(){

      productsService.getAllSections(function(res){

        console.log(res);

        if(res.success == true){

          $scope.sections = res.sections;

        }

      });

    }

    $scope.getSections();

    /**
     * [addProducts description]
     * Method add new Product on BD
     */
    $scope.addProducts = function(){

      $scope.productM.farmaseutic_form_id = $scope.selectedFarmaseutic.id;

      productsService.addProduct($scope.productM, function(res){

        console.log(res);
        console.log($scope.productM);
        if(res.success == true){

          $scope.resetProductM();
          $scope.pageResultsNewProduct();
        }

      });

    }



    /**
     * [stateAc description]
     * @type {Array}
     */
     /** @type {Array} [description] */
        $scope.state = [

          {name:'Habilitado', code:1},
          {name:'Inhabiitado', code:0}

        ];




    /**
     * [stateAct description]
     * @param  {[type]} product [description]
     * @return {[type]}         [description]
     */
    $scope.stateAct = function(product){

     $scope.updateProduct = product;

     if($scope.updateProduct.state == 0){

      $scope.updateProduct.state = 1;

     }else{

      $scope.updateProduct.state = 0;
     }



     productsService.editProduct($scope.updateProduct, function(res){

      console.log(res);

      if(res.success == true){

        $scope.resetProductM();
        $scope.pageResultsNewProduct(0);

      }

     });

    }

    $scope.updateProducts = function(){

      $scope.updateProduct.farmaseutic_form_id = $scope.selectedFarmaseutic.id;

      productsService.editProduct($scope.updateProduct, function(res){

        console.log(res);
        console.log($scope.updateProduct);

        if(res.success == true){

          
         $scope.hideEditProduct();
          $scope.pageResultsNewProduct();

         

        }

      });

    }

    /**
     * [showEditProduct description]
     * @return {[type]} [description]
     */
    $scope.showEditProduct = function(product){

      $scope.updateProduct = product;

      $('.edit-product').modal('show');

    }

    $scope.hideEditProduct = function(){

      $('.edit-product').modal('hide');

    }



  /**Lista de Formas Farmaseuticas
  */
  $scope.farmaseuticForm = undefined;
  $scope.selectedFarmaseutic = undefined;

  $scope.getFarmaseuticForm = function(){

    farmaseuticFormService.getAll(function(res){
      if(res){
       
        $scope.farmaseuticForm = res.farmaseuticForm;

        $scope.selectedFarmaseutic = $scope.farmaseuticForm[0];
      
      }
    },function(error){});
  }

  $scope.getFarmaseuticForm();
     
}]);