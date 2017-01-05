<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

require_once(ROOT . DS . 'vendor' . DS . "tecnick.com" . DS . "tcpdf" . DS . "tcpdf.php");

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Users', 'Orders', 'FormPayments', 'BillTypes']
        ];
        $payments = $this->paginate($this->Payments);

        $this->set(compact('payments'));
        $this->set('_serialize', ['payments']);
    }


    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['getPaymentBillCash', 'sumAllCopyment', 'getCopaymentCash', 'getCopaymentCards', 
            'getCopaymentCreditCard' , 'getCopaymentCheck', 'getCopaymentBond','getCopaymentConsignment',
            'getPaymentBillCash', 'getPaymentBillCards', 'getPaymentBillCheck',
            'getPaymentBillBond','getPaymentBillConsignment', 'totalBills', 'totalOnlyCash', 'totalOnlyCards',
            'totalOnlyChecks', 'totalOnlyBonds', 'totalOnlyConsignment', 'allTotal', 'prePayments','downloadPrev',
            'getPermission'
            ]);

    }


    /**
     * Permissions
     */
    
    public function getPermission()
    {
        if($permissions){

            $success = true;

            $this->set(compact('success', 'permissions'));

        }else{

            $success = false;

            $errors = $permissions->errors();

            $this->set(compact('success', 'errors'));

        }
    }
    /**
     * Obtiene todas las ventas por cliente.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2017-01-03
     * @datetime 2017-01-03T13:52:49-0500
     * @return   [type]                   [description]
     */
    public function getSalesByClient(){

        $connection = ConnectionManager::get('default');

        $data = $this->request->data;


        $sales =   $connection->execute("
            SELECT 
            clients.nit AS Nit,
            clients.name AS Nombre_Razon_Social,
            SUM(payments.debit) AS debit,
            SUM(payments.credit) AS credit,
            SUM(payments.donation) AS donations,
            SUM(payments.discount) AS discount,
            SUM(payments.debit + payments.credit + payments.donation + payments.discount) AS total
            FROM
            bills
            INNER JOIN
            payments ON payments.bills_id = bills.id
            INNER JOIN
            orders_bills ON orders_bills.bills_id = bills.id
            INNER JOIN
            orders ON orders.id = orders_bills.orders_id
            INNER JOIN
            clients ON clients.id = orders.clients_id
            INNER JOIN
            rates ON rates.id = orders.rates_id
            INNER JOIN
            centers ON centers.id = orders.centers_id
            WHERE
            DATE(bills.created) >= '".$data['dateIni']."'
            AND DATE(bills.created) <= '".$data['dateEnd']."'
            and orders.centers_id = '".$data['center']."'
            and bills.canceled = 0
            GROUP BY clients.id
            ORDER BY total DESC
            ")->fetchAll('assoc');


        $totales =   $connection->execute("
            SELECT
            'TOTAL' AS Nit,
            '' AS Nombre_Razon_Social,
            SUM(payments.debit) AS debit,
            SUM(payments.credit) AS credit,
            SUM(payments.donation) AS donations,
            SUM(payments.discount) AS discount,
            SUM(payments.debit + payments.credit + payments.donation + payments.discount) AS total
            FROM
            bills
            INNER JOIN
            payments ON payments.bills_id = bills.id
            INNER JOIN
            orders_bills ON orders_bills.bills_id = bills.id
            INNER JOIN
            orders ON orders.id = orders_bills.orders_id
            INNER JOIN
            clients ON clients.id = orders.clients_id
            INNER JOIN
            rates ON rates.id = orders.rates_id
            INNER JOIN
            centers ON centers.id = orders.centers_id
            WHERE
            DATE(bills.created) >= '".$data['dateIni']."'
            AND DATE(bills.created) <= '".$data['dateEnd']."'
            and orders.centers_id = '".$data['center']."'
            and bills.canceled = 0
            ")->fetchAll('assoc');


        if($sales){
         $success = true;

         $this->set(compact('success', 'sales','totales'));
     }else{

        $success = false;

        $errors = (is_array( $sales) ? [] : $sales->errors());

        $this->set(compact('success', 'errors'));

    }



}


    /**
     * All Funtions For Copayment
     */
    
    /**
     * [sumAllCopyment description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T17:25:37-0500
     * @return   [type] [Todos los cobros de la fecha selecionados para la forma copago]
     */
    public function sumAllCopyment()
    {
     $connection = ConnectionManager::get('default');

     $data = $this->request->data;

     $date = $data['date'];

     $id = $data['id'];

     $sumCopyment = $connection->execute("SELECT SUM(debit) as todo 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date'
        AND payments.users_id = '$id' 
        AND payments.bill_types_id = 1
        ")->fetchAll('assoc');

     if($sumCopyment)
     {
        $success = true;

        $this->set(compact('success', 'sumCopyment'));
    }else{

        $success = false;

        $errors = $sumCopyment->errors();

        $this->set(compact('success', 'errors'));

    }
}

    /**
     * [getCopaymentCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T15:03:31-0500
     * @return   [type]  [Suma los valores de copaogo que pertecen a efectivo]
     */
    public function getCopaymentCash()
    {
       $connection = ConnectionManager::get('default');

       $data = $this->request->data;

       $date = $data['date'];

       $id = $data['id']; 


       $query = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where 
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date'
        AND payments.users_id = '$id' 
        AND payments.bill_types_id = 1 
        AND payments.form_payments_id = 1;
        ")->fetchAll('assoc');


       if($query)
       {
        $success = true;

        $this->set(compact('success', 'query'));
    }else{

        $success = false;

        $errors = $query->errors();

        $this->set(compact('success', 'errors'));

    }
}

     /**
     * [getCopaymentCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T15:03:31-0500
     * @return   [type]                   [Suma los valores de copaogo que pertecen a Tarjeta Debito]
     */
     public function getCopaymentCards()
     {
      $connection = ConnectionManager::get('default');

      $data = $this->request->data;

      $date = $data['date'];

      $id = $data['id']; 


      $queryDebit = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id WHERE 
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date' 
        AND payments.users_id = '$id'
        AND payments.bill_types_id = 1
        AND payments.form_payments_id = 2
        ")->fetchAll('assoc');

      $queryCredit = $connection->execute("SELECT SUM(credit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id WHERE 
        DATE(payments.created) = '$date'
        AND payments.users_id = '$id'
        AND payments.bill_types_id = 1
        AND payments.form_payments_id = 3
        ")->fetchAll('assoc');


      if($queryDebit)
      {
        $success = true;

        $this->set(compact('success', 'queryDebit'));
    }else{

        $success = false;

        $errors = $queryDebit->errors();

        $this->set(compact('success', 'errors'));

    }

    if($queryCredit)
    {
        $success = true;

        $this->set(compact('success', 'queryCredit'));
    }else{

        $success = false;

        $errors = $queryCredit->errors();

        $this->set(compact('success', 'errors'));

    }
}


     /**
     * [getCopaymentCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T15:03:31-0500
     * @return   [type]                   [Suma los valores de copago que pertecen a Cheque]
     */
     public function getCopaymentCheck()
     {
       $connection = ConnectionManager::get('default');

       $data = $this->request->data;

       $date = $data['date']; 

       $id = $data['id'];


       $query = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date'
        AND payments.users_id = '$id'  
        AND payments.bill_types_id = 1 
        AND payments.form_payments_id = 4;
        ")->fetchAll('assoc');;


       if($query)
       {
        $success = true;

        $this->set(compact('success', 'query'));
    }else{

        $success = false;

        $errors = $query->errors();

        $this->set(compact('success', 'errors'));

    }
}
     /**
     * [getCopaymentCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T15:03:31-0500
     * @return   [type]                   [Suma los valores de copaogo que pertecen a Bonos]
     */
     public function getCopaymentBond()
     {
       $connection = ConnectionManager::get('default');

       $data = $this->request->data;

       $date = $data['date']; 

       $id = $data['id'];


       $query = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where 
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date'
        AND payments.users_id = '$id'  
        AND payments.bill_types_id = 1 
        AND payments.form_payments_id = 5;
        ")->fetchAll('assoc');;


       if($query)
       {
        $success = true;

        $this->set(compact('success', 'query'));
    }else{

        $success = false;

        $errors = $query->errors();

        $this->set(compact('success', 'errors'));

    }
}

     /**
     * [getCopaymentCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T15:03:31-0500
     * @return   [type]                   [Suma los valores de copaogo que pertecen a Consignaciones]
     */
     public function getCopaymentConsignment()
     {
       $connection = ConnectionManager::get('default');

       $data = $this->request->data;

       $date = $data['date']; 

       $id = $data['id'];


       $query = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where
        bills.canceled <> 1
        and payments.payment_type_id = 1 
        AND DATE(payments.created) = '$date' 
        AND payments.users_id = '$id' 
        AND payments.bill_types_id = 1 
        AND payments.form_payments_id = 6;
        ")->fetchAll('assoc');;


       if($query)
       {
        $success = true;

        $this->set(compact('success', 'query'));
    }else{

        $success = false;

        $errors = $query->errors();

        $this->set(compact('success', 'errors'));

    }
}


    /**
     * All Funtions For Manual Bills
     */

    /**
     * [getPaymentBillCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T11:16:56-0500
     * @return   [type]                   [ Suma los valores de facturacion que pertencen a efectivo]
     */
    public function getPaymentBillCash()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date']; 

        $id = $data['id'];

        
        $query = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 1;
            ")->fetchAll('assoc');;


        if($query)
        {
            $success = true;

            $this->set(compact('success', 'query'));
        }else{

            $success = false;

            $errors = $query->errors();

            $this->set(compact('success', 'errors'));

        }
    }

    /**
     * [getPaymentBillCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T11:16:56-0500
     * @return   [type]                   [Suma los valores de facturacion que pertencen a tarjetas ]
     */
    public function getPaymentBillCards()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date']; 

        $id = $data['id'];

        
        $queryDebitBill = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 2
            ")->fetchAll('assoc');

        if($queryDebitBill)
        {
            $success = true;

            $this->set(compact('success', 'queryDebitBill'));
        }else{

            $success = false;

            $errors = $queryDebitBill->errors();

            $this->set(compact('success', 'errors'));

        }

        $queryCreditBill = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 3
            ")->fetchAll('assoc');


        if($queryCreditBill)
        {
            $success = true;

            $this->set(compact('success', 'queryCreditBill'));
        }else{

            $success = false;

            $errors = $queryCreditBill->errors();

            $this->set(compact('success', 'errors'));

        }
    }
    /**
     * [getPaymentBillCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T11:16:56-0500
     * @return   [type]                   [Suma los valores de facturacion que pertencen a cheques ]
     */
    public function getPaymentBillCheck()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date']; 

        $id = $data['id'];

        
        $query = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 4;
            ")->fetchAll('assoc');;


        if($query)
        {
            $success = true;

            $this->set(compact('success', 'query'));
        }else{

            $success = false;

            $errors = $query->errors();

            $this->set(compact('success', 'errors'));

        }
    }

    /**
     * [getPaymentBillCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T09:26:56-0500
     * @return   [type]                   [Suma los valores de facturacion que pertencen a efectivo a Bonos]
     */
    public function getPaymentBillBond()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date']; 

        $id = $data['id'];

        
        $query = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 5;
            ")->fetchAll('assoc');;


        if($query)
        {
            $success = true;

            $this->set(compact('success', 'query'));
        }else{

            $success = false;

            $errors = $query->errors();

            $this->set(compact('success', 'errors'));

        }
    }

    /**
     * [getPaymentBillCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-22
     * @datetime 2016-09-22T11:16:56-0500
     * @return   [type]                   [Suma los valores de facturacion que pertencen a consignaciones ]
     */
    public function getPaymentBillConsign()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date']; 

        $id = $data['id'];

        
        $query = $connection->execute("SELECT SUM(debit) as Total 
            FROM payments INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id' 
            AND payments.bill_types_id = 2 
            AND payments.form_payments_id = 6;
            ")->fetchAll('assoc');;


        if($query)
        {
            $success = true;

            $this->set(compact('success', 'query'));
        }else{

            $success = false;

            $errors = $query->errors();

            $this->set(compact('success', 'errors'));

        }
    }

    /**
     * [totalBills description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:24:32-0500
     * @return   [type]                   [Ingresos Totales por facturación]
     */
    public function totalBills()
    {
      $connection = ConnectionManager::get('default');

      $data = $this->request->data;

      $date = $data['date'];

      $id = $data['id'];

      $totalManualBills = $connection->execute("SELECT SUM(debit) as total FROM payments 
        INNER JOIN bills ON payments.bills_id = bills.id
        Where 
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date' 
        AND payments.users_id = '$id' 
        AND payments.bill_types_id = 2

        ")->fetchAll('assoc');

      if($totalManualBills)
      {

        $success = true;

        $this->set(compact('success', 'totalManualBills'));

    }else{

        $success = false;

        $errors = $totalManualBills->errors();

        $this->set(compact('success', 'errors'));

    }

}

    /**
     * Totales Parciales
     */
    
    /**
     * [totalOnlyCash description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:24:21-0500
     * @return   [type]                   [Ingreso Total en Efectivo]
     */
    public function totalOnlyCash()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'];

        $id = $data['id'];

        $allTotalCash = $connection->execute("SELECT SUM(debit) as total FROM payments 
            INNER JOIN bills ON payments.bills_id = bills.id
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date'
            AND payments.users_id = '$id' 
            AND payments.form_payments_id= 1

            ")->fetchAll('assoc');

        if($allTotalCash)
        {
            $success = true;

            $this->set(compact('success', 'allTotalCash'));
        }else{


            $success = false;

            $errors = $allTotalCash->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * [totalOnlyCards description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:25:55-0500
     * @return   [type]                   [Ingreso Total por Tarjetas Credito y Debito]
     */
    public function totalOnlyCards()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'] ;

        $id = $data['id'];

        $allTotalCardsDebit = $connection->execute("SELECT SUM(debit) as total FROM payments 
            INNER JOIN bills ON payments.bills_id = bills.id
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date'
            AND payments.users_id = '$id'  
            AND payments.form_payments_id= 2 
            ")->fetchAll('assoc');

        if($allTotalCardsDebit)
        {
            $success = true;

            $this->set(compact('success', 'allTotalCardsDebit'));
        }else{


            $success = false;

            $errors = $allTotalCardsDebit->errors();

            $this->set(compact('success', 'errors'));
        }

        $allTotalCardsCredit = $connection->execute("SELECT SUM(debit) as total FROM payments 
            INNER JOIN bills ON payments.bills_id = bills.id
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date'
            AND payments.users_id = '$id'  
            AND payments.form_payments_id= 3 
            ")->fetchAll('assoc');

        if($allTotalCardsCredit)
        {
            $success = true;

            $this->set(compact('success', 'allTotalCardsCredit'));
        }else{


            $success = false;

            $errors = $allTotalCardsCredit->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * [totalOnlyChecks description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:34:50-0500
     * @return   [type]                   [Ingreso Total por Cheques]
     */
    public function totalOnlyChecks()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'] ;

        $id = $data['id'];

        $allTotalChecks = $connection->execute("SELECT SUM(debit) as total FROM payments 
            INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date'
            AND payments.users_id = '$id' 
            AND payments.form_payments_id= 4

            ")->fetchAll('assoc');

        if($allTotalChecks)
        {
            $success = true;

            $this->set(compact('success', 'allTotalChecks'));
        }else{


            $success = false;

            $errors = $allTotalChecks->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * [totalOnlyBonds description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:34:58-0500
     * @return   [type]                   [Ingreso Total Por Bonos]
     */
    public function totalOnlyBonds()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'];

        $id = $data['id'];

        $allTotalBonds = $connection->execute("SELECT SUM(debit) as total FROM payments 
            INNER JOIN bills ON payments.bills_id = bills.id
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1 
            AND DATE(payments.created) = '$date'
            AND payments.users_id = '$id' 
            AND payments.form_payments_id= 5

            ")->fetchAll('assoc');

        if($allTotalBonds)
        {
            $success = true;

            $this->set(compact('success', 'allTotalBonds'));
        }else{


            $success = false;

            $errors = $allTotalBonds->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * [totalOnlyConsignment description]
     * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
     * @date     2016-09-23
     * @datetime 2016-09-23T10:35:05-0500
     * @return   [type]                   [Ingreso Total por Consignaciones]
     */
    public function totalOnlyConsignment()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'];

        $id = $data['id'];

        $allTotalConsignment = $connection->execute("SELECT SUM(debit) as total FROM payments
            INNER JOIN bills ON payments.bills_id = bills.id 
            Where
            bills.canceled <> 1
            and payments.payment_type_id = 1 
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id'
            AND payments.form_payments_id= 6

            ")->fetchAll('assoc');

        if($allTotalConsignment)
        {
            $success = true;

            $this->set(compact('success', 'allTotalConsignment'));
        }else{


            $success = false;

            $errors = $allTotalConsignment->errors();

            $this->set(compact('success', 'errors'));
        }
    }

    /**
     * Total
     */
    
    public function allTotal()
    {
        $connection = ConnectionManager::get('default');

        $data = $this->request->data;

        $date = $data['date'];

        $id = $data['id'];

        $total = $connection->execute("SELECT SUM(debit) as total FROM payments
            INNER JOIN bills ON payments.bills_id = bills.id
            Where 
            bills.canceled <> 1
            and payments.payment_type_id = 1
            AND DATE(payments.created) = '$date' 
            AND payments.users_id = '$id'
            ")->fetchAll('assoc');

        if($total)
        {
            $success = true;

            $this->set(compact('success', 'total'));

        }else{

            $success = false;

            $errors = $total->errors();

            $this->set(compact('success'));
        }
    }


    public function getLeaveCopaymentCach(){
      $connection = ConnectionManager::get('default');

      $data = $this->request->data;

      $date = $data['date'];

      $id = $data['id']; 


      $query = $connection->execute("SELECT SUM(debit) as Total 
        FROM payments INNER JOIN bills ON payments.bills_id = bills.id
        Where 
        bills.canceled <> 1
        and payments.payment_type_id = 1
        AND DATE(payments.created) = '$date'
        AND payments.users_id = '$id' 
        AND payments.bill_types_id = 1 
        AND payments.form_payments_id = 2;
        ")->fetchAll('assoc');


      if($query)
      {
        $success = true;

        $this->set(compact('success', 'query'));
    }else{

        $success = false;

        $errors = $query->errors();

        $this->set(compact('success', 'errors'));

    }
}

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => ['Users', 'Orders', 'FormPayments', 'BillTypes']
            ]);

        $this->set('payment', $payment);
        $this->set('_serialize', ['payment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $payment = $this->Payments->newEntity();
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }
        }
        $users = $this->Payments->Users->find('list', ['limit' => 200]);
        $orders = $this->Payments->Orders->find('list', ['limit' => 200]);
        $formPayments = $this->Payments->FormPayments->find('list', ['limit' => 200]);
        $billTypes = $this->Payments->BillTypes->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'users', 'orders', 'formPayments', 'billTypes'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->data);
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The payment could not be saved. Please, try again.'));
            }
        }
        $users = $this->Payments->Users->find('list', ['limit' => 200]);
        $orders = $this->Payments->Orders->find('list', ['limit' => 200]);
        $formPayments = $this->Payments->FormPayments->find('list', ['limit' => 200]);
        $billTypes = $this->Payments->BillTypes->find('list', ['limit' => 200]);
        $this->set(compact('payment', 'users', 'orders', 'formPayments', 'billTypes'));
        $this->set('_serialize', ['payment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)

    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    private function getUserById($id = null){
        $this->loadModel('Users');

        $id = $this->request->data['id'];

        $user = $this->Users->find('all',['contain'=>['People'],'conditions'=>['Users.id '=> $id]])->first();
        
        return $user;
    }

    public function prePayments()
    {

        // $this->autoRender = false;
        $data = $this->request->data;

        setlocale(LC_MONETARY, 'en_US');



        /**
         * [$cashCopyment Valores de Copago]
         * @var [type]
         */
        $cashCopyment            = money_format('%(#10n',$data['cashcopayment']);
        $totalsCardsCopyments    = money_format('%(#10n',$data['totalsCardsCopyments']);
        $payCheckCopyment        = money_format('%(#10n',$data['payCheckCopyment']);
        $payBondCopayment        = money_format('%(#10n',$data['payBondCopayment']);
        $payConsignmentCopayment = money_format('%(#10n',$data['payConsignmentCopayment']);
        $copymentsTotal          = money_format('%(#10n',$data['copymentsTotal']);


        /**
         * Cuadre para Factuta
         */
        
        $copymentsBillCash        = money_format('%(#10n',$data['copymentsBillCash']);
        $totalCardsBill           = money_format('%(#10n',$data['totalCardsBill']);
        $copymentsBillCheck       = money_format('%(#10n',$data['copymentsBillCheck']); 
        $copymentsBillBond        = money_format('%(#10n',$data['copymentsBillBond']);
        $copymentsBillConsignment = money_format('%(#10n',$data['copymentsBillConsignment']);
        $totalSaleBills           = money_format('%(#10n',$data['totalSaleBills']);

        /**
         * Cuadre Total
         */
        
        $totalCash       = money_format('%(#10n',$data['cash']);
        $totalCards      = money_format('%(#10n',$data['cards']);
        $totalChecks     = money_format('%(#10n',$data['checks']);
        $totalBond       = money_format('%(#10n',$data['bonds']);
        $totalCosnign    =money_format('%(#10n', $data['consignment']);
        $totalDay        = money_format('%(#10n',$data['totalDay']);

        /**
         *  
         * Tickects
         */
        
        $numTicketModel = money_format('%(#10n',$data['numTicketModel']);
        $ticketModel      = money_format('%(#10n',$data['ticketModel']);

        /**
         * Coins
         */
        
        $numCoinsModel   = money_format('%(#10n',$data['numCoinsModel']);
        $coinsModel      = money_format('%(#10n',$data['coinsModel']);

        /**
         * Totales
         */
        
        $totalTickeck  = money_format('%(#10n',$data['updateTotal']);
        $diference     = money_format('%(#10n',$data['diference']);
        $totalAll      = money_format('%(#10n',$data['totalAll']);      

        /**
         * Base de caja
         */
        
        $baseCash = money_format('%(#10n',$data['baseCash']);

        /**
         * Usuario que impreme
         */
        
        $pritnt_user = $data['pritnt_user'];

        $user_caja_id =  $data['report_user'];
        $caja_name  = $this->getUserById($user_caja_id);

        $report_date = $data['report_date'];
        


        // Instanciacion
        $tcpdf = new XTCPDF(); 

        // $pdf->addText(puntos_cm(4),puntos_cm(26.7),12,'Encabezado');

        // Info del documento
        $tcpdf->SetAuthor("Gatoloco Studios S.A.S."); 

        // Usuario: '.$bills[0]['Bill']['user']
        
        // Informacion del ecabezado y footer
        $tcpdf->xheadertext = '
        <table style="padding: 1px; width: 100%" border="0">
            <tr style="font-size: 100%">
                <td colspan="2">
                   <br><img src="img/logo_londono.png">
               </td>
           </tr>
       </table> 
       <br>
       ';  
        //  <tr style="font-size:8px">
        //   <img src="img/Franja-01.png" height="5px" width="100px">
        // </tr>

        // $tcpdf->variable = $opcion; // Set de la variable de validación de previsualización 
       $tcpdf->xfootertext = '
       <br>
       <div style="font-size:8px; text-align:right;"><b> Impreso por : '.$pritnt_user.' Fecha: '.date('Y-m-d').' '.date('H:i:s').'  Página'.$tcpdf->getAliasNumPage().' de '.$tcpdf->getAliasNbPages().'</b></div>
       <div style="border-bottom-width: 4px; border-bottom-color: #2B5C9C; height: 10px;" ></div>
       <br>
       <table style="padding: 2px; width: 95%" border="0">
        <tr style="font-size: 70%;">        
            <td style=" text-align: left; font-size:7px;">
               Sede Norte: Carrera 15 # 1Norte - 49 Armenia, Quindío<br>
               Sede Sur: Carrera 18 # 43 - 70 Esquina Armenia, Quindío<br>
               PBX: (6) 7455566&nbsp;&nbsp;&nbsp;&nbsp; FAX: (6) 7455566 Ext. 8<br>
               <span style="text-decoration:underline; color:#1F1A5A">citas@fundacionalejandrolondono.com</span>
           </td>
           <td style="text-align: right; font-size:7px;"> 
            <i>Visitanos en:</i>
            <br> < style="text-decoration:underline; color:#1F1A5A">www.fundacionalejandrolondono.com</span>
            <br> <span style="text-decoration:underline; color:#1F1A5A">www.facebook.com/FundacionAlejandroLondono.Oficial</span>
            <br> <span style="text-decoration:underline; color:#1F1A5A">info@fundacionalejandrolondono.com</span>
        </td>
    </tr>
    <tr> 
     <td colspan="2" align="center">
        <b>Original</b>
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
        $tcpdf->SetMargins(25,45, 25, false);


        $tcpdf->SetHeaderMargin(18);
        $tcpdf->SetFooterMargin(70);
        
        // Cambio de pagina
        $tcpdf->SetAutoPageBreak(true, 45); 
        
        //$tcpdf->setHeaderFont(array($textfont,'',40)); 
        //$tcpdf->xheadercolor = array(150,0,0); 

        // Validacion para la aparicion tanto del header como del footer
        $tcpdf->SetPrintHeader(true);
        $tcpdf->SetPrintFooter(true);

        // Adicion de nueva pagina con tamaño predefinido en mm
        //$resolution= array(216, 279);
        $resolution= array(216, 279);
        $tcpdf->AddPage('P', $resolution);
        
        setlocale(LC_MONETARY, 'en_US');
        
        //$tcpdf->SetFont('freesans', '', 12);

        //-----------------------  Contenido del pdf -----------------------------------
        $html ='


        <table style="width:100%;">
            <tr  style="font-size: 8px">
                <td style="width: 12%;"><label><strong>Caja : </strong></label></td>
                <td style="width: 40%;"><label><strong>'.$caja_name .'</strong></label></td>
                <td style="width: 12%;"><label><strong>Base Caja : </strong> </label></td>
                <td style="width: 36%;"><label><strong> '.$baseCash['total'].'</strong> </label></td>
            </tr>
            <tr  style="font-size: 8px">
                <td style="width: 12%;"><strong>Fecha Cierre</strong></td>
                <td style="width: 40%;"><strong>'.$report_date.'</strong></td>
                <td style="width: 12%;"><strong>Fecha </strong></td>
                <td style="width: 36%;"><strong>'.date('Y-m-d').' '.date('H:i:s').'</strong></td>
            </tr>
        </table>
        <br>
        <br>
        <table style="border: 1px solid black;  padding: 1px; width:100%" >
            <tbody>
                <tr style="font-size: 100%">
                    <td colspan="2" style="border-right: 1px solid black; font-size:8px;">
                      <p><strong>Ingresos Copagos</strong></p>
                  </td>
                  <td colspan="2" style="border-right: 1px solid black; font-size:8px;">
                      <p><strong>Ingresos Particulares </strong></p>
                  </td>
                  <td colspan="2" style="border-right: 1px solid black; font-size:8px;">
                     <p><strong>Devoluciones</strong></p>
                 </td>
             </tr>
             <tr style="font-size: 100%">
                <td style=" padding:2px;  text-align: left; font-size: 7px">
                    <p>Efectivo:</p>
                    <p>Tarjetas:</p>
                    <p>Cheques:</p>
                    <p>Bonos:</p>
                    <p>Consignaciòn :</p>
                    <p><strong>SUBTOTAL  COPAGO:</strong></p>
                </td>

                <td style=" padding:2px;  text-align: right; font-size:7px; border-right: 1px solid black;">
                    <p >'.$cashCopyment.'</p>
                    <p >'.$totalsCardsCopyments.'</p>
                    <p >'.$payCheckCopyment.'</p>
                    <p >'.$payBondCopayment.'</p>
                    <p >'.$payConsignmentCopayment.'</p>
                    <p >'.$copymentsTotal.'</p>
                </td>

                <td style=" padding:2px;  text-align: left; font-size:7px;">

                    <p>Efectivo:</p>
                    <p>Tarjetas:</p>
                    <p>Cheques:</p>
                    <p>Bonos:</p>
                    <p>Consignaciòn:</p>
                    <p><strong>SUBTOTAL  PARTICULAR:</strong></p>
                </td>

                <td style=" padding:2px;  text-align: right; font-size:7px; border-right: 1px solid black;">

                    <p >'.$copymentsBillCash.'</p>
                    <p >'.$totalCardsBill.'</p>
                    <p >'.$copymentsBillCheck.'</p>
                    <p >'.$copymentsBillBond.'</p>
                    <p >'.$copymentsBillConsignment.'</p>
                    <p >'.$totalSaleBills.'</p>
                </td>

                <td style=" padding:2px;  text-align: left; font-size:7px; ">

                    <p>Efectivo:</p>
                    <p>Tarjetas:</p>
                    <p>Cheques:</p>
                    <p>Bonos:</p>
                    <p>Consignaciòn :</p>
                    <p><strong>SUBTOTAL  COPAGO:</strong></p>
                </td>
                <td style=" padding:2px;  text-align: right;  font-size:7px; border-right: 1px solid black;">

                    <p >'.$cashCopyment.'</p>
                    <p >'.$totalsCardsCopyments.'</p>
                    <p >'.$payCheckCopyment.'</p>
                    <p >'.$payBondCopayment.'</p>
                    <p >'.$payConsignmentCopayment.'</p>
                    <p >'.$copymentsTotal.'</p>
                </td>

            </tr>

        </tbody> 
    </table>
    <table style="border: 1px solid black;  padding: 2px; width:100%" hidden>
        <tr style="font-size: 70%">
            <td style=" padding:2px; width:30%; text-align: center; border-right: 1px solid black;">
                <strong>Totales</strong>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE VENTAS EN EFECTIVO:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE VENTAS EN TARJETA:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE VENTAS EN CHEQUE:</strong></p>

            </td>
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Valor</strong>
                <p>'.$totalCash.'</p>
                <p>'.$totalCards.'</p>
                <p>'.$totalChecks.'</p>



            </td>
            <td style="width:30%; text-align: center; border-right: 1px solid black;">
                <strong>Totales</strong>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE VENTAS EN BONO:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE VENTAS EN CONSIGNACIÓN:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>TOTAL DE INGRESOS:</strong></p>

            </td>
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Valor</strong>
                <p>'.$totalBond.'</p>
                <p>'.$totalCosnign.'</p>
                <p>'.$totalDay.'</p>

            </td>
        </tr>
    </table>



    <table style="border: 1px solid black;  padding: 2px; width:100%" >
        <tr style="font-size: 70%">
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Billetes</strong>
                <p style="text-align: left; font-size:7px;"><strong>$100.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$50.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$20.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$10.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$5.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$2.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$1.000:</strong></p>

            </td>
            <td style="width:10%; text-align: center; border-right: 1px solid black;">
                <strong>Cantidad</strong>

                <p style="font-size:7px;">'.$numTicketModel['v1'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v2'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v3'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v4'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v5'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v6'].'</p>
                <p style="font-size:7px;">'.$numTicketModel['v7'].'</p>






            </td>
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Valor</strong>
                <p style="font-size:7px;">'.$ticketModel['c1'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c2'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c3'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c4'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c5'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c6'].'</p>
                <p style="font-size:7px;">'.$ticketModel['c7'].'</p>


            </td>
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Monedas</strong>
                <p style="text-align: left; font-size:7px;"><strong>$1.000:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$500:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$200:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$100:</strong></p>
                <p style="text-align: left; font-size:7px;"><strong>$50:</strong></p>

            </td>
            <td style="width:10%; text-align: center; border-right: 1px solid black;">
                <strong>Cantidad</strong>
                <p style="font-size:7px;">'.$numCoinsModel['m1'].'</p>
                <p style="font-size:7px;">'.$numCoinsModel['m2'].'</p>
                <p style="font-size:7px;">'.$numCoinsModel['m3'].'</p>
                <p style="font-size:7px;">'.$numCoinsModel['m4'].'</p>
                <p style="font-size:7px;">'.$numCoinsModel['m5'].'</p>

            </td>
            <td style="width:20%; text-align: center; border-right: 1px solid black;">
                <strong>Valor</strong>
                <p style="font-size:7px;">'.$coinsModel['m1'].'</p>
                <p style="font-size:7px;">'.$coinsModel['m2'].'</p>
                <p style="font-size:7px;">'.$coinsModel['m3'].'</p>
                <p style="font-size:7px;">'.$coinsModel['m4'].'</p>
                <p style="font-size:7px;">'.$coinsModel['m5'].'</p>

            </td>
        </tr>
    </table>

    <table style="border: 1px solid black;  padding: 2px; width:100%">
        <tr style="font-size: 70%">
            <td style="width:33.33%; text-align: center; border-right: 1px solid black;">
                <strong>Total de Efectivo</strong>
                <p style="text-align: center; font-size:7px;"><strong>'.$totalTickeck.'</strong></p>

            </td>
            <td style="width:33.33%; text-align: center; border-right: 1px solid black;">
                <strong>Total a Consignar</strong>

                <p style="font-size:7px;">'.$totalAll.'</p>


            </td>

            <td style="width:33.33%; text-align: center; border-right: 1px solid black;">
                <strong>Diferencia</strong>

                <p style="font-size:7px;">'.$diference.'</p>


            </td>
        </tr>
    </table>


    <br>

    <p>Impreso por: '.$pritnt_user.'</p>         


    '

    ;


        // output the HTML content
    $tcpdf->writeHTML($html, true, false, true, false, '');

        // output the HTML content
        //$tcpdf->writeHTML($html, true, false, true, false, '');
        // if ($opcion = 1)
        // {

    $tcpdf->Output(WWW_ROOT.'files/PrevioResult'.''.'.pdf', 'F');




        // }
        // else
        // {
        //     echo 'pase';
        //     $tcpdf->Output(WWW_ROOT.'/files/Pedido_'.$this->Session->read('User.userId').'.pdf', 'F');
        // }


}


public function downloadPrev(){

    $this->autoRender = false;

    $this->response->file(WWW_ROOT.'/files/PrevioResult.pdf', array('download' => true, 'name' => 'CuadreCaja.pdf'));

}

}

class XTCPDF extends \TCPDF
{
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
        //var $xfooterfontsize = 8 ;

    function Header()
    {

            //list($r, $b, $g) = $this->xheadercolor;
        $this->setY(15);
            //$this->SetFillColor($r, $b, $g);
            //$this->SetTextColor(0 , 0, 0);
            //$this->Cell(0,20, '', 0,1,'C', 1);
            //$this->Text(15,26,$this->xheadertext );


        $this->writeHTML($this->xheadertext, true, false, true, false, '');

            // Transformacion para la rotacion de el numero de orden y el contenedor de la muestra
        $this->StartTransform();
        $this->SetFont('freesans', '', 5);
        $this->Rotate(-90, 116, 120);
            //$tcpdf->Rect(39, 50, 40, 10, 'D');
            // $this->Text(5, 30, 'Software de Administración Médica "SAM" V.1.1 ® - www.gatolocostudios.com ®');
            // Stop Transformation
        $this->StopTransform();

            // if ( $this->variable = 1 )
            // {
                // draw jpeg image                         x,  y  ancho, alto
                // $this->Image(WWW_ROOT.'/img/BORRADOR.png', 40, 60, 450, 250, '', '', '', true, 72);

                // restore full opacity
        $this->SetAlpha(0);
            // }

    }

    function Footer()
    {
            //$year = date('Y');
            //$footertext = sprintf($this->xfootertext, '');
        $this->SetY(-50);
            //$this->SetTextColor(0, 0, 0);
            //$this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
        $this->writeHTML($this->xfootertext, true, false, true, false, '');
            //$this->Cell(0,8, $footertext,'T',3,'L');
    }





}

