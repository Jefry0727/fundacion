<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;


/**
 * ResourceManager component
 */
class ResourceManagerComponent extends Component
{

    /**
     * ejemplos de uso:
     * $this->saveResource(1, 'patients', 'profile_pic', '1234');
     * $this->getResources(1, 'profile_pic');
     */

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [

        /**
         * Identificador del archivo que se cargara
         */
        'singleFileIdentifier' => 'file',

        'multipleFileIdentifier' => 'files'
    
    ];


    public $components = ['Auth'];


    /**
     * Función que obtiene recursos
     * @param  [type] $entity_id    identificador de la entidad hija
     * @param  [type] $resourceType Tipo de recurso
     * @return Array               Datos
     */
    public function getResources($entity_id = null, $parentEntityName = null, $resourceType = null){
        
        
        $this->Resources = TableRegistry::get('Resources');

        /**
         * identificador de tipo de recurso
         * @var Int
         */

        $resourceTypeId =  $this->getResourceTypeId($resourceType); 

        /**
         * Recursos encontrados
         * @var Array
         */
        $resources = $this->Resources->find('all',[

            'conditions' => [
                'Resources.resource_types_id'    => $resourceTypeId, 
                'Resources.entity_id'            => $entity_id
            ]
        ])->toArray();



        /**
         * Ruta principal de la aplicación
         * @var String
         */
        $url = $this->getResourcesPath();



        /**
         * Identificador de la entidad padre
         * @var Int
         */
        $parentEntityId = $this->getParentEntityId($parentEntityName);



        /**
         * verificamos si existe un directorio asociado a la entidad
         * @var String nombre, Boolean false en caso de no encontrarlo
         */
        $entityDirectory = $this->getEntityDirectory($parentEntityId);




        /**
         * recorrido del arreglo de recursos
         */
        foreach ($resources as $resource) {
    

            /**
             * contruyendo ruta absoluta del archivo
             * @var String
             */
            $resource->url = $url . $entityDirectory ."/". $resource->stored_file_name;

            /**
             * Formateo de fechas
             * @var [type]
             */
            
            if(!empty($resource->created) && !empty($resource->modified)){
                $resource->created = $resource->created->i18nFormat('yyyy-MM-dd');
                $resource->modified = $resource->modified->i18nFormat('yyyy-MM-dd');
            }
            if(empty($resource->created)){
                $resource->created = date('Y-m-d');
            }
            if(empty($resource->modified)){
                $resource->modified = date('Y-m-d');
            }

                

            /**
             * Extension
             */
            // $resource->extension = $resource->


            /**
             * Nombre de archivo mas extension
             */

             // $resource->fileName = $resource->

        }     

        /**
         * retornamos el arreglo con los resultados
         */
        return $resources;
    }


    /**
     * Function that creates a file
     * @param  String $content      Contenido del archivo
     * @param  String $extension    Extensión
     * @param  String $fileName     Nombre del archivo
     * @param  String $folderName   Nombre del directorio
     * @return Array          
     */
    public function createFile($content, $extension, $fileName, $folderName){

        $url = $this->getPhysicalResourcesPath();

        $microtime = $this->getMicroTime();

        $filePath = $url .$folderName.'/'.$microtime.'.'.$extension;
        
        $handle = fopen($filePath, 'w') or die('Cannot open file:  '.$filePath);
        
        fwrite($handle, $content);
        
        fclose($handle);    


        $sizeBytes = filesize($filePath);
        
        $fileInfo = Array(
            'storedFileName'   => $microtime.'.'.$extension,
            'name'              => $fileName,
            'extension'         => $extension,
            'sizeBytes'         => $sizeBytes ,
            'sizeFormat'        => $this->formatSizeUnits($sizeBytes),

        );

        return $fileInfo;

    }   



    /**
     * Función que guarda un archivo en disco y contruye las relaciones de este en BD
     * @param  Int $entityId                identificador de la entidad hija
     * @param  String $parentEntityName     nombre de la entidad padre
     * @param  String $resourceType         tipo de recurso
     * @param  String $entityFolderName     nombre del tipo de recurso
     * @return Boolean $saved                  [description]
     */
    public function saveResourceCreateFile($entityId, $parentEntityName, $resourceType, $entityFolderName, $content, $extension, $fileName){

        /**
         * Identificador de la entidad padre
         * @var Int
         */
        $parentEntityId = $this->getParentEntityId($parentEntityName);


        /**
         * Variable que contiene el identificador del tipo de recurso
         * @var Int
         */
        $resourceTypeId = $this->getResourceTypeId($resourceType); 

        /**
         * verificamos si existe un directorio asociado a la entidad
         * @var String nombre, Boolean false en caso de no encontrarlo
         */
        $entityDirectory = $this->getEntityDirectory($parentEntityId);

        /**
         * Si no existe, se crea
         * @var [type]
         */
        if($entityDirectory === false){

            /**
             * nombre del directorio creado
             * @var String
             */
            $entityDirectory = $this->setEntityFolder($entityFolderName, $parentEntityId);

        }

    
        /**
         * Ruta del servidor hasta el nombre del directorio
         * @var [type]
         */
        $fullFolderPath = $this->getPhysicalFolder($entityDirectory);
        
        /**
         * Creación del archivo, se obtiene información del mismo
         * @var Array
         */
        $fileInfo = $this->createFile($content, $extension, $fileName, $entityFolderName);

        /**
         * Se guarda el archivo y obtenemos el Nombre con su extensión
         * @var String
         */
        $storedFileName = $fileInfo['storedFileName']; 

        /**
         * Si se guardo con éxito
         */
        if($storedFileName !== false){

            /**
             * Guardamos los datos del archivo en la BD
             * @var Boolean
             */
            $saved = $this->insertIntoResources($this->Auth->user('id'), $storedFileName, $fileInfo['name'], $this->getExtensionId($fileInfo['extension']), $parentEntityId, $resourceTypeId, $entityId, $fileInfo['sizeBytes'], $fileInfo['sizeFormat']);

            /**
             * Si se guardo con éxito
             */
            if($saved){

                return true;
            
            }else{

                return false;
            }

        }

    }
    




    /**
     * Función que guarda un archivo en disco y contruye las relaciones de este en BD
     * @param  Int $entityId          identificador de la entidad hija
     * @param  String $parentEntityName  nombre de la entidad padre
     * @param  String $resourceType      tipo de recurso
     * @param  String $entityFolderName  nombre del tipo de recurso
     * @return Boolean $saved                  [description]
     */
    public function saveResource($entityId, $parentEntityName, $resourceType, $entityFolderName){

        /**
         * Identificador de la entidad padre
         * @var Int
         */
        $parentEntityId = $this->getParentEntityId($parentEntityName);


        /**
         * Variable que contiene el identificador del tipo de recurso
         * @var Int
         */
        $resourceTypeId = $this->getResourceTypeId($resourceType); 

        /**
         * verificamos si existe un directorio asociado a la entidad
         * @var String nombre, Boolean false en caso de no encontrarlo
         */
        $entityDirectory = $this->getEntityDirectory($parentEntityId);


        /**
         * Si no existe, se crea
         * @var [type]
         */
        if($entityDirectory === false){

            /**
             * nombre del directorio creado
             * @var String
             */
            $entityDirectory = $this->setEntityFolder($entityFolderName, $parentEntityId);

        }

    
        /**
         * Ruta del servidor hasta el nombre del directorio
         * @var [type]
         */
        $fullFolderPath = $this->getPhysicalFolder($entityDirectory);

        /**
         * Archivo que viene en el post
         * @var File
         */
        $file = $_FILES[$this->_defaultConfig['singleFileIdentifier']];

        /**
         * Información del archivo
         * @var Array
         */
        $fileInfo = $this->getFileInfo($file);


        /**
         * Se guarda el archivo y obtenemos el Nombre con su extensión
         * @var String
         */
        $storedFileName = $this->saveFileToDisk($file, $fullFolderPath);

        /**
         * Si se guardo con éxito
         */
        if($storedFileName !== false){

            /**
             * Guardamos los datos del archivo en la BD
             * @var Boolean
             */
            $saved = $this->insertIntoResources($this->Auth->user('id'), $storedFileName, $fileInfo['name'], $this->getExtensionId($fileInfo['extension']), $parentEntityId, $resourceTypeId, $entityId, $fileInfo['sizeBytes'], $fileInfo['sizeFormat']);

            /**
             * Si se guardo con éxito
             */
            if(!$saved){

                return false;
            
            }

        }

        return $this->getResources($entityId, $parentEntityName ,$resourceType);
       

    }





    /**
     * Función que guarda un archivo en disco y contruye las relaciones de este en BD
     * @param  Int $entityId          identificador de la entidad hija
     * @param  String $parentEntityName  nombre de la entidad padre
     * @param  String $resourceType      tipo de recurso
     * @param  String $entityFolderName  nombre del tipo de recurso
     * @return Boolean $saved                  [description]
     */
    public function saveResources($entityId, $parentEntityName, $resourceType, $entityFolderName){

        /**
         * Identificador de la entidad padre
         * @var Int
         */
        $parentEntityId = $this->getParentEntityId($parentEntityName);


        /**
         * Variable que contiene el identificador del tipo de recurso
         * @var Int
         */
        $resourceTypeId = $this->getResourceTypeId($resourceType); 

        /**
         * verificamos si existe un directorio asociado a la entidad
         * @var String nombre, Boolean false en caso de no encontrarlo
         */
        $entityDirectory = $this->getEntityDirectory($parentEntityId);

        /**
         * Si no existe, se crea
         * @var [type]
         */
        if($entityDirectory === false){

            /**
             * nombre del directorio creado
             * @var String
             */
            $entityDirectory = $this->setEntityFolder($entityFolderName, $parentEntityId);

        }

    
        /**
         * Ruta del servidor hasta el nombre del directorio
         * @var [type]
         */
        $fullFolderPath = $this->getPhysicalFolder($entityDirectory);

        /**
         * Archivo que viene en el post
         * @var File
         */
        
        $files = $this->diverse_array($_FILES[$this->_defaultConfig['multipleFileIdentifier']]);


        foreach ($files as $file) {
        

            /**
             * Información del archivo
             * @var Array
             */
            $fileInfo = $this->getFileInfo($file);


            /**
             * Se guarda el archivo y obtenemos el Nombre con su extensión
             * @var String
             */
            $storedFileName = $this->saveFileToDisk($file, $fullFolderPath);


                
            /**
             * Si se guardo con éxito
             */
            if($storedFileName !== false){


                /**
                 * Guardamos los datos del archivo en la BD
                 * @var Boolean
                 */
                $saved = $this->insertIntoResources($this->Auth->user('id'), $storedFileName, $fileInfo['name'], $this->getExtensionId($fileInfo['extension']), $parentEntityId, $resourceTypeId, $entityId, $fileInfo['sizeBytes'], $fileInfo['sizeFormat']);



                /**
                 * Si se guardo con éxito
                 */
                if(!$saved){

                    return false;
                
                }
            }


        }


        return $this->getResources($entityId, $parentEntityName ,$resourceType);
       

        

    }


    /**
     * Función que obtiene el identificador de un tipo de recurso
     * @param  String $resourceType Nombre del tipo de recurso
     * @return Int                  Identificador del recurso, false en caso de no encontrarlo
     */
    public function getResourceTypeId($resourceType = null){


        $this->ResourceTypes = TableRegistry::get('ResourceTypes');

        $ResourceType = $this->ResourceTypes->find('all', ['conditions'=>['ResourceTypes.name' => $resourceType]])->first();
    
        if ($ResourceType) {

            return $ResourceType->id;
        }

        return false;

    }


    /**
     * Función que guarda un archivo fisicamente
     * @param  File     $file           Archivo
     * @param  String   $fullFolderPath Ruta completa del directorio del usuario
     * @return Boolean                  true o false en caso de errores
     */
    public function saveFileToDisk($file = null, $fullFolderPath = null ){
            
        /**
         * Obtenemos el TimesTamp Actual
         * @var String
         */
        $microtime = $this->getMicroTime();

        /**
         * Información del archivo
         * @var Array
         */
        $fileInfo = $this->getFileInfo($file);

        /**
         * Subimos el archivo y retornamos su nombre
         */
        if(move_uploaded_file($file['tmp_name'], $fullFolderPath.'/'.$microtime.'.'.$fileInfo['extension'])) {
            return $microtime.'.'.$fileInfo['extension'];

        }
        /**
         * Retornamos false por defecto
         */
        return false;

    }


    public function getPhysicalFolder($directoryName){

        $fullFolderPath = $this->getPhysicalResourcesPath().$directoryName;

        $state = true;

        /**
         * Si la carpeta no existe la creamos
         */
        if (!file_exists($fullFolderPath))
        {
            /**
             * si no se ha creado
             */
            if(!mkdir($fullFolderPath, 0777)){
                $state = false;
            }   
        }

        if ($state) {

            return $fullFolderPath;
        }

    }

    /**
     * Funcion que guarda el nombre del nuevo directorio 
     * @param [type] $entityId         Identificador de la entidad
     * @param [type] $directoryName    nombre del directorio
     * @param [type] $parentEntityName nomnbre de la entidad padre
     */
    public function setEntityFolder($directoryName, $parentEntityId){


        return $this->saveEntityFolder($directoryName, $parentEntityId);
  

    }

    /**
     * [saveEntityFolder description]
     * @param  [type] $entityId               [description]
     * @param  [type] $directoryName          [description]
     * @param  [type] $resourceParentEntityId [description]
     * @return [type]                         [description]
     */
    public function saveEntityFolder($directoryName, $resourceParentEntityId){

            $this->ResourceEntityDirectories = TableRegistry::get('ResourceEntityDirectories');

            $newResourceEntityDirectory = $this->ResourceEntityDirectories->newEntity();

            $newData = Array(
            
                'directory'                     => $directoryName,
                
                'resource_parent_entities_id'   => $resourceParentEntityId
            
            );  

            $newResourceEntityDirectory = $this->ResourceEntityDirectories->patchEntity($newResourceEntityDirectory, $newData);
            
            if($this->ResourceEntityDirectories->save($newResourceEntityDirectory)){
               
               return $directoryName;
           
            }else{

                return false;
            }  

    }


    /**
     * Funcion que retorna el nombre del directorio definido para una entidad
     * @param  [type] $directoryName [description]
     * @return [type]                [description]
     */
    public function getEntityDirectory($parentEntityId){

        $this->ResourceEntityDirectories = TableRegistry::get('ResourceEntityDirectories');


        $found = $this->ResourceEntityDirectories->find('all',
            ['conditions'=>[
                    'ResourceEntityDirectories.resource_parent_entities_id' => $parentEntityId
                ]
            ]
        )->first();


        if($found){

            return $found->directory;

        }else{

            return false;
        }
        
    }


    /**
     * Función usada para insertar un nuevo recurso en la base de datos
     * @param  Int $users_id                    	Id del usuario
     * @param  String $stored_file_name             nombre del aruchiv guardado en disco
     * @param  String $name                        	Nombre del archivo
     * @param  Int $resource_extensions_id      	Identificador de la extensión
     * @param  Int $resource_parent_entities_id 	Identificador de la entidad padre
     * @return Boolean                              True si fue exitoso, false si ocurrio un error
     */
    public function insertIntoResources($users_id = null, $stored_file_name = null, $name = null, $resource_extensions_id = null, $resource_parent_entities_id = null, $resourceTypeId = null, $entity_id = null, $sizeBytes = null, $sizeFormat = null){


        $this->Resources = TableRegistry::get('Resources');

		$newResource = $this->Resources->newEntity();


		$newResourceData = Array(
		
			'users_id' 	            		=> 	$users_id,
		
			'stored_file_name' 				=> 	$stored_file_name,
		
			'name' 		            		=> 	$name,
		
			'resource_extensions_id'		=>  $resource_extensions_id,
        
            'resource_types_id'     		=>  $resourceTypeId,
		
			'resource_parent_entities_id' 	=>  $resource_parent_entities_id,
		
			'entity_id' 					=>  $entity_id,
        
            'size_format' 					=>  $sizeFormat,
        
            'bytes' 						=>  $sizeBytes
		
		);

        $newResource = $this->Resources->patchEntity($newResource, $newResourceData);


    	if(!$this->Resources->save($newResource)){
    		return false;
    	} 

    	return true; 

    }



    /**
     * Función que obtiene el identificador de una entidad padre
     * @param  String $parentEntityName nombre de la entidad padre
     * @return Int  Identificador de la entidad, boolean False si no existe
     */
    public function getParentEntityId($parentEntityName = null){

        
        $this->ResourceParentEntities = TableRegistry::get('ResourceParentEntities');

        $parentEntity =  $this->ResourceParentEntities->find('all',Array('conditions'=>array('ResourceParentEntities.name'=> $parentEntityName)))->first();

        if ($parentEntity) {
            
           return $parentEntity->id;
        }

         return false;
    }


    /**
     * Función que obtiene el identificador de una extensión 
     * @param  String $extension nombre de la exrensión
     * @return Int identificador de la extensión, boolean false en caso de no entrado 
     */
    public function getExtensionId($extension = null){

    	$this->ResourceExtensions = TableRegistry::get('ResourceExtensions');

        $resourceExtension = $this->ResourceExtensions->find('all', ['conditions'=> ['ResourceExtensions.extension' => $extension]])->first();
    
        if ($resourceExtension) {
    
            return $resourceExtension->id;
    
        }

        return false;
    }


    public function deleteResource($id, $entityId, $parentEntityName){

        $this->Resources = TableRegistry::get('Resources');

        $resource = $this->Resources->get($id);

        $fileName = $resource->stored_file_name;

        $serverPath = $this->getPhysicalResourcesPath(); 


        /**
         * Identificador de la entidad padre
         * @var Int
         */
        $parentEntityId = $this->getParentEntityId($parentEntityName);


        /**
         * verificamos si existe un directorio asociado a la entidad
         * @var String nombre, Boolean false en caso de no encontrarlo
         */
        $entityDirectory = $this->getEntityDirectory($parentEntityId);
    

        $filePath = $serverPath.$entityDirectory.'/'.$fileName;

        /**
         * Si el archivo existe procedemos a eliminarlo
         */
        if(file_exists($filePath)){

            unlink($filePath);
        }

        $this->Resources->delete($resource);

    }

    /**
     * Función que obtiene la fecha y hora actuales de un objeto DateTime
     * @return String Fecha Actual en formato numerico
     */
    public function getMicroTime(){
        
        ini_set('precision', 25);

		return str_replace('.', '', microtime(true));

    }


   /**
     * Función que devuelve la ruta del servidor donde se suben los archivos
     * @return String ruta
     */
    public function getPhysicalResourcesPath(){

    	return WWW_ROOT.'resources/';           

    }

    /**
     * Funcion que retorna la url del directorio 
     * @return String url
     */
    public function getResourcesPath(){
            
    	return Router::url('/'.'resources/', true);
    
    }


    /**
     * Función que convierte un arreglo de archivos subidos de una manera mas legible y fácil de manejar
     * @param  Array $vector Arreglo de archivos
     * @return Array Arreglo formateado
     */
    function diverse_array($vector) { 
        $result = array(); 
            foreach($vector as $key1 => $value1) 
                foreach($value1 as $key2 => $value2) 
                    $result[$key2][$key1] = $value2; 
            return $result; 
    } 


    /**
     * Función que obtiene información de un archivo
     * @param  File $file Archivo
     * @return Array Arreglo con la información del archivo
     */
    public function getFileInfo($file){

        $path_parts = pathinfo($file["name"]);

        $filename = trim($path_parts['filename']);
        $extension = $path_parts['extension'];
        $sizeBytes = $file['size'];

        $fileInfo = Array('name'=> $filename,'extension'=> $extension,'sizeBytes'=> $sizeBytes ,'sizeFormat'=> $this->formatSizeUnits($sizeBytes));
        return $fileInfo;

    }


     function formatSizeUnits($bytes)
        {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }




}
