<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ProductsStudiesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\ProductsStudiesController Test Case
 */
class ProductsStudiesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products_studies',
        'app.products',
        'app.studies',
        'app.specializations',
        'app.service_types',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.medical_offices',
        'app.studies_medical_offices',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.users',
        'app.roles',
        'app.zones',
        'app.regimes',
        'app.studies_specialists',
        'app.schedule_specialists',
        'app.schedule_specialist_types'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
