<?php
namespace app\components;
require_once('TCPDF/tcpdf.php');

use TCPDF;
use Yii;
use app\models\Solicitud;
use app\models\Vacante;

class SolicitudPDF extends TCPDF {
    protected $solicitud;
    protected $vacante;
    
    public function __construct($vacante, $solicitud) {
        $this->vacante = $vacante;
        $this->solicitud = $solicitud;
        
        parent::__construct(PDF_PAGE_ORIENTATION, 'pt', PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }
    
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

        // set header and footer fonts
        $this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        //$this->SetMargins(20, 154, 20);
        $this->SetMargins(20, 20, 20);
        $this->setPrintHeader(false);
        //$this->setPrintFooter(false);
        $this->SetFooterMargin(20);

        // set auto page breaks
        $this->SetAutoPageBreak(TRUE, 20);

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
        $this->SetFont('helvetica', 'B', 14);

        // Add a page
        $this->AddPage();
        
        // Bordes utilizados en las celdas:
        // $borderStyleOuterCell se utiliza para resaltar cuadros grandes o importantes
        // $borderStyleInnerCell se utiliza para resaltar cuadros pequeños que forman parte de un cuadro grande
        $borderStyleOuterCell = array('width' => '1.5', 'join' => 'mitter', 'dash' => 0, 'color' => array(0, 0, 0));
        $borderStyleInnerCell = array('width' => '1', 'join' => 'mitter', 'dash' => 0, 'color' => array(0, 0, 0));
        
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  HEADER
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        $this->Rect(59, 20, 516, 79, 'F', array(), array(255, 0, 0));

        $image_file = Yii::getAlias("@web") . '/images/aspirante/' . $this->solicitud->foto;
        $image_extension = substr(strrchr($this->solicitud->foto, "."), 1);//strtoupper(pathinfo($this->solicitud->foto, PATHINFO_EXTENSION));
        $this->Image($image_file, 464, 40, 85, 85, $image_extension, '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 32);
        $this->SetTextColor(255, 255, 255);
        // Title
        $this->Text(80, 32, 'Solicitud de Empleo');

        $this->Rect(80, 81, 221, 71, 'F', array(), array(255, 255, 204));
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('helvetica', '', 10);
        $this->Text(84, 85, 'Puesto de Trabajo: ' . $this->vacante->puesto);
        $this->Text(138, 105, 'Fecha: ' . date('d/m/Y'));
        $this->Text(88, 125, 'Sueldo Aprobado: _____________________');
        
        $this->SetXY(20, 154);
        
        // La estructura del PDF es de 2 columnas
        // Se define la ubicacion en X y Y de las columnas
        $this->setDestination('columna1', $this->GetY() + 5);
        $this->setDestination('columna2', $this->GetY() + 5, '', $this->GetX() + 192);
        
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  ESTRUCTURA DE LA COLUMNA 1
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE DOCUMENTACIÓN
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->SetXY($this->getDestination()['columna1']['x'], $this->getDestination()['columna1']['y']);
        $this->Cell(187, 20, 'Documentación', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        
        $this->SetFont('helvetica', '', 10);
        $this->Cell(187, 14, 'Clave Única de Registro de Población', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->curp, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'AFORE', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->afore, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Registro Federal de Contribuyentes', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->rfc, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Número de Seguridad Social', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->nss, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Cartilla de Servicio Militar', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->cartilla_militar, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Pasaporte', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->pasaporte, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $licencia = $this->solicitud->licencia ? ($this->solicitud->clase_licencia . " #" . $this->solicitud->numero_licencia):"Sin licencia";
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Licencia de manejar', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $licencia, array('LRB' => $borderStyleOuterCell), 'L');



        // ---------------------------------------------------------
        //  CUADRO GRANDE HÁBITOS PERSONALES
        // ---------------------------------------------------------
        $this->setDestination('columna1', $this->GetY() + 5);

        $this->SetY($this->getDestination()['columna1']['y']);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(187, 20, 'Hábitos Personales', array('LRTB' => $borderStyleOuterCell), 1, 'C');

        $deporte = $this->solicitud->deportista ? $this->solicitud->deporte:"Ninguno";

        $this->SetFont('helvetica', '', 10);
        $this->Cell(187, 14, 'Deporte que práctica', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $deporte, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');

        $club = $this->solicitud->club ? "Es parte de un club":"No es parte de un club";

        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Club social o deportivo', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $club, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');

        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Pasatiempo favorito', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->pasatiempo, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');

        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Meta en la vida', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->meta, array('LRB' => $borderStyleOuterCell), 'L');

        
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE ESCOLARIDAD
        // ---------------------------------------------------------
        $this->setDestination('columna1', $this->GetY() + 5);

        $this->SetY($this->getDestination()['columna1']['y']);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(187, 20, 'Escolaridad', array('LRTB' => $borderStyleOuterCell), 1, 'C');

        $this->SetFont('helvetica', '', 10);
        $this->Cell(187, 14, 'Último grado de estudio', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->estudio, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');

        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Nombre de la escuela', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->escuela, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $periodo = date_format(date_create_from_format("Y-m-d", $this->solicitud->inicio), "d/m/Y");
        $periodo .= (" - " . date_format(date_create_from_format("Y-m-d", $this->solicitud->finalizacion), "d/m/Y")) ;
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Periodo de estudio', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $periodo, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->SetFontSize(10);
        $this->Cell(187, 14, 'Título recibido', array('LR' => $borderStyleOuterCell), 1);
        $this->SetFontSize(12);
        $this->MultiCell(187, 20, $this->solicitud->titulo, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $this->setDestination('columna1', $this->GetY() + 5);
        
        
        
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  ESTRUCTURA DE LA COLUMNA 2
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        if ($this->getPage() > 1)
            $this->setPage(1);
        $this->SetXY($this->getDestination()['columna2']['x'], $this->getDestination()['columna2']['y']);
        
        $this->SetFontSize(12);

        // Definicion de textos que requieran alguna adecuacion para mostrarse
        $fechaNacimiento = explode('-', $this->solicitud->fecha_nacimiento);
        $edad = ((date("md", date("U", mktime(0, 0, 0, $fechaNacimiento[1], $fechaNacimiento[2], $fechaNacimiento[0]))) > date("md")
                 ? ((date("Y") - $fechaNacimiento[0]) - 1) : (date("Y") - $fechaNacimiento[0]))) . " años";
        $fechaNacimiento = $fechaNacimiento[2] . "/" . $fechaNacimiento[1] . "/" . $fechaNacimiento[0];
        
        // Conjunto de tamaños de altura que representan los textos para cada cuadro
        // divididos por los cuadros grandes y por las filas que ocupan
        // Se excluyen los datos de
        //  - Conocimientos Generales
        $heightCells = array(
            'datosPersonales' => array(
                '1' => array(
                    $this->getStringHeight(
                        290, $this->solicitud->nombre, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        73, $edad, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    )
                ),
                '2' => array(
                    $this->getStringHeight(
                        160, $this->solicitud->calle . " #" . $this->solicitud->numero, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        130, $this->solicitud->colonia, false, true, '', array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        73, $this->solicitud->codigo_postal, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    )
                ),
                '3' => array(
                    $this->getStringHeight(
                        100, $this->solicitud->estado_civil, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        90, $this->solicitud->nacionalidad, false, true, '', array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        50, $this->solicitud->estatura . " m", false, true, '', array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        50, $this->solicitud->peso . " kg", false, true, '', array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        73, $this->solicitud->sexo, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    )
                ),
                '4' => array(
                    $this->getStringHeight(
                        160, $fechaNacimiento, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        73, $this->solicitud->dependientes, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    )
                )
            ),
            //  Las llaves deben coincidir con las que fueron declaradas en setDestination
            'conocimientosGenerales' => array(
                'sub1' => array(
                    'subcolumna1' => $this->getStringHeight(
                        181, $this->solicitud->otras_funciones, false, true, '', array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    'subcolumna2' => $this->getStringHeight(
                        182, $this->solicitud->maquinaria_oficina, false, true, '', array('RB' => $borderStyleOuterCell)
                    )
                )
            ),
            'empleo' => array(
                '1' => array(
                    $this->getStringHeight(
                        120, $this->solicitud->compania, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        243, $this->solicitud->direccion, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    )
                ),
                '2' => array(
                    $this->getStringHeight(
                        120, $this->solicitud->telefono, false, true, '', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        95, $this->solicitud->tiempo_trabajo, false, true, '', array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        148, $this->solicitud->puesto, false, true, '', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    ),
                ),
                '3' => array(
                    $this->getStringHeight(
                        120, $this->solicitud->sueldo_inicial, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        120, $this->solicitud->sueldo_final, array('RB' => $borderStyleInnerCell)
                    )
                ),
                'sub1' => array(
                    'subcolumna1' => $this->getStringHeight(
                        240, $this->solicitud->puesto_jefe, array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    'subcolumna2' => $this->getStringHeight(
                        123, $this->solicitud->motivo_separacion, array('RB' => $borderStyleOuterCell)
                    )
                )
            ),
            'referenciasPersonales' => array(
                '1' => array(
                    $this->getStringHeight(
                        130, $this->solicitud->nombre_ref1, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        145, $this->solicitud->domicilio_ref1, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        90, $this->solicitud->telefono_ref1, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        125, $this->solicitud->ocupacion_ref1, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        65, $this->solicitud->tiempo_ref1, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    ),
                ),
                '2' => array(
                    $this->getStringHeight(
                        130, $this->solicitud->nombre_ref2, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        145, $this->solicitud->domicilio_ref2, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        90, $this->solicitud->telefono_ref2, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        125, $this->solicitud->ocupacion_ref2, array('RB' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        65, $this->solicitud->tiempo_ref2, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell)
                    ),
                ),
                '3' => array(
                    $this->getStringHeight(
                        130, $this->solicitud->nombre_ref3, array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        145, $this->solicitud->domicilio_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        90, $this->solicitud->telefono_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        125, $this->solicitud->ocupacion_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell)
                    ),
                    $this->getStringHeight(
                        65, $this->solicitud->tiempo_ref3, array('RB' => $borderStyleOuterCell)
                    ),
                ),
            )
        );
        
        // Funcion anonima para obtener la altura común que se utilizara en la fila especificada
        // en cada cuadro grande
        //  $i cuadro grande que representan las celdas
        //  $j fila que representa del cuadro grande
        $commonHeight = function($i, $j) use(&$heightCells) {
            $valor = 0;
            foreach ($heightCells[$i][$j] as $h) {
                if ($h > $valor)
                    $valor = $h;
            }
            
            return $valor < 20 ? 20:$valor;
        };
        
        // Funcion anonima para obtener ajustar la altura de las subcolumnas independientes
        // para establecer el cuadro grande
        //  $i cuadro grande que representan las celdas
        //  $j subcolumnas a tomar en cuenta
        $adjustableHeight = function($i, $j) use(&$heightCells) {
            $largestHeight = 0;
            $fixedHeight = array();
            foreach($heightCells[$i][$j] as $k => $h) {
                $h = $h < 20 ? 20:$h;
                if ($h + $this->getDestination()[$k]['y'] > $largestHeight)
                    $largestHeight = $h + $this->getDestination()[$k]['y'];
            }
            
            foreach($heightCells[$i][$j] as $k => $h) {
                array_push($fixedHeight, $largestHeight - $this->getDestination()[$k]['y']);
            }
            
            return $fixedHeight;
        };
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE DATOS PERSONALES
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(363, 20, 'Datos Personales', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        $this->SetX($this->getDestination()['columna2']['x']);

        $this->SetFont('helvetica', '', 10);
        $this->Cell(290, 14, 'Nombre', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
        $this->Cell(73, 14, 'Edad', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $height = $commonHeight('datosPersonales', '2');
        
        $this->MultiCell(290, $height, $this->solicitud->nombre, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(73, $height, $edad, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(160, 14, 'Domicilio', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
        $this->Cell(130, 14, 'Colonia', array('R' => $borderStyleInnerCell));
        $this->Cell(73, 14, 'Código Postal', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $height = $commonHeight('datosPersonales', '3');
        
        $this->MultiCell(160, $height, $this->solicitud->calle . " #" . $this->solicitud->numero, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(130, $height, $this->solicitud->colonia, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(73, $height, $this->solicitud->codigo_postal, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(100, 14, 'Estado Civil', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
        $this->Cell(90, 14, 'Nacionalidad', array('R' => $borderStyleInnerCell));
        $this->Cell(50, 14, 'Estatura', array('R' => $borderStyleInnerCell));
        $this->Cell(50, 14, 'Peso', array('R' => $borderStyleInnerCell));
        $this->Cell(73, 14, 'Sexo', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $height = $commonHeight('datosPersonales', '4');
        
        $this->MultiCell(100, $height, $this->solicitud->estado_civil, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(90, $height, $this->solicitud->nacionalidad, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(50, $height, $this->solicitud->estatura . " m", array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(50, $height, $this->solicitud->peso . " kg", array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(73, $height, $this->solicitud->sexo, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(120, 14, 'Fecha de Nacimiento', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
        $this->Cell(243, 14, 'No. de dependientes', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $height = $commonHeight('datosPersonales', '4');
        
        $this->MultiCell(120, $height, $fechaNacimiento, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(243, $height, $this->solicitud->dependientes, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetXY($this->getDestination()['columna2']['x'], $this->GetY() + 5);
        
        
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE CONOCIMIENTOS GENERALES
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(363, 20, 'Conocimientos Generales', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        // Esta columna se define por dos subcolumnas
        $this->setDestination('subcolumna1', $this->GetY(), '', $this->GetX());
        $this->setDestination('subcolumna2', $this->GetY(), '', $this->GetX() + 181);
        
        //  Subcolumna 1
        $this->SetFont('helvetica', '', 10);
        $this->Cell(181, 14, 'Idioma', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['subcolumna1']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(181, 0, $this->solicitud->idioma . " " . $this->solicitud->porcentaje . "%", array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['subcolumna1']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(181, 14, 'Software', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['subcolumna1']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(181, 0, $this->solicitud->software, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['subcolumna1']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(181, 14, 'Otras funciones', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['subcolumna1']['x']);
        
        // Se almacena la ubicacion de la columna independiente otras funciones
        $this->setDestination('subcolumna1', $this->GetY(), '', $this->GetX());
        
        //  Subcolumna 2
        $this->SetXY($this->getDestination()['subcolumna2']['x'], $this->getDestination()['subcolumna2']['y']);
        
        $this->Cell(182, 14, 'Funciones de Oficina', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['subcolumna2']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(182, 0, $this->solicitud->funciones_oficina, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['subcolumna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(182, 14, 'Maquinaria de oficina o taller', array('R' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['subcolumna2']['x']);
        
        // Se almacena la ubicacion de la columna independiente maquinaria_oficina
        $this->setDestination('subcolumna2', $this->GetY(), '', $this->GetX());
        
        $this->SetFontSize(12);
        
        //  Con las dos columnas independientes se procede a ajustar la altura de cada una para que coincidan con el
        //  tamaño del cuadro grande
        $height = $adjustableHeight('conocimientosGenerales', 'sub1');
        
        $this->MultiCell(182, $height[1], $this->solicitud->maquinaria_oficina, array('RB' => $borderStyleOuterCell), 'L');
        
        $this->SetXY($this->getDestination()['subcolumna1']['x'], $this->getDestination()['subcolumna1']['y']);
        $this->MultiCell(181, $height[0], $this->solicitud->otras_funciones, array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L');
        
        $this->SetXY($this->getDestination()['columna2']['x'], $this->GetY() + 5);
        
        /*$heightSubcolumna1 = $this->getDestination()['subcolumna1']['y'] + $this->getStringHeight(
                        181, $this->solicitud->otras_funciones, false, true, '', array('LB' => $borderStyleOuterCell)
                    );
        $heightSubcolumna2 = $this->getDestination()['subcolumna2']['y'] + $this->getStringHeight(
                        182, $this->solicitud->maquinaria_oficina, false, true, '', array('RB' => $borderStyleOuterCell)
                    );
        $additionalHeight = abs($heightSubcolumna1 - $heightSubcolumna2);
        
        if ($heightSubcolumna1 > $heightSubcolumna2)
            $heightSubcolumna2 += ($additionalHeight - $this->getDestination()['subcolumna2']['y']);
        else
            $heightSubcolumna1 += ($additionalHeight - $this->getDestination()['subcolumna1']['y']);
        */
        
        
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE ANTECEDENTE DE TRABAJO
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(363, 20, 'Empleo Inmediato Anterior', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFont('helvetica', '', 10);
        if ($this->solicitud->trabajo_anterior) {
            
            $this->Cell(120, 14, 'Compañia', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
            $this->Cell(243, 14, 'Dirección', array('R' => $borderStyleOuterCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(12);
            $height = $commonHeight('empleo', '1');
            
            $this->MultiCell(120, $height, $this->solicitud->compania, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(243, $height, $this->solicitud->direccion, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(10);
            $this->Cell(120, 14, 'Teléfono', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
            $this->Cell(95, 14, 'Tiempo de servicio', array('R' => $borderStyleInnerCell));
            $this->Cell(148, 14, 'Puesto', array('R' => $borderStyleOuterCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(12);
            $height = $commonHeight('empleo', '2');
            
            $this->MultiCell(120, $height, $this->solicitud->telefono, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(95, $height, $this->solicitud->tiempo_trabajo, array('RB' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(148, $height, $this->solicitud->puesto, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(10);
            $this->Cell(120, 14, 'Sueldo Mensual Inicial', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell));
            $this->Cell(120, 14, 'Sueldo Mensual Final', array('R' => $borderStyleInnerCell));
            $this->Cell(123, 14, 'Motivo de Separación', array('R' => $borderStyleOuterCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(12);
            $height = $commonHeight('empleo', '3');
            
            $this->MultiCell(120, $height, $this->solicitud->sueldo_inicial, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(120, $height, $this->solicitud->sueldo_final, array('RB' => $borderStyleInnerCell), 'L', false, 0);
            // Se guarda la ubicacion de la columna independiente motivo de separacion
            $this->setDestination('subcolumna2', $this->GetY(), '', $this->GetX());
            
            $this->Ln();
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(10);
            $this->Cell(240, 14, 'Nombre del jefe directo', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(12);
            $this->MultiCell(240, 20, $this->solicitud->nombre_jefe, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L');
            $this->SetX($this->getDestination()['columna2']['x']);
            
            $this->SetFontSize(10);
            $this->Cell(240, 14, 'Puesto del jefe directo', array('L' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            // Se guarda la ubicacion de la columna independiente puesto del jefe directo
            $this->setDestination('subcolumna1', $this->GetY(), '', $this->GetX());
            
            $this->SetFontSize(12);
            $height = $adjustableHeight('empleo', 'sub1');
            
            $this->MultiCell(240, $height[0], $this->solicitud->puesto_jefe, array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L');
            
            $this->SetXY($this->getDestination()['subcolumna2']['x'], $this->getDestination()['subcolumna2']['y']);
            $this->MultiCell(123, $height[1], $this->solicitud->motivo_separacion, array('RB' => $borderStyleOuterCell), 'L');
            
        } else {
            
            $this->Cell(363, 14, 'Experiencia de trabajo', array('LR' => $borderStyleOuterCell), 1);
            $this->SetX($this->getDestination()['columna2']['x']);
            $this->SetFontSize(12);
            $this->Cell(363, 20, 'Sin experiencia laboral', array('LRB' => $borderStyleOuterCell), 1);
            
        }
        
        $this->setDestination('columna2', $this->GetY() + 5, '', $this->getDestination()['columna2']['x']);
        
        
        
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  INICIO DE NUEVA PAGINA
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        
        // Se establece la ultima pagina
        $this->lastPage();
        
        // Si no hay pagina nueva se crea
        if ($this->page == 1)
            $this->AddPage();
        
        //
        // Se establece la posicion de Y de la columna 1 a la de la columna 2 si:
        //  - ambas columnas se encuentran en la nueva pagina pero la posicion Y de columna 2 es superior
        //  - columna 1 no se encuntra en la nueva pagina pero la columna 2 si
        //
        // Se reinicia la posicion Y de columna 1 si:
        //  - ambas columnas no pasaron a la siguiente pagina
        //  
        // En caso que no entren la posicion actual de columna 1 es correcta
        if (
            (
                $this->getDestination()['columna1']['p'] == $this->page &&
                $this->getDestination()['columna2']['p'] == $this->page &&
                $this->getDestination()['columna2']['y'] > $this->getDestination()['columna1']['y']
            ) || (
                $this->getDestination()['columna1']['p'] < $this->page &&
                $this->getDestination()['columna2']['p'] == $this->page
            )
        )
            $this->setDestination('columna1', $this->getDestination()['columna2']['y'], '');
        else if (
            $this->getDestination()['columna2']['p'] < $this->page &&
            $this->getDestination()['columna1']['p'] < $this->page
        )
            $this->setDestination('columna1', $this->GetY());
            
        
        $this->setDestination('columna1', $this->getDestination()['columna1']['y'] + 5, '');
        $this->SetXY($this->getDestination()['columna1']['x'], $this->getDestination()['columna1']['y']);
        
        
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE DE REFERENCIAS PERSONALES
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(555, 20, 'Referencias Personales', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        
        $this->SetFont('helvetica', '', 10);
        $this->MultiCell(130, 27, 'Nombre', array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'C', false, 0, '', '', true, 0, false, true, 20, 'B');
        $this->MultiCell(145, 27, 'Domicilio', array('RB' => $borderStyleInnerCell), 'C', false, 0, '', '', true, 0, false, true, 20, 'B');
        $this->MultiCell(90, 27, 'Teléfono', array('RB' => $borderStyleInnerCell), 'C', false, 0, '', '', true, 0, false, true, 20, 'B');
        $this->MultiCell(125, 27, 'Ocupación', array('RB' => $borderStyleInnerCell), 'C', false, 0, '', '', true, 0, false, true, 20, 'B');
        $this->MultiCell(65, 27, 'Tiempo de conocerlo', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'C');
        
        $this->SetFontSize(12);
        $height = $commonHeight('referenciasPersonales', '1');
        
        $this->MultiCell(130, $height, $this->solicitud->nombre_ref1, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(145, $height, $this->solicitud->domicilio_ref1, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(90, $height, $this->solicitud->telefono_ref1, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(125, $height, $this->solicitud->ocupacion_ref1, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(65, $height, $this->solicitud->tiempo_ref1, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $height = $commonHeight('referenciasPersonales', '2');
        
        $this->MultiCell(130, $height, $this->solicitud->nombre_ref2, array('L' => $borderStyleOuterCell, 'RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(145, $height, $this->solicitud->domicilio_ref2, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(90, $height, $this->solicitud->telefono_ref2, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(125, $height, $this->solicitud->ocupacion_ref2, array('RB' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(65, $height, $this->solicitud->tiempo_ref2, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        
        $height = $commonHeight('referenciasPersonales', '3');
        
        $this->MultiCell(130, $height, $this->solicitud->nombre_ref3, array('LB' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(145, $height, $this->solicitud->domicilio_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(90, $height, $this->solicitud->telefono_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(125, $height, $this->solicitud->ocupacion_ref3, array('B' => $borderStyleOuterCell, 'R' => $borderStyleInnerCell), 'L', false, 0);
        $this->MultiCell(65, $height, $this->solicitud->tiempo_ref3, array('RB' => $borderStyleOuterCell), 'L');
        $this->SetY($this->GetY() + 5);
        
        // Comienza division en columnas
        $this->setDestination('columna1');
        $this->setDestination('columna2', $this->GetY(), '', $this->GetX() + 145);
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  ESTRUCTURA DE LA COLUMNA 1
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE DE DATOS GENERALES
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(140, 20, 'Datos Generales', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        
        $this->SetFont('helvetica', '', 10);
        $this->MultiCell(85, 27, 'Parientes en la empresa', array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        $this->MultiCell(85, 27, 'Afianzado', array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        $this->MultiCell(85, 27, 'Afiliado a un sindicato', array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        $this->MultiCell(85, 27, 'Tiene seguro de vida', array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        $this->MultiCell(85, 27, 'Puede viajar', array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        $this->MultiCell(85, 27, 'Puede cambiar residencia', array('LB' => $borderStyleOuterCell), 'R');
        $this->SetXY($this->getDestination()['columna1']['x'] + 85, $this->getDestination()['columna1']['y'] + 20);
        
        $this->SetFontSize(12);
        $this->Cell(55, 27, $this->solicitud->parientes ? 'Si':'No', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['columna1']['x'] + 85);
        $this->Cell(55, 27, $this->solicitud->afianzado ? 'Si':'No', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['columna1']['x'] + 85);
        $this->Cell(55, 27, $this->solicitud->sindicato ? 'Si':'No', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['columna1']['x'] + 85);
        $this->Cell(55, 27, $this->solicitud->seguro_vida ? 'Si':'No', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['columna1']['x'] + 85);
        $this->Cell(55, 27, $this->solicitud->viajar ? 'Si':'No', array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 1);
        $this->SetX($this->getDestination()['columna1']['x'] + 85);
        $this->Cell(55, 27, $this->solicitud->cambiar_residencia ? 'Si':'No', array('RB' => $borderStyleOuterCell), 1);
        
        $this->setDestination('columna1', $this->GetY(), '', $this->GetX());
        $this->SetXY($this->getDestination()['columna2']['x'], $this->getDestination()['columna2']['y']);
        
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        //  ESTRUCTURA DE LA COLUMNA 2
        // ---------------------------------------------------------
        // ---------------------------------------------------------
        
        // ---------------------------------------------------------
        //  CUADRO GRANDE DE DATOS ECONOMICOS
        // ---------------------------------------------------------
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(410, 20, 'Datos Económicos', array('LRTB' => $borderStyleOuterCell), 1, 'C');
        
        $this->SetFont('helvetica', '', 10);
        $this->SetX($this->getDestination()['columna2']['x']);
        $this->Cell(410, 14, 'Otros ingresos', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        if ($this->solicitud->otros_ingresos) {
            $this->MultiCell(210, 20, "Cuenta con otros ingresos", array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(200, 20, "Importe Mensual: $" . $this->solicitud->importe_ingresos, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        } else {
            $this->MultiCell(410, 20, 'No cuenta con otros ingresos', array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        }
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Importe del conyuge', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        if ($this->solicitud->conyuge_trabaja) {
            $this->MultiCell(210, 20, "Si hay aportaciones", array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(200, 20, "Percepción Mensual: $" . $this->solicitud->percepcion, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        } else {
            $this->MultiCell(410, 20, 'No hay ingresos de su parte', array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        }
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Casa propia', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        if ($this->solicitud->casa_propia) {
            $this->MultiCell(210, 20, "Con casa propia", array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(200, 20, "Valor Aproximado: $" . $this->solicitud->valor_casa, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        } else {
            $this->MultiCell(410, 20, 'Sin casa propia', array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        }
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Renta', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        if ($this->solicitud->paga_renta) {
            $this->MultiCell(210, 20, "Actualmente rentando" , array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(200, 20, "Renta Mensual: $" . $this->solicitud->renta, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        } else {
            $this->MultiCell(410, 20, 'No esta rentando', array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        }
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Automóvil', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(410, 20, $this->solicitud->automovil ? "Tiene":"No tiene", array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Deudas', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        if ($this->solicitud->deudas) {
            $this->MultiCell(310, 20, 'Endeudado con ' . $this->solicitud->acreedor, array('L' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L', false, 0);
            $this->MultiCell(100, 20, 'Importe: $' . $this->solicitud->importe_deudas, array('R' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'R');
        } else {
            $this->MultiCell(410, 20, 'No tiene deudas', array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        }
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Abono Mensual', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(410, 20, '$' . $this->solicitud->abono_mensual, array('LR' => $borderStyleOuterCell, 'B' => $borderStyleInnerCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(10);
        $this->Cell(410, 14, 'Gastos Mensuales', array('LR' => $borderStyleOuterCell), 1);
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->SetFontSize(12);
        $this->MultiCell(410, 20, '$' . $this->solicitud->gastos_mensuales, array('LRB' => $borderStyleOuterCell), 'L');
        $this->SetX($this->getDestination()['columna2']['x']);
        
        $this->setDestination('columna2', $this->GetY(), '', $this->GetX());



        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $this->Output($this->vacante->puesto . ': ' . $this->solicitud->nombre . '.pdf', 'I');
        
        /*
        SELECT vacante.*, vacante_aspirante.id_aspirante 
        FROM vacante 
        LEFT JOIN vacante_aspirante ON vacante_aspirante.id_vacante = vacante.id 
        WHERE vacante_aspirante.id_aspirante <> 4 OR vacante_aspirante.id_aspirante IS NULL
        
        (new \yii\db\Query())
        ->select('vacante.*, vacante_aspirante.id_aspirante')
        ->from('vacante')
        ->leftJoin('vacante_aspirante', 'vacante_aspirante.id_vacante = vacante.id')
        ->where('vacante_aspirante.id_aspirante <> :aspirante OR vacante_aspirante.id_aspirante IS NULL', [':aspirante' => valor de aspirante]);
        */
    }
}