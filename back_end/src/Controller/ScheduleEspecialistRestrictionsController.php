<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * ScheduleEspecialistRestrictions Controller
 *
 * @property \App\Model\Table\ScheduleEspecialistRestrictionsTable $ScheduleEspecialistRestrictions
 */
class ScheduleEspecialistRestrictionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specialists']
        ];
        $scheduleEspecialistRestrictions = $this->paginate($this->ScheduleEspecialistRestrictions);

        $this->set(compact('scheduleEspecialistRestrictions'));
        $this->set('_serialize', ['scheduleEspecialistRestrictions']);
    }

    /**
     * View method
     *
     * @param string|null $id Schedule Especialist Restriction id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->get($id, [
            'contain' => ['Specialists']
        ]);

        $this->set('scheduleEspecialistRestriction', $scheduleEspecialistRestriction);
        $this->set('_serialize', ['scheduleEspecialistRestriction']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->newEntity();
        
            $data = $this->request->data;

            $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->patchEntity($scheduleEspecialistRestriction, $data);
           
            if ($this->ScheduleEspecialistRestrictions->save($scheduleEspecialistRestriction)) {
           
                $success= true;
           
                $this->set(compact('success', 'scheduleEspecialistRestriction'));
           
            } else {
           
                $success = false;
           
                $errors = $scheduleEspecialistRestriction->errors();
           
                $this->set(compact('success', 'errors','scheduleEspecialistRestriction'));
           
            }

    }

    /**
     * Edit method
     *
     * @param string|null $id Schedule Especialist Restriction id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        if($id == null){
            $id=$this->request->data['Id'];
            $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->get($id, [
                'contain' => []
            ]);
        }


        if ($this->request->is(['patch', 'post', 'put'])) {

            $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->patchEntity($scheduleEspecialistRestriction, $this->request->data);

            if ($this->ScheduleEspecialistRestrictions->save($scheduleEspecialistRestriction)) {
                
                $success = true;   

            } else {
               $success = false;
               $errors=$scheduleEspecialistRestriction->errors();
                     
            }
        }

       $this->set(compact('success', 'scheduleEspecialistRestriction','errors'));     
    }

    /**
     * Delete method
     *
     * @param string|null $id Schedule Especialist Restriction id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $id = $this->request->data['id'];

        $scheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->get($id);

        if($this->ScheduleEspecialistRestrictions->delete($scheduleEspecialistRestriction))
        {
            $success = true;
            
        }else{
            $success = false;

        }

        $this->set(compact('success', 'scheduleEspecialistRestriction'));
    }

     /*
     *Method Get
     **/


     public function getScheduleEspecialistRestriction()
     {
        $data = $this->request->data;

        $offset = $data['offset'];

        $scheduleEspecialistRestrictions = $this->ScheduleEspecialistRestrictions->find('all', ['limit'=>10, 'offset'=>$offset])->toArray();

        $totalScheduleEspecialistRestriction = $this->ScheduleEspecialistRestrictions->find('all')->count();

        foreach ($scheduleEspecialistRestrictions as $scheduleEspecialistRestriction) {

            $scheduleEspecialistRestriction['date_ini'];
            $scheduleEspecialistRestriction['date_end'];
        }

        if($scheduleEspecialistRestrictions){

            $succes = true;

            $this->set(compact('success', 'scheduleEspecialistRestrictions', 'totalScheduleEspecialistRestriction'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }
     }
     
     


}
