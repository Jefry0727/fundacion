<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;

use ZipArchive;

/**
 * AttentionStudies Controller
 *
 * @property \App\Model\Table\AttentionStudiesTable $AttentionStudies
 */
class RipsController extends AppController
{

    private $dateIni;
    private $dateEnd;
    private $sede;
    private $cliente;
    private $plan;
    private $numRemision;
    private $billsId;
    private $ordersId;
    private $lines;

    public function initialize(){
        parent::initialize();
        $this->Auth->allow(['genTxt', 'downloadTxt']);
    }


    /**
     * Funcion que genera un documento tipo txt para rips
     * @param  string $name   Nombre del archivo
     * @param  string $suffix sufijo del archivo
     * @param  Array  $dataArray arreglo bidimensional con solo indices con la informacion a escribir 
     * @return File   Archivo .txt de descarga automatico
     */
    public function genTxt($name = 'US',$suffix =''){

        $this->autoRender = false;

        $dataArray = $this->request->data;

        /**
         * Longitud del arreglo
         * @var Int
         */
        $lenght = count($dataArray);

        /**
         * Ruta fisica del servidor
         * @var String
         */
        $dir = $this->getPhysicalResourcesPath();

        /**
         * Ruta completa donde se guardaran los rips temporalmente
         * @var String
         */
        $filePath = $dir.'rips/'.$name.$suffix.'.TXT';
            
        /**
         * manejo de archivo
         */
        $handle = fopen($filePath, 'w') or die('Cannot open file:  '.$filePath);


        /**
         * Recorrido de datos
         */
        foreach ($dataArray as $row) {
            
            unset($row['id']);       
            unset($row['fecha']);
            unset($row['entidad']);
            unset($row['state']);  
            unset($row['orderConsectuiva']);      


            /**
             * Linea a escribir
             * @var string
             */
            $line = '';

            /**
             * Recorrido de cara fila
             */
            foreach ($row as $data) {
                
                $line .= $data.',';    

            }

            /**
             * eliminacion del ultimo caracter
             * @var String
             */
            $line = substr ($line, 0, -1);
            
            /**
             * Linea mas salto
             * @var String
             */
            $line = $line.PHP_EOL;
            /**
             * Escritura en en 
             */
            fwrite($handle, $line);

        }
        
        /**
         * Cierre del archivo
         */
        fclose($handle);    


        /**
         * Descarga del archivo generado
         */
        $this->response->file($filePath, array('download' => true, 'name' => $name.$suffix.'.TXT'));

    }

    public function downloadTxt(){
        



        $this->autoRender = false;
        
          
        $files=scandir( WWW_ROOT . DS . "rips" . DS );
        unset( $files[ 0 ] );
        unset( $files[ 1 ] );
        
        // Objeto que crea los zip 
        $zip = new ZipArchive();

        // ruta completa
        $archivo = WWW_ROOT . "rips" . DS  . 'rips.zip';
        
        // archivo
        $result_code = $zip->open( $archivo , ZipArchive::OVERWRITE | ZipArchive::CREATE  );


        foreach( $files as $nombre ){
            
            $zip->addFile( WWW_ROOT . 'rips/' . $nombre , $nombre);

    
        }
        @$zip->close();




        $this->response->file( $archivo , [ 'download' => true, 'name' => 'Rips_' . date('Y-m-d') . '.zip' ]);

    }

   /**
     * Función que devuelve la ruta del servidor donde se suben los archivos
     * @return String ruta
     */
    public function getPhysicalResourcesPath(){

        return WWW_ROOT;           

    }


    /* Carlos Felipe Aguirre Taborda 2016-11-28 12:28:45
       Establece las propiedades del objeto para ejecutar los filtros sobre las facturas
    */
    public function setRipProperties( $data = null ){
        if( $data == null ){

            $data = $this->request->data;

        }

        foreach( $data as $llave => $valor ){

            $this->{$llave} = $valor;

        }
        switch( $data['filter'] ){

            case '1':
                // Obtiene todas las facturas
                $resultado = $this->getBillsByClient( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;
            case '2':
                // obtiene las facturas para cuentas de cobro
                $resultado = $this->getAptBills( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;
            case '3':
                // otiene las facturas sin resultados
                $resultado = $this->getWithoutResults( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;
                      
            case '4':
                // Obtiene las facturas con estudios en prestamop de placas
                $resultado = $this->getWithLendPlates( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;
            case '5':
                // Obtiene las facturas con estudios que necesitan complementarios
                $resultado = $this->getWithComplementary( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;
            case '6':
                // Obtiene las facturas con ordenes sin número de validación
                $resultado = $this->getWithoutValidator( $data['offset'] );
                $this->set( compact( 'resultado' ) );
                break;


        }
        

    
    }



    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-11-28 11:59:26
      Tipo de retorno:  void
      Descripción: Obtiene las facuras de ese cliente que esten dentro del rango de fechas
    */
    private function getBillsByClient( $page=1 ){
        $this->loadModel( 'Bills' );

        $dateEnd = $this->dateEnd." 23:59:00";
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede;
 
        $resultado  =  $this->Bills->find()
                                    ->select([
                                        'id',
                                        'bill_number',
                                        'created'    
                                    ])
                                    ->distinct(['bill_number'])
                                    ->where([ 
                                        'Bills.created >=' => date('Y-m-d H:i:s', strtotime( $dateIni ) ),
                                        'Bills.created <=' => date('Y-m-d H:i:s', strtotime( $dateEnd ) ),
                                        'Bills.canceled'   =>0
                                    ])
                                    ->matching( 'BillResolutions', 
                                        function( $q ){ 
                                            return $q->select(['bill_types_id'])->where(['bill_types_id'=>1]);
                                    })
                                    ->matching( 'Payments', 
                                        function( $q ){ 
                                            return $q->select([
                                                'copayment',
                                                'credit',
                                                'donation',
                                                'discount'
                                            ]);
                                        } )
                                    ->matching('Orders', 
                                        function( $q ) use( $cliente, $plan, $sede ){
                                            return $q->select(['id',
                                                                'order_consec'
                                            ])
                                            ->where([
                                                'clients_id' => $cliente,
                                                'rates_id'   => $plan,
                                                'centers_id' => $sede,
                                                'Orders.bill_types_id'=>1
                                            ]);
                                         } )
                                    ->matching('Orders.Patients.People', function($q){

                                        return $q->select([
                                            'identification',
                                            'first_name',
                                            'middle_name',
                                            'last_name',
                                            'last_name_two'
                                        ]);
                                    })
                                    ->matching( 'Orders.Appointments.Studies', function( $q ){
                                        return $q->select([ 'cup', 'name' ])->limit(1);
                                     } )
                                    ->order(['Bills.created'=>'DESC'])
                                    ->limit(30)
                                    ->page( $page );

        if( $resultado ){
            $resultado = $resultado->toArray();
            return $resultado;
        }
        else{

            if( $resultado->errors() ){
                return $resultado->errors();
            }
            else{

                return [];
            }
            

        
        }
    }


    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-11-30 10:17:13
      Tipo de retorno: array
      Descripción: Esta funcion retorna una lista con la información de las facturas
        que son aptas para hacer las cuentas de cobro
    */
    private function getAptBills( $page, $limit=30 ){
        $dateEnd = $this->dateEnd;
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede;


        $this->loadModel( 'Bills' );

        $connection = ConnectionManager::get('default');
        $results = $connection->execute('
        SELECT 
            bills.id as bills_id,
            results.id as results_id,
            orders.id as orders_id,
            orders.order_consec,
            bills.created,
            bill_resolutions.id as bill_resolutions_id,
            count( orders.id ) as results_number,
            STUDIESNUMBER.studies_number,
            attentions.id as attentions_id
            
        FROM
            results
            INNER JOIN
                attentions
            ON
                results.attentions_id = attentions.id
            INNER JOIN
                appointments
            ON
                attentions.appointments_id = appointments.id
            INNER JOIN
                order_appointments
            ON
                appointments.id = order_appointments.appointments_id
            INNER JOIN
                orders
            ON
                order_appointments.orders_id = orders.id
            INNER JOIN
                orders_bills
            ON
                orders.id = orders_bills.orders_id
            INNER JOIN
                bills
            ON
                orders_bills.bills_id = bills.id
            INNER JOIN
                bill_resolutions
            ON
                bills.bill_resolutions_id = bill_resolutions.id
            INNER JOIN
            (
                SELECT 
                    bills.id AS bills_id,
                    orders.id AS orders_id,
                    orders.order_consec,
                    COUNT(orders.id) AS studies_number,
                    bills.bill_number
                FROM
                    appointments
                        INNER JOIN
                    order_appointments ON appointments.id = order_appointments.appointments_id
                        INNER JOIN
                    orders ON order_appointments.orders_id = orders.id
                        INNER JOIN
                    orders_bills ON orders.id = orders_bills.orders_id
                        INNER JOIN
                    bills ON orders_bills.bills_id = bills.id
                        INNER JOIN
                    bill_resolutions ON bills.bill_resolutions_id = bill_resolutions.id
                WHERE
                    bill_resolutions.bill_types_id = 1
                    AND 
                        date( bills.created ) >= "'. $dateIni .'"
                    AND
                        date( bills.created ) <= "'. $dateEnd .'"
                GROUP BY orders.id
            )
            STUDIESNUMBER
            ON
                bills.id = STUDIESNUMBER.bills_id
            WHERE 
                bill_resolutions.bill_types_id =1
            AND 
                date( bills.created ) >= "'. $dateIni .'"
            AND
                date( bills.created ) <= "'. $dateEnd .'"
            AND
                orders.centers_id = '. $sede .'
            AND
                orders.rates_id   ='. $plan .'
            AND 
                attentions.lend_plates = 0
            AND
                results.state = 1
            AND 
                bills.id NOT IN (

                    SELECT 
                    	bills_id 
                    FROM 
                    	payment_accounts_bills 
                        inner join 
                        payment_accounts 
                        ON
                    		payment_accounts_bills.payment_accounts_id = payment_accounts.id
                    	WHERE
                    		payment_accounts.state = 0
                            AND
                            payment_accounts.clients_id = ' . $cliente . '
                            AND
                            payment_accounts.rates_id = '. $plan .'

                )
        GROUP BY orders.id
        HAVING 
            results_number = studies_number;
        ')->fetchAll('assoc');
            
        // Obtiene solo los ids de las facturas validas para cuentas de cobro
        foreach( $results as $valor ){
            foreach( $valor as $llave => $valor2 ){
                if( $llave == 'bills_id' ){
                    $billsId[] = $valor2;
                }
            }
        }

        if( empty( $billsId ) ){
            
            return [];
        
        }

        $resultado  =  $this->Bills->find()
                                    ->select([
                                        'id',
                                        'bill_number',
                                        'created'    
                                    ])
                                    ->distinct(['bill_number'])
                                    ->where([ 
                                        'Bills.id      IN' => $billsId,
                                        'Bills.canceled'   =>0
                                    ])
                                    ->matching( 'BillResolutions', function( $q ){ 
                                        return $q->select(['bill_types_id']);
                                    } )
                                    ->matching( 'Payments', 
                                        function( $q ){ 
                                            return $q->select([
                                                'id',
                                                'copayment',
                                                'credit',
                                                'donation',
                                                'discount'
                                            ]);
                                        } )
                                    ->matching('Orders', 
                                        function( $q ) use( $cliente, $plan, $sede ){
                                            return $q->select(['id',
                                                                'order_consec',
                                                                'rates_id',
                                                                'clients_id'
                                            ])
                                            ->where([
                                                'clients_id' => $cliente,
                                                'rates_id'   => $plan,
                                                'centers_id' => $sede,
                                                'validator IS NOT NULL',
                                                'validator <> "" '
                                            ]);
                                         } )
                                    ->matching('Orders.Patients.People', function($q){

                                        return $q->select([
                                            'identification',
                                            'first_name',
                                            'middle_name',
                                            'last_name',
                                            'last_name_two'
                                        ]);
                                    })
                                    ->matching( 'Orders.Appointments.Studies', function( $q ){
                                        return $q->select([ 'cup', 'name' ])->limit(1);
                                     } )
                                    ->limit( $limit )
                                    ->page( $page );
        
        if( $resultado ){
            $resultado = $resultado->toArray();
            return $resultado;
        }
        else{

            if( $resultado->errors() ){
                return $resultado->errors();
            }
            else{

                return [];
            }
            

        
        }

    }


    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-05 17:07:54
      Tipo de dato de retorno:array
      Descripción: Esta funcion devuelve las facturas que aun no tienen los resultados
    */
    private function getWithoutResults( $page = 1 ){
        $this->loadModel( 'Bills' );

        $dateEnd = $this->dateEnd;
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede;
        
        $connection = ConnectionManager::get('default');
        $results = $connection->execute('
            SELECT 
                bills.id as bills_id
            FROM
                bills

                LEFT JOIN
                    orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                LEFT JOIN
                    orders
                    ON
                        orders_bills.orders_id = orders.id
                LEFT JOIN 
                    order_appointments
                    ON
                        orders.id = order_appointments.orders_id
                LEFT JOIN
                    appointments
                    ON 
                        order_appointments.appointments_id = appointments.id
                LEFT JOIN
                    attentions
                    ON
                        appointments.id = attentions.appointments_id
            WHERE 
                attentions.id NOT IN (
                    SELECT 
                        results.attentions_id
                    FROM 
                        results
                    LEFT JOIN
                        attentions
                            ON
                            results.attentions_id = attentions.id
                    LEFT JOIN
                        appointments
                        ON
                        attentions.appointments_id = appointments.id
                    LEFT JOIN
                        order_appointments
                        ON
                        appointments.id = order_appointments.appointments_id
                    LEFT JOIN 
                        orders
                        ON
                        order_appointments.orders_id =  orders.id
                    LEFT JOIN
                        orders_bills
                        ON 
                            orders.id = orders_bills.orders_id
                    LEFT JOIN 
                        bills
                        ON
                        orders_bills.bills_id = bills.id
                    WHERE 
                       
                            DATE( bills.created ) >= "'. $dateIni .'"
                        AND 
                            DATE( bills.created ) <= "' . $dateIni . '"
                        AND 
                            orders.centers_id = ' . $sede . '
                )
                AND
                    DATE( bills.created ) >= "'. $dateIni .'"
                AND 
                    DATE( bills.created ) <= "' . $dateIni . '"
                AND 
                    orders.centers_id= ' . $sede . '
        ')->fetchAll('assoc');

        // Obtiene solo los ids de las facturas validas para cuentas de cobro


        foreach( $results as $valor ){
            foreach( $valor as $llave => $valor2 ){
                if( $llave == 'bills_id' ){
                    $billsId[] = $valor2;
                }
            }
        }


        if( empty( $billsId ) ){
            return [];
        }

        $resultado  =  $this->Bills->find()
                            ->select([
                                'id',
                                'bill_number',
                                'created'    
                            ])
                            ->where([ 
                                'Bills.id IN'      => $billsId,
                                'Bills.canceled'   =>0
                            ])
                            ->matching( 'BillResolutions.BillTypes', function( $q ){ 
                                return $q->select([])->where(['BillTypes.id'=>1]);
                            } )
                            ->matching( 'Payments', 
                                function( $q ){ 
                                    return $q->select([
                                        'copayment',
                                        'credit',
                                        'donation',
                                        'discount'
                                    ]);
                                } )
                            ->matching('Orders', 
                                function( $q ) use( $cliente, $plan, $sede ){
                                    return $q->select(['id',
                                                        'order_consec'
                                    ])
                                             ->where([
                                                 'clients_id' => $cliente,
                                                 'rates_id'   => $plan,
                                                 'centers_id' => $sede
                                             ]);
                                 } )
                            ->matching('Orders.Patients.People', 
                                function($q){
                                    return $q->select([
                                        'identification',
                                        'first_name',
                                        'middle_name',
                                        'last_name',
                                        'last_name_two'
                                    ]);
                                })
                            ->matching( 'Orders.Appointments.Studies', function( $q ){
                                return $q->select([ 'cup', 'name' ])->limit(1);
                             } )
                            ->limit(30)
                            ->page( $page );

      if( $resultado ){
           
           $resultado = $resultado->toArray();
           return $resultado;
       
       }
       else{ 
       
           if( $resultado->errors() ){
       
               return $resultado->errors();
       
           }
       
           else{   
       
               return [];
       
           }

       }
    
    }

    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-05 17:12:06
      Tipo de dato de retorno:array
      Descripción: Esta funcion devuelve las facturas qcon estudios que tienen pretamo de placas
    */
    private function getWithLendPlates( $page = 1, $limit = 30 ){

        $this->loadModel( 'Bills' );

        $dateEnd = $this->dateEnd;
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede;
        
        $connection = ConnectionManager::get('default');
        $results = $connection->execute('
            SELECT 
                bills.id as bills_id
            FROM
                bills

                LEFT JOIN
                    orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                LEFT JOIN
                    orders
                    ON
                        orders_bills.orders_id = orders.id
                LEFT JOIN 
                    order_appointments
                    ON
                        orders.id = order_appointments.orders_id
                LEFT JOIN
                    appointments
                    ON 
                        order_appointments.appointments_id = appointments.id
                LEFT JOIN
                    attentions
                    ON
                        appointments.id = attentions.appointments_id
            WHERE 
                attentions.lend_plates = 1
                AND
                    DATE( bills.created ) >= "'. $dateIni .'"
                AND 
                    DATE( bills.created ) <= "' . $dateEnd . '"
                AND 
                    orders.centers_id= ' . $sede . '
                AND 
                    bills.id NOT IN (

                        SELECT 
                        	bills_id 
                        FROM 
                        	payment_accounts_bills 
                            inner join 
                            payment_accounts 
                            ON
                        		payment_accounts_bills.payment_accounts_id = payment_accounts.id
                        	WHERE
                        		payment_accounts.state = 0
                                AND
                                payment_accounts.clients_id = ' . $cliente . '
                                AND
                                payment_accounts.rates_id = '. $plan .'

                    )
        ')->fetchAll('assoc');

        // Obtiene solo los ids de las facturas validas para cuentas de cobro



        foreach( $results as $valor ){
            foreach( $valor as $llave => $valor2 ){
                if( $llave == 'bills_id' ){
                    $billsId[] = $valor2;
                }
            }
        }


        if( empty( $billsId ) ){
            return [];
        }


        $resultado  =  $this->Bills->find()
                            ->select([
                                'id',
                                'bill_number',
                                'created'    
                            ])
                            ->distinct(['Bills.id'])
                            ->where([ 
                                'Bills.id IN'      => $billsId,
                                'Bills.canceled'   =>0
                            ])
                            ->matching( 'BillResolutions', 
                                function( $q ){ 
                                    return $q->select(['bill_types_id'])->where(['bill_types_id'=>1]);
                            })
                            ->matching( 'Payments', 
                                function( $q ){ 
                                    return $q->select([
                                        'copayment',
                                        'credit',
                                        'donation',
                                        'discount'
                                    ]);
                                } )
                            ->matching('Orders', 
                                function( $q ) use( $cliente, $plan, $sede ){
                                    return $q->select(['id',
                                                        'order_consec',
                                                        'rates_id',
                                                        'clients_id'
                                    ])
                                             ->where([
                                                 'clients_id' => $cliente,
                                                 'rates_id'   => $plan,
                                                 'centers_id' => $sede
                                             ]);
                                 } )
                            ->matching('Orders.Patients.People', 
                                function($q){
                                    return $q->select([
                                        'identification',
                                        'first_name',
                                        'middle_name',
                                        'last_name',
                                        'last_name_two'
                                    ]);
                                })
                            ->matching( 'Orders.Appointments.Studies', function( $q ){
                                return $q->select([ 'cup', 'name' ])->limit(1);
                             } )
                            ->limit( $limit )
                            ->page( $page );

      if( $resultado ){
           
           $resultado = $resultado->toArray();
           return $resultado;
       
       }
       else{ 
       
           if( $resultado->errors() ){
       
               return $resultado->errors();
       
           }
       
           else{   
       
               return [];
       
           }

       }

    }

    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-05 17:32:49
      Tipo de dato de retorno: array
      Descripción: Devuelve un array con las facturas de ordenes que tienen estudios que necesitan complementarios
    */
    private function getWithComplementary( $page = 1 ){

        $this->loadModel( 'Bills' );

        $dateEnd = $this->dateEnd;
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede;

        $connection = ConnectionManager::get('default');
        $results = $connection->execute('
            SELECT 
                bills.id as bills_id
            FROM
                bills

                INNER JOIN
                    orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                INNER JOIN
                    orders
                    ON
                        orders_bills.orders_id = orders.id
                INNER JOIN 
                    order_appointments
                    ON
                        orders.id = order_appointments.orders_id
                INNER JOIN
                    appointments
                    ON 
                        order_appointments.appointments_id = appointments.id
                INNER JOIN
                    attentions
                    ON
                        appointments.id = attentions.appointments_id
                INNER JOIN 
                    results
                    ON
                        attentions.id   = results.attentions_id
            WHERE 
                    DATE( bills.created ) >= "'. $dateIni .'"
                AND 
                    DATE( bills.created ) <= "' . $dateEnd . '"
                AND 
                    orders.centers_id      = ' . $sede . '
                AND
                    results.complement     =  1

        ')->fetchAll('assoc');

        // Obtiene solo los ids de las facturas validas para cuentas de cobro


        foreach( $results as $valor ){
            foreach( $valor as $llave => $valor2 ){
                if( $llave == 'bills_id' ){
                    $billsId[] = $valor2;
                }
            }
        }


        if( empty( $billsId ) ){
            return [];
        }

        $resultado  =  $this->Bills->find()
                            ->select([
                                'id',
                                'bill_number',
                                'created'    
                            ])
                            ->distinct(['Bills.id'])
                            ->where([ 
                                'Bills.id IN'      => $billsId,
                                'Bills.canceled'   =>0
                            ])
                            ->matching( 'BillResolutions', 
                                function( $q ){ 
                                    return $q->select(['bill_types_id'])->where(['bill_types_id'=>1]);
                            })
                            ->matching( 'Payments', 
                                function( $q ){ 
                                    return $q->select([
                                        'copayment',
                                        'credit',
                                        'donation',
                                        'discount'
                                    ]);
                                } )
                            ->matching('Orders', 
                                function( $q ) use( $cliente, $plan, $sede ){
                                    return $q->select(['id',
                                                       'order_consec',
                                                       'rates_id',
                                                       'clients_id'
                                    ])
                                             ->where([
                                                 'clients_id' => $cliente,
                                                 'rates_id'   => $plan,
                                                 'centers_id' => $sede
                                             ]);
                                 } )
                            ->matching('Orders.Patients.People', 
                                function($q){
                                    return $q->select([
                                        'identification',
                                        'first_name',
                                        'middle_name',
                                        'last_name',
                                        'last_name_two'
                                    ]);
                                })
                            ->matching( 'Orders.Appointments.Studies', function( $q ){
                                return $q->select([ 'cup', 'name' ])->limit(1);
                             } )
                            ->limit(30)
                            ->page( $page );

      if( $resultado ){
           
           $resultado = $resultado->toArray();
           return $resultado;
       
       }
       else{ 
       
           if( $resultado->errors() ){
       
               return $resultado->errors();
       
           }
       
           else{   
       
               return [];
       
           }

       }


    }

    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-06 08:37:38
      Tipo de dato de retorno: array
      Descripción: Devuelve un array con la lista de facturas que poseen ordenes sin numero de validacion
    */
    private function getWithoutValidator( $page = 1 ){
       $this->loadModel( 'Bills' );

        $dateEnd = $this->dateEnd;
        $dateIni = $this->dateIni;
        $cliente = $this->cliente;
        $plan    = $this->plan;
        $sede    = $this->sede; 


        $resultado  =  $this->Bills->find()
                            ->select([
                                'id',
                                'bill_number',
                                'created'    
                            ])
                            ->distinct(['Bills.id'])
                            ->where([ 
                                'Bills.created >=' =>$dateIni,
                                'Bills.created <=' =>$dateEnd
                            ])
                            ->matching( 'BillResolutions', 
                                function( $q ){ 
                                    return $q->select(['bill_types_id'])->where(['bill_types_id'=>1]);
                            })
                            ->matching( 'Payments', 
                                function( $q ){ 
                                    return $q->select([
                                        'copayment',
                                        'credit',
                                        'donation',
                                        'discount'
                                    ]);
                                } )
                            ->matching('Orders', 
                                function( $q ) use( $cliente, $plan, $sede ){
                                    return $q->select(['id',
                                                        'order_consec'
                                    ])
                                             ->where([
                                                 'clients_id' => $cliente,
                                                 'rates_id'   => $plan,
                                                 'centers_id' => $sede,
                                                 'validator IS NULL OR validator=""'
                                             ]);
                                 } )
                            ->matching('Orders.Patients.People', 
                                function($q){
                                    return $q->select([
                                        'identification',
                                        'first_name',
                                        'middle_name',
                                        'last_name',
                                        'last_name_two'
                                    ]);
                                })
                            ->matching( 'Orders.Appointments.Studies', function( $q ){
                                return $q->select([ 'cup', 'name' ])->limit(1);
                             } )
                            ->limit(30)
                            ->page( $page );

      if( $resultado ){
           
           $resultado = $resultado->toArray();
           return $resultado;
       
       }
       else{ 
       
           if( $resultado->errors() ){
       
               return $resultado->errors();
       
           }
       
           else{   
       
               return [];
       
           }

       }
    }



    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-12 11:43:15
      Tipo de dato de retorno: void
      Descripción: obtiene las facturas aptas y con placas prestadas y las envia para ponerlas en la cuenta de cobro
    */
    public function generatePaymentAccount(){

        $data= $this->request->data;

        foreach( $data as $llave => $valor ){

            $this->{$llave} = $valor;

        }

        $resultado = array_merge( $this->getAptBills( 1, 10000) , $this->getWithLendPlates( 1, 10000 ) );
        $this->set( compact( 'resultado' ) );
    }

    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-12 11:41:19
      Tipo de dato de retorno:  void
      Descripción: esta funcion guarda  los registros en la base de datos de la cuenta de cobro y las facturas relacionadas a esta
    */
    public function saveAccount(){
        

        
        $this->loadModel('PaymentAccounts');
        $this->loadModel('PaymentAccountsBills');
        
        $data = $this->request->data;
        

        // asigna las propiedates faltantes
        for( $i = 0; $i < count( $data ); $i++ ){

            $consecutivo = $this->PaymentAccounts->find()->select( [ 'consec' => 'max(PaymentAccounts.payment_consec)' ] )->first()->toArray();
            $consecutivo = $consecutivo['consec'] + 1;

            $data[ $i ]['payment_consec'] = $consecutivo;
            $data[ $i ]['created'] = date('Y-m-d H:i:s');
            $data[ $i ]['state']   = '0';
            
        }

        // Guarda la cuenta de cobro
        $paymentAccount = $this->PaymentAccounts->newEntity();
        $paymentAccount = $this->PaymentAccounts->patchEntity( $paymentAccount, $data[ 0 ] );
        
        if( !$this->PaymentAccounts->save( $paymentAccount ) ){
            
            $success = false;
            $resultado = $paymentAccount->errors();
            $this->set( compact( 'success', 'resultado' ) );
        
        }
        else{
            $paymentAccountId = $paymentAccount->id;
        }

        // guarda las facturas de las cuentas de cobro
        for( $i = 0; $i < count( $data ); $i++ ){
            $data[$i]['payment_accounts_id'] = $paymentAccountId ;

            $paymentAccountsBills = $this->PaymentAccountsBills->newEntity();
            $paymentAccountsBills = $this->PaymentAccountsBills->patchEntity( $paymentAccountsBills, $data[ $i ] );
            
            if( !$this->PaymentAccountsBills->save( $paymentAccountsBills ) ){
            
                $success = false;
                $resultado = $paymentAccountsBills->errors();
                $this->set( compact( 'success', 'resultado' ) );
        
            }

        }

        $success = true;
        $resultado['consec'] = $data[ 0 ]['payment_consec'];    
        //  $resultado['consec']=101;
        $this->set( compact( 'success', 'resultado' ) );


        
        
        


    }


    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-12 16:42:56
      Tipo de dato de retorno:  void
      Descripción: cambia el estado de la cuenta de cobro a 1 (anulado)
    */
    public function cancelPaymentAccount(){
        $this->loadModel('PaymentAccounts');
        
        $consecutivo = $this->request->data['order_consec'];



        $registro = $this->PaymentAccounts->find()->select(['id'])->where([
                                  'id >'=>1,
                                  'payment_consec'=>$consecutivo
                              ])->first();  
        
        if( $registro  ){
            $registro = $registro->toArray();
            $resultado=$this->PaymentAccounts->query()
                      ->update()
                      ->set([
                          'state'=>1
                      ])
                      ->where([
                          'id '=>$registro['id']
                      ])
                      ->execute();
            $success = true;

            $this->set( compact( 'resultado', 'success' ) );
        }
        else{
            
            $resultado=[];
            $success = false;
            $this->set( compact( 'resultado', 'success' ) );
        
        }

        
    }




    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-13 10:50:31
      Tipo de dato de retorno:  void
      Descripción: Busca la informacion de las facturas relacionadas a una cuenta de cobro dada
    */
    public function findPaymentAccount(){
      

      $this->loadModel('Bills');

      $consecutivo = $this->request->data['order_consec'];

        if( !empty( $this->getBillsId( $consecutivo ) ) ){
            
            $success = true;

           // obtiene los ids de las facturas relacionadas con la cuenta de cobro
            $billsId = $this->getBillsId( $consecutivo );


            // Obtiene los items en las cuentas de cobro
                    $paymentAccount  =  $this->Bills->find()
                                    ->select([
                                        'id',
                                        'bill_number',
                                        'created'    
                                    ])
                                    ->distinct(['bill_number'])
                                    ->where([ 
                                        'Bills.canceled'   =>0,
                                        'Bills.id IN'=> $billsId
                                    ])
                                    ->matching( 'BillResolutions', 
                                        function( $q ){ 
                                            return $q->select(['bill_types_id'])->where(['bill_types_id'=>1]);
                                    })
                                    ->matching( 'Payments', 
                                        function( $q ){ 
                                            return $q->select([
                                                'copayment',
                                                'credit',
                                                'donation',
                                                'discount'
                                            ]);
                                        } )
                                    ->matching('Orders', 
                                        function( $q ){
                                            return $q->select(['id',
                                                                'order_consec'
                                            ])
                                            ->where([
                                                'Orders.bill_types_id'=>1
                                            ]);
                                         } )
                                    ->matching('Orders.Patients.People', function($q){

                                        return $q->select([
                                            'identification',
                                            'first_name',
                                            'middle_name',
                                            'last_name',
                                            'last_name_two'
                                        ]);
                                    })
                                    ->matching( 'Orders.Appointments.Studies', function( $q ){
                                        return $q->select([ 'cup', 'name' ])->limit(1);
                                     } )
                                    ->order(['Bills.created'=>'DESC']);
            // ya obtuvo los items de la cuenta de cobro



     


            $this->set( compact( 'paymentAccount', 'success' ) );
        
        }
        else{
            $success = false;

            $resultado =[];
            $this->set( compact( 'resultado', 'success' ) );

        }

    }

    public function generateRips(){
        
        $consecutivo = $this->request->data[ 'payment_consec' ];
        $billsId = $this->getBillsId( $consecutivo, false );
        
        if( !empty( $billsId ) ){
            $this->deleteLastRips();
            $this->generateRipAF( $billsId );
            $this->generateRipAP( $billsId );
            $this->generateRipUS( $billsId );
            $this->generateRipAC( $billsId );
            $this->generateRipAT( $billsId );
            $this->generateRipAD( $billsId );
            $this->generateRipAM( $billsId );
            $this->generateRipCT( $billsId, $consecutivo );
            $success = true;
            $this->set( compact( 'success' ) );

        }
    }







    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-12-13 11:54:44
      Tipo de dato de retorno:  void
      Descripción: Obtiene la lista de los ids de las facturas relacionadas a una cuenta de cobro
    */
    private function getBillsId( $consecutivo, $list = true ){
      $this->loadModel('PaymentAccountsBills');  


      $resultado = $this->PaymentAccountsBills->find()
                                        ->select([
                                            'bills_id'
                                        ])
                                        ->matching( 'PaymentAccounts', function( $q ) use( $consecutivo ) { 
                                            return $q->select(['state'])->where(['payment_consec'=>$consecutivo]);
                                      } );
      if( $resultado->toArray() ){
          
            $resultado =  json_decode( json_encode( $resultado ), true);

            // obtiene los ids de las facturas 
            foreach( $resultado as $valor ){
               foreach( $valor as $llave => $valor2 ){
                
                    if( $llave == 'bills_id' ){
                    
                        $billsId[] = $valor2;
                    }
               }

            }
            
            if( $list ){
            
                return $billsId;
            }
            else{
                 
                 return '(' . implode( ",", $billsId ) . ')';
            }


      }
      else{
          return [];
      }


    }


    // Genera el rip AF a partir de una consulta
    private function generateRipAF( $billsId ){

        $query = 'SELECT 
                    habilitation_code.code as A,
                 	"FUNDACION ALEJANDRO LONDONO" as B,
                    "NI" as C,
                    "800135582-7" as D,
                 	bills.bill_number as E,
                    DATE( bills.created ) as F,
                    CONCAT( SUBSTRING( attentions.date_time_ini, 1, 8 ), "01") as G,
                    LAST_DAY( attentions.date_time_ini ) as H,
                    clients.ars_code as I,
                    clients.name as  J,
                    "número de contrato" as K,
                    rates.name as L,
                    "vacío" as M,
                    payments.copayment as N,
                    "0" as O,
                 	"0" as P,
                    payments.credit as Q
                 FROM 
                 	bills
                     INNER JOIN orders_bills
                     ON
                 		bills.id = orders_bills.bills_id
                 	INNER JOIN orders
                     ON
                 		orders_bills.orders_id = orders.id
                 	INNER JOIN clients
                     ON
                 		orders.clients_id = clients.id
                 	INNER JOIN patients
                     ON
                 		orders.patients_id = patients.id
                 	INNER JOIN people
                     ON
                 		patients.people_id = people.id
                 	INNER JOIN payments
                     ON
                 		bills.id = payments.bills_id
                 	INNER JOIN centers
                     ON
                 		orders.centers_id = centers.id
                 	INNER JOIN habilitation_code 
                     ON
                 		centers.id = habilitation_code.centers_id
                 	INNER JOIN order_appointments
                     ON
                 		orders.id = order_appointments.orders_id
                 	INNER JOIN appointments
                     ON
                 		order_appointments.appointments_id = appointments.id
                 	INNER JOIN attentions
                     ON
                 		appointments.id = attentions.appointments_id
                 	INNER JOIN rates
                     ON
                 		orders.rates_id = rates.id
                     
                     WHERE 
                 		bills.id IN ' . $billsId  . '
                 	GROUP BY bills.id';

                     $resultado = $this->executeQuery( $query  );
                     $this->lines[ 'AF' ] = count( $resultado );
                     $this->createFile( $resultado, 'AF' );

    }

    // Genera el rip AP a partir de una consulta
    private function generateRipAP( $billsId ){


                $query = "SELECT 
                        	bills.bill_number as A,
                            habilitation_code.code as B,
                            document_types.initials as C,
                            people.identification as D,
                            DATE( attentions.date_time_ini ) as E,
                            orders.validator as F,
                            studies.cup as G,
                            '1' as H,
                            '1' as I,
                        	'1' as J,
                            cie_ten_codes.code as K,
                            'vacío' as L,
                            'vacío' as M,
                            'vacío' as N,
                            rate_studies.value as O
                        FROM
                        	appointments
                        	INNER JOIN order_appointments
                        	ON
                        		appointments.id = order_appointments.appointments_id
                        	INNER JOIN	orders
                            ON
                        		order_appointments.orders_id = orders.id
                            
                            INNER JOIN orders_bills
                        	ON
                        		orders.id = orders_bills.orders_id
                        	INNER JOIN bills
                        		ON
                                orders_bills.bills_id = bills.id
                            
                        	INNER JOIN centers
                        	ON
                        		orders.centers_id = centers.id
                        	INNER JOIN habilitation_code 
                        	ON
                        		centers.id = habilitation_code.centers_id
                            
                        	INNER JOIN patients
                            ON
                        		orders.patients_id = patients.id
                        	INNER JOIN people
                            ON
                        		patients.people_id = people.id
                        	INNER JOIN document_types
                            ON
                        		people.document_types_id = document_types.id
                            
                        	INNER JOIN attentions
                            ON
                        		appointments.id = attentions.appointments_id
                        	INNER JOIN studies
                            ON
                        		appointments.studies_id = studies.id
                        	INNER JOIN cie_ten_codes
                            ON
                        		orders.cie_ten_codes_id = cie_ten_codes.id
                        	INNER JOIN rates
                            ON
                        		orders.rates_id = rates.id
                        	INNER JOIN rate_studies
                            ON
                        		( 
                        			rates.id = rate_studies.rates_id
                                    AND
                                    studies.id = rate_studies.studies_id
                        		)
                            WHERE
                        		bills.id IN " . $billsId ;
        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'AP' ] = count( $resultado );
        $this->createFile( $resultado, 'AP' );
    }


    // Genera el rip US a partir de una consulta
    private function generateRipUS( $billsId ){
        $query = "
            SELECT 
                document_types.initials as A,
                people.identification as B,
                clients.ars_code as C,
                regimes.id as D,
                people.last_name as E,
                people.last_name_two as F,
                people.first_name as G,
                people.middle_name as H,
                CONCAT(
                    TIMESTAMPDIFF( YEAR, people.birthdate, now() ),'.',
                    TIMESTAMPDIFF( MONTH, people.birthdate, now() ) % 12,'.',
                    FLOOR(TIMESTAMPDIFF( DAY, people.birthdate, now() ) % 30.4375 )
                ) as I,
                '1' as J,
                gender.initials as K,
                municipalities.divipola as L,
                departments.divipola as M,
                SUBSTRING( zones.zone, 1, 1 ) as N
            FROM orders
                INNER JOIN orders_bills
                ON
                    orders.id = orders_bills.orders_id
                INNER JOIN	bills
                ON
                    orders_bills.bills_id = bills.id
                INNER JOIN patients
                ON
                    orders.patients_id = patients.id
                INNER JOIN people
                ON
                    patients.people_id = people.id
                INNER JOIN document_types
                ON
                    people.document_types_id = document_types.id
                INNER JOIN clients
                ON
                    orders.clients_id = clients.id
                INNER JOIN regimes
                ON 
                    patients.regimes_id = regimes.id
                INNER JOIN gender
                ON
                    people.gender = gender.id

                INNER JOIN zones
                ON
                    patients.zone_id = zones.id
                INNER JOIN municipalities
                ON
                    people.municipalities_id = municipalities.id
                INNER JOIN departments
                ON
                    municipalities.department_id = departments.id
                WHERE bills.id IN " . $billsId . "
            GROUP BY people.id;
        ";
      
        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'US' ] = count( $resultado );
        $this->createFile( $resultado, 'US' );

    }


    // Genera el rip AC a partir de una consulta
    private function generateRipAC( $billsId ){

        $query = "SELECT
                    bills.bill_number as A,
                    habilitation_code.code as B ,
                    document_types.initials as C,
                    people.identification as D,
                    DATE( attentions.date_time_ini ) as E,
                    orders.validator as F,
                    studies.cup as G,
                    '10' as H,
                    '15' as I,
                    cie_ten_codes.code as J,
                    '' as K,
                    '' as L,
                    '' as M,
                    '1' as N,
                    bill_details_items.value as O,
                    payments.copayment as P,
                    payments.credit as Q
                FROM
                    bill_details_items
                    INNER JOIN 	bill_details
                    ON
                        bill_details_items.bill_details_a_id = bill_details.id
                    INNER JOIN	bills
                    ON
                        bill_details.bills_id = bills.id
                    INNER JOIN orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                    INNER JOIN orders
                    ON
                        orders_bills.orders_id = orders.id
                    INNER JOIN order_appointments
                    ON
                        orders.id = order_appointments.orders_id
                    INNER JOIN appointments
                    ON
                        order_appointments.appointments_id = appointments.id
                    INNER JOIN studies
                    ON
                        bill_details_items.item_id = studies.id
                    INNER JOIN clients
                    ON
                        orders.clients_id = clients.id
                    INNER JOIN habilitation_code
                    ON
                        orders.centers_id = habilitation_code.centers_id
                    INNER JOIN patients
                    ON 
                        orders.patients_id = patients.id
                    INNER JOIN people
                    ON
                        patients.people_id = people.id
                    INNER JOIN document_types
                        ON
                            people.document_types_id = document_types.id
                    INNER JOIN attentions
                        ON
                            appointments.id = attentions.appointments_id
                    INNER JOIN cie_ten_codes
                    ON
                        orders.cie_ten_codes_id = cie_ten_codes.id
                    INNER JOIN payments
                    ON
                        bills.id = payments.bills_id
                    INNER JOIN bill_resolutions
                    ON
                        (
                        bills.bill_resolutions_id = bill_resolutions.id
                        AND
                        bill_resolutions.bill_types_id = 1
                        )
                WHERE 
                    bills.id IN ". $billsId ."
                    AND
                    studies.name LIKE '%consulta%'
                GROUP BY bill_details_items.id
        ";

        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'AC' ] = count( $resultado );
        $this->createFile( $resultado, 'AC' );


    }


    // Genera el rip AT a partir de una consulta
    private function generateRipAT( $billsId ){
        $query = "
            SELECT 

                bills.bill_number as A,
                habilitation_code.code as B,
                document_types.initials as C,
                people.identification as D,
                orders.validator as E,
                product_services_types.numerical_indicator as F,
                services.cup as G,
                services.name as H,
                bill_details_items.quantity as I,
                bill_details_items.value as J,
                bill_details_items.quantity *bill_details_items.value as K
            FROM
                bill_details_items
                INNER JOIN bill_details 
                ON 
                    bill_details_items.bill_details_a_id = bill_details.id
                INNER JOIN bills 
                ON 
                    bill_details.bills_id = bills.id
                INNER JOIN orders_bills 
                ON 
                    bills.id = orders_bills.bills_id
                INNER JOIN orders 
                ON 
                    orders_bills.orders_id = orders.id
                INNER JOIN habilitation_code 
                ON 
                    orders.centers_id = habilitation_code.centers_id
                INNER JOIN patients 
                ON 
                    orders.patients_id = patients.id
                INNER JOIN people 
                ON 
                    patients.people_id = people.id
                INNER JOIN document_types 
                ON 
                    people.document_types_id = document_types.id
                INNER JOIN services 
                ON 
                (bill_details_items.item_id = services.id
                AND
                bill_details_items.item_types_id = 1)
                INNER JOIN product_services_types_services
                ON
                    services.id = product_services_types_services.services_id
                INNER JOIN product_services_types
                ON
                    (
                        product_services_types_services.product_services_types_id = product_services_types.id
                        AND
                        product_services_types.numerical_indicator IN ('1','2', '3', '4')
                    )
                WHERE bills.id IN " . $billsId . "
                GROUP BY bills.id, services.id
        ";
        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'AT' ] = count( $resultado );
        $this->createFile( $resultado, 'AT' );
    }

    // Genera el rip AD a partir de una consulta
    private function generateRipAD( $billsId ){
    
        $query = "
            (
                SELECT 
                    bills.bill_number as A,
                    habilitation_code.code as B,
                    study_types.numerical_indicator as C,
                    bill_details_items.quantity as D,
                    bill_details_items.value as E,
                    bill_details_items.quantity*bill_details_items.value as F
                FROM bill_details_items
                    INNER JOIN bill_details
                    ON
                        bill_details_items.bill_details_a_id = bill_details.id
                    INNER JOIN bills
                    ON
                        bill_details.bills_id = bills.id
                    INNER JOIN orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                    INNER JOIN orders
                    ON 
                        orders_bills.orders_id = orders.id
                    INNER JOIN habilitation_code
                    ON 
                        orders.centers_id = habilitation_code.centers_id
                    INNER JOIN studies
                    ON
                        bill_details_items.item_id = studies.id
                    INNER JOIN study_types_studies
                    ON
                        studies.id = study_types_studies.studies_id
                    INNER JOIN study_types
                    ON
                        study_types_studies.study_types_id = study_types.id
                WHERE
                    bill_details_items.item_types_id = 2
                    AND
                    bills.id IN ". $billsId ."
            )
            UNION ALL
            (
                SELECT 
                    bills.bill_number as A,
                    habilitation_code.code as B,
                    product_services_types.numerical_indicator as C,
                    bill_details_items.quantity as D,
                    bill_details_items.value as E,
                    bill_details_items.quantity*bill_details_items.value as F
                FROM bill_details_items
                    INNER JOIN bill_details
                    ON
                        bill_details_items.bill_details_a_id = bill_details.id
                    INNER JOIN bills
                    ON
                        bill_details.bills_id = bills.id
                    INNER JOIN orders_bills
                    ON
                        bills.id = orders_bills.bills_id
                    INNER JOIN orders
                    ON 
                        orders_bills.orders_id = orders.id
                    INNER JOIN habilitation_code
                    ON 
                        orders.centers_id = habilitation_code.centers_id
                    INNER JOIN services
                    ON
                        bill_details_items.item_id = services.id
                    INNER JOIN product_services_types_services
                    ON
                        services.id = product_services_types_services.services_id
                    INNER JOIN product_services_types
                    ON
                        product_services_types_services.product_services_types_id = product_services_types.id
                WHERE
                    bill_details_items.item_types_id = 1
                    AND
                    product_services_types.id >4
                    AND
                    bills.id IN ". $billsId ."
            )
                ORDER BY A

        ";

        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'AD' ] = count( $resultado );
        $this->createFile( $resultado, 'AD' );

    }
    
    // Genera el rip AM a partir de una consulta
    private function generateRipAM( $billsId ){
        $query = '
            SELECT
                bills.bill_number as A,
                habilitation_code.code as B,
                document_types.initials as C,
                people.identification as D,
                orders.validator as E,
                services.cup as F,
                IF( services.is_pos = TRUE,
                        "1",
                    "2") as G,
                services.name as H,
                "" as I,
                "" as J,
                "" as K,
                bill_details_items.quantity as L,
                bill_details_items.value as M,
                bill_details_items.quantity*bill_details_items.value as N
            FROM
                bill_details_items
                INNER JOIN bill_details
                ON
                    bill_details_items.bill_details_a_id = bill_details.id
                INNER JOIN bills
                ON
                    bill_details.bills_id = bills.id
                INNER JOIN orders_bills
                ON
                    bills.id = orders_bills.bills_id
                INNER JOIN orders
                ON 
                    orders_bills.orders_id = orders.id
                INNER JOIN habilitation_code
                ON
                    orders.centers_id = habilitation_code.centers_id
                INNER JOIN patients
                ON
                    orders.patients_id = patients.id
                INNER JOIN people
                ON
                    patients.people_id = people.id
                INNER JOIN document_types
                ON
                    people.document_types_id = document_types.id
                INNER JOIN services
                    ON 
                    bill_details_items.item_id = services.id/*
                INNER JOIN services_has_products
                    ON 
                        services.id = services_has_products.services_id
                INNER JOIN products
                    ON
                        services_has_products.products_id = products.id
                INNER JOIN farmaseutic_form
                    ON
                        products.farmaseutic_form_id = farmaseutic_form.id*/
            WHERE 
                bill_details_items.item_types_id = 1
                AND 
                bills.id IN ' . $billsId . '
        ';

        $resultado = $this->executeQuery( $query  );
        $this->lines[ 'AM' ] = count( $resultado );
        $this->createFile( $resultado, 'AM' );

    }

    // Genera el rip CT a partir de los demas archivos
    private function generateRipCT( $billsId, $consecutivo ){

        // Obtiene el codigo de la ips
        $query = "SELECT habilitation_code.code FROM habilitation_code LIMIT 1";
        $resultado = $this->executeQuery( $query  );
        $code = $resultado[ 0 ][ 'code' ];

        // Obtiene los rips
        $files = scandir( WWW_ROOT  . 'rips' );


        // renombra los archivos de rips para que correspondan con el archivo de control
        $i = 0;
        foreach( $files as $file ){
            
            if( $file != "." && $file != ".." && $file != ".DS_Store" ){
                
                rename( WWW_ROOT . "rips" . DS . $file, WWW_ROOT . "rips" . DS . $file . "_000" . $consecutivo. ".txt" );
                
                $ripCT[$i][] = $code;
                $ripCT[$i][] = date('Ymd');
                $ripCT[$i][] = $file . "_000" . $consecutivo. ".txt";
                // Obtiene el numero de resultados para cada archivo
                $ripCT[$i][] = $this->lines[ $file ];
                
                $i++;
            
            }
        }
        

        $this->createFile( $ripCT, "CT.txt" );

    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2016-12-15 17:10:05
      Tipo de dato de retorno:  array
      Descripción: Ejecuta una consulta pasada en string y retorna un array con las filas que encontro, 
    */
    private function executeQuery( $query ){
        
        $connection = ConnectionManager::get('default');
        $results = $connection->execute( $query )->fetchAll('assoc');
        return $results;
    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2016-12-15 17:13:08
      Tipo de dato de retorno:  void
      Descripción: genera un archivo separado por comas con extension TXT en la carpeta back_end/rips con el nombre indicado
    */
    private function createFile( $data, $name){
        $filePath = WWW_ROOT . 'rips' . DS . $name;
        $line='';
        foreach( $data as $fila ){
            
            $llaves = array_keys( $fila );
            
            for( $i =0; $i< count(  $llaves); $i++ ){

                $line.= $fila[ $llaves[ $i ] ] . ',';

                if( $i == count( $llaves )-1 ){
                    $line.= PHP_EOL;
                }
            }


        }

        $handle = fopen($filePath, 'w') or die('Cannot open file:  '.$filePath);
        fwrite($handle, $line);
        fclose($handle);   
    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2016-12-22 12:05:24
      Tipo de dato de retorno:  void
      Descripción: borra todos los archivos que estan en la carpeta de rips ( se usa para borrar los rips viejos )
    */
    private function deleteLastRips(){
       
       $archivos = scandir( WWW_ROOT . 'rips' );

       foreach( $archivos as $archivo ){

           if( $archivo != '.' && $archivo != '..' ){

               unlink( WWW_ROOT . 'rips' . DS . $archivo );

           }
            
       }

    }


}