<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ResultProfiles Controller
 *
 * @property \App\Model\Table\ResultProfilesTable $ResultProfiles
 */
class ResultProfilesController extends AppController
{   

    private $pre;

        public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['addResultProfile','getAllStudies', 'getResultProfile', 'getContentStudies', 'editResultProfile', 'deleteResultProfile', 'getAllResultsProfile', 'getContentUpdate', 'preResultProfile', 'downloadPrev']);
    }
    /**
     * [getAllStudies description]
     * Obtine la lista de los estudios por cada Especialista Seleccionado
     * @return [type] [description]
     */
    public function getAllStudies()
    {
        $data = $this->request->data;

        $idSpecialist = $data['specialists_id'];

        $resultProfile = $this->ResultProfiles->find('all', ['contain'=>['Studies'], 
            'conditions'=>['ResultProfiles.specialists_id'=> $idSpecialist]
            ])->toArray();

        if($resultProfile)
        {
            $success = true;

            $this->set(compact('success', 'resultProfile'));

        }else{

            $success = false;

            $this->set(compact('success'));
        }
    }

    /**
     * [getResultProfile description]
     * Lista de los Resultados de Perfiles 
     * @return [type] [description]
     */
    public function getResultProfile()
    {
        $data = $this->request->data;

        $idSpecialist = $data['specialists_id'];
        
        $idStudie = $data['studies_id'];

        $resultProfile = $this->ResultProfiles->find('all',
            ['conditions'=>['ResultProfiles.specialists_id'=> $idSpecialist, 'ResultProfiles.studies_id'=>$idStudie]]
            )->toArray();

        if($resultProfile)
        {
            $success = true;

            $this->set(compact('success', 'resultProfile'));

        }else{

            $success = false;

            $this->set(compact('success'));

        }
    }

    /** [getContentUpdate description] Contenido de la plantilla */
    public function getContentUpdate()
    {
        $data = $this->request->data;

        $id = $data['idProfile'];

        $resultProfile = $this->ResultProfiles->find('all',
            ['conditions'=>['ResultProfiles.id'=> $id]]
            )->first();

        if($resultProfile)
        {
            $success = true;

            $this->set(compact('success', 'resultProfile'));

        }else{

            $success = false;

            $this->set(compact('success'));

        }
    }




    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Specialists', 'Studies']
        ];
        $resultProfiless = $this->paginate($this->ResultProfiles);

        $this->set(compact('resultProfiles'));
        $this->set('_serialize', ['resultProfiles']);
    }

    /**
     * View method
     *
     * @param string|null $id Result Profile id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $resultProfile = $this->ResultProfiles->get($id, [
            'contain' => ['Specialists', 'Studies']
        ]);

        $this->set('resultProfile', $resultProfile);
        $this->set('_serialize', ['resultProfile']);
    }

 

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resultProfile = $this->ResultProfiles->newEntity();
        if ($this->request->is('post')) {
            $resultProfile = $this->ResultProfiles->patchEntity($resultProfile, $this->request->data);
            if ($this->ResultProfiles->save($resultProfile)) {
                $this->Flash->success(__('The result profile has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The result profile could not be saved. Please, try again.'));
            }
        }
        $specialists = $this->ResultProfiles->Specialists->find('list', ['limit' => 200]);
        $studies = $this->ResultProfiles->Studies->find('list', ['limit' => 200]);
        $this->set(compact('resultProfile', 'specialists', 'studies'));
        $this->set('_serialize', ['resultProfile']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Result Profile id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editResultProfile()
    {
        $id = $this->request->data['id'];

        $resultProfile = $this->ResultProfiles->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $resultProfile = $this->ResultProfiles->patchEntity($resultProfile, $this->request->data);

            if ($this->ResultProfiles->save($resultProfile)) {

                    $success = true;

                    $this->set(compact('success', 'resultProfile'));           

            } else {

                    $success = false;

                    $this->set(compact('success'));
                
            }
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Result Profile id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function deleteResultProfile($id = null)
    {

        $id = $this->request->data['id'];

        $this->request->allowMethod(['post', 'delete']);

        $resultProfile = $this->ResultProfiles->get($id);

        if ($this->ResultProfiles->delete($resultProfile)) {
           
           $success = true;

           $this->set(compact('success', 'resultProfile'));

        } else {
            
            $success = false;

            $this->set(compact('success'));

        }
       
    }


    public function addResultProfile(){

        $resultProfiles = $this->ResultProfiles->newEntity();

        if ($this->request->is('post')) {


            $resultProfiles = $this->ResultProfiles->patchEntity($resultProfiles, $this->request->data);

            if ($this->ResultProfiles->save($resultProfiles)) {

                $success = true;

                $this->set(compact('success','resultProfiles'));

            } else {
               $success = false;

               $errors = $resultProfiles->errors();

               $this->set(compact('success','errors'));
           }
       }


    }

  public function getContentStudies()
  {

    $data = $this->request->data;

    $id = $data['id'];

    $resultProfileContent = $this->ResultProfiles->find('all', ['conditions'=>['ResultProfiles.id' => $id]])->first();

    if($resultProfileContent){

        $success = true;

        $this->set(compact('success', 'resultProfileContent'));

    }else{

        $success = false;

        $this->set(compact('success'));

    }

  }


  public function getAllResultsProfile(){

      $data = $this->request->data;

        $idSpecialist = $data['idSpecialist'];
        
        $idStudie = $data['idStudie'];

        $resultProfile = $this->ResultProfiles->find('all',
            ['conditions'=>['ResultProfiles.specialists_id'=> $idSpecialist, 'ResultProfiles.studies_id'=>$idStudie]]
            )->toArray();

        if($resultProfile)
        {
            $success = true;

            $this->set(compact('success', 'resultProfile'));

        }else{

            $success = false;

            $this->set(compact('success'));

        }


  }

  // -----------------------------------------PDF------------------------------------------
  /**
   * Impresion de resultados.
   * Generacion del PD con el resulado
   * @author Deicy Rojas <deirojas.1@gmail.com>
   * @date     2016-12-01
   * @datetime 2016-12-01T15:43:02-0500
   * @return   [type]                   [description]
   */
  public function preResultProfile()
    {

        // $this->autoRender = false;
        $data = $this->request->data;

        $this->pre = $data['pre'];

        $peopleName = $data['peopleName'];

        $order = $data['order'];

        $sex = $data['sex'];

        $appointment = $data['appointment'];

        $summernote = $data['summernote'];

        $specialistSelected = $data['specialistSelected'];

        //$picturePatient = $data['picture'];

        //$firmSpecialist = $data['firmSpecialist'];

        $firmSpecialist = $data['firmSpecialist'];

        $validate = $data['validate'];

        var_dump($data['validate']);
        // exit();


      
        // Instanciacion
        $tcpdf = new XTCPDF(); 

        // $pdf->addText(puntos_cm(4),puntos_cm(26.7),12,'Encabezado');

        // Info del documento
        $tcpdf->SetAuthor("Gatoloco Studios S.A.S."); 

        // Usuario: '.$bills[0]['Bill']['user']
        
        // Informacion del ecabezado y footer
        $tcpdf->xheadertext = '
        <div style="font-size:8px; text-align:right;"><b>'.$peopleName['identification'].' - Fecha: '.date('Y-m-d').' '.date('H:i:s').'  Página'.$tcpdf->getAliasNumPage().' de '.$tcpdf->getAliasNbPages().'</b></div>
                    <table style="padding: 2px; width: 100%" border="0">
                        <tr style="font-size: 100%">
                            <td colspan="2">
                               <br><img src="img/logo_londono.png">
                            </td>
                        </tr>
                    </table> 
                    <br>
                    <br>
             ';  
        //  <tr>
        //   <img src="img/Franja-01.png" height="5px" width="100px">
        // </tr>
        
        // $tcpdf->variable = $opcion; // Set de la variable de validación de previsualización 
        $tcpdf->xfootertext = '
        <br>
            <div style="border-bottom-width: 4px; border-bottom-color: #2B5C9C; height: 10px;" ></div>
        <br>
         <table style="padding: 2px; width: 95%" border="0">
            <tr style="font-size: 70%;">        
                <td style=" text-align: left; font-size:7px;">
                   Sede Norte: Carrera 15 # 1Norte - 49 Armenia, Quindío<br>
                   Sede Sur: Carrera 18 # 43 - 70 Esquina Armenia, Quindío<br>
                   PBX: (6) 7455566&nbsp;&nbsp;&nbsp;&nbsp; FAX: (6) 7455566 Ext. 8<br>
                   <span style="text-decoration:underline; color:#1F1A5A">citas@fundacionalejandrolondono.com</span>
                </td>
                <td style="text-align: right; font-size:7px;"> 
                        <i>Visitanos en:</i>
                        <br> < style="text-decoration:underline; color:#1F1A5A">www.fundacionalejandrolondono.com</span>
                        <br> <span style="text-decoration:underline; color:#1F1A5A">www.facebook.com/FundacionAlejandroLondono.Oficial</span>
                        <br> <span style="text-decoration:underline; color:#1F1A5A">info@fundacionalejandrolondono.com</span>
                </td>
            </tr>
            <tr> 
             <td colspan="2" align="center">
                    <b>Original</b>
                  </td>
                </tr>
            </table>

            ';
        
        // Fuentes del doc
        $textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 
        //$tcpdf->SetFont('Verdana', '', 10);
        // Margenes 
        // $tcpdf->SetMargins(10, 63, 3, false);


        /**
         * inicio de contenido
         */
        $tcpdf->SetMargins(25,40, 25, false);


        $tcpdf->SetHeaderMargin(18);
        $tcpdf->SetFooterMargin(70);
        
        // Cambio de pagina
        $tcpdf->SetAutoPageBreak(true, 40); 
        
        //$tcpdf->setHeaderFont(array($textfont,'',40)); 
        //$tcpdf->xheadercolor = array(150,0,0); 

        // Validacion para la aparicion tanto del header como del footer
        $tcpdf->SetPrintHeader(true);
        $tcpdf->SetPrintFooter(true);

        // Adicion de nueva pagina con tamaño predefinido en mm
        //$resolution= array(216, 279);
        $resolution= array(216, 279);
        $tcpdf->AddPage('P', $resolution);
        
        setlocale(LC_MONETARY, 'en_US');
        
        //$tcpdf->SetFont('freesans', '', 12);
            
        //-----------------------  Contenido del pdf -----------------------------------
       $html .= '

          <table style="padding: 2px; width: 95%;font-family:Verdana;  font-size: 10px; " 
            border="0" 
            cellspacing="0"
            > 
            <br>
            <br>

        <tr style="font-size: 8px;">
            <td rowspan="6" width=20%>
               <img src="'.$picturePatient.'"  style=" width:80px; height: 80px">
              </td>
            
            <td ><b>Paciente:</b> </td>
            <td style="margin: 1px;">'.$peopleName['first_name'].' '.$peopleName['middle_name'].' 
            '.$peopleName['last_name'].' '.$peopleName['last_name_two'].'</td> <br>
        </tr>
          <tr style="font-size: 8px;">
            <td ><b>Documento:</b> </td>
            <td >'.$peopleName['identification'].'</td> <br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Entidad:</b></td>
            <td>'.$order['client']['name'].'</td><br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Genero/Edad:</b></td>
            <td>'.$sex.' '.$order['calculated_age'].'</td><br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Nº Orden:</b></td>
            <td>'.$order['order_consec'].'</td> <br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Fecha Atención:</b></td>
            <td >'.$peopleName['created'].'</td>
        </tr>

        <tr>
        <td colspan="3" style="font-size: 11px; text-align:center;" >
                <br>
                <br>
                <b>'.$appointment['study']['cup'].'</b> - <b>'.$appointment['study']['name'].'</b> 
                <br>
        </td>
        </tr>
         </table>
           
       <hr  >
        ';

         // contenido del resultado
        $html .='
        <table style="padding-left:4px; width: 100%;"  border="0">
        <tr style="text-align:justify; font-family:Verdana; font-size:9px">
          <td>
            <p style="text-align:justify; font-family:Verdana; font-size:9px; margin:1px;">'.$summernote.'</p>
            </td>  
        </tr>';

    if($validate == false){

          $html .='<br> <br><br>';
        
            }else{
             $html .='
              <tr>
              <td >
                <img src="'.$firmSpecialist.'"  style=" width:120px; height: 60px">
              </td>
            </tr>';

            }

            $html .='<tr>
                    <td  style="font-size: 8px;"><b>'.$specialistSelected['person']['first_name'].' 
                    '.$specialistSelected['person']['middle_name'].' '.$specialistSelected['person']['last_name'].' '.$specialistSelected['person']['last_name_two'].'.</b></td>
                </tr>
                <tr>
                    <td  style="font-size: 8px;"><b>'.$specialistSelected['speciality'].'</b></td>
                </tr>
                <tr>
                    <td   style="font-size: 8px;"><b>'.$specialistSelected['professionar_card'].'</b></td>
                </tr>
                <tr>
                    <td  style="font-size: 6px;" ><b></b> </td>
                </tr>
                <p>'.$picture['stored_file_name'].'</p>
        <br>';
    
    $html .='</table>';

        // output the HTML content
        $tcpdf->writeHTML($html, true, false, true, false, '');

        // output the HTML content
        //$tcpdf->writeHTML($html, true, false, true, false, '');
        // if ($opcion == 1)
        // {
        
        $tcpdf->Output(WWW_ROOT.'files/PrevioResultProfile'.''.'.pdf', 'F');

            
       

        // }
        // else
        // {
        //     echo 'pase';
        //     $tcpdf->Output(WWW_ROOT.'/files/Pedido_'.$this->Session->read('User.userId').'.pdf', 'F');
        // }


        }


      public function downloadPrev($data, $order_consec){

        // var_dump($order_consec);

        // exit;
        
        if($data == 'true'){
            $this->response->file(WWW_ROOT.'/files/PrevioResultProfile.pdf', array('download' => true, 'name' => 'Previo_Resultado.pdf'));

        }else{

            $this->response->file(WWW_ROOT.'/files/PrevioResultProfile.pdf', array('download' => true, 'name'=>'Resultado_'.$order_consec.'.pdf'));
        }

        $this->autoRender= false;

        
           
      }
   
}

  class XTCPDF extends \TCPDF
    {
        var $xfooterfont  = PDF_FONT_NAME_MAIN ;
        //var $xfooterfontsize = 8 ;

        function Header()
        {
            
            //list($r, $b, $g) = $this->xheadercolor;
            $this->setY(15);
            //$this->SetFillColor($r, $b, $g);
            //$this->SetTextColor(0 , 0, 0);
            //$this->Cell(0,20, '', 0,1,'C', 1);
            //$this->Text(15,26,$this->xheadertext );
            
            
            $this->writeHTML($this->xheadertext, true, false, true, false, '');
            
            // Transformacion para la rotacion de el numero de orden y el contenedor de la muestra
            $this->StartTransform();
            $this->SetFont('freesans', '', 5);
            $this->Rotate(-90, 116, 120);
            //$tcpdf->Rect(39, 50, 40, 10, 'D');
            // $this->Text(5, 30, 'Software de Administración Médica "SAM" V.1.1 ® - www.gatolocostudios.com ®');
            // Stop Transformation
            $this->StopTransform();
            
            // if ( $this->variable == 1 )
            // {
                // draw jpeg image                         x,  y  ancho, alto
                // $this->Image(WWW_ROOT.'/img/BORRADOR.png', 40, 60, 450, 250, '', '', '', true, 72);

                // restore full opacity
                $this->SetAlpha(0);
            // }
            
        }

        function Footer()
        {
            //$year = date('Y');
            //$footertext = sprintf($this->xfootertext, '');
            $this->SetY(-50);
            //$this->SetTextColor(0, 0, 0);
            //$this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
            $this->writeHTML($this->xfootertext, true, false, true, false, '');
            //$this->Cell(0,8, $footertext,'T',3,'L');
        }

       



    }
