<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\RequestActionTrait;
use Cake\Datasource\ConnectionManager;


require_once(ROOT . DS . 'vendor' . DS . "tecnick.com" . DS . "tcpdf" . DS . "tcpdf.php");
require_once(ROOT . DS . 'src' . DS . 'Controller' . DS . 'PeopleController.php');
require_once(ROOT . DS . 'src' .DS.'Controller' . DS . 'Component' . DS .'StringUtilsComponent.php');

/**
 * Results Controller
 *
 * @property \App\Model\Table\ResultsTable $Results
 */
class ResultsController extends AppController
{



    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['downloadPrev', 'getResultsAttention']);
        $this->loadComponent('StringUtils');



    }


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
        'contain' => ['Attentions', 'Specialists']
        ];
        $results = $this->paginate($this->Results);

        $this->set(compact('results'));
        $this->set('_serialize', ['results']);
    }

    /**
     * View method
     *
     * @param string|null $id Result id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $result = $this->Results->get($id, [
            'contain' => ['Attentions', 'Specialists']
            ]);

        $this->set('result', $result);
        $this->set('_serialize', ['result']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $result = $this->Results->newEntity();

        $datos = $this->request->data;

        $datos['content'] = preg_replace('/<\/?div>/i','',$datos['content']);
        $datos['content'] = preg_replace('/<p><br\/?><\/p>/i', PHP_EOL,$datos['content']);

        if ($this->request->is('post')) {

           $datos['created'] = date('Y-m-d H:i:s');

           $datos['users_id'] = $this->Auth->user('id');

            $result = $this->Results->patchEntity($result,$datos);

            if ($this->Results->save($result)) {

                $success = true;

                $this->set(compact('success','result'));

            } else {
               $success = false;

               $errors = $result->errors();

               $this->set(compact('success','errors'));
           }
       }

   }

    /**
     * Edit method
     *
     * @param string|null $id Result id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $id = $this->request->data['id'];

        $result = $this->Results->get($id, ['contain' => []
            ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $this->request->data['modified'] = date('Y-m-d H:i:s');

            $this->request->data['content'] = preg_replace('/<\/?div>/i','', $this->request->data['content']);
            $this->request->data['content'] = preg_replace('/<p><br\/?><\/p>/i', PHP_EOL, $this->request->data['content']);
            $result = $this->Results->patchEntity($result, $this->request->data);

            if ($this->Results->save($result)) {

                $success = true;

                $this->set(compact('success','result'));

            } else {

               $success = false;

               $errors = $result->errors();

               $this->set(compact('success','errors'));

           }

       }


   }

    /**
     * Delete method
     *
     * @param string|null $id Result id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $result = $this->Results->get($id);
        if ($this->Results->delete($result)) {
            $this->Flash->success(__('The result has been deleted.'));
        } else {
            $this->Flash->error(__('The result could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function getByAttention(){

       $data = $this->request->data;

       $idAttention  = $data['id'];
      

       $result = $this->Results->find('all',[
            /*'contain' =>  ['Specialists'],*/
            'conditions'=> ['Results.id = (SELECT MAX(rs.id) FROM results rs WHERE rs.attentions_id = '.$idAttention.')']])->first();

        if ($result) {

          $success = true;

          $this->set(compact('success','result'));

        }else{

          $success = false;

          $this->set(compact('success'));

        }
}
 
        // getSpecialistSignature


     // public function getResultByPerson(){

     //    $data = $this->request->data;
     //    // Obtiene numero documento del paciente. 
     //    $docPatient = data['id'];

     // }
     // 
     // 
     // 
     // 
     // 
     

  //------------------------------ IMPRESION DE RESULTADOS ----------------------------


    public function downloadPrev($order_code){

        $this->autoRender = false;
        
        //$this->response->file(WWW_ROOT.'/files/PrevioPedido.pdf', array('download' => true, 'name' => 'PrevioPedido.pdf'

        $this->response->file(WWW_ROOT.'/files/Resultado.pdf', array('download' => true, 'name' => 'Resultado_'.$order_code.'.pdf'));

    }

    // function puntos_cm ($medida, $resolucion=72)
    // {
    //    //// 2.54 cm / pulgada
    //    return ($medida/(2.54))*$resolucion;
    // }


    /**
     * Función de previsualizacion de Factura
     */
    public function prevResult()
    {

       // $this->autoRender = false;
        $data = $this->request->data;

        $resultado = $data['result'];
        $paciente = $data['people'];
        $specialista = $data['specialsita'];

        $photoPatien = $data['peoplePhoto'];
        $date = date("Y-m-d H:i:s");

        $specialist_name = ($specialista['person']['first_name'].' '.$specialista['person']['middle_name'].' '.$specialista['person']['last_name'].' '.$specialista['person']['last_name_two']);

        /*
        Obtiene el nombre del usuario logueado
        Carlos Felipe Aguirre
        2016-10-07
         */
        
        $PeopleController = new PeopleController();
        $persona = $PeopleController->view($this->Auth->user('people_id'));
        $_nombrePersona= $persona['first_name'] . ' ' . $persona['middle_name'] . ' ' . $persona['last_name'] . ' ' . $persona['last_name_two'];
        $_nombrePersona = $this->StringUtils->getInitials($_nombrePersona);
        /*ya se ha obtenido el nombre*/

      
        // Instanciacion
        $tcpdf = new XTCPDF(); 

        // $pdf->addText(puntos_cm(4),puntos_cm(26.7),12,'Encabezado');

        // Info del documento
        $tcpdf->SetAuthor("Gatoloco Studios S.A.S."); 

        // Usuario: '.$bills[0]['Bill']['user']
        
        // Informacion del ecabezado y footer
        $tcpdf->xheadertext = '
        <div style="font-size:8px; text-align:right;">' . $paciente['identification'] . '<b style="left:2em">  Fecha: '.date('Y-m-d').' '.date('H:i:s').'  Página'.$tcpdf->getAliasNumPage().' de '.$tcpdf->getAliasNbPages().'</b></div>
                    <table style="padding: 2px; width: 100%" border="0">
                        <tr style="font-size: 100% ; margin:2px;">
                            <td colspan="2">
                               <br><img src="img/logo_londono.png"><br>
                            </td>
                        </tr>
                
                    </table> 
                    
             '; 
        //  <tr>
        //   <img src="img/Franja-01.png" height="5px" width="100px">
        // </tr>
        
        // $tcpdf->variable = $opcion; // Set de la variable de validación de previsualización 
        $tcpdf->xfootertext = '
        <br>
            <div style="border-bottom-width: 2px; border-bottom-color: #2B5C9C; height: 10px;" ></div>
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
        $html ='';

        // informacion del paciente y el estudio realizado
       //  $html .= '

       //       <table style="padding: 2px; width:100%">
       //          <tr style="font-size: 70%">
       //              <td style="width:20%; text-align: center;">
       //                  <br><br>
       //                  <p style="text-align:left;"><img src="'.$photoPatien.'" style="width:80px; height:90px;" alt=""></p>
                       
                        
       //              </td>
       //              <td style="width:30%; text-align: left;">
       //                  <br><br>
                        
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Nombre:</p>
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Documento:</p>
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Entidad:</p>
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Genero/Edad:</p>
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Nº Orden:</p>
       //                  <p style="font-size:6px;  margin: -10px 0 0 0;">Fecha Atención:</p>


       //              </td>
                    
       //          </tr>
       //      </table>

       //      <br>

       //      <p style="text-align:center;">'.$resultado['study_code'].'</b> - <b>'.$resultado['study_name'].'</p>

       // <hr  >
       //  ';
       //  
       //  
           $html .= '

            <table style="padding: 2px; width: 95%;font-family:Verdana;  font-size: 10px; " 
            border="0" 
            cellspacing="0"
            > 
            <br>
            <br>


        <tr style="font-size: 8px;">
            <td rowspan="6" width=20%>
                <img src="'.$photoPatien.'"  style=" width:80px; height: 80px">
              </td>
            
            <td ><b>Paciente:</b> </td>
            <td style="margin: 1px;">'.$paciente['lastNames'].' '.$paciente['names'].'</td> <br>
        </tr>
          <tr style="font-size: 8px;">
            <td ><b>Documento:</b> </td>
            <td >'.$paciente['identification'].'</td> <br>
        </tr>
         <tr style="font-size: 8px;">
            <td ><b>Entidad:</b></td>
            <td>'.$resultado['client'].'</td><br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Genero/Edad:</b></td>
            <td>'.$paciente['genero'].' - '.$resultado['patient_edad'].'</td><br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Nº Orden:</b></td>
            <td>'.$resultado['order_code'].'</td> <br>
        </tr>
        <tr style="font-size: 8px;">
            <td ><b>Fecha Atención:</b></td>
            <td >'.$resultado['result_date'].'</td>
        </tr>
        <tr>
        <td colspan="3" style="font-size: 11px;" align="center">
                <br>
                <br>
                <b>'.$resultado['study_code'].'</b> - <b>'.$resultado['study_name'].'</b> 
                <br>
        </td>
        </tr>
         </table>
       
       <hr>
        ';

        // contenido del resultado
        $html .='
        <table style="padding-left:4px; width: 100%;"  border="0">
        <tr style="text-align:justify; font-family:Verdana; font-size:9px">
          <td>
            <p style="text-align:justify; font-family:Verdana; font-size:9px; margin:1px;">'.$resultado['result_content'].'</p>
            </td>  
        </tr>
        <tr>
              <td >
                <img src="'.$specialista['signature'].'"  style=" width:120px; height: 60px">
              </td>
            </tr>
                <tr>
                    <td  style="font-size: 8px;"><b>'.$specialist_name.'</b></td>
                </tr>
                <tr>
                    <td  style="font-size: 8px;"><b>'.$specialista['speciality'].'</b></td>
                </tr>
                <tr>
                    <td   style="font-size: 8px;"><b>'.$specialista['professionar_card'].'</b></td>
                </tr>
                <tr>
                    <td  style="font-size: 6px;" ><b>'.$_nombrePersona.'</b> </td>
                </tr>
        <br>
        </table>
        ';



        // Firma del Medico
        $html .='';
       

        // output the HTML content
        $tcpdf->writeHTML($html, true, false, true, false, '');

        // output the HTML content
        //$tcpdf->writeHTML($html, true, false, true, false, '');
        // if ($opcion == 1)
        // {
        
        $tcpdf->Output(WWW_ROOT.'files/Resultado.pdf', 'F');

            
        // $this->response->file(WWW_ROOT.'/files/PrevioResult.pdf', array('download' => true, 'name' => 'PrevioResult.pdf'));

        // }
        // else
        // {
        //     echo 'pase';
        //     $tcpdf->Output(WWW_ROOT.'/files/Pedido_'.$this->Session->read('User.userId').'.pdf', 'F');
        // }


        }
//bbbbb

    }

//aaaaaaaaaa
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
