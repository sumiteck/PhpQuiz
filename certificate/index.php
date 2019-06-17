

<?php

session_start();
ob_start();
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require('../courses/model/database.php');

// if(!empty($_POST['submit'])){
	// $f_name=$_POST['firstName'];
	// $l_name=$_POST['lastName'];

$name = getUserName($_SESSION['user_email']);
$f_name = $name['firstName'];
$l_name = $name['lastName'];
$course = getCourseName($_SESSION["id"]);
	

require_once('testpdf/fpdf.php');
require_once('FPDI/src/autoload.php');

$pdf = new Fpdi('l');

$pageCount = $pdf->setSourceFile('certificate.pdf');
$tpl = $pdf->importPage(1);
// Reference the PDF you want to use (use relative path)

$pdf->AddPage();
// Use the imported page as the template
$pdf->useTemplate($tpl);
// Set the default font to use
$pdf->SetFont('Helvetica');
// adding a Cell using:
// $pdf->Cell( $width, $height, $text, $border, $fill, $align);
// First box - the user's Name
$pdf->SetFontSize('20'); // set font size
$pdf->SetXY(70, 88); // set the position of the box
$pdf->Cell(150, 10, $f_name . " " .$l_name, 0, 0, 'C'); // add the text, align to Center of cell
// add the reason for certificate
// note the reduction in font and different box position
$pdf->SetFontSize('20');
$pdf->SetXY(80, 105);
$pdf->Cell(150, 10, $course , 0, 0, 'C');
// the day
$pdf->SetFontSize('20');
$pdf->SetXY(118,122);
$pdf->Cell(20, 10, date('d'), 0, 0, 'C');
// the month
$pdf->SetXY(160,122);
$pdf->Cell(30, 10, date('M'), 0, 0, 'C');
// the year, aligned to Left
$pdf->SetXY(200,122);
$pdf->Cell(20, 10, date('y'), 0, 0, 'L');
// render PDF to browser
$pdf->SetFont('Courier','BI','18'); // set font size
$pdf->SetXY(130, 145); // set the position of the box
$pdf->Cell(150, 10, "Team Phoenix", 0, 0, 'C');


$pdf->Output();
// }
ob_end_flush();

 function getUserName($email){
      global $db;
      $query = "SELECT firstName, lastName FROM user WHERE email = '$email'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data;   
  }

    function getCourseName($courseId){
      global $db;
      $query = "SELECT courseName FROM courses WHERE courseId = '$courseId'";

      $statement = $db->prepare($query);
      $statement->execute();
      $data = $statement->fetch();
      $statement->closeCursor();
      // print_r($data);
      return $data['courseName'];   
  }

?>



<!DOCTYPE html>
 <html>
 <head>
 	<title>Online Certificate</title>
 </head>
 <body>
 	<form action="" method="post">
 	First name: <input type="text" name="firstName"><br>
  Quiz name: <input type="text" name="lastName"><br>
  
    <input type="submit" name="submit" value="Submit">
 </form>
 </body>
 </html>