<?php
require_once('TCPDF/tcpdf.php');

namespace app\components;

use app\models\Solicitud;
use app\models\Vacante;

class SolicitudPDF extends TCPDF {
    protected $solicitud;
    protected $vacante;
    
    public function __construct($vacante, $solicitud) {
        $this->vacante = $vacante;
        $this->solicitud = $solicitud;
        
        parent::__construct(PDF_PAGE_ORIENTATION, 'in', PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }
    
    public function Header() {
        $image_file = '@web/images/aspirante/' . $this->solicitud->foto;
        $image_extension = substr(strrchr($this->solicitud->foto, "."), 1);//strtoupper(pathinfo($this->solicitud->foto, PATHINFO_EXTENSION));
		$this->Image($image_file, 444, 20, 85, 85, $image_extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        $this->SetFillSpotColor('My TCPDF Dark Green', 100);
        $this->Rect(39, 0, 516, 79, 'F', array(), array(255, 0, 0));
		// Set font
		$this->SetFont('helvetica', 'B', 32);
		// Title
		$this->Text(60, 12, 'Solicitud de Empleo');
    }
    
    public function Footer() {
        
    }
    /**
     *  Función que genera el PDF de la solicitud de empleo
     *  TCPDF es necesario para ello
     *
     *  $v representa app\models\Vacante
     *  $s representa app\models\Solicitud
     */
    public function getPDFAspirante() {
        // set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('Biempleos');
        $this->SetTitle('Solicitud de Empleo');
        $this->SetSubject($this->vacante->puesto . ': ' . $this->solicitud->nombre);
        $this->SetKeywords('Solicitud, Empleo');

        // set default header data
        //$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$this->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $this->SetMargins(0.278, 0.278, 0.278);
        $this->SetHeaderMargin(0);
        $this->SetFooterMargin(0);

        // set auto page breaks
        $this->SetAutoPageBreak(TRUE, 0.278);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/examples/lang/spa.php')) {
            require_once(dirname(__FILE__).'/examples/lang/spa.php');
            $this->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set default font subsetting mode
        $this->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $this->SetFont('dejavusans', '', 14, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $this->AddPage();

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->Output($this->vacante->puesto . ': ' . $this->solicitud->nombre . '.pdf', 'I');
    }
}