<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
/**
 * InvimaCodes Controller
 *
 * @property \App\Model\Table\InvimaCodesTable $InvimaCodes
 */
class InvimaCodesController extends AppController
{



    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow([]);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $invimaCodes = $this->paginate($this->InvimaCodes);

        $this->set(compact('invimaCodes'));
        $this->set('_serialize', ['invimaCodes']);
    }

    /**
     * View method
     *
     * @param string|null $id Invima Code id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invimaCode = $this->InvimaCodes->get($id, [
            'contain' => ['ProductsDetails']
            ]);

        $this->set('invimaCode', $invimaCode);
        $this->set('_serialize', ['invimaCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->data;

        $resultado = $this-> InvimaCodes->find()
                                        ->where( ['code LIKE '=>'%'.$data['code'].'%'] )
                                        ->limit(1)
                                        ->toArray();
         if( empty( $resultado ) ){
             
             $resultado       = $this->InvimaCodes->newEntity();
             $data['created']  = date( 'Y-m-d H:i:s' );
             $data['modified'] = date( 'Y-m-d H:i:s' );
             $data['state']    = 1;

             $resultado = $this->InvimaCodes->patchEntity($resultado, $data);
             $this->InvimaCodes->save($resultado);
             

         }else{
             $resultado = $resultado[0];
         }

         $this->set( compact( 'resultado' ) );

    }

    /**
     * Edit method
     *
     * @param string|null $id Invima Code id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invimaCode = $this->InvimaCodes->get($id, [
            'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invimaCode = $this->InvimaCodes->patchEntity($invimaCode, $this->request->data);
            if ($this->InvimaCodes->save($invimaCode)) {
                $this->Flash->success(__('The invima code has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The invima code could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('invimaCode'));
        $this->set('_serialize', ['invimaCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Invima Code id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invimaCode = $this->InvimaCodes->get($id);
        if ($this->InvimaCodes->delete($invimaCode)) {
            $this->Flash->success(__('The invima code has been deleted.'));
        } else {
            $this->Flash->error(__('The invima code could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     *obtener un Invima code.
     * @return [type] [description]
     */
    public function getInvimaCodes(){

        $data= $this->request->data;
        $id = $data['id'];

        $invimaCode = $this->InvimaCodes->find('all');

        $invimaCode = $invimaCode->matching('ProductsDetails', function ($q) use ($id) {
            return $q->where(['ProductsDetails.products_id' =>$id ]);
        }); 
        if($invimaCode)
        {
            $success = true;

            $this->set(compact('success', 'invimaCode'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

    // INVIMA CODIGOS para un producto specifico. 
    public function getInvimaByProduc(){
         // $this->autoRender = false;

         // $id  = 2; 
        $data= $this->request->data;

        $id = $data['id'];
        

        $conn = ConnectionManager::get('default');



        $query = $conn->execute('
            SELECT distinct inv.id
            FROM invima_codes as inv  
            inner join product_details as prd 
            on inv.id = prd.invima_codes_id 
            where inv.id = 1 or prd.products_id ='.$id)->fetchAll('assoc');     


        if($query){
            $idList= [];
            foreach ($query as $row) {

                array_push($idList, $row['id']);
            }
            
            // pr($idList);

            $invimaCode = $this->InvimaCodes->find('all',
                ['conditions'=>['InvimaCodes.id in'=>$idList]])->toArray();
            
            // pr($invimaCode);
            
            if($invimaCode)
            {
                $success = true;

                $this->set(compact('success', 'invimaCode'));
            }else{
                $success = false;

                $this->set(compact('success'));

            }

            
        }else{
            
            $success = false;

            $this->set(compact('success'));

        }

    }
}
