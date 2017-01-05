<?php
namespace Vendor\ValidateRips;
use Cake\Datasource\ConnectionManager;

class ValidatesRips {

    private $billsId;
    private $ordersId;
    private $fechaInicio;
    private $fechaFin;
    private $ratesId;
    private $ordersConsec;


   /*
     Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
     Fecha: 2016-11-21 11:50:20
     Tipo de retorno:  void
     Descripción: Este ess el constructor de la clase inicializa las propiedades y se ejecuta al ser instaciada
   */
   public function __construct( $fechaInicio = null, $fechaFin = null, $ratesId = null){
        $this->billsId      = [];
        $this->ordersId     = [];
        $this->ordersConsec = [];
        $this->fechaInicio  = $fechaInicio;
        $this->fechaFin     = $fechaFin;
        $this->ratesId      = $ratesId;

        if( empty( $fechaInicio ) || empty( $fechaFin ) || empty( $ratesId ) ){

            echo "Alguna propidad debe ser iniciada y no se ha hecho";
            exit();
        }

    }

    /*
      Carlos Felipe Aguirre Taborda GATOLOCO STUDIOS S.A.S
      Fecha: 2016-11-21 11:49:06
      Tipo de retorno:  void
      Descripción: esta función debe consultar los datos de las facturas que no estan facturadas
    */
    public static function obtenerNoCanceladas(){


    }
   
}