<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * MedicalOffices Controller
 *
 * @property \App\Model\Table\MedicalOfficesTable $MedicalOffices
 */
class PdfGeneratorController extends AppController
{



    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['invoice']);
    }

    /**
     * Función para generar factura de ejemplo
     * @return [type] [description]
     */
    public function invoice(){

        



    }


}






