<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;


/**
 * Julian Andres Muñoz Cardozo
 * Logging component 
 */
class LogRegisterComponent extends Component
{

    public $components = ['Auth'];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    /**
     * Function that saves the new loggin register
     * @param  String $section section name
     * @param  String $action  action name
     * @param  Array $data    data to convert into json 
     * @return Boolean true if saved false if problems
     */
    public function register($section, $action, $data){

        /**
         * encoding array data
         * @var JsonString
         */
    	$encodedData = json_encode($data);

        /**
         * Array with data to save
         * @var [type]
         */
        $newLogData = Array(
            'users_id'              => $this->Auth->user('id'),
            'register'              => $encodedData,
            'logging_sections_id'   => $this->getLogginSectionId($section),
            'logging_actions_id'    => $this->getLoggingActionId($action)
        );
        /**
         * saving and returning result
         */
        return $this->saveRegister($newLogData);

    }

    /**
     * Function that saves the new loggin register into database
     * @param  Array $newLogData Array with key values to save
     * @return Boolean true if saved false if problems
     */
    public function saveRegister($newLogData){

        $this->Logging = TableRegistry::get('Logging');

        $newLog = $this->Logging->newEntity();

        $newLog = $this->Logging->patchEntity($newLog,$newLogData);

        if ($this->Logging->save($newLog)) {

            return true;
            
        }else {
            
            return false;

        }

    }


    /**
     * Function that retrieves the loggin section name id from its name
     * @param  String $sectionName section name saved in database
     * @return int identifier
     */
    public function getLogginSectionId($sectionName){

        $this->LoggingSections = TableRegistry::get('LoggingSections');

        $record = $this->LoggingSections->find('all', ['conditions' => ['LoggingSections.name' => $sectionName]])->first();

        return $record->id;

    }


    /**
     * Function that retrieves the loggin action id from its name
     * @param  String $actionName action name saved in database
     * @return int identifier
     */
    public function getLoggingActionId($actionName){

        $this->LoggingActions = TableRegistry::get('LoggingActions');

        $record = $this->LoggingActions->find('all', ['conditions' => ['LoggingActions.action' => $actionName]])->first();

        return $record->id;

    }


}
