<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AttentionStudiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AttentionStudiesTable Test Case
 */
class AttentionStudiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AttentionStudiesTable
     */
    public $AttentionStudies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.attention_studies',
        'app.users',
        'app.roles',
        'app.people',
        'app.document_types',
        'app.patients',
        'app.zones',
        'app.regimes',
        'app.orders',
        'app.order_details',
        'app.clients',
        'app.municipalities',
        'app.departments',
        'app.rates',
        'app.rates_clients',
        'app.external_specialists',
        'app.service_types',
        'app.order_types',
        'app.centers',
        'app.order_states'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('AttentionStudies') ? [] : ['className' => 'App\Model\Table\AttentionStudiesTable'];
        $this->AttentionStudies = TableRegistry::get('AttentionStudies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AttentionStudies);

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
