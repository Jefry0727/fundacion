<?php
namespace App\Controller;

use App\Controller\AppController;


/**
 * PhpExcel
 */
require_once(ROOT . DS . 'vendor' . DS . "PHPExcel" . DS . "Classes" . DS . "PHPExcel.php");

/**
 * Para Usar la clase ConnectionManager
 * Deicy Rojas H.
 */
use Cake\Datasource\ConnectionManager;

// use App\Controller\PHPExcel;

class ExcelGeneratorController extends AppController {


  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow([
      'generateExcel',
      'gexcel',
      'generateExcelTemplate',
      'pastGenerateExcel',
      'downloadRes',
      'getBirads']);
  }


    /**
       * Función que devuelve la ruta del servidor donde se suben los archivos
       * @return String ruta
       */
    public function getPhysicalResourcesPath(){

      return WWW_ROOT;           

    }


    public function alphabet(){

      return Array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    }

    public function getBirads($value='')
    {
  //Obtiene resultados sin prestamo de placas
    //  var_dump($value);

      $this->loadModel('Birads');

      $query = $this->Birads->find('all',['conditions'=>[
        'Birads.results_id'=>$value]])->select(['birad'])->first();

      return $query;


    }

/**
 * Funcion para obtener las siglas del documento de identidad.
 * @author Deicy Rojas <deirojas.1@gmail.com>
 * @date     2016-10-20
 * @datetime 2016-10-20T15:04:09-0500
 * @param    string                   $value [description]
 * @return   [type]                          [description]
 */
public function getSiglasDocumentType($value=''){

 $this->loadModel('DocumentTypes');

 $query = $this->DocumentTypes->find('all',['conditions'=>[
  'DocumentTypes.id'=>$value]])->select(['initials'])->first();

 return $query;

}




public function getSiglasGender($value=''){

 $this->loadModel('Gender');

 $query = $this->Gender->find('all',['conditions'=>[
  'Gender.id'=>$value]])->select(['initials'])->first();

 return $query;


}
    /**
     * Funcion para descargar un archivo.
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-10-10
     * @datetime 2016-10-10T10:45:12-0500
     * @return   [type]                   [description]
     */
    public function downloadRes(){

      $this->autoRender = false;

        // $this->response->file(WWW_ROOT.'/files/PrevioPedido.pdf', array('download' => true, 'name' => 'Factura_'. rand(1000, 9999) .'.pdf'));

      $this->response->file(WWW_ROOT.'/excel/Reporte4505.xls', array('download' => true, 'name' => 'Reporte4505.xls'));

    }



    /**
     * Generar Plantilla de exel del la resolucion 4505
     * @author Deicy Rojas <deirojas.1@gmail.com>
     * @date     2016-10-19
     * @datetime 2016-10-19T12:25:14-0500
     * @return   [type]                   [description]
     */
    public function generateExcelTemplate(){

     $this->autoRender = false;
          /**
           * Datos que llegan.. hasta el momento.
           * @var [type]
           */
          
          $data = $this->request->data();
          //Datos de la consulta.
          $model = $data['model'];
          // informacion del cliente.
          $client = $model['client'];
          //Resultado de la consulta.
          $registros = $data['data'];

        //  var_dump($client);


          $fecha = date("Ymd");
          $codHabilitacion ='800135582S01';
          $name = 'SGD280RPED'.$fecha.'NI'.$codHabilitacion.'.TXT';

          $codARS = $client['ars_code'];

          $fechaInicio =$model['dateStart'];
          $fechaFinal = $model['dateEnd'];
          
          //$numRegistros = count($registros);
          //numero de registros ingresado en el informe
          $numRegistros = 0;

          $objPHPExcel = new \PHPExcel();

          $objPHPExcel->setActiveSheetIndex(0);
          
          $objPHPExcel->getProperties()->setCreator("Gato Loco Studios S.A.S.")
          ->setLastModifiedBy("Gato Loco Studios S.A.S.")
          ->setTitle("Reporte Ingresos")
          ->setSubject("Office 2007 XLSX Test Document")
          ->setDescription("Reporte Ingresos.")
          ->setKeywords("office 2007 openxml php")
          ->setCategory("Test result file");


          $xlsName = "Reporte4505.xls";


          /**
           * Autofit Columns
           */
          $sheet = $objPHPExcel->getActiveSheet();
          
          $cellIterator = $sheet->getRowIterator(4)->current()->getCellIterator();
          
          $cellIterator->setIterateOnlyExistingCells( true );

          /** @var PHPExcel_Cell $cell */
          foreach( $cellIterator as $cell ) {

            $sheet->getColumnDimension( $cell->getColumn() )->setAutoSize( true );

          }

          $filaExcel = 3;
          $alphabet =$this->alphabet();
          $tipo_Registro = 2;


         /**
          * datos encabezado del arvhivo.
          */
         $objPHPExcel->getActiveSheet()->setCellValue('B1',$name);
         $objPHPExcel->getActiveSheet()->setCellValue('B2',1);
         $objPHPExcel->getActiveSheet()->setCellValue('C2',$codARS);
         $objPHPExcel->getActiveSheet()->setCellValue('D2',$fechaInicio);
         $objPHPExcel->getActiveSheet()->setCellValue('E2',$fechaFinal);

          /**
           * Encabezado guirme en validaciones
           */
          $objPHPExcel->getActiveSheet()->setCellValue('CO2','FECHA DE COLPOSCOPIA AAAA-MM-DD');
          $objPHPExcel->getActiveSheet()->setCellValue('CT2','FECHA DE MAMOGRAFIA AAAA-MM-DD');
          $objPHPExcel->getActiveSheet()->setCellValue('CW2','FECHA TOMA DE BIOPSIA SENO POR BACAF'); // 


          /**
           * Ciclo para recorrer el arreglo inicial
           * @var integer
           */
          foreach ($registros as $key => $value) {

           // var_dump($value);
            var_dump($value['identification']);

            $isValid = false;


              //FECHA DE ATENCION 
            $dateAttention = date_format(date_create($value['attention_date']),'Y-m-d');


            if($value['study_id'] == 244 || $value['study_id'] == 217 || $value['study_id'] == 75 || $value['study_id'] == 312){

              if($value['gender'] == '1'){
                var_dump('Ingeso F ');

                $isValid = true;


               /**
                * Validaciones de la edad. 
                *
                */
               


               $age = $value['order_age'];
               //var_dump('Edad :  '.$age);

               $newAge = explode('.',$age);
               $years  = ( int ) $newAge[0];
               echo $years . "<br/>";
               
               var_dump($value['study_id']);

               if($value['study_id'] == 244 && $years >= 10){
                //para los campos 91 y 92 las edad debe ser mayor de 10 años  (estudio 244 -> 702200)

                $isValid = false;
                var_dump('no tiene edad 244 ');


              }elseif ($value['study_id'] == 217 && $years >= 35) {
                //para los campos 96, 97, 98 la edad debe ser mayor de 35 años (estudio 217 -> 876802) 

                $isValid = false;
                var_dump('no tiene edad  217');

              }else{
                var_dump('no ingreso a ninguna');
              }
            }else{
              $isValid = false;
              var_dump('Ingreso a M');
            }
          }




          if($isValid){



            $objPHPExcel->getActiveSheet()->setCellValue('A'.$filaExcel,$value['order_client'].' '.$value['order_code']);
            /**
             * 0
             */
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$filaExcel,$tipo_Registro); // tipo de registro
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$filaExcel,$numRegistros); //consecutivo             
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$filaExcel,$codHabilitacion); //COD HABILITACION IPS PRIMARIA
            /**
             * Obtener iniciales documento identificacion.
             */ 
            $inictial = $this->getSiglasDocumentType($value['document_types_id']);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$filaExcel,$inictial['initials']); //TIPO DE IDENTIFICACION
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$filaExcel,$value['identification']);// numero documento
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$filaExcel,$value['last_name']);// primer apellido

            /**
             * Validar apellido
             */
            
            if($value['last_name_two'] ==""){
              $objPHPExcel->getActiveSheet()->setCellValue('H'.$filaExcel,'NONE'); // SEGUNDO APELLIDO
            }else{
               $objPHPExcel->getActiveSheet()->setCellValue('H'.$filaExcel,$value['last_name_two']); // SEGUNDO APELLIDO
             }


            $objPHPExcel->getActiveSheet()->setCellValue('I'.$filaExcel,$value['first_name']); // PRIMER NOMBRE 

             /**
             * Validar apellido
             */

             if($value['middle_name'] ==""){
               $objPHPExcel->getActiveSheet()->setCellValue('J'.$filaExcel,'NONE');// SEGUNDO NOMBRE

             }else{
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$filaExcel,$value['middle_name']);// SEGUNDO NOMBRE

              }

              $dateBirthdate = date_format(date_create($value['birthdate']),'Y-m-d');
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$filaExcel,$dateBirthdate); // FECHA DE NACIMIENTO
            /**
             * 10
             */
            
            /**
             * Obtiene siglas del genero
             */
            $gender = $this->getSiglasGender($value['gender']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$filaExcel,$gender['initials']); // GENERO
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$filaExcel,6); // CODIGO DE PERTENENCIA ETNICA
            // tengo duda es 9999 no se conoce dato o 9998 no aplica.
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$filaExcel,9999); //CODIGO DE OCUPACION
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$filaExcel,13); //CODIGO DE NIVEL EDUCATIVO
            /**
             * Variable 14 
             * Cuando el calculo de la edad sea menor a '10 anios' o mayor o igual a '60 anios', el valor de esta variable debe ser '0'.
             */
            if($years >= 10 && $years <= 60){
               $objPHPExcel->getActiveSheet()->setCellValue('P'.$filaExcel,0); // GESTACION
             }else{
              $objPHPExcel->getActiveSheet()->setCellValue('P'.$filaExcel,21); // GESTACION

            } 
            /**
             * variable 15
             * Esta variable debe ser '0' siempre que la variable 14 (GESTACION) es '0', '2' o '21'.
             * Esta variable debe ser '0' siempre que el calculo de la edad sea mayor o igual a '10 anios' y la variable 10 (SEXO) sea igual a 'F' y la variable 14 (GESTACION) sea diferente de '1'
             */
            if($years >= 10  && $value['gender'] == '1'){
              $objPHPExcel->getActiveSheet()->setCellValue('Q'.$filaExcel,0); //SIFILIS GESTACIONAL O CONGENITA
            }else{

               $objPHPExcel->getActiveSheet()->setCellValue('Q'.$filaExcel,21); //SIFILIS GESTACIONAL O CONGENITA
             }


            //16
            $objPHPExcel->getActiveSheet()->setCellValue('R'.$filaExcel,21); // HIPERTENSION INDUCIDA POR LA GESTACION
            /**
             * Cuando el calculo de la edad sea mayor a '3 anios', el valor de esta variable debe ser '0'.
             */
            if($years >= 3){

            $objPHPExcel->getActiveSheet()->setCellValue('S'.$filaExcel,0); // HIPOTIROIDISMO CONGENITO
          }else{
                  $objPHPExcel->getActiveSheet()->setCellValue('S'.$filaExcel,21); // HIPOTIROIDISMO CONGENITO
                }
            $objPHPExcel->getActiveSheet()->setCellValue('T'.$filaExcel,21); // SINTOMATICO RESPIRATORIO
            $objPHPExcel->getActiveSheet()->setCellValue('U'.$filaExcel,21); //TUBERCULOSIS MULTIDROGORESISTENTE
            /**
             * 20
             */
            $objPHPExcel->getActiveSheet()->setCellValue('V'.$filaExcel,21); // LEPRA
            $objPHPExcel->getActiveSheet()->setCellValue('W'.$filaExcel,21); // OBESIDAD O DESNUTRICION PROTEICO CALORICA
            $objPHPExcel->getActiveSheet()->setCellValue('X'.$filaExcel,21); // VICTIMA DE MALTRATO
            $objPHPExcel->getActiveSheet()->setCellValue('Y'.$filaExcel,21); // VICTIMA DE VIOLENCIA SEXUAL
            $objPHPExcel->getActiveSheet()->setCellValue('Z'.$filaExcel,21); // INFECCIONES DE TRANSMISION SEXUAL
            $objPHPExcel->getActiveSheet()->setCellValue('AA'.$filaExcel,21); // ENFERMEDAD MENTAL
            $objPHPExcel->getActiveSheet()->setCellValue('AB'.$filaExcel,21); // CANCER DE CERVIX
            $objPHPExcel->getActiveSheet()->setCellValue('AC'.$filaExcel,21); // CANCER DE SENO
            $objPHPExcel->getActiveSheet()->setCellValue('AD'.$filaExcel,21); // FLUOROSIS DENTAL
            $objPHPExcel->getActiveSheet()->setCellValue('AE'.$filaExcel,'1800-01-01'); // FECHA DEL PESO AAAA-MM-DD
            /**
             * 30
             */
            $objPHPExcel->getActiveSheet()->setCellValue('AF'.$filaExcel,999);// PESO EN KILOGRAMOS
            $objPHPExcel->getActiveSheet()->setCellValue('AG'.$filaExcel,'1800-01-01');// FECHA DE LA TALLA AAAA-MM-DD
            $objPHPExcel->getActiveSheet()->setCellValue('AH'.$filaExcel,999); // TALLA EN CENTIMETROS
            $objPHPExcel->getActiveSheet()->setCellValue('AI'.$filaExcel,'1845-01-01'); // FECHA PROBABLE DE PARTO 
            $objPHPExcel->getActiveSheet()->setCellValue('AJ'.$filaExcel,0);// EDAD GESTACIONAL AL NACER
            $objPHPExcel->getActiveSheet()->setCellValue('AK'.$filaExcel,0); // BCG
            $objPHPExcel->getActiveSheet()->setCellValue('AL'.$filaExcel,0); // HEPATITIS B MENORES DE 1 AÑO
            $objPHPExcel->getActiveSheet()->setCellValue('AM'.$filaExcel,0); // PENTAVALENTE
            $objPHPExcel->getActiveSheet()->setCellValue('AN'.$filaExcel,0); // POLIO
            $objPHPExcel->getActiveSheet()->setCellValue('AO'.$filaExcel,0); //DPT MENORES 5 AÑOS
            /**
             * 40
             */
            $objPHPExcel->getActiveSheet()->setCellValue('AP'.$filaExcel,0); //ROTAVIRUS
            $objPHPExcel->getActiveSheet()->setCellValue('AQ'.$filaExcel,0); //NEUMOCOCO
            $objPHPExcel->getActiveSheet()->setCellValue('AR'.$filaExcel,0); // INFLUENZA NIÑOS
            $objPHPExcel->getActiveSheet()->setCellValue('AS'.$filaExcel,0); // FIEBRE AMARILLA NIÑOS DE 1 AÑO
            $objPHPExcel->getActiveSheet()->setCellValue('AT'.$filaExcel,0); // HEPATITIS A
            $objPHPExcel->getActiveSheet()->setCellValue('AU'.$filaExcel,0); // TRIPLE VIRAL NIÑOS
            // se debe valdiar **
            $objPHPExcel->getActiveSheet()->setCellValue('AV'.$filaExcel,22); // VIRUS DEL PAPILOMA HUMANO (VPH)
            
            //TENGO DUDA CON ESTE CAMPO
            $objPHPExcel->getActiveSheet()->setCellValue('AW'.$filaExcel,0); // TD o TT MUJERES EN EDAD FERTIL 15 A 49 AÑOS
            // debe ser menor de 2 años para ser 0 ** 
            $objPHPExcel->getActiveSheet()->setCellValue('AX'.$filaExcel,22); // CONTROL DE PLACA
            /**
             * Cuando tenga el valor de '1845-01-01', la variable 14 (GESTACION) debe ser '0'.
             */
            $objPHPExcel->getActiveSheet()->setCellValue('AY'.$filaExcel,'1845-01-01'); // FECHA PARTO O CESAREA
            /**
             * 50
             */
            $objPHPExcel->getActiveSheet()->setCellValue('AZ'.$filaExcel,'1845-01-01'); // FECHA SALIDA DE ATENCION DEL PARTO O CESAREA
            /**
             * Cuando tenga el valor de '1845-01-01', el cálculo de la edad debe ser menor de 10 años o mayor a 60 años.
             */
            if($years <= 10 && $years >=60 && $value['gender'] == '1'){
              $objPHPExcel->getActiveSheet()->setCellValue('BA'.$filaExcel,'1845-01-01'); //FECHA DE CONSEJERIA DE LACTANCIA MATERNA
            }else{
              $objPHPExcel->getActiveSheet()->setCellValue('BA'.$filaExcel,'1800-01-01'); //FECHA DE CONSEJERIA DE LACTANCIA 
            }
            $objPHPExcel->getActiveSheet()->setCellValue('BB'.$filaExcel,'1845-01-01'); // FECHA CONTROL DE RECIEN NACIDO
            $objPHPExcel->getActiveSheet()->setCellValue('BC'.$filaExcel,'1800-01-01'); // PLANIFICACION FAMILIAR PRIMERA VEZ
            $objPHPExcel->getActiveSheet()->setCellValue('BD'.$filaExcel,0); // SUMINISTRO DE METODO ANTICONCEPTIVO
            $objPHPExcel->getActiveSheet()->setCellValue('BE'.$filaExcel,'1845-01-01'); // FECHA SUMINISTRO DE METODO ANTICONCEPTIVO
            $objPHPExcel->getActiveSheet()->setCellValue('BF'.$filaExcel,'1845-01-01'); // CONTROL PRENATAL DE PRIMERA VEZ
            $objPHPExcel->getActiveSheet()->setCellValue('BG'.$filaExcel,0); // CONTROL PRENATAL
            $objPHPExcel->getActiveSheet()->setCellValue('BH'.$filaExcel,'1845-01-01'); // ULTIMO CONTROL PRENATAL
            $objPHPExcel->getActiveSheet()->setCellValue('BI'.$filaExcel,0); // SUMINISTRO DE ACIDO FOLICO EN EL ULTIMO CONTROL PRENATAL
            /**
             * 60
             */
            $objPHPExcel->getActiveSheet()->setCellValue('BJ'.$filaExcel,0); // SUMINISTRO DE SULFATO FERROSO EN EL ULTIMO CONTROL PRENATAL
            $objPHPExcel->getActiveSheet()->setCellValue('BK'.$filaExcel,0); // SUMINISTRO DE CARBONATO DE CALCIO EN EL ULTIMO CONTROL PRENATAL
            $objPHPExcel->getActiveSheet()->setCellValue('BL'.$filaExcel,'1845-01-01'); // VALORACION DE LA AGUDEZA VISUAL
            $objPHPExcel->getActiveSheet()->setCellValue('BM'.$filaExcel,'1845-01-01'); // CONSULTA POR OFTALMOLOGIA
            $objPHPExcel->getActiveSheet()->setCellValue('BN'.$filaExcel,'1845-01-01'); // FECHA DIAGNOSTICO DESNUTRICION PROTEICO CALORICA
            $objPHPExcel->getActiveSheet()->setCellValue('BO'.$filaExcel,'1845-01-01'); // CONSULTA MUJER O MENOR VICTIMA DEL MALTRATO
            $objPHPExcel->getActiveSheet()->setCellValue('BP'.$filaExcel,'1845-01-01'); // CONSULTA VICTIMAS DE VIOLENCIA SEXUAL
            $objPHPExcel->getActiveSheet()->setCellValue('BQ'.$filaExcel,'1845-01-01'); // CONSULTA NUTRICION
            $objPHPExcel->getActiveSheet()->setCellValue('BR'.$filaExcel,'1845-01-01'); // CONSULTA DE PSICOLOGIA
            $objPHPExcel->getActiveSheet()->setCellValue('BS'.$filaExcel,'1845-01-01'); // CONSULTA DE CRECIMIENTO Y DESARROLLO PRIMERA VEZ
            /**
             * 70
             */
            $objPHPExcel->getActiveSheet()->setCellValue('BT'.$filaExcel,0); // SUMINISTRO DE SULFATO FERROSO EN LA ULTIMA CONSULTA DE MENOR DE 10 AÑOS
            $objPHPExcel->getActiveSheet()->setCellValue('BU'.$filaExcel,0); //SUMINISTRO DE VITAMINA A EN LA ULTIMA CONSULTA DE MENOR DE 10 AÑOS
            $objPHPExcel->getActiveSheet()->setCellValue('BV'.$filaExcel,'1845-01-01'); // CONSULTA DE JOVEN PRIMERA VEZ
            $objPHPExcel->getActiveSheet()->setCellValue('BW'.$filaExcel,'1845-01-01'); // CONSULTA DE ADULTO PRIMERA VEZ
            $objPHPExcel->getActiveSheet()->setCellValue('BX'.$filaExcel,0); // PRESERVATIVOS ENTREGADOS A PACIENTES CON ITS
            $objPHPExcel->getActiveSheet()->setCellValue('BY'.$filaExcel,'1845-01-01'); // ASESORIA PRE TEST ELISA PARA VIH
            $objPHPExcel->getActiveSheet()->setCellValue('BZ'.$filaExcel,'1845-01-01'); // ASESORIA POST TEST ELISA PARA VIH
            $objPHPExcel->getActiveSheet()->setCellValue('CA'.$filaExcel,0); //PACIENTE CON DIAGNOSTICO DE: ANSIEDAD, DEPRESION, .....
            $objPHPExcel->getActiveSheet()->setCellValue('CB'.$filaExcel,'1845-01-01'); // FECHA ANTIGENO DE SUPERFICIE HEPATITIS B EN GESTANTES
            $objPHPExcel->getActiveSheet()->setCellValue('CC'.$filaExcel,0); // RESULTADO ANTIGENO DE SUPERFICIE HEPATITIS B EN GESTANTES
            /**
             * 80
             */
            $objPHPExcel->getActiveSheet()->setCellValue('CD'.$filaExcel,'1845-01-01'); // FECHA SEROLOGIA PARA SIFILIS
            $objPHPExcel->getActiveSheet()->setCellValue('CE'.$filaExcel, 0); // RESULTADO SEROLOGIA PARA SIFILIS
            $objPHPExcel->getActiveSheet()->setCellValue('CF'.$filaExcel,'1845-01-01'); // FECHA TOMA DE ELISA PARA VIH
            $objPHPExcel->getActiveSheet()->setCellValue('CG'.$filaExcel,0); //RESULTADO ELISA PARA VIH
            $objPHPExcel->getActiveSheet()->setCellValue('CH'.$filaExcel,'1845-01-01'); // FECHA TSH NEONATAL
            $objPHPExcel->getActiveSheet()->setCellValue('CI'.$filaExcel,0); // RESULTADO DE TSH NEONATAL
            $objPHPExcel->getActiveSheet()->setCellValue('CJ'.$filaExcel,0); // TAMIZAJE DE CANCER DE CUELLO UTERINO
            $objPHPExcel->getActiveSheet()->setCellValue('CK'.$filaExcel,'1845-01-01'); // CITOLOGIA CERVICOUTERINA
            $objPHPExcel->getActiveSheet()->setCellValue('CL'.$filaExcel,0); // CITOLOGIA CERVICOUTERINA RESULTADOS SEGÚN BETHESDA
            $objPHPExcel->getActiveSheet()->setCellValue('CM'.$filaExcel,0); // CALIDAD DE LA MUESTRA CERVICO UTERINA
            /**
             * 90
             */
            $objPHPExcel->getActiveSheet()->setCellValue('CN'.$filaExcel,0); // COD HABILITACION IPS DONDE SE TOMA CITOLOGIA CERVICO UTERINA



            if($value['study_id']== 244){
                /**
                 * Campos 91 y 92
                 */

                    /**
                     * FECHA DE COLPOSCOPIA
                    AAAA-MM-DD

                    Si no se tiene el dato registrar 
                    1800-01-01
                    Si no realiza por una tradición registrar 1805-01-01
                    Si no se realiza por una condición de salud registrar 1810-01-01
                    Si no se realiza por negociación del usuario registrar 1825-01-01
                    Si no se realiza por tener datos de contacto del usuario no actualizados registrar 1830-01-01
                    No se reagistra por otras razones 1835-01-01
                    Si no aplica registrar
                    1845-01-01

                    Cuando tenga el valor diferente de '0', la variable 91 (FECHA COLPOSCOPIA) debe registrar un dato diferente de '1805-01-01', '1810-01-01', '1825-01-01', '1830-01-01', '1835-01-01' y '1845-01-01'.
El tamanio del codigo de habilitacion de la IPS debe ser igual a 12.
                     */

                $objPHPExcel->getActiveSheet()->setCellValue('CO'.$filaExcel,$dateAttention); // FECHA DE COLPOSCOPIA
                /**
                 * COD HABILITACION IPS DONDE SE TOMA COLPOSCOPIA
                    (TABLA REPS)
                    Si es desconocido registrar 99
                    Si no aplica registrar 98
                 */
                $objPHPExcel->getActiveSheet()->setCellValue('CP'.$filaExcel,$codHabilitacion); //  COD HABILITACION IPS DONDE SE TOMA COLPOSCOPIA 

              }else{
                    // NO SE REALIZA COLPOSCOPIA. 
                $objPHPExcel->getActiveSheet()->setCellValue('CO'.$filaExcel,'1800-01-01'); // FECHA DE COLPOSCOPIA

                $objPHPExcel->getActiveSheet()->setCellValue('CP'.$filaExcel,0); //  COD HABILITACION IPS DONDE SE TOMA COLPOSCOPIA (TABLA REPS)

              }

            $objPHPExcel->getActiveSheet()->setCellValue('CQ'.$filaExcel,'1845-01-01'); // FECHA DE BIOPSIA CERVICAL
            $objPHPExcel->getActiveSheet()->setCellValue('CR'.$filaExcel,0); // RESULTADO DE BIOPSIA CERVICAL
            $objPHPExcel->getActiveSheet()->setCellValue('CS'.$filaExcel,0); // COD HABILITACION IPS DONDE SE TOMA BIOPSIA CERVICAL (TABLA REPS)


            if($value['study_id'] == 217 || $value['study_id'] == 75){
                /**
                 * campos 96, 97, 98
                 */

                // Obtiene el numero de atencion.

                $birad = $this->getBirads($value['result_id']);
                //$birad = '';
              //  var_dump($birad['birad']);


                    /**
                     * "FECHA DE MAMOGRAFIA
                    AAAA-MM-DD

                    Si no se tiene el dato registrar 
                    1800-01-01
                    Si no realiza por una tradición registrar 1805-01-01
                    Si no se realiza por una condición de salud registrar 1810-01-01
                    Si no se realiza por negociación del usuario registrar 1825-01-01
                    Si no se realiza por tener datos de contacto del usuario no actualizados registrar 1830-01-01
                    No se reagistra por otras razones 1835-01-01
                    Si no aplica registrar
                    1845-01-01"


                     */
                $objPHPExcel->getActiveSheet()->setCellValue('CT'.$filaExcel,$dateAttention); //FECHA DE MAMOGRAFIA AAAA-MM-DD

                /**
                 *  "RESULTADO DE MAMOGRAFIA
                    Clasificación BIRADS registre:
                    1 BIRADS O: Necesidad de nuevo estudio imagenologico o mamograma previo para evaluación
                    2 BIRADS 1: Negativo
                    3 BIRADS 2: Hallazgos Benignos
                    4 BIRADS 3: Probablemente Benigno
                    5 BIRADS 4: Anormalidad Sospechosa
                    6 BIRADS 5: Altamente Sospechosa de Malignidad
                    7 BIRADS 6: Malignidad por Biopsica conocida
                    Si no tiene el dato registrar 999
                    Si no aplica registrar 0"
                 */
                $objPHPExcel->getActiveSheet()->setCellValue('CU'.$filaExcel,$birad['birad']); //RESULTADO DE MAMOGRAFIA BIRADS

                $objPHPExcel->getActiveSheet()->setCellValue('CV'.$filaExcel,$codHabilitacion); // COD HABILITACION IPS DONDE SE TOMA  MAMOGRAFIA (TABLA REPS)

              }else {

                $objPHPExcel->getActiveSheet()->setCellValue('CT'.$filaExcel,'1845-01-01'); //FECHA DE MAMOGRAFIA AAAA-MM-DD
                $objPHPExcel->getActiveSheet()->setCellValue('CU'.$filaExcel,0); //RESULTADO DE MAMOGRAFIA BIRADS
                $objPHPExcel->getActiveSheet()->setCellValue('CV'.$filaExcel,0); //COD HABILITACION IPS DONDE SE TOMA  MAMOGRAFIA (TABLA REPS)

              }

              if($value['study_id'] == 312){
                /**
                 * Campos 99, 100, 101, 102
                 */

                /**
                 *  "FECHA TOMA DE BIOPSIA SENO POR BACAF
                AAAA-MM-DD

                Si no se tiene el dato registrar 
                1800-01-01
                Si no realiza por una tradición registrar 1805-01-01
                Si no se realiza por una condición de salud registrar 1810-01-01
                Si no se realiza por negociación del usuario registrar 1825-01-01
                Si no se realiza por tener datos de contacto del usuario no actualizados registrar 1830-01-01
                No se reagistra por otras razones 1835-01-01
                Si no aplica registrar
                1845-01-01"

             */

                $dateResult = date_format(date_create($value['result_date']),'Y-m-d');

            $objPHPExcel->getActiveSheet()->setCellValue('CW'.$filaExcel,$dateAttention); // FECHA TOMA DE BIOPSIA SENO POR BACAF

            /**
             *  "FECHA RESULTADO DE BIOPSIA SENO POR BACAF
                AAAA-MM-DD

                Si no se tiene el dato registrar 
                1800-01-01

                Si no aplica registrar
                1845-01-01"

             */
            $objPHPExcel->getActiveSheet()->setCellValue('CX'.$filaExcel,$dateResult); // FECHA RESULTADO DE BIOPSIA SENO POR BACAF
            /**
             *  "BIOPSIA SENO POR BACAF

                1 Benigna
                2 Atípica (Indeterminada)
                3 Malignidad sospechosa/probable
                4  Maligna
                5 No satisfactoria

                Si es desconocido registrar 999
                Si no aplica registrar 0"   

             */
            $objPHPExcel->getActiveSheet()->setCellValue('CY'.$filaExcel,''); // BIOPSIA SENO POR BACAF

            /**
             * 
                "COD HABILITACION IPS DONDE SE TOMA  BIOPSIA DE SENO POR BACAF
                (TABLA REPS)
                Si es desconocido registrar 999
                Si no aplica registrar 0"
             */
            $objPHPExcel->getActiveSheet()->setCellValue('CZ'.$filaExcel,$codHabilitacion); // COD HABILITACION IPS DONDE SE TOMA  BIOPSIA DE SENO POR BACAF

          }else{  
    // no aplica  
            $objPHPExcel->getActiveSheet()->setCellValue('CW'.$filaExcel,'1845-01-01'); // FECHA TOMA DE BIOPSIA SENO POR BACAF
            $objPHPExcel->getActiveSheet()->setCellValue('CX'.$filaExcel,'1845-01-01'); // FECHA RESULTADO DE BIOPSIA SENO POR BACAF
            $objPHPExcel->getActiveSheet()->setCellValue('CY'.$filaExcel,0); // BIOPSIA SENO POR BACAF
            $objPHPExcel->getActiveSheet()->setCellValue('CZ'.$filaExcel,0); // COD HABILITACION IPS DONDE SE TOMA  BIOPSIA DE SENO POR BACAF
          }

        /**
         * 103
         */
            $objPHPExcel->getActiveSheet()->setCellValue('DA'.$filaExcel,'1845-01-01'); //FECHA TOMA DE HEMOGLOBINA
            $objPHPExcel->getActiveSheet()->setCellValue('DB'.$filaExcel,0); // HEMOGLOBINA
            $objPHPExcel->getActiveSheet()->setCellValue('DC'.$filaExcel,'1845-01-01'); // FECHA TOMA DE GLICEMIA BASAL
            $objPHPExcel->getActiveSheet()->setCellValue('DD'.$filaExcel,'1845-01-01'); // FECHA TOMA DE CREATININA
            $objPHPExcel->getActiveSheet()->setCellValue('DE'.$filaExcel,0); // CREATININA
            $objPHPExcel->getActiveSheet()->setCellValue('DF'.$filaExcel,'1845-01-01'); // FECHA HEMOGLOBINA GLICOSILADA
            $objPHPExcel->getActiveSheet()->setCellValue('DG'.$filaExcel,0); // HEMOGLOBINA GLICOSILADA
            /**
             * 110
             */
            $objPHPExcel->getActiveSheet()->setCellValue('DH'.$filaExcel,'1845-01-01'); // FECHA TOMA DE MICROALBUMINURIA
            $objPHPExcel->getActiveSheet()->setCellValue('DI'.$filaExcel,'1845-01-01'); // FECHA TOMA DE HDL
            $objPHPExcel->getActiveSheet()->setCellValue('DJ'.$filaExcel,'1845-01-01'); // FECHA TOMA DE BACILOSCOPIA DE DIAGNOSTICO
             /**
             * Cuando tenga el valor diferente de '4', la variable 112 (FECHA TOMA DE BASCILOSCOPIA DIAGNOSTICA) debe registrar un dato diferente de '1805-01-01', '1810-01-01', '1825-01-01', '1830-01-01', '1835-01-01' y '1845-01-01'.
             */
            $objPHPExcel->getActiveSheet()->setCellValue('DK'.$filaExcel,4); // BACILOSCOPIA DE DIAGNOSTICO
            $objPHPExcel->getActiveSheet()->setCellValue('DL'.$filaExcel,0); //TRATAMIENTO PARA HIPOTIROIDISMO CONGENITO
            $objPHPExcel->getActiveSheet()->setCellValue('DM'.$filaExcel,0); //  TRATAMIENTO PARA SIFILIS GESTACIONAL
            $objPHPExcel->getActiveSheet()->setCellValue('DN'.$filaExcel,0); // TRATAMIENTO PARA SIFILIS CONGENITA
            $objPHPExcel->getActiveSheet()->setCellValue('DO'.$filaExcel,0); // TRATAMIENTO PARA LEPRA
            $objPHPExcel->getActiveSheet()->setCellValue('DP'.$filaExcel,'1845-01-01'); // FECHA DE TERMINACION TRATAMIENTO LEISHMANIASIS


            $filaExcel++; 

            $numRegistros++;
          }

          $objPHPExcel->getActiveSheet()->setCellValue('F2',$numRegistros);
        }



        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="'.$xlsName.'"');

        header('Cache-Control: max-age=0');

          // Write file to the browser
        //$objWriter->save('php://output');


        $objWriter->save(WWW_ROOT.'/excel/Reporte4505.xls');


                // $this->response->file(
                //   $file['path'],
                //   ['download' => true, 'name' => 'foo']
                // );

        // $this->response->file(WWW_ROOT.'/excel/Reporte4505.xlsx', array('download' => true, 'name' => 'ReporteCeo.xls'));

        return $this->response;



      }




      public function generateExcel(){

        $this->autoRender = false;

        $objPHPExcel = new \PHPExcel();


        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getProperties()->setCreator("Gato Loco Studios S.A.S.")
        ->setLastModifiedBy("Gato Loco Studios S.A.S.")
        ->setTitle("Reporte Ingresos")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Reporte Ingresos.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");


        $fecha = date("Y-m-d H:i:s"); 

          // $this->getData($objPHPExcel, $report, $userId, $paciente,$fecha);

        $xlsName = "Reporte.xls";

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('A1', "Fecha");           

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('B1', $fecha);                        


        $objPHPExcel->getActiveSheet() 
        ->setCellValue('A2', "NOMBRE");          

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('B2', 'APELLIDO');  

          /**
           * Autofit Columns
           */
          $sheet = $objPHPExcel->getActiveSheet();
          
          $cellIterator = $sheet->getRowIterator(4)->current()->getCellIterator();
          
          $cellIterator->setIterateOnlyExistingCells( true );

          /** @var PHPExcel_Cell $cell */
          foreach( $cellIterator as $cell ) {

            $sheet->getColumnDimension( $cell->getColumn() )->setAutoSize( true );

          }

          $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          header('Content-Type: application/vnd.ms-excel');

          header('Content-Disposition: attachment;filename="'.$xlsName.'"');

          header('Cache-Control: max-age=0');

          // Write file to the browser
          $objWriter->save('php://output');

        }


        public function pastGenerateExcel($report,$userId){

          $this->autoRender = false;

          $this->loadModel('Paciente'); 

          $paciente = $this->Paciente->find('first',array('conditions' => array('Paciente.id'=>$userId)));

          $objPHPExcel = new PHPExcel();

          $objPHPExcel->setActiveSheetIndex(0);

          $objPHPExcel->getProperties()->setCreator("Gato Loco Studios S.A.S.")
          ->setLastModifiedBy("Gato Loco Studios S.A.S.")
          ->setTitle("Reporte Ingresos")
          ->setSubject("Office 2007 XLSX Test Document")
          ->setDescription("Reporte Ingresos.")
          ->setKeywords("office 2007 openxml php")
          ->setCategory("Test result file");


          $fecha = date("Y-m-d H:i:s"); 

          $this->getData($objPHPExcel, $report, $userId, $paciente,$fecha);



          $xlsName = "Reporte ".$report. "-". $paciente['Paciente']['fullName']."-" . $fecha .".xls";



          $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

          header('Content-Type: application/vnd.ms-excel');

          header('Content-Disposition: attachment;filename="'.$xlsName.'"');

          header('Cache-Control: max-age=0');

    			// Write file to the browser
          $objWriter->save('php://output');

        }



        public function getData($objPHPExcel, $report,$userId,$paciente,$fecha){


         switch($report){

          case 'seguimiento-dosis':

          $dataSource = $this->requestAction(array('controller'=>'Seguimiento', 'action'=>'getDataColumnsDosis',$userId));

          break;


          case 'farmacovigilancia':

          $dataSource = $this->requestAction(array('controller'=>'Seguimiento', 'action'=>'getDataColumnsFarmaco',$userId));


          break;  


          case 'laboratorios':

          $dataSource = $this->requestAction(array('controller'=>'Seguimiento', 'action'=>'getDataColumnsLaboratorios',$userId));

          break;  

        }

        $columns = $dataSource['columns'];

        $data = $dataSource['data'];

        $alphabet = $this->alphabet();

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('A1', "Fecha");           

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('B1', $fecha);                        


        $objPHPExcel->getActiveSheet() 
        ->setCellValue('A2', "Paciente");          

        $objPHPExcel->getActiveSheet() 
        ->setCellValue('B2', $paciente['Paciente']['fullName']);          

       		/**
       		 * Columnas
       		 */
       		for ($i = 0; $i < count($columns); $i++) { 

			    // Titulos de las columnas
             $objPHPExcel->getActiveSheet() 
             ->setCellValue($alphabet[$i].'4', $columns[$i]);

           }

       		/**
       		 * Datos
         	 */
          for ($i = 0; $i < count($data); $i++)
          {   

           for ($j=0; $j < count($columns); $j++) { 

  		      		/**
  		      		 * Ingreso de los datos de cada columna por fila
  		      		 */
               $objPHPExcel->getActiveSheet() 
               ->setCellValue($alphabet[$j].($i+5), $data[$i][$j]);

             }

           }

           switch($report){

            case 'seguimiento-dosis':

            $columnsDoses = $dataSource['datesDoses']['columns'];  

            $dataDoses = $dataSource['datesDoses']['data'];

            $fromRow = count($data) + 6;

            for ($i = 0; $i < count($columnsDoses); $i++) { 

                  // Titulos de las columnas
              $objPHPExcel->getActiveSheet() 
              ->setCellValue($alphabet[$i].$fromRow, $columnsDoses[$i]);

            }

            $fromRow = $fromRow + count($columnsDoses);

                  /**
                   * Datos
                   */
                  for ($i = 0; $i < count($dataDoses); $i++)
                  {   

                    for ($j=0; $j < count($columnsDoses); $j++) { 

                        /**
                         * Ingreso de los datos de cada columna por fila
                         */
                        $objPHPExcel->getActiveSheet() 
                        ->setCellValue($alphabet[$j].($i+$fromRow), $dataDoses[$i]);

                      }   
                    }

                    $columnsDosesCount = $dataSource['loseDosesCountDays']['columns'];  

                    $dataDosesCount = $dataSource['loseDosesCountDays']['data'];                                    
                    $fromRow = $fromRow + count($dataDoses) +1;


                    for ($i = 0; $i < count($columnsDosesCount); $i++) { 

                  // Titulos de las columnas
                      $objPHPExcel->getActiveSheet() 
                      ->setCellValue($alphabet[$i].$fromRow, $columnsDosesCount[$i]);

                    }


                    $fromRow = $fromRow + 1;

                    $sum = 0;

                  /**
                   * Datos
                   */
                  for ($i = 0; $i < count($dataDosesCount); $i++)
                  {   

                    for ($j=0; $j < count($columnsDosesCount); $j++) { 

                        /**
                         * Ingreso de los datos de cada columna por fila
                         */
                        $objPHPExcel->getActiveSheet() 
                        ->setCellValue($alphabet[$j].($i+$fromRow), $dataDosesCount[$i][$j]);

                        if($alphabet[$j] == "C"){

                          $sum = $sum + intval($dataDosesCount[$i][$j]);

                        }

                      }

                    }

                    $fromRow = $fromRow + count($dataDosesCount) + 1;

                    $objPHPExcel->getActiveSheet() 
                    ->setCellValue('B'.$fromRow, "Total");

                    $objPHPExcel->getActiveSheet() 
                    ->setCellValue('C'.$fromRow, $sum);

                    break;

                    case 'farmacovigilancia':

                    break;  

                    case 'laboratorios':

                    break;  

                  }

        /**
         * Autofit Columns
         */
        $sheet = $objPHPExcel->getActiveSheet();
        $cellIterator = $sheet->getRowIterator(4)->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells( true );

        /** @var PHPExcel_Cell $cell */
        foreach( $cellIterator as $cell ) {
          $sheet->getColumnDimension( $cell->getColumn() )->setAutoSize( true );
        }

      }




/**
 * ------------------------------------------INICIA INFORME RESOLUCION 4505 ----------------------
 * DEICY ROJAS H. 
 */


public function new4505Report(){
  $data = $this->request->data();

}



}     

