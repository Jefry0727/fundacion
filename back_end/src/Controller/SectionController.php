<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Section Controller
 *
 * @property \App\Model\Table\SectionTable $Section
 */
class SectionController extends AppController
{

     public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['getSection']);

    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $section = $this->paginate($this->Section);

        $this->set(compact('section'));
        $this->set('_serialize', ['section']);
    }

    /**
     * View method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $section = $this->Section->get($id, [
            'contain' => ['Logging', 'Products']
        ]);

        $this->set('section', $section);
        $this->set('_serialize', ['section']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $section = $this->Section->newEntity();
        if ($this->request->is('post')) {
            $section = $this->Section->patchEntity($section, $this->request->data);
            if ($this->Section->save($section)) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }
        $logging = $this->Section->Logging->find('list', ['limit' => 200]);
        $this->set(compact('section', 'logging'));
        $this->set('_serialize', ['section']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $section = $this->Section->get($id, [
            'contain' => ['Logging']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $section = $this->Section->patchEntity($section, $this->request->data);
            if ($this->Section->save($section)) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }
        $logging = $this->Section->Logging->find('list', ['limit' => 200]);
        $this->set(compact('section', 'logging'));
        $this->set('_serialize', ['section']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Section id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $section = $this->Section->get($id);
        if ($this->Section->delete($section)) {
            $this->Flash->success(__('The section has been deleted.'));
        } else {
            $this->Flash->error(__('The section could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * [getSection description]
     * @return [type] [description]
     */
    public function getSection()
    {
        $sections = $this->Section->find('all')->toArray();

        if($sections)
        {
            $success = true;

            $this->set(compact('success', 'sections'));
        }else{

            $success = false;

            $this->set(compact('success'));
        }


    }
}
