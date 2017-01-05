<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RateStudies Controller
 *
 * @property \App\Model\Table\RateStudiesTable $RateStudies
 */
class RateStudiesController extends AppController
{



     public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['Studies', 'RatesClients','getRateStudies','getNewStudiesValues']);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Studies', 'RatesClients','getRateStudies','getNewStudiesValues']
        ];
        $rateStudies = $this->paginate($this->RateStudies);

        $this->set(compact('rateStudies'));
        $this->set('_serialize', ['rateStudies']);
    }

    /**
     * View method
     *
     * @param string|null $id Rate Study id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rateStudy = $this->RateStudies->get($id, [
            'contain' => ['Studies', 'RatesClients']
        ]);

        $this->set('rateStudy', $rateStudy);
        $this->set('_serialize', ['rateStudy']);

    }

    /**
     * consulta rate_studies
     */

    public function getRate()
    {
        
        $this->request->data;

        $idRatesClients = $data['rates_clients_id'];
        $idStudies = $data['studies_id'];

        $rate = $this->RateStudies->find('all',[

            'conditions'=>['RateStudies.rates_clients_id' =>  $idRatesClients, 'RateStudies.studies_id' => $idStudies]
            ]);

        // pr($rate);

        $this->set(compact('rate'));
    }

    public function getRateStudies()
    {
        
        $data = $this->request->data;

        $idRates = $data['idRate'];

        $idStudies = $data['idStudie'];

        $rate = $this->RateStudies->find('all',[

            'conditions'=>['RateStudies.rates_id' =>  $idRates, 'RateStudies.studies_id' => $idStudies]
            ])->Select(['RateStudies.value'])->toArray();

        // pr($rate);
        
    if ($rate) {

        $success = true;

        $this->set(compact('success','rate'));

    }else{

        $success = false;

        $this->set(compact('success'));

    }
}


    // Carlos Felipe Aguirre Taborda
    // 2016-11-04 14:29:00
    // Obtiene los valores de los estudios y productos segun sus IDs

    public function getNewStudiesValues()
    {


        $data = $this->request->data;

        $idRates = $data['idRate'];
        
        $servicesIds = $data['servicesIds'];
    
        
        $rate = $this->RateStudies->find('all',[

            'conditions'=>['RateStudies.rates_id' =>  $idRates, 'RateStudies.studies_id IN' => $servicesIds]
            ]);


        if ($rate) {
          $rate = json_decode( json_encode( $rate->toArray() ), true) ;

            // Si hay un estudio repetido
            if( count( $servicesIds ) > count( $rate ) ){
              
              $valores = array_count_values($servicesIds);
              $llaves = array_keys($valores);

              // Obtiene cuales son los  estudios repetidos
              for( $i = 0; $i < count( $llaves ); $i++ ){
                
                if( $valores[ $llaves[$i] ] > 1 ){
                  $repetidos[] = $llaves[$i];
                }
              
              }


              // añade el valor de los estudios repetidos a la respuesta
              for( $i = 0; $i < count($rate); $i++){

                if( !empty($repetidos) ){
                  for($b = 0; $b < count( $repetidos ); $b++ ){

                    if( !empty($rate) && !empty($llaves)){

                      if( $rate[$i]['studies_id'] == $llaves[$b] ){
                          $rate[ count($rate) ] = $rate[$i];
                          unset($llaves[$b]);
                      }

                    }
                  
                  }
                }

              }

            }


            $rate2 = [];
            

            // Se encarga de ordenar los valores en la repuesta 
            // para que coincidan con los que se tienen en la vista
            for( $i=0; $i < count( $servicesIds ); $i++ ){
              
              for($b =0; $b <count( $rate ); $b++ ){
                
                if( $servicesIds[$i] == $rate[$b]['studies_id'] ){
                  
                  $rate2[$i] = $rate[$b];
                
                }
              
              }
            
            }



            $rate=$rate2;
            
            // Ya se añadió el valor del estudio repetido
            

            $success = true;

            $this->set(compact('success','rate'));

        }else{

            $success = false;

            $errors = $rate->errors();

            $this->set(compact('success','errors'));

        }

    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rateStudy = $this->RateStudies->newEntity();
        if ($this->request->is('post')) {
            $rateStudy = $this->RateStudies->patchEntity($rateStudy, $this->request->data);
            if ($this->RateStudies->save($rateStudy)) {
                $this->Flash->success(__('The rate study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate study could not be saved. Please, try again.'));
            }
        }
        $studies = $this->RateStudies->Studies->find('list', ['limit' => 200]);
        $ratesClients = $this->RateStudies->RatesClients->find('list', ['limit' => 200]);
        $this->set(compact('rateStudy', 'studies', 'ratesClients'));
        $this->set('_serialize', ['rateStudy']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate Study id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rateStudy = $this->RateStudies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rateStudy = $this->RateStudies->patchEntity($rateStudy, $this->request->data);
            if ($this->RateStudies->save($rateStudy)) {
                $this->Flash->success(__('The rate study has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rate study could not be saved. Please, try again.'));
            }
        }
        $studies = $this->RateStudies->Studies->find('list', ['limit' => 200]);
        $ratesClients = $this->RateStudies->RatesClients->find('list', ['limit' => 200]);
        $this->set(compact('rateStudy', 'studies', 'ratesClients'));
        $this->set('_serialize', ['rateStudy']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate Study id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rateStudy = $this->RateStudies->get($id);
        if ($this->RateStudies->delete($rateStudy)) {
            $this->Flash->success(__('The rate study has been deleted.'));
        } else {
            $this->Flash->error(__('The rate study could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    
}
