'use strict';

/* Controllers */

angular.module('app')
    .controller('clientsCtrl', 
        ['$scope', 
        '$state',
        '$rootScope',
        '$localStorage',
        '$location',
        '$timeout',
         'clientsService',
         'departmentsService',
         'municipalitiesService',
         'ratesClientsService',
         'appointmentService',
         function(
            $scope, 
            $state, 
            $rootScope,
            $localStorage, 
            $location, 
            $timeout, 
            clientsService, 
            departmentsService, 
            municipalitiesService,
            ratesClientsService,
            appointmentService) {
    	

        // se debe quitar appointmentService 
    	$scope.Clients;

       /**
        * Model to create new client.
        * @type {Object}
        */
        $scope.newClient = {
        	id: "",
            name: "",
            nit: "",
            social_reazon: "",
            ars_code: "",
            address: "",
            responsible: "",
            email: "",
            phone: "",
            phone2: "",
            state:1,
            municipalities_id: "",
            types_client_id :""

        } 

      



            /**
             * Reset de modal when finish to create new client. 
             * @return {[type]} [description]
             */
        $scope.resetNewClient = function (){
                     // clients model
            $scope.newClient = {
                id: "",
                name: "",
                nit: "",
                social_reazon: "",
                ars_code: "",
                address: "",
                responsible: "",
                email: "",
                phone: "",
                phone2: "",
                state:1,
                municipalities_id: "",
                types_client_id :"",
                ciiu: ""

            }   

        }
        /**
         * Model to update Client.
         * @type {Object}
         */
        $scope.updateClient = {
          	id: "",
            name: "",
            nit: "",
            social_reazon: "",
            ars_code: "",
            address: "",
            responsible: "",
            email: "",
            phone: "",
            phone2: "",
            state: "",
            municipalities_id: "",
            types_client_id :"",
            ciiu: ""


        }
        /** @type {Object} Model to  delete client.  */
        $scope.deleteClient = {
            id: ""

        }

       
    	/** @type {Number} Var to paginate list. */
        $scope.currentPageClients = 0;
        $scope.pageSizeClients = 10;
        $scope.clientsTotal;

         /** @type {Object} Model To get List of departments to the dropdown */
        $scope.Departments={
            id:"",
            name:""
        }
         /**
          * Var to know what it't the department selected. 
          */
        $scope.selectedDepatment;

        /**
         * Object to get  the list of municipalities
         * @type {Object}
         */
        $scope.Municipalities = {

                    id:"",
                    municipality:"",
                    department_id:""
         }
      
         /**
          * Var to know what it't the municipalitie selected. 
          */

         $scope.selectedMunicipalitie;

         /**
          * Get the list of departments for the  dropdown
          * @return {[type]} [description]
          */
        $scope.getDepartments = function(){

            departmentsService.get(function(res){

                $scope.Departments = res.departments;


                $scope.selectedDepatment = $scope.Departments[0];
                $scope.getMunicipalities();
                               
             
                   
                 
            }, function(error){
                console.log(error);
            });
         }
        

        /**
         * function que selecciona un departamento por su indice para el dropdown
         */
         $scope.selectDeparment = function(index){

                 $scope.selectedDepatment = $scope.Departments[index];

         }  
         /**
          * obtener la lista de municipios para un departamentos seleccionado. 
          * @param  {[type]} cityId [description]
          * @return {[type]}        [description]
          */
         $scope.getMunicipalities = function(cityId){
            municipalitiesService.getByDepartment({id:$scope.selectedDepatment.id}, function(res){
               
                $scope.Municipalities = res.municipalities;

                if(cityId === undefined){

                        $scope.selectedMunicipalitie = $scope.Municipalities[0];
            
                }else{

                    for (var i = 0; i < $scope.Municipalities.length; i++) {
                       
                        if($scope.Municipalities[i].id == cityId){

                            $scope.selectedMunicipalitie = $scope.Municipalities[i];
                            
                            break;
                    }          
                }
            }
            
            }, function(error){
                console.log(error);

            });

         }
         /**
          * Obtener el departamento al cual pertenece un  municipio
          * @return {[type]} [description]
          */
        $scope.getByMunicipality = function(){


             $scope.idCity = $scope.updateClient.municipalities_id; // get the 
             
                municipalitiesService.getByMunicipality({id:$scope.idCity}, function(res){
    
                for (var i = 0; i < $scope.Departments.length; i++) {

                    if($scope.Departments[i].id == res.municipalities[0].department_id){
                        

                            $scope.selectDeparment(i); 

                           $scope.getMunicipalities($scope.idCity);
                    
                        break;
                    }
                
                }



             }, function(error){
                console.log(error);

            });
         }

        /**
         * pagina actual
         * @type {Number}
         */
        $scope.currentPageGetClients = 0;
        
        /**
         * Tamaño de la pagina
         * @type {Number}
         */
        $scope.pageSizeGetClients = 10;

        /**
         * Get all the clients. 
         * @param  {[type]} page [description]
         * @return {[type]}      [description]
         */
        $scope.getClients = function(page){

              var offset = 0;

            if (page > 1) {

                offset = (page - 1) * 10
            }

            clientsService.getAll({offset: offset},function(res){

                $scope.clientsTotal = res.total;

                $scope.Clients = res.clients;

                              
                }, function (error) {
                  
                	console.log(error);
            });

        }

        $scope.getClients(0);

        $scope.getDepartments();

     /** show moda Add new Client */
        $scope.showModalAdd = function(){
          
            $('.add-client').modal('show');
        }

        /** Hide the modal to add new client when it's finished */
         $scope.hideModalAdd = function(){

            $('.add-client').modal('hide');
            }

        $scope.state = [
          
          {name:"Habilitado", code:1},
          {name:"Inhabilitado", code:0}

        ];    

    
        /**
         * Funcition to add new Client
         */
        $scope.addClients = function(){


            /**
             * calling service to add a new role
             */

            $scope.newClient.municipalities_id =  $scope.selectedMunicipalitie.id;
            clientsService.add($scope.newClient,function(res){

                  
                    
                    if (res.success == true){

                        $scope.clientsBusinesM.clients_id = res.client.id;


                        console.log($scope.clientsBusinesM.id_client);
                        
                        clientsService.addClientBusines($scope.clientsBusinesM, function(res){

                            console.log(res);

                            if(res.success == true){

                              $scope.hideModalAdd();

                              // $scope.hideModalAdd();

                              $scope.getClients();
                              
                               $scope.resetNewClient();

                               $scope.resetClientsBusinesM(); 



                            }


                        });


                      // $scope.addBusiness();

                        // $scope.hideModalAdd();

                        // $scope.getClients();
                        
                        // $scope.resetNewClient(); 


                    }else{

                    }
                    
                
                }, function (error) {

                    console.log(error);

            });

        }
        /**
         * Show the modal to edit client.
         * @param  {[type]} client [description]
         * @return {[type]}        [description]
         */
        $scope.showModalEdit = function(client){

            console.log(client);
            $scope.updateClient = client;
     
            //  // obtiene todos los departamentos primera vez.    
            $scope.getByMunicipality();
            $scope.getClientsBusines(client);
            

            $('.edit-client').modal('show');



        }


        /**
         * Hide the modal to edit client when it`s finished.
         * @return {[type]} [description]
         */
        $scope.hideModalEdit = function(){

            $('.edit-client').modal('hide');
        }
        /**
         * Funciotn to update client
         * @return {[type]} [description]
         */
        $scope.updateClients = function(){
            
            $scope.updateClient.municipalities_id = $scope.selectedMunicipalitie.id;

            clientsService.edit($scope.updateClient, function(res){

                    console.log(res);
                    
                    if (res.success == true){

                      clientsService.editClientBusiness($scope.updateClientsBusiness, function(res){

                        console.log(res);

                     if(res.success == true){

                        $scope.hideModalEdit();

                        $scope.getClients();
                        //
                        //$scope.getClientsBus();
                        // $scope.getBusinesTer();

                     }


                      });

                       

                    }else{

                    }
                    
                
                }, function (errors) {

                    console.log(errors);

            });

        }
        /** Function to disable client */
        $scope.disableClient= function(client){

            $scope.updateClient = client; 
            if($scope.updateClient.state == 0){

                $scope.updateClient.state = 1;
            
            }else {

                 $scope.updateClient.state = 0;
            }
            clientsService.edit($scope.updateClient,function(res){

                    if(res.succes == true){
                        $scope.getClients();
                    }
                }, function (error) {

                    console.log(error);

            });
        }


$scope.prueba  = function (){
    var date = '2016-06-29';

    appointmentService.getAllAppoinmentsByDay({date:date},function(res){
        console.log('res prueba');
         console.log(res);
                }, function (error) {

                    console.log(error);
            });

}

$('#timepicker').timepicker(); 

$scope.selectedDate = moment(new Date()).format('YYYY-MM-DD');

// $scope.prueba();

    /** @type {Object} [description] */
    $scope.clientsBusinesM = {

    id:'',
    observation:'',
    capital:'',
    type:'',
    date_end:'',
    created:'',
    clients_id:'',
    business_terms_id:''

   };

   /**
    * [updateClientsBusiness description]
    * @type {Object}
    */
   $scope.updateClientsBusiness = {

    id:0,
    observation:'',
    capital:'',
    type:'',
    date_end:'',
    created:'',
    clients_id:'',
    business_terms_id:''

   };


   $scope.resetClientsBusinesM = function(){

     $scope.clientsBusinesM = {

    id:'',
    observation:'',
    capital:'',
    type:'',
    date_end:'',
    created:'',
    clients_id:'',
    business_terms_id:''

   };

   }
   

   /**
    * [getClientsBusines description]
    * @return {[type]} [description]
    */
   $scope.getClientsBusines = function(client){

            // console.log(client.id);
    

    clientsService.getClientBusines({idClient:client.id},function(res){

        console.log(res);

        if(res.success == true){

            $scope.updateClientsBusiness = res.clientBusines[0];

        }

    });

   }


   $scope.addBusiness = function(){



   }

   

  /**
   * [type description]
   * @type {Array}
   */
  $scope.type = [

  {name:"bolsa", code:0},
  {name:"per capita", code:1}

  ];

  $scope.type[0];

  $scope.selectType = $scope.type[0];


    /** @type {Object} [description] */
    $scope.businessTermsM = {

        id:0,
        term:'',
        term_days:''

    };

  $scope.updataBusinessTerms = {

        id:0,
        term:'',
        term_days:''

  };

    /** @type {Array} [description] */
    $scope.term = [

    {name:"contado", code:1},
    {name:"crédito", code:2},
    {name:"crédito 30", code:3},
    {name:"crédito 60", code:4},
    {name:"crédito 90", code:5}    

    ];
    /** @type {[type]} [description] */
    $scope.selectFormPay = $scope.term[0];

    /**
     * [getBusinesTer description]
     * @return {[type]} [description]
     */
    $scope.getBusinesTer = function(){

      clientsService.getBusinesTerminos(function(res){

        console.log(res);
        if(res.success == true){

            
            $scope.BusinessTerms = res.getBusinesTerm;

            console.log($scope.BusinessTerms);
        }

      });  

    }

    $scope.getBusinesTer();

      //talk with controller CLientContacts
      //
    /**
     * [clientsContactsM description]
     * @type {Object}
     */
    $scope.clientsContactsM = {

      id :0,
      name:'',
      phone:'',
      email:'',
      contact_types_id:'',
      clients_id:''

    }; 

  /**
   * [updateClientContactM description]
   * @type {Object}
   */
  $scope.updateClientContactM ={

      id :0,
      name:'',
      phone:'',
      email:'',
      contact_types_id:'',
      clients_id:''

    }; 

    /**
     * [resetClientsContactsM description]
     * @return {[type]} [description]
     */
    $scope.resetClientsContactsM = function(){

    $scope.clientsContactsM = {

      id :0,
      name:'',
      phone:'',
      email:'',
      contact_types_id:'',
      clients_id:''

    }; 

    }

    $scope.clientsContactTypesM = {

      id:0,
      type:''

    };


    

    /**
     * [getClientContac description]
     * @return {[type]} [description]
     */
    $scope.getClientContac = function(){

      clientsService.getClientCont(function(res){

        console.log(res);

        if(res.success == true){

          $scope.clientContactType = res.clientContact;

        }

      });

    }

    $scope.infoClienContact = {

            id: "",
            name: "",
            nit: "",
            social_reazon: "",
            ars_code: "",
            address: "",
            responsible: "",
            email: "",
            phone: "",
            phone2: "",
            state: "",
            municipalities_id: ""

    }

    $scope.getClientContac();

    // $scope.customer = function(){

    //     $scopeupdateClientsBusiness = client;

    //     clientsService.customerBusiness({id:$scope.infoClienContact.id}, function(res){

    //         console.log(res);

    //         if(res.success == true){

    //         $scope.getBusiness = res.customerBusiness;

    //         }

    //     });
    // }



    $scope.modalInfoClient = function(client){

      $scope.infoClienContact = client;

      $scope.getClientsBusines(client);



      $('.info-client-contact').modal('show');

    }

    $scope.hidelModalInfoClient = function(){

       $('.info-client-contact').modal('hide'); 

    }

    $scope.typesContact = [

    {name:'Contratación', code:1},
    {name:'Tesorero', code:2},
    {name:'Cartera', code:3},
    {name:'Glosa', code:4},    

    ];



    }]);






  


    // $scope.addBusinessClient = function(){

    //         $('.add-clien').modal('hide');
    //     }

    

