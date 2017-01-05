<?php
namespace App\Test\TestCase\Controller;

use App\Controller\StudiesMedicalOfficesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\StudiesMedicalOfficesController Test Case
 */
class StudiesMedicalOfficesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studies_medical_offices',
        'app.studies',
        'app.specializations',
        'app.products',
        'app.products_studies',
        'app.informed_consents',
        'app.studies_informed_consents',
        'app.specialists',
        'app.people',
        'app.document_types',
        'app.users',
        'app.roles',
        'app.schedule',
        'app.schedule_specialists',
        'app.studies_specialists',
        'app.medical_offices'
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
