<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Datasource\ConnectionManager;

/**
 * RipMedicamentos Controller
 *
 * @property \App\Model\Table\RipMedicamentosTable $RipMedicamentos
 */
class RipMedicamentosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $ripMedicamentos = $this->paginate($this->RipMedicamentos);

        $this->set(compact('ripMedicamentos'));
        $this->set('_serialize', ['ripMedicamentos']);
    }

    /**
     * View method
     *
     * @param string|null $id Rip Medicamento id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ripMedicamento = $this->RipMedicamentos->get($id, [
            'contain' => []
        ]);

        $this->set('ripMedicamento', $ripMedicamento);
        $this->set('_serialize', ['ripMedicamento']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ripMedicamento = $this->RipMedicamentos->newEntity();
        if ($this->request->is('post')) {
            $ripMedicamento = $this->RipMedicamentos->patchEntity($ripMedicamento, $this->request->data);
            if ($this->RipMedicamentos->save($ripMedicamento)) {
                $this->Flash->success(__('The rip medicamento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip medicamento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripMedicamento'));
        $this->set('_serialize', ['ripMedicamento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rip Medicamento id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ripMedicamento = $this->RipMedicamentos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ripMedicamento = $this->RipMedicamentos->patchEntity($ripMedicamento, $this->request->data);
            if ($this->RipMedicamentos->save($ripMedicamento)) {
                $this->Flash->success(__('The rip medicamento has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The rip medicamento could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ripMedicamento'));
        $this->set('_serialize', ['ripMedicamento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rip Medicamento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ripMedicamento = $this->RipMedicamentos->get($id);
        if ($this->RipMedicamentos->delete($ripMedicamento)) {
            $this->Flash->success(__('The rip medicamento has been deleted.'));
        } else {
            $this->Flash->error(__('The rip medicamento could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }




    // Carlos Felipe Aguirre Taborda
    // 2016-10-26
    // Este metodo agrega la información necesaria al rip de Medicamentos
    public function addRip($data){
        
        //Codigos de medicamentos
        $items = json_decode( $data['items'], true );

        $i=0;
        foreach( $items as $item ){
            if($item['type'] == '1'){
                $i++;
            }
        }
        if( $i < 1 ){
            return;
        }


        // Numero de factura
        $insertar['num_factura'] = $data['bill_number'];

        //  Codigo IPS
        $insertar['cod_ips']    = $data ['ips_code'];

        // Tipo de identificación
        $connection = ConnectionManager::get('default');
        $initial = $connection->execute("SELECT document_types.initials FROM document_types 
                                         INNER JOIN people ON people.document_types_id = document_types.id
                                         WHERE people.identification = " . $data['people_identification'])->fetchAll('assoc');

        $insertar['document_type'] = $initial[0]['initials'];

        // Numero de identificacion
        $insertar['identificacion'] = $data['people_identification'];

        // Numero de autorizacion
        $insertar['num_autorizacion'] = $data['order_consec'];

        // id de la tarifa
        $insertar['rates_id'] = $data['rates_id'];

        
        

            
        foreach($items as $item){
            if( $item['type'] == "1" ){
                $codes[] = $item[1];
            }
        }


        $insertar['cod_medicamento'] = json_encode($codes);

        // Nombre Medicamento

            
        foreach($items as $item){
            
            if($item['type'] == "1" ){
                $names[] = $item[2];
            }
        
        }
  

        $insertar['nombre_gen'] = json_encode($names);

        // Cantidad

            
        foreach($items as $item){
            
            if( $item['type'] == "1" ){
                $quatities[] = $item[3];
            }
        
        }
  

        $insertar['cantidad'] = json_encode($quatities);

        // Valor Unitario

            
        foreach($items as $item){
            
            if( $item['type'] == "1" ){

                $singleValues[] = ( float ) $item[4];
            }
        
        }

        $insertar['val_unitario'] = json_encode($singleValues);

        // Valor Total

            
        foreach($items as $item){
        
            if( $item['type'] == "1" ){
                $totalValues[] = ( float ) $item[5];
            }
        
        }
  

        $insertar['val_total'] = json_encode($totalValues);

        
        // Pos o no pos
        for( $i = 0; $i < count($items); $i++ ){
        
            if( $items[ $i ]['type'] == "1"){
                $isPost[] = 1;
            }

        }

        $insertar['tipo_medicamento'] = json_encode( $isPost );

        // Fecha
        $insertar['date'] = $data['bill_created'];

        // ID del cliente
        $insertar['clients_id'] = ( int ) $data['clients_id'];

        $ripMedicamento = $this->RipMedicamentos->newEntity();
        $ripMedicamento = $this->RipMedicamentos->patchEntity( $ripMedicamento, $insertar );
        $ripMedicamentoResult = $this->RipMedicamentos->save($ripMedicamento);
        
        if( !$ripMedicamentoResult ){
            
            $success = false;
            $errors = $ripMedicamentoResult->errors();
            $this->set( compact('success', 'errors') );
            exit();

        }


        
    }



    public function generateAM(){
        $data = $this->request->data;
        
        $resultado = $this->RipMedicamentos->query(
            "SELECT * FROM rip_medicamentos
             WHERE clients_id = " . $data['clientId'] . " 
             AND date >= '" . $data['dateIni'] . "' AND date <= '" . $data['dateEnd'] . "' 
             AND clients_id = '" . $data['clientId']
        )->toArray();

        $resultado = json_decode( json_encode( $resultado ), true );

        if( is_array($resultado) && !empty($resultado[0]) ){

            $llaves = array_keys($resultado[0]);

            for( $i = 0; $i < count( $resultado ); $i++  ){

                for( $b = 0; $b < count($llaves); $b++ ){

                    $resultado[$i][ $llaves[$b] ] = ( json_decode( $resultado[$i][ $llaves[$b] ] , true) != null)? json_decode( $resultado[$i][ $llaves[$b] ] , true) : $resultado[$i][ $llaves[$b] ] ;

                }
            

            }

            $textRip = "";

            for($i = 0 ; $i < count($resultado); $i++ ){
                
                $repeticiones = count( $resultado[$i]['cod_medicamento'] );
                
                for( $b=0; $b < $repeticiones; $b++ ){

                    $textRip .= preg_replace('/(\s)+/', '', $resultado[$i]['num_factura'] ) . "," . $resultado[$i]['cod_ips'] . "," .  $resultado[$i]['document_type'] .
                               "," . $resultado[$i]['identificacion'] . "," . $resultado[$i]['num_autorizacion'] . "," . $resultado[$i]['cod_medicamento'][$b] . "," . $resultado[$i]['tipo_medicamento'][$b] . "," . $resultado[$i]['nombre_gen'][$b] . ",,,," . $resultado[$i]['cantidad'][$b] . "," . $resultado[$i]['val_unitario'][$b] . "," . $resultado[$i]['val_total'][$b] . PHP_EOL;

                }

                
            }


            $this->createFileRip($textRip);
            $this->set(compact('textRip'));            
            

        }
        else{
            $this->createFileRip();
            $textRip = "No se encontaron resultados";
            $this->createFileRip($textRip);
            $this->set(compact('textRip'));
        }

        

        
    }


    private function createFileRip($message){
        
        $dir = $this->getPhysicalResourcesPath();

        $filePath = $dir.'rips/US.TXT';
            

        $handle = fopen($filePath, 'w') or die('No se puede abrir :  '.$filePath);

        fwrite($handle, $message);

        fclose($handle); 

    }


    public function getPhysicalResourcesPath(){

        return WWW_ROOT;           

    }

}
