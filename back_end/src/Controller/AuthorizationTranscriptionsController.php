<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AuthorizationTranscriptions Controller
 *
 * @property \App\Model\Table\AuthorizationTranscriptionsTable $AuthorizationTranscriptions
 */
class AuthorizationTranscriptionsController extends AppController
{


   public function initialize() 
   {
    parent::initialize();

    $this->Auth->allow(['getResultsByState']);


    $this->loadComponent('StringUtils');
}

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $authorizationTranscriptions = $this->paginate($this->AuthorizationTranscriptions);

        $this->set(compact('authorizationTranscriptions'));
        $this->set('_serialize', ['authorizationTranscriptions']);
    }



    public function verAll (){

    }



    public function getResultsByState()
    {

        $data = $this->request->data;

        $dateIni = $data['dateIni'];
        $dateEnd = $data['dateEnd'];
        $center = $data['center'];
        $state = $data['state'];
        $page = $data['offset'];
        $specialists =$data['specialists_id'];
        //pr($state);
        $this->loadModel('Results');
        $this->loadModel('Attentions');
        $results = $this->Results->find('all'
            ,['conditions'=>
            ['Results.state' => $state,'Results.id = (SELECT MAX(rs.id) FROM results rs WHERE rs.attentions_id = Attentions.id)','Results.specialists_id'=> $specialists,'Results.complement'=> 0
            ]]

            )
        ->matching(
            'Attentions',
            function( $q ) use ($dateIni,$dateEnd ){
                return $q->select(['date_time_ini'])-> where (['DATE(Attentions.date_time_ini) >='=>$dateIni,'DATE(Attentions.date_time_end) <='=>$dateEnd]);
            }
            ) ->matching('Attentions.Appointments',
            function( $q ){
                return $q->select(['id','observations']);
            }
            )
            ->matching('Attentions.Appointments.Orders',
                function( $q ) use ($center){
                    return $q->select(['order_consec'])->where(['centers_id' => $center]);
                }
                )
            ->matching('Attentions.Appointments.Studies',
                function( $q ){
                    return $q->select(['cup','name']);
                }
                )
            ->matching('Attentions.Appointments.Orders.Patients',
                function( $q ){
                    return $q->select(['id']);
                }
                )
            ->matching('Attentions.Appointments.Orders.Patients.People',
                function( $q ){
                    return $q->select(['identification','first_name','middle_name','last_name','last_name_two','gender','birthdate']);
                }
                )
            ->matching('Attentions.Appointments.Orders.Patients.People.DocumentTypes',
                function( $q ){
                    return $q->select(['type']);
                }
                )
            // ->matching('Results', function ($q)
            // {
            //    return $q-> where(['Results.id = (SELECT MAX(r.id) FROM results r WHERE r.attentions_id = Results.id)']);
            // })
            //->limit(30)
            //->page( $page )
            ->toArray();


       // var_dump($results);
        
            if($results){
                $success = true;

                $this->set(compact('success','results'));
            } else{

                $success = false;

                $this->set(compact('success'));
            }

        }
    }
