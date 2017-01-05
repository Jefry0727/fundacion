<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FingerprintsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FingerprintsTable Test Case
 */
class FingerprintsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FingerprintsTable
     */
    public $Fingerprints;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fingerprints',
        'app.people',
        'app.document_types',
        'app.municipalities',
        'app.departments',
        'app.patients',
        'app.users',
        'app.roles',
        'app.centers',
        'app.user_centers',
        'app.zones',
        'app.regimes',
        'app.eps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Fingerprints') ? [] : ['className' => 'App\Model\Table\FingerprintsTable'];
        $this->Fingerprints = TableRegistry::get('Fingerprints', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fingerprints);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
