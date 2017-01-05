<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Datasource\ConnectionManager;

/**
 * Studies Controller
 *
 * @property \App\Model\Table\StudiesTable $Studies
 */
class StudiesController extends AppController
{
    public function initialize()
        {
            parent::initialize();
            $this->Auth->allow(['add','edit','delete','index','get','getBySpecialization', 'getServicesProducts']);
        } 

        /**
         * [getServicesProducts description]
         * @author Luis David Lemir Aguirre <ldlemir@gmail.com>
         * @date     2016-11-02
         * @datetime 2016-11-02T11:42:27-0500
         * @return   [type]                   [Obtiene los productos que pertenecen a un servicio]
         */
    public function getServicesProducts(){

    $connection = ConnectionManager::get('default');

    $data = $this->request->data;

    $idStudy = $data['idStudy'];

    $idService = $data['idService'];

    $products = $connection->execute("SELECT DISTINCT *
        FROM studies
        INNER JOIN (products_studies, services, services_has_products, products)
        ON studies.id = products_studies.studies_id
        AND products_studies.servicises_id = services.id
        AND services.id = services_has_products.services_id
        AND services_has_products.products_id = products.id
        WHERE studies.id = $idStudy
        AND services.id = $idService
        ")->fetchAll('assoc');

    if($products){

        $success = true;

        $this->set(compact('success', 'products'));

    }else{

        $success = false;

        $errors = $products->errors();

        $this->set(compact('success','errors'));
    }

    }     

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $studies = $this->paginate($this->Studies);

        $this->set(compact('studies'));
        $this->set('_serialize', ['studies']);
    }

    /**
     * Get all the studies 
     * @return [type] [description]
     */
      public function get(){

        $studies = $this->Studies->find('all')->toArray();
        
         if ($studies) {
        
            $success = true;

            $this->set(compact('success','studies'));
    
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }
    //Filtra los studios por centros de costos. 
    public function getBySpecialization(){

            $data = $this->request->data;

            $idSpecialization  = $data['idSpecialization']; 

            $this->loadModel('Specializations');
            
            // $specializations = $this->Specializations->find('all',
            //         ['conditions'=>['Specializations.cost_centers_id' => $idSpecialization]]
            // )->select(['Specializations.id']);

       
            $studies = $this->Studies->find('all', ['conditions'=>['Studies.specializations_id IN' => $idSpecialization]])->toArray();
        
         if ($studies) {
        
            $success = true;

            $this->set(compact('success','studies'));
       
        }else{
        
            $success = false;

            $this->set(compact('success'));

        }
        
    }



    /**
     * Función que se encarga de buscar los servicios por codigo cup o por nombre
     * @return [type] [description]
     */
    public function queryStudies($data, $client = null,$rate = null,$term){
        $rates_id = $rate;

        $this->autoRender = false;

        /**
         * data id Centro de costos.
         */
        
        $this->loadModel('Specializations');
        
        $specializations = $this->Specializations->find('all',
                ['conditions'=>['Specializations.cost_centers_id' => $data]]
            )->select(['Specializations.id']);

        /**
         * Si es tipo 1 buscar por nombre
         * @var Int
         */
        if(is_numeric($term)){

            $services = $this->Studies->find('all',['contain' => ['Specializations.CostCenters','Services','StudiesInformedConsents','Instructives'],
             'conditions'=>
             ["Studies.cup like '%".$term."%' ",
             'Studies.specializations_id IN' => $specializations,
             'Studies.id IN (SELECT studies_id 
                            FROM rate_studies  
                            INNER JOIN rates_clients ON rate_studies.rates_id = rates_clients.rates_id 
                            WHERE  rates_clients.rates_id = '.$rate.'  AND rates_clients.clients_id = '.$client.' )'
             ]]);

            // $services = $services->matching(
            //     'RateStudies', 
            //     function( $q) use($rate){
            //         return $q->Where(
            //             ['RateStudies.rates_id'=>$rate, 
            //             'RateStudies.studies_id'=> 'Studies.id']);
            // })->toArray();


            $services = json_decode( json_encode( $services ), true );
            

            foreach($services as $llave => $valor){
                $services[ $llave ]['products'] = $valor['services']; 
                unset( $services[ $llave ]['services'] );
                

                // Si el estudio poseé productos relacionados entonces obtiene los 
                // IDs de los productos
        
                if( !empty( $services[ $llave ]['products'] ) ){
                
                    for( $i = 0; $i < count( $services[ $llave ]['products'] ); $i++ ){
                        
                        $idProductos[]=$services[ $llave ]['products'][$i]['id'];
                    
                    }
                
                }

            }

            
        
        /**
         * De lo contrario buscar por codigo cup
         */
        }else{
            
            $services = $this->Studies->find('all',['contain' => 
                ['Specializations.CostCenters','Services','StudiesInformedConsents','Instructives'], 
                'conditions'=>
                ["Studies.name like '%".$term."%' " ,
                'Studies.specializations_id IN' => $specializations,
                          'Studies.id IN (SELECT studies_id 
                            FROM rate_studies  
                            INNER JOIN rates_clients ON rate_studies.rates_id = rates_clients.rates_id 
                            WHERE  rates_clients.rates_id = '.$rate.'  AND rates_clients.clients_id = '.$client.' )']
                            ]);

            
            $services = json_decode( json_encode( $services ), true );
            
            foreach($services as $llave => $valor){
                $services[ $llave ]['products'] = $valor['services']; 
                unset( $services[ $llave ]['services'] );
                
            
                // Si el estudio poseé productos relacionados entonces obtiene los 
                // IDs de los productos

                if( !empty( $services[ $llave ]['products'] ) ){
                
                    for( $i = 0; $i < count( $services[ $llave ]['products'] ); $i++ ){
                        
                        $idProductos[]=$services[ $llave ]['products'][$i]['id'];
                    
                    }
                
                }

            }

       

            

        }

        // Si hay IDs de productos entonces obtiene el precio, cup, id
        if(!empty($idProductos)){
            
            $conection = ConnectionManager::get('default');
            
            for($i = 0; $i < count($idProductos); $i++){        

                $res=$conection->execute(
                    'SELECT services.id,rate_services.value,rate_services.value as cost,services.cup 
                     FROM rate_services INNER JOIN services ON rate_services.servicises_id = services.id
                     WHERE rate_services.rates_id = ' . $rates_id . ' AND rate_services.state = 1 AND services.id=' . $idProductos[$i]
                )->fetchAll('assoc');
                    
                if(!empty($res)){
                    $services_details[] = $res[0];
                }
            }
        }

             
        // Pone los datos en valor adecuado dentro del array de respuesta
        for( $i = 0; $i < count($services); $i++ ){


            if( !empty($services_details) ){
                for($b=0; $b<count($services_details); $b++){
                    
                    // Si la consulta de la respuesta
                    if(!empty($services[$i]['products'])){
                       
                        for( $c = 0; $c < count( $services[$i]['products'] ); $c++){

            
                            // Compara los productos del estudio y con los ids de los productos que se consultaron
                            // y si coinciden los combina en uno solo
                            if( $services[$i]['products'][$c]['id'] ==  $services_details[$b]['id'] ){
                                
                                $services[$i]['products'][$c] = array_merge( $services[$i]['products'][$c], $services_details[$b] );
                            
                            }
                            
                        
                        }
                    
                    }
                }
            }
        }    


        /**
         * url de instructivos
         */
        $url = Router::url('/'.'resources/', true).'instructives/';

     //   var_dump($services[0]->study->services);
        
        //var_dump($services);

        echo json_encode(Array('services'=>$services));

        // $this->set(compact('services'));


    }



    /**
     * View method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $study = $this->Studies->get($id, [
            'contain' => []
        ]);

        $this->set('study', $study);
        $this->set('_serialize', ['study']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $study = $this->Studies->newEntity();
        if ($this->request->is('post')) {
            $study = $this->Studies->patchEntity($study, $this->request->data);
            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The study could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('study'));
        $this->set('_serialize', ['study']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $study = $this->Studies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $study = $this->Studies->patchEntity($study, $this->request->data);
            if ($this->Studies->save($study)) {
                $this->Flash->success(__('The study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The study could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('study'));
        $this->set('_serialize', ['study']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Study id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $study = $this->Studies->get($id);
        if ($this->Studies->delete($study)) {
            $this->Flash->success(__('The study has been deleted.'));
        } else {
            $this->Flash->error(__('The study could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
