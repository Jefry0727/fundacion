<?php
require_once(ROOT . DS . 'vendor' . DS . "tecnick.com" . DS . "tcpdf" . DS . "tcpdf.php");



 class XTCPDF extends TCPDF
    {
        var $xfooterfont  = PDF_FONT_NAME_MAIN ;
        var $xfooterfontsize = 8 ;

        function Header()
        {
            
            //list($r, $b, $g) = $this->xheadercolor;
            $this->setY(5);
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
            $this->Text(5, 30, 'Software de Administración Médica "SAM" V.1.1 ® - www.gatolocostudios.com ®');
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
            $this->SetY(-20);
            //$this->SetTextColor(0, 0, 0);
            $this->SetFont($this->xfooterfont,'',$this->xfooterfontsize);
            $this->writeHTML($this->xfootertext, true, false, true, false, '');
            //$this->Cell(0,8, $footertext,'T',3,'L');
        }
    }
    
    // Instanciacion
    $tcpdf = new XTCPDF(); 

    // Info del documento
    $tcpdf->SetAuthor("Gatoloco Studios S.A.S."); 
    
    // Informacion del ecabezado y footer
    $tcpdf->xheadertext = '
        <table style="padding: 2px; padding-right:40px">
            <tr>
                <td style="width: 20%">

                 <img src="http://www.coca-cola.co.uk/stories/history/advertising/the-logo-story/_jcr_content/lead/smartslides1/slide1.img.png/1426182101987.jpg" width="80">
                   
                </td>
                <td style="text-align:center; width: 50%; LINE-HEIGHT:11px; font-family: Verdana !important">
                    <br>
                    <br>
                    <strong style="color: #0d72b3;">CDC Centro de Diagnóstico Clínico S.A.S.</strong><br>
                    <strong style="color: #0d72b3; font-size: 65%">NIT: 900220827-2</strong><br>
                    <strong style="color: #56ade0; font-size: 65%">Calle 17N # 11-70 Piso 4 Telefax: (6) 748 5515</strong><br>
                    <strong style="color: #56ade0; font-size: 65%">Cel: 314 680 1257</strong><br>
                    <strong style="color: #56ade0; font-size: 65%">E-mail: gerencia@cdclaboratorio.com - asistente@cdclaboratorio.com</strong><br>
                    <strong style="color: #56ade0; font-size: 65%">Armenia - Quindío - Colombia</strong><br>
                    <strong style="color: #56ade0; font-size: 65%">www.cdclaboratorio.com</strong>
                </td>
                <td style="text-align:center; width: 30%; LINE-HEIGHT:11px; font-family: Verdana !important">
                    <br>
                    <br>
                    <br>
                    <br>
                    <strong style="color: #0d72b3;">SOLICITUD DE PEDIDO</strong><br><br>
                    <strong style="color: #0d72b3;">#: &nbsp;&nbsp;&nbsp;</strong> <strong style="color: black; font-size:150% !important"></strong><br><br>
                </td>
            </tr>
        </table>
        <br>
        <table style="padding: 2px; width: 95%">
            <tr style="font-size: 70%">
                <td style="text-align: left;">
                    <br><strong>Solicita: </strong></td>
                <td style="text-align: rigth;">
                    <br><strong>Fecha de Solicitud: </strong>
                </td>
            </tr>
        </table>
        <br>
        <table style="padding: 2px; width: 95%">
            <tr style="font-size: 70%">
                <td style="width: 10%; text-align: center; background-color: #56ade0; border-top: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black;">
                    <br><strong>#</strong>
                </td>
                <td style="width: 10%; text-align: center; background-color: #56ade0; border-top: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black;">
                    <br><strong>Cód.</strong>
                </td>
                <td style="width: 50%; text-align: center; background-color: #56ade0; border-top: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black;">
                    <br><strong>Producto</strong>
                </td>
                <td style="width: 15%; text-align: center; background-color: #56ade0; border-top: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black;">
                    <br><strong>Cantidad</strong>
                </td>
                <td style="width: 15%; text-align: center; background-color: #56ade0; border-top: 1px solid black;border-right: 1px solid black; border-bottom: 1px solid black;">
                    <br><strong>U. Salida</strong>
                </td>
            </tr>
        </table>';  
    
    
    // $tcpdf->variable = $opcion; // Set de la variable de validación de previsualización 
    $tcpdf->xfootertext = '    
        <table style="padding: 2px; width: 95%">
            <tr style="font-size: 80%">
                <td style="text-align: center; width: 50%;">
                    <br><strong>Solicitado por:</strong>
                </td>
                <td style="text-align: center; width: 50%;">
                    <br><strong>Recibido por:</strong>
                </td>
            </tr>
            <tr style="font-size: 80%">
                <td style="text-align: center; width: 50%;">
                    <br><br>______________________________________
                </td>
                <td style="text-align: center; width: 50%;">
                    <br><br>______________________________________
                </td>
            </tr>
        </table>';
    
    // Fuentes del doc
    $textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 
    //$tcpdf->SetFont('freesans', '', 10);
    // Margenes 
    $tcpdf->SetMargins(10, 50, 3, false);
    $tcpdf->SetHeaderMargin(10);
    $tcpdf->SetFooterMargin(20);
    
    // Cambio de pagina
    $tcpdf->SetAutoPageBreak( true, 20); 
    
    //$tcpdf->setHeaderFont(array($textfont,'',40)); 
    //$tcpdf->xheadercolor = array(150,0,0); 

    // Validacion para la aparicion tanto del header como del footer
    $tcpdf->SetPrintHeader(true);
    $tcpdf->SetPrintFooter(true);

    // Adicion de nueva pagina con tamaño predefinido en mm
    //$resolution= array(216, 279);
    $resolution= array(216, 139);
    $tcpdf->AddPage('L', $resolution);
    
    setlocale(LC_MONETARY, 'en_US');
    
    //$tcpdf->SetFont('freesans', '', 12);
    
    // Contenido del pdf
    $html = '<br>
        <table style="padding: 2px; width: 95%">';
		


    // Ciclo Asignar los datos rergistrados para facturacion
    for ($j = 0; $j < 20; $j++)
    {
        $cod = $j + 1;
        
        $html = $html.'
            <tr style="font-size: 70%">
                <td style="width: 10%; text-align: center;">
                    '.$j.'	
                    <br>
                </td>
                <td style="width: 10%; text-align: center;">
                    '.$j.'
                    <br>
                </td>
                <td style="width: 50%; text-align: left;">
                    '.$j.'
                    <br>
                </td>
                <td style="width: 15%; text-align: center;"> 
                    '.$j.'
                    <br>
                </td>
                <td style="width: 15%; text-align: center;">
                    '.$j.'	
                    <br>
                </td>
            </tr>
        ';
    }    
    
    // Validacion para ingreso de observaciones de la salida de productos
    // if ( $observacion == '' || $observacion == null)
    // {
        
    // }
    // else
    // {
    //     // Ingreso de Observaciones
    //     $html = $html.'
    //         <tr style="font-size: 70%">
    //             <td style="text-align: left;" colspan="2">
    //                 <br><strong>Observación:</strong>
    //             </td>
    //             <td style="width:63%; text-align: justify;" colspan="3">
    //                 <br>'.$observacion.'
    //             </td>
    //         </tr>
    //     ';
    // }

    $html = $html.'
        </table>
        <br>';

    // output the HTML content
    $tcpdf->writeHTML($html, true, false, true, false, '');

    

    // output the HTML content
    //$tcpdf->writeHTML($html, true, false, true, false, '');
    // if ($opcion == 1)
    // {
        $tcpdf->Output(WWW_ROOT.'files/PrevioPedido.pdf', 'F');

        $this->response->file(WWW_ROOT.'/files/PrevioPedido.pdf', array('download' => true, 'name' => 'PrevioPedido.pdf'));


    // }
    // else
    // {
    //     echo 'pase';
    //     $tcpdf->Output(WWW_ROOT.'/files/Pedido_'.$this->Session->read('User.userId').'.pdf', 'F');
    // }


