<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Core\App;

use Cake\ORM\TableRegistry;

use Cake\Datasource\ConnectionManager;
//
require_once(ROOT . DS . 'vendor' . DS . "tecnick.com" . DS . "tcpdf" . DS . "tcpdf.php");
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'RegimesController.php');
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'BillResolutionsController.php');
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'PeopleController.php');
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'AccountController.php');
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'BillDetailsController.php');



/**
 * Bills Controller
 *
 * @property \App\Model\Table\BillsTable $Bills
 */

class BillsController extends AppController
{


    public function initialize() 
    {
        parent::initialize();

        $this->Auth->allow(['prevBill','downloadPrev','getBillNumer','getBillsByDate','cancelBill','ver','getBillDetails', 'generateBillDetailReport']);


        $this->loadComponent('StringUtils');
    }



    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Orders', 'BillResolutions.BillDetailsItems']
        ];
        $bills = $this->paginate($this->Bills);

        $this->set(compact('bills'));
        $this->set('_serialize', ['bills']);
    }
   
    /**
     * Obtiene todas facturas activas de una Orden. 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-23
     * @datetime 2016-12-23T15:33:09-0500
     * @return   [type]                   [description]
     */
    public function getBillByOrder(){

            $order = $this->request->data['id'];
            $bill = $this->Bills->find('all',
                ['contain'=>['BillDetails','Payments'],
                'field'=>['id','bill_number'],
                'conditions'=>
                    ['Bills.canceled' => 0,
                     'Bills.id IN (select bills_id from orders_bills where orders_id ='.$order.')']
                ]);
            if($bill){
                $bills = $bill->toArray();
                $success = true;
                $this->set(compact('success','bills'));
            }
            else{
                $success = false;
                $error = $bills->errors();
                $this->set(compact('success','errors'));
            }
        }

        public function ver(){

            $this->autoRender = false;

            echo $this->StringUtils->getInitials("Julian asd andres muñoz Cardozo");

        }
    /**
     * View method
     *
     * @param string|null $id Bill id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $bill = $this->Bills->get($id, [
            'contain' => ['Orders', 'BillResolutions']
            ]);

        $this->set('bill', $bill);
        $this->set('_serialize', ['bill']);
    }

    /**
     * Anular una FActura
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:00:25-0500
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function cancelBill($id){

        //$id = $this->request->data['id'];

        $editBill = $this->Bills->get($id);

        $editBill['canceled'] = 1;

        $editBill = $this->Bills->patchEntity($editBill, $editBill);

        if ($this->Bills->save($editBill)) {

            $success = true;

            return $success;

         //  $this->set(compact('success','editBill'));
        } else {

            $errors = $editBill->errors();

            return $errors;

       //     $this->set(compact('success','errors'));

        }

    }
    

    /**
     * Nota de Venta 
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-07
     * @datetime 2016-12-07T16:00:43-0500
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
     public function saleNoteBills($id){

        //$id = $this->request->data['id'];

        $editBill = $this->Bills->get($id);

        $editBill['canceled'] = 2;

        $editBill = $this->Bills->patchEntity($editBill, $editBill);

        if ($this->Bills->save($editBill)) {

            $success = true;

            return $success;

         //  $this->set(compact('success','editBill'));
        } else {

            $errors = $editBill->errors();

            return $errors;

       //     $this->set(compact('success','errors'));

        }

    }




    /**
     * Funcion que genera un numero de facturación
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T08:21:23-0500
     * @param    [type]                   $billTypeId   [description]
     * @param    [type]                   $setNewNumber [description]
     * @return   [type]                                 [description]
     */
    public function getBillNumer($billTypeId,$center, $setNewNumber = false){

        $this->loadModel('BillResolutions');


        $resolution = $this->BillResolutions->find('all', ['order'=>['BillResolutions.id DESC'], 'conditions'=>['BillResolutions.bill_types_id' => $billTypeId, 
           'BillResolutions.center_id'=>$center]])->first();

        // se envia para actualizar codigo current.
        if($setNewNumber == true){

            $newNumber = $this->updateCurrentNumberResolution(
                $resolution['id'], 
                $resolution['current_number']);

            if($newNumber !== false){

                return Array('newNumber' => $resolution['prefix'].$newNumber, 
                   'id' => $resolution['id'],
                   'resolutionDetails'=>$resolution);

            }else{

                return false;    
            }

        }else{

            $currentNumber =  $resolution['current_number'];

            $currentNumber = intval($currentNumber) + 1;

            return Array( 'newNumber' => $resolution['prefix'].$currentNumber , 
              'id' => $resolution['id'], 
              'resolutionDetails'=>$resolution);


        }
        

    }

    /**
     * actualiza el numero de resolucion en bill resolution
     * @param  [type] $id              Bill resolution
     * @param  [type] $current_number  ultimo numero en facturacion
     * @return [type]                 [description]
     */
    public function updateCurrentNumberResolution($id, $current_number){

        $this->loadModel('BillResolutions');

        $BillResolutions = $this->BillResolutions->get($id, [
            'contain' => []
            ]);

        $BillResolutions = $this->BillResolutions->patchEntity($BillResolutions, ['current_number' => ($current_number + 1)]);

        if ($this->BillResolutions->save($BillResolutions)) {

            return  ($current_number + 1);

        } else {

            return false;
        }
    }

    /**
     * Si una orden tiene una factura
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T15:00:11-0500
     * @return   [type]                   [description]
     */
    public function orderHasBill(){


        $this->loadModel('Orders'); 

        $id = $this->request->data['orderId'];


        // $order = $this->Orders->get($id, [
        //     'contain' => ['Bills']
        //     ]);

        $order = $this->Bills->find('all',
            ['conditions'=>
            ['Bills.canceled' => 0,
            'Bills.id IN (select bills_id from orders_bills where orders_id ='.$id.')']
            ])->count();
        $this->set(compact('order')); 

    }

    public function getAllOrderBills(){
        $data = $this->reques->data;
        $bills = $this->Bills->find('all')->matching('OrdersBill',function($q) use ($data) {
            return $q->where(
                ['OrdersBill.bills_id'=>$data],
                ['OrdersBill.orders_id'=> 'OrdersBill.orders_id'])->toArray();
        });

        if($bills){
            $success = true;
            $this->set(compact('success','bills'));
        }else{
            $success = false;
            $this->set(compact('success'));
            }
    }


    /*
      Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S
      Fecha: 2017-01-03 10:59:49
      Tipo de dato de retorno: array
      Descripción: devuelve un array con las facturas que cumplen con el filtro del formulario
    */
    public function getBillsFiltered( $data ){
        $query = "
            SELECT 
            	bills.id as '0' 
            FROM 
            	bills
            INNER JOIN bill_resolutions
            ON	
            	bills.bill_resolutions_id = bill_resolutions.id
            INNER JOIN bill_types
            	ON 
                bill_resolutions.bill_types_id = bill_types.id
            INNER JOIN orders_bills
            	ON
                bills.id = orders_bills.bills_id
            INNER JOIN orders
            	ON
            	orders_bills.orders_id = orders.id
            WHERE 
                bill_types.id IN " . ($data['filter'] == 3 ? '(1)' :  ( $data[ 'filter' ] == 4? '(2)': '(1,2)' )  ) . "
                AND
                DATE( bills.created ) >= '". $data['dateIni'] ."'
                AND 
                DATE( bills.created ) <= '". $data['dateEnd'] ."'
                AND
                orders.centers_id = ". $data['center'] ."
        ";
        
        if( !empty( $data[ 'users_id' ] ) ){
            $query .= PHP_EOL."AND bills.users_id =".$data[ 'users_id' ];
        }


        $connection = ConnectionManager::get('default');
        $results = $connection->execute( $query )->fetchAll('assoc');


        if( is_array( $results ) ){
            $ids = [];
            foreach( $results as $id ){
                $ids[] = $id[0];
            }

            return $ids;
        }
        else{
            return [];
        }


    }

    /**
     * Obtiene Facturas Feneradas en un Periodo de tiempo.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-12-19
     * @datetime 2016-12-19T14:30:20-0500
     * @return   [type]                   [description]
     */
    public function getBillsByDate(){

        $data = $this->request->data;
        $dateIni = $data['dateIni'];
        $dateEnd = $data['dateEnd'];
        $center = $data['center'];


        $ids = $this->getBillsFiltered( $data );

        if( !empty( $ids ) ){

            $this->loadModel('Orders');

            $bills = $this->Bills->find('all',
                ['contain'=>
                ['Payments','Users.People'],
                'conditions'=>[
                'DATE(Bills.created) >=' => $dateIni,
                'DATE(Bills.created) <=' => $dateEnd, 
                'Bills.id IN '=>$ids
                //'Bills.bill_resolutions_id in (SELECT id from billResolutions where billResolutions.center_id = '.$center.')'
                ]])->order(['Bills.created' => 'DESC']);

            $bills = $bills->matching('Orders', 
                function ($q) use ($center) {
                    return $q->select(
                            ['order_consec','id'
                            ])->where(['Orders.centers_id' =>$center]);
                })->matching('Orders.Patients.People',
                function( $q ){
                    return $q->select(['identification','first_name','middle_name','last_name','last_name_two']);
                })->matching('Orders.Rates', 
                function( $q ){
                    return  $q->select(['name']);
                })->matching('Users.People', function($q){
                    return  $q->select(['usuario'=>['first_name','last_name']]);
                })->matching('Payments',function($q){
                    return $q->where(['Payments.payment_type_id'=>1]);
                })
                ->toArray(); 

                if($bills){
                    $success = true;
                    $this->set(compact('success','bills'));
                } else {
                    $success = false;
                    $this->set(compact('success','errors'));        

                }
        }
        else{

            $success = false;
            $bills   = [];
            $this->set( compact( 'success', 'bills' ) );

        }
    }

    /**
     * Guardado de nueva Factura
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T14:59:38-0500
     * @return   [type]                   [description]
     */
    public function saveBill(){

      // $this->autoRender = false;

        $toAccount;

        $success = true;

        $data = $this->request->data;

        $payment = $data['payment'];

        $order = $data['order'];

        $orderId = $order['id'];

        $center = $order['center'];

        $res = $this->editOrder($orderId, $order);

        /**
         * Guardado de las dos facturas, si el tipo de pago es 1: copago se generan imprimen 2 copias.
         */
        //var_dump('tipo de facturacion '. $payment['bill_types_id']);
        if($payment['bill_types_id'] == 1 ){
            /**
             * Si existe un copago se debe generar una facturacion adicional por valor del copago.
             */
          //  var_dump('Valor del Copago '. $order['copayment'] );

            if($order['copayment'] == 0){

                $numberCop = 2;

            }else{
                $numberCop = 1;
            }

        }else{
            /**
             * Si se factura por particular no se guarde un valor en copago.
             * @var integer
             */
            $numberCop = 2;
            $order['copayment'] = 0;
        }

        /**
         * genera la facturacion Correspondiente.
         * @var [type]
         */
        for ($i = $numberCop; $i <= 2 ; $i++) {
            // var_dump('Ingeso al ciclo en '. $i);


            $newBill = $this->Bills->newEntity();

            // $billData['orders_id'] = $orderId;

            // falta obtener la resolucion... 

            $billData['users_id'] = $this->Auth->user('id');
            /**
             * Obtiene el numero de RESOLLUCION PARA LA FACTURA.
             * @var [type]
             */
            if($payment['bill_types_id'] == 2){
                // Factura particular
                $resolutionAndNumber = $this->getBillNumer(2,$center,true);
            }else{

                if($i == 1){
                    // FActura del COPAGO 
                    $resolutionAndNumber = $this->getBillNumer(2,$center,true);
                }else{
                    //Factura del ENTIDAD
                    $resolutionAndNumber = $this->getBillNumer(1,$center,true);
                }
            }
            $billData['bill_number'] = $resolutionAndNumber['newNumber'];

            $billData['bill_resolutions_id'] = $resolutionAndNumber['id'];

            $billData['canceled'] = 0;

            $newBill = $this->Bills->patchEntity($newBill, $billData);

           /**
            * Guarda la Factura correspodiente.
            */
           if ($this->Bills->save($newBill)) {

                $this->loadModel('OrdersBills');

                $OrdersBill = $this->OrdersBills->newEntity();

                $OrdersBill = $this->OrdersBills->patchEntity($OrdersBill, [
                    'orders_id'     => $orderId, 
                    'bills_id'      => $newBill['id']
                    ]);
            /**
             * Asocia la factura con una orden.
             */
                if ($this->OrdersBills->save($OrdersBill)){
                    // var_dump('PAGO A INGRESAR -> '. $i);
                    // var_export($payment);
                    // 

                    $toAccount[$payment['bill_types_id']] = $OrdersBill;

                    $success = true;

                    $this->loadModel('Payments');

                    $payment = $data['payment'];

                    $payment['users_id'] = $this->Auth->user('id');
                    /**
                    * Se ingresan Valores factura credito;
                    * @var [type]
                    */
                    if($payment['bill_types_id'] == 1){
                        if($i == 2){
                            //VAOR PARA PAGO CREDITO
                        // var_dump('pago credito');
                        $payment['credit'] = $order['total'];
                        $payment['debit'] = 0;
                        $payment['discount'] =0;
                        $payment['donation'] = 0;
                        $payment['copayment'] = $order['copayment'];
                        }else{
                                // VALOR PAGO DEL COPAGO.
                            // var_dump('pago credito');
                            $payment['debit'] = $order['total_cancel'];
                            $payment['credit'] = 0;
                            $payment['discount'] = $order['discount'];
                            $payment['donation'] = $order['donation'];
                            $payment['copayment'] = 0;
                        }
                }else{
                    //  var_dump('pago PARTICULAR');
                    $payment['debit'] = $order['total_cancel'];
                    $payment['credit'] = 0;
                    $payment['discount'] = $order['discount'];
                    $payment['donation'] = $order['donation'];
                    $payment['copayment'] = 0;
                }
                $payment['bills_id'] = $newBill['id'];

                $payment['payment_type_id'] = 1;

                $newPayment = $this->Payments->newEntity();


                $newPayment = $this->Payments->patchEntity($newPayment, $payment);


                /**
                * Guarda el pago correspondiente.
                */
                if ($this->Payments->save($newPayment)) {

                //  var_dump('newPayment');

                    $success = true;

                    /**
                    * Contabilizar la Facuracion. 
                    * @var AccountController
                    */
                    $saveAccount = new AccountController(); 


                    if($payment['bill_types_id'] == 2){
                                    // Factura particular

                        $saveAccount->addFV($OrdersBill['id']); 
                    }else{

                        if($i == 1){
                                        // FActura del COPAGO 
                        $saveAccount->addFV($OrdersBill['id']); 
                        
                        }else{
                                        //Factura del ENTIDAD

                            $saveAccount->addFE($OrdersBill['id']); 

                        }
                    }






                    } else {
                            $error =  $newPayment->errors();
                            pr( $error );
                            $success = false;
                    }

                }else{
                    // var_dump('Error Guardando OrdersBill');
                    // var_dump($OrdersBill->errors());
                }


            }else {

                $errors = ' nueva factura '.$newBill->errors();
 
                $success = false;

                $this->set(compact('success','errors'));        

            }
        }

        $this->set(compact('success','toAccount'));


    }


    public function generateBillDetailReport(){

         $data = $this->request->data;
         var_dump( $data );
         exit();

     }


       // funcion encargada de la conversion de numeros a su equivalente en letras
public function numToLetras($xcifra)
{

    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 
        30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 
        600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
            //
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
            //$xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
                $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
                //$xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
            }

            $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
            $xcadena = "";
            for ($xz = 0; $xz < 3; $xz++) {
                $xaux = substr($XAUX, $xz * 6, 6);
                $xi = 0;
                $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
                $xexit = true; // bandera para controlar el ciclo del While
                while ($xexit) {
                    if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                        break; // termina el ciclo
                    }

                    $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                    $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                    for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                        switch ($xy) {
                            case 1: // checa las centenas
                                if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                                } else {
                                    $key = (int) substr($xaux, 0, 3);
                                    if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                        $xseek = $xarray[$key];
                                        $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                        if (substr($xaux, 0, 3) == 100)
                                            $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                        else
                                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                        $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                    }
                                    else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                        $key = (int) substr($xaux, 0, 1) * 100;
                                        $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 0, 3) < 100)
                                break;
                            case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {

                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                    } // ENDIF ($xseek)
                                } // ENDIF (substr($xaux, 1, 2) < 10)
                                break;
                            case 3: // checa las unidades
                                if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                                } else {
                                    $key = (int) substr($xaux, 2, 1);
                                    $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                    $xsub = $this->subfijo($xaux);
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                } // ENDIF (substr($xaux, 2, 1) < 1)
                                break;
                        } // END SWITCH
                    } // END FOR
                    $xi = $xi + 3;
                } // ENDDO

                if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

                if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

                // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
                if (trim($xaux) != "") {
                    switch ($xz) {
                        case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                        case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                        case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS M/CTE";
                                //$xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO M/CTE ";
                                //$xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                                $xcadena.= " PESOS M/CTE "; //
                                //$xcadena.= " PESOS $xdecimales/100 M.N. "; //
                            }
                            break;
                    } // endswitch ($xz)
                } // ENDIF (trim($xaux) != "")
                // ------------------      en este caso, para México se usa esta leyenda     ----------------
                $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
                $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
                $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
                $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
            } // ENDFOR ($xz)
            return trim($xcadena);
        }

        // END FUNCTION

        public function subfijo($xx)
        { // esta función regresa un subfijo para la cifra
            $xx = trim($xx);
            $xstrlen = strlen($xx);
            if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
                $xsub = "";
            //
            if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
                $xsub = "MIL";
            //
            return $xsub;
        }

    /**
     * Funcion que actualiza una orden
     *
     * @param string|null $id Order id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editOrder($orderId, $order)
    {

        $this->loadModel('Orders');

        $editOrder = $this->Orders->get($orderId);

        unset($order['center']);

        $editOrder = $this->Orders->patchEntity($editOrder, $order);

        if ($this->Orders->save($editOrder)) {

            $success = true;

            return true;

        } else {

            $errors = $editOrder->errors();

            return Array('state' => true, 'erros' => $errors);

        }

    }

    /**
     * Funcion para descargar un archivo.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-10-10
     * @datetime 2016-10-10T10:45:12-0500
     * @return   [type]                   [description]
     */
    public function downloadPrev($data = '', $name = '/files/PrevioPedido' ){
        $data = ( !empty($data) )? $data : rand(1000, 9999);
        $this->autoRender = false;

        $this->response->file(WWW_ROOT.'/files/'. $name .'.pdf', array('download' => true, 'name' => $name .'.pdf'));
    }

    
    /**
     * Función de previsualizacion de Factura
     * @author Julián Andrés Muñoz Cardozo <julianmc90@gmail.com>
     * @date     2016-09-13
     * @datetime 2016-09-13T09:06:15-0500
     * @return   [type]                   [description]
     */
    public function generateBill(){

        setlocale(LC_MONETARY, 'en_US');

        $data = $this->request->data;


        $affiliation_type = $data['affiliation_type'];

        $order = $data['order']; // Obtiene la Orden. 

        $sede = $order['center']; // Obtiene la sede

        $payment = $data['payment'];

        $billTypesId = $payment['bill_types_id']; // tipo de facturacion.. 1:Copago, 2:factura.

        $billNumber = $data['billNumber'];

        $clients = $data['clients']; // obtiene la informacion del cliente

        $services = $data['services']; // Obtiene los items a facturar

        $patient = $data['patient']; // Obtiene la informacion del paciente

        $costCenter = $data['costCenter']; // Obtiene el Centro de Costos.

        $plan = $data['plan']; // Obtiene la Tarifa

        $date = date("Y-m-d");

        //Obtiene y asigna el nombre del regimen depediendo del id
        $RegimesController = new RegimesController;
        $regimes = $RegimesController->view($data['regimes']);
        
        // Obtener Resolucion de Facturacion.. 

        $patientName = $patient['first_name'].' '.$patient['middle_name'].' '.$patient['last_name'].' '.$patient['last_name_two'];

        /**
         * Si es Copago, Entidad
         * @var [type]
         */
        if($billTypesId == 1){

         $clientsName = $clients['name'];
         $clientsNit =  $clients['nit'];
         $subtotal = money_format('%(#10n', $order['subtotal']);
         $copayment = money_format('%(#10n', $order['copayment']);
         $discountValue = money_format('%(#10n', 0);
         $donationValue = money_format('%(#10n', 0);
         $numerosLetras = $this->numToLetras($order['subtotal'] -  $order['copayment']);
         $total  =  money_format('%(#10n', ($order['subtotal'] -  $order['copayment'])); 

        }else{
            $clientsName = $patientName;
            $clientsNit =  $patient['identification'] ;
            $subtotal = money_format('%(#10n', $order['subtotal']);
            $copayment = money_format('%(#10n', $order['copayment'] );
            $discountValue = money_format('%(#10n', $order['discountValue']);
            $donationValue = money_format('%(#10n', $order['donationValue']); 
            $numerosLetras = $this->numToLetras($order['total_cancel']);
            $total  =money_format('%(#10n', $order['total_cancel']);
        }


    if($affiliation_type == 2){
        $name_cotizante = $patientName;
        $name_beneficiario ="";
        $document_cot = $patient['identification'];
        $document_beneficiario = "";
    }
    else{
        $name_cotizante = "";
        $name_beneficiario =$patientName;   
        $document_beneficiario = $patient['identification'];
        $document_cot = "";
    }


        //establecer los dias de vencimiento
        //obtenerlos y establecerlos
    $days_expired = 90;


    /* Bloque de codigo que obtiene la resolucion correcta para la factura(verifica que este vigente) */
        // Carlos Felipe Aguirre
    $BillResolutionsController = new BillResolutionsController();
    $bill_resolution = $BillResolutionsController->getResolutionBill($order['centers_id'], $billTypesId);
    /*Ya obtuvo la resolucion*/


        /*
        Obtiene el nombre del usuario logueado
        Carlos Felipe Aguirre
        2016-10-07
         */
        
        $PeopleController = new PeopleController();
        $persona = $PeopleController->view($this->Auth->user('people_id'));
        $_nombrePersona= $persona['first_name'] . ' ' . $persona['middle_name'] . ' ' . $persona['last_name'] . ' ' . $persona['last_name_two'];
        $_nombrePersona = $this->StringUtils->getInitials($_nombrePersona);
        /*ya se ha obtenido el nombre*/



        // Instanciacion
        $tcpdf = new XTCPDF(); 

        $tcpdf->setIsBillPrev($data['isPrev']);

            // Info del documento
        $tcpdf->SetAuthor("Gatoloco Studios S.A.S."); 

            // Informacion del ecabezado y footer





        $tcpdf->xheadertext = '

        <table border="0" align="center" cellspacing="0" style="width: 95%">
            <tr>
                <td>
                   <table border="0" cellspacing="0" style="width: 100%">
                    <tr style="font-size:80%">
                        <td align="center" style="width: 50%"><img src="img/logo_londono.png"></td>
                        <td align="center" valign="middle" style="width: 25%">
                            <h6>PERSONA JURIDICA 0158 DE JUNIO 6 DE 1991<br> 
                                NIT. 800.135.582-7 <br>
                                ARMENIA-QUINDIO </h6></td>
                                <td align="center" style="width: 25%; HEIGHT:10px;"><h6 bgcolor="#bff2ff" >Original</h6>

                                    <table border="0" style="width: 100% " cellspacing="2">
                                        <tr style="line-height:3px" >
                                            <td style="" colspan="2" align="center">
                                                <h5>Factura de venta No.</h5>
                                            </td>
                                        </tr>
                                        <tr style="line-height:7px" bgcolor="#bff2ff">
                                            <td style="margin-bottom:3px" colspan="2" align="center" valign="middle" >
                                                <h5>'.$billNumber.'</h5>
                                            </td>
                                        </tr>
                                        <tr style="line-height:3px" >
                                            <td align="left" >
                                                <br><h6>FECHA FACTURA</h6>
                                            </td>
                                            <td align="right" ><br><h6>'.$date.'</h6></td>
                                        </tr>
                                        <tr style="line-height:3px"> 
                                            <td align="left" >
                                                <br><h6>FECHA VENCIMIENTO</h6>
                                            </td>
                                            <td align="right"><br><h6>'.date('Y-m-d', strtotime($date.' +'. $days_expired .' days')).'</h6></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0">
                            <tr>

                                <td style="font-size:80%; width: 50%;" align="left"><h6>'.$bill_resolution.'</h6></td>
                                <td style="font-size:80%; width: 25%;" align="left"><h6>NÚMERO DE AUTORIZACIÓN:  '.$order['validator'].'</h6></td>
                                <td style="font-size:80%; width: 12%;" align="left"><h6> CREDITO</h6></td>
                                <td style="font-size:80%; width: 13%;" align="right"><h6>'.$days_expired.' DIAS</h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0">
                            <tr style="HEIGHT:10px;">
                                <td style="HEIGHT:10px; width: 50%; font-size:80%" bgcolor="#bff2ff" align="left"><h6>CLIENTE: &nbsp;'.$clientsName .' </h6></td>
                                <td style="HEIGHT:10px; width: 30%; font-size:80%" bgcolor="#bff2ff" align="left"><h6>PLAN:&nbsp;'.$plan['name'] .' </h6></td>
                                <td style="HEIGHT:10px; width: 20%; font-size:80%" bgcolor="#bff2ff" align="left"><h6>NIT: '.$clientsNit .' </h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0" style="padding:0px">
                            <tr style="">
                                <td style="text-align:center; font-size:50%; HEIGHT:10px;"> 
                                    <strong>EL COMPRADOR PAGARÁ A LA ORDEN DE LA VENDEDORA EL VALOR TOTAL DE ESTA FACTURA. ESTA FACTURA ES UN TÍTULO VALOR LEY 1231 DEL 17 - 07 - 2008.</strong>
                                </td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0">
                            <tr style="font-size:80%; ">
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff; width: 34%" ><h6>AFILIADO:&nbsp;'.$name_cotizante.' </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff; width: 33%" ><h6>CÉDULA No :&nbsp;'.$document_cot .' </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff; width: 33%" colspan="2"><h6>SEDE:&nbsp;'.$sede['name'].' </h6></td>
                            </tr>
                            <tr style="font-size:80%; ">
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>BENEFICIARIO:&nbsp;'.$name_beneficiario.' </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>CÉDULA No :&nbsp;'.$document_beneficiario .'  </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>SEXO:&nbsp;'.$patient['gender'].' </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>EDAD:&nbsp;'.$order['calculated_age'].' </h6></td>
                            </tr>
                            <tr style="font-size:80%; ">
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>DIRECCION:&nbsp;'.$patient['address'].'</h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>TELEFONO:&nbsp;'.$patient['phone'] .' </h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff" colspan="2"><h6>CIUDAD:&nbsp; '. $data['city']['municipality'] .'  </h6></td>
                            </tr>
                            <tr style="font-size:80%; ">
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>CENTRO DE COSTOS:&nbsp;'.$costCenter['name'].'</h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff"><h6>ADMISIONES O RIPS:&nbsp;'.$order['order_consec'].'</h6></td>
                                <td style="HEIGHT:10px; text-align: left; background-color:#bff2ff" colspan="2"><h6>RÉGIMEN:&nbsp; '. strtoupper($regimes['regime']) .' </h6></td>
                            </tr>
                        </table>

                        <table  border="0" cellspacing="0">
                            <tr style="font-size:20%">
                                <td align="center"></td>
                            </tr>
                        </table>

                        <table  border="0" cellspacing="0">
                            <tr style="font-size:90%; HEIGHT:10px;">
                                <td style="HEIGHT:10px; width: 6%;" bgcolor="#bff2ff" align="center"><h6>Item</h6></td>
                                <td style="HEIGHT:10px; width: 8%;" bgcolor="#bff2ff" align="center"><h6>Código</h6></td>
                                <td style="HEIGHT:10px; width: 58%;" bgcolor="#bff2ff" align="center"><h6>Descripción</h6></td>
                                <td style="HEIGHT:10px; width: 8%;" bgcolor="#bff2ff" align="center"><h6>Cantidad</h6></td>
                                <td style="HEIGHT:10px; width: 10%;" bgcolor="#bff2ff" align="center"><h6>Valor</h6></td>
                                <td style="HEIGHT:10px; width: 10%;" bgcolor="#bff2ff" align="center"><h6>Total</h6></td>
                            </tr>
                        </table>


                    </td>
                </tr>
            </table>

            ';


            // $tcpdf->variable = $opcion; // Set de la variable de validación de previsualización 
            $tcpdf->xfootertext = ' 

            <table border="0" align="center" cellspacing="0" style="width: 95%">
                <tr>
                    <td>
                        <table  border="0" cellspacing="1">
                            <tr style="font-size:80%; line-height:7px">
                                <td style="width:72%; line-height:7px" rowspan="4" align="left" bgcolor="#bff2ff"><h6>SON: VALOR EN LETRAS :<br><br>'.$numerosLetras.'</h6></td>
                                <td style="width:3%" align="left"><h6></h6></td>
                                <td style="width:15%" align="left"><h6>TOTAL SERVICIOS</h6></td>
                                <td style="width:10%"  align="right"><h6>'.$subtotal.'</h6></td>
                            </tr>
                            <tr style="font-size:80%; line-height:7px">
                                <td style="width:3%" bgcolor="#bff2ff" rowspan="3"></td>
                                <td style="width:15%" align="left"><h6>DESCUENTOS</h6></td>
                                <td  align="right"><h6>'.$discountValue.'</h6></td>
                            </tr>
                            <tr style="font-size:80%; line-height:7px">
                                <td align="left"><h6>DONACIONES</h6></td>
                                <td  align="right"><h6>'.$donationValue.'</h6></td>
                            </tr>
                            <tr style="font-size:80%; line-height:7px">
                                <td align="left"><h6>COPAGO/CUOTA MOD. </h6></td>
                                <td  align="right"><h6>'.$copayment.'</h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="1">
                            <tr style="font-size:80%; HEIGHT:10px; line-height:7px">
                                <td style="width:72%" align="left"><h6>EXCENTOS DE RETEFUENTE &quot;ENTIDAD SIN ANIMO DE LUCRO&quot; E.T. Arts. 23 y 369 D.R. 841/98 Art. 6o. </h6></td>
                                <td style="width:3%" bgcolor="#bff2ff">&nbsp;</td>
                                <td style="width:15%" bgcolor="#bff2ff" align="left"><h6>TOTAL A PAGAR </h6></td>
                                <td style="width:10%"  align="right"><h6>'.$total.'</h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="1">
                            <tr style="font-size:74%; HEIGHT:10px;">
                                <td align="justify"><h6>EN CASO DE MORA SE CAUSARAN INTERESES COMERCIALES SIN PERJUICIO DE LAS ACCIONES LEGALES DEL ACREEDOR SE HACE CONSTAR QUE LA FIRMA DE UNA PERSONA DISTINTA DEL COMPRADOR IMPLICA QUE DICHA ESTE AUTORIZADA EXPRESAMENTE POR EL COMPRADOR PARA FIRMAR, CONFESAR LA CEDULA Y OBLIGAR AL COMPRADOR. FAVOR PAGAR INMEDIATAMENTE CHEQUE CRUZADO A PARTIR BENEFICIARIO. </h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0">
                            <tr style="font-size:80%;">
                                <td bgcolor="#bff2ff" style="width:39%"><h6>Elaborado por:</h6><br/><span style="font-size=10px !important">'.
                                    $_nombrePersona.'</span><h6><br/>Fecha y Hora de Elaboración: '.date('Y-m-d H:i:s').'</h6>
                                </td>
                                <td style="width:2%"><h6></h6></td>
                                <td align="justify" bgcolor="#bff2ff" style="width:59%"><h6>RECIBI A SATISFACCION LA ENTREGA REAL Y MATERIAL DE LOS SERVICIOS Y MERCANCIAS DE QUE TRATA ESTA FACTURA Y ACEPTO EL VALOR ESTIPULADO DE LA MISMA <br></h6>
                                    <h6>___________________________________________________
                                        <br>FIRMA, SELLO Y C.C</h6></td>
                            </tr>
                        </table>

                        <table border="0" cellspacing="0">
                            <tr style="font-size:80%; HEIGHT:10px;">
                                <td align="center" valign="middle"><h6> Sede Norte: Carrera 15 # 1Norte - 49 Armenia, Quindío 
                                   Sede Sur: Carrera 18 # 43 - 70 Esquina. PBX: (6) 745 55 66. Armenia, Quindío
                                   <br>www.fundacionalejandrolondono.com - info@fundacionalejandrolondono.com</h6>
                               </td>
                           </tr>
                       </table>
                    </td>
                </tr>
            </table>
                   ';


            // Fuentes del doc
            $textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 
            //$tcpdf->SetFont('Verdana', '', 10);
            // Margenes 
            // $tcpdf->SetMargins(10, 63, 3, false);

            /**
             * inicio de contenido
             */
            //$tcpdf->SetMargins(10, 100, 3, false);
            $tcpdf->SetMargins(10, 58, 3, false);


            $tcpdf->SetHeaderMargin(10);
            $tcpdf->SetFooterMargin(40);
            
            // Cambio de pagina
            //$tcpdf->SetAutoPageBreak(true, 50); 
            $tcpdf->SetAutoPageBreak(true, 0); 
            
            //$tcpdf->setHeaderFont(array($textfont,'',40)); 
            //$tcpdf->xheadercolor = array(150,0,0); 

            // Validacion para la aparicion tanto del header como del footer
            $tcpdf->SetPrintHeader(true);
            $tcpdf->SetPrintFooter(true);

            // Adicion de nueva pagina con tamaño predefinido en mm
            $resolution= array(216, 139); // Tamaño Media Página
            //$resolution= array(216, 279); // Tamaño Carta
            $tcpdf->AddPage('L', $resolution);
            
            setlocale(LC_MONETARY, 'en_US');
            
            

            //$tcpdf->SetFont('freesans', '', 12);


            $html = '';

        // Contenido del pdf
        /*$html .= '
            <table style="padding: 2px; width: 95%">';
        
        //Ciclo Asignar los datos rergistrados para facturacion
        for ($j = 0; $j < count($services); $j++)
        {
            $html = $html.'
                <tr style="font-size: 60%">
                    <td style="width: 10%; text-align: center;">
                        <br>'.$services[$j]['index'].'
                    </td>
                    <td style="width: 10%; text-align: center;">
                        <br>'.$services[$j]['ref'].'
                    </td>
                    <td style="width: 50%; text-align: justify;">
                        <br>' . $services[$j]['desc'] . '
                    </td>
                    <td style="width: 10%; text-align: center;"> 
                        <br>' . $services[$j]['cant'] . ' 
                    </td>
                    <td style="width: 10%; text-align: right;">
                        <br>' . money_format('%(#10n', $services[$j]['valor']) . '  
                    </td>
                    <td style="width: 10%; text-align: right;">
                        <br>' . money_format('%(#10n', $services[$j]['cost'] ) . '  
                    </td>
                </tr>
            ';
        }    

        // Contenido del pdf
        $html .= '
            </table>';
            */

            $items="";
            $html .= '
            <table border="0"  cellspacing="0" style="width: 95%">
                <tr>
                    <td>
                        <table  border="0" cellspacing="0" style="width: 100%">';
                            
                            //Ciclo Asignar los datos rergistrados para facturacion
                            for ($j = 0; $j < count($services); $j++)
                            {
                                $html .=  '
                            <tr style="line-height:20px; ">
                                <td style="font-size:50%; width: 6%; " align="center">
                                    <br>'.$services[$j]['index'].'
                                </td>
                                <td style="font-size:50%; width: 8%; " align="center">
                                    <br>'.$services[$j]['ref'].'
                                </td>
                                <td style="font-size:50%; width: 58%; word-wrap:break-word; ">
                                    <br>' . $services[$j]['desc'] . '
                                </td>
                                <td style="font-size:50%; width: 8%; " align="center">
                                    <br>' . $services[$j]['cant'] . ' 
                                </td>
                                <td style="font-size:50%; width: 10%; " align="right">
                                    <br>' . money_format('%(#10n', $services[$j]['valor']) . '  
                                </td>
                                <td style="font-size:50%; width: 10%; " align="right">
                                    <br>' . money_format('%(#10n', $services[$j]['cost'] ) . '  
                                </td>
                            </tr>
                                ';

                                if( $data['first'] ){
                                    $items[$j]['item_id'] = $services[$j]['id'];
                                    $items[$j]['value'] = $services[$j]['valor'];
                                    $items[$j]['quantity'] = $services[$j]['cant'];
                                    $items[$j]['item_types_id'] = ( $services[$j]['isService'] ? '1' : '2');
                                    $items[$j]['created']  = date( 'Y-m-d H:i:s' ); 
                                }


                            }    

                            $html = $html.' 
                        </table>
                    </td>
                </tr>
            </table>
            ';

             if($data['first']){

                 $billDetail[ 'people_full_name' ] = (!empty( $name_cotizante) ? $name_cotizante : $name_beneficiario) ;
                 $billDetail[ 'people_identification' ] = ( !empty( $document_cot ) ? $document_cot : $document_beneficiario );
                 
                 $billDetail['bills_id'] = $data[ 'billId' ] ;
                 $billDetail['items'] = $items;
                 $billDetail[ 'bill_resolutions' ] = $bill_resolution ;
                 $billDetail[ 'people_address' ] = $patient['address'] ;
                 $billDetail[ 'client_name' ] = $clientsName;
                 $billDetail[ 'rate_name' ] = $plan['name'];
                 $billDetail[ 'bill_created' ] = $date;
                 $billDetail[ 'bill_expiration' ] = date('Y-m-d', strtotime($date.' +'. $days_expired .' days'));
                 $billDetail[ 'order_center' ] = $sede['name'];
                 $billDetail[ 'order_cost_center' ] = $costCenter['name'];
                 $billDetail[ 'order_consec' ] = $order['order_consec'];
                 $billDetail[ 'regimes_name' ] = strtoupper($regimes['regime']);
                 $billDetail[ 'people_age' ] = $order['calculated_age'];
                 $billDetail[ 'order_validator' ] = $order['validator'];
                 $billDetail[ 'client_nit' ] = $clientsNit;
                 $billDetail[ 'people_phone' ] = $patient['phone'];
                 $billDetail[ 'city' ]         = $data['city']['municipality'];

                 $billDetails = new BillDetailsController();
                 $billDetails->add( $billDetail );

             }




            // // Get the page width/height
            // $myPageWidth = $tcpdf->getPageWidth();
            // $myPageHeight = $tcpdf->getPageHeight();

            // // Find the middle of the page and adjust.
            // $myX = ( $myPageWidth / 2 ) - 75;
            // $myY = ( $myPageHeight / 2 ) + 25;

            // // Set the transparency of the text to really light
            // $tcpdf->SetAlpha(0.09);

            // // Rotate 45 degrees and write the watermarking text
            // $tcpdf->StartTransform();
            // $tcpdf->Rotate(45, $myX, $myY);
            // $tcpdf->SetFont("courier", "", 45);
            // $tcpdf->Text($myX, $myY,"Prueba Factura");
            // $tcpdf->StopTransform();

            // // Reset the transparency to default
            // $tcpdf->SetAlpha(1);





        // output the HTML content
            $tcpdf->writeHTML($html, true, false, true, false, '');

            



        // output the HTML content
        //$tcpdf->writeHTML($html, true, false, true, false, '');
        // if ($opcion == 1)
        // {

            $tcpdf->Output(WWW_ROOT.'files/' . $order['order_consec'] . '_' . $billNumber . '_' . $date .'.pdf', 'F');
            $success = true;
            $message = $order['order_consec'] . '_' . $billNumber . '_' . $date;
            $this->set(compact('success', 'message', 'order'));

            
            // $this->response->file(WWW_ROOT.'/files/PrevioPedido.pdf', array('download' => true, 'name' => 'PrevioPedido.pdf'));

        // }
        // else
        // {
        //     echo 'pase';
        //     $tcpdf->Output(WWW_ROOT.'/files/Pedido_'.$this->Session->read('User.userId').'.pdf', 'F');
        // }

        }
    }

    class XTCPDF extends \TCPDF
    {
        var $xfooterfont  = PDF_FONT_NAME_MAIN ;
        //var $xfooterfontsize = 8 ;

        public $isBillPrev = true;


        public function setIsBillPrev($is) {

            $this->isBillPrev = $is;

        }

        function Header(){

           setlocale(LC_MONETARY, 'en_US');

            //list($r, $b, $g) = $this->xheadercolor;
           $this->setY(10);
            //$this->SetFillColor($r, $b, $g);
            //$this->SetTextColor(0 , 0, 0);
            //$this->Cell(0,20, '', 0,1,'C', 1);
            //$this->Text(15,26,$this->xheadertext );


           $this->writeHTML($this->xheadertext, true, false, true, false, '');

            // Transformacion para la rotacion de el numero de orden y el contenedor de la muestra
            $this->StartTransform();
            $this->SetFont('freesans', '', 5);
            $this->Rotate(-90, 19, 23);
            //$tcpdf->Rect(39, 50, 40, 10, 'D');
            $this->Text(5, 30, 'Factura Impresa por Computador.');
            // Stop Transformation
            $this->StopTransform();


           // para poner marca de agua cuando es prev  Deicy R  
            //  if ($this->isBillPrev == true ){

            if(true){

                // marca de agua: borrador
                // draw jpeg image                         x,  y  ancho, alto
            // $this->Image(WWW_ROOT.'/img/BORRADOR.png', 20, 60, 175, 40, '', '', '', true, 72);


                // restore full opacity
             $this->SetAlpha(0);
         }
     }






     function Footer(){

        setlocale(LC_MONETARY, 'en_US');
            //$year = date('Y');
            //$footertext = sprintf($this->xfootertext, '');
        $this->SetY(-40);
            //$this->SetTextColor(0, 0, 0);
            //$this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
        $this->writeHTML($this->xfootertext, true, false, true, false, '');
            //$this->Cell(0,8, $footertext,'T',3,'L');
    }
}
