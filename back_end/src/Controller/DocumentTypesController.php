<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DocumentTypes Controller
 *
 * @property \App\Model\Table\DocumentTypesTable $DocumentTypes
 */
class DocumentTypesController extends AppController
{

      public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','token','index','getInitialDocumentType']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $documentTypes = $this->paginate($this->DocumentTypes);

        $this->set(compact('documentTypes'));
        $this->set('_serialize', ['documentTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => []
        ]);

        $this->set('documentType', $documentType);
        $this->set('_serialize', ['documentType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $documentType = $this->DocumentTypes->newEntity();
        if ($this->request->is('post')) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->data);
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The document type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('documentType'));
        $this->set('_serialize', ['documentType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $documentType = $this->DocumentTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $documentType = $this->DocumentTypes->patchEntity($documentType, $this->request->data);
            if ($this->DocumentTypes->save($documentType)) {
                $this->Flash->success(__('The document type has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The document type could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('documentType'));
        $this->set('_serialize', ['documentType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Document Type id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $documentType = $this->DocumentTypes->get($id);
        if ($this->DocumentTypes->delete($documentType)) {
            $this->Flash->success(__('The document type has been deleted.'));
        } else {
            $this->Flash->error(__('The document type could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }



public function getInitialDocumentType($value=''){

   $this->loadModel('DocumentTypes');

   $query = $this->DocumentTypes->find('all',['conditions'=>[
    'DocumentTypes.id'=>$value]])->select(['initials'])->first();

    return $query;

}


}
