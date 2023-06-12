<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
require_once('../TCPDF/tcpdf.php');

//get the value of the payment transaction from the session set
$paymentId = $_SESSION["PAYMENT_ID"];
//fetch data on this transaction from db
$transactionQuery = $db->query("SELECT * FROM `fees_invoices` WHERE `id`='{$paymentId}'");
$transactionData  = mysqli_fetch_array($transactionQuery);

//fetch the student data
$studentId = (int)$transactionData['student_id'];
$studentQuery   = $db->query("SELECT `stdname`, `registration_number` FROM `students` WHERE `id`='{$studentId}'");
$studentData    = mysqli_fetch_array($studentQuery);

// create new PDF document 
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('HILLSTOP ACADEMY MIRERA');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData($_SERVER['DOCUMENT_ROOT'].$configurationData['school_logo'], PDF_HEADER_LOGO_WIDTH, "HILLSTOP ACADEMY MIRERA", "P.O BOX 1091-20117");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 18));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// create some HTML content
$html = '
<h3>Fees Receipt:</h3>
<h4 style="font-weight: normal;">STUDENT NAME: '.$studentData["stdname"].'</h4>
<h4 style="font-weight: normal; padding: 20px 5px;">UPI NUMBER: '.$studentData["registration_number"].'</h4>
<br>
<h4 style="width: 100%; text-align: right; margin: 30px 0px;">DATE: '.date("m-d-Y").'</h4>
<br>
<table border="1" cellspacing="0" cellpadding="4" style="margin-top: 40px;">
    <tr style="background-color: red">
        <th style="width: 10%;">#</th>
        <th style="width: 60%;">DESCRIPTION</th>
        <th style="width: 30%;">AMOUNT(Kshs.)</th>
    </tr>
    <tr>
       <td>1</td>
       <td>'.$transactionData["mode"].'</td>
       <td style="float:right;">'.decimal($_GET["amt"]).'</td>
    </tr>
    <tr style="height: 200px;">
        <td colspan="2">TOTAL AMOUNT</td>
        <td style="float:right">'.decimal($_GET["amt"]).'</td>
    </tr>
</table>';

//$html =  preg_replace('/\s\s+/', '', $html);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('receipt.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+