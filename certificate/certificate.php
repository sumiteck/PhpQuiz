<?php

session_start();
require('fpdf181/fpdf.php');



require('../courses/model/database.php');

// if(!empty($_POST['submit'])){
// $f_name=$_POST['firstName'];
// $l_name=$_POST['lastName'];

$name = getUserName($_SESSION['user_email']);
$f_name = $name['firstName'];
$l_name = $name['lastName'];
$course = getCourseName($_SESSION["id"]);



$subject = $course;
$fullname= $f_name ." " . $l_name;


$pdf = new FPDF('L','pt','A4');

//Loading data
$pdf->SetTopMargin(20); $pdf->SetLeftMargin(20); $pdf->SetRightMargin(20);

$pdf->AddPage();
//  Print the edge of
$pdf->Image("a.png", 20, 20, 800);
// Print the certificate logo

$pdf->SetFont('times','B',80);
$pdf->Cell(740+10,200,"CERTIFICATE",0,0,'C');



$pdf->SetFont('Arial','I',34);
$pdf->SetXY(130,200);
$pdf->Cell(350,25,$fullname,"B",0,'C',0);



$pdf->SetFont('Arial','I',20);
$pdf->SetXY(340,200);
$message = "have successfully ";
$pdf->Cell(350,14,$message,0,'C',0);


$pdf->SetFont('Arial','I',20);
$pdf->SetXY(130,280);
$message = "passed the test. You are now certified in";
$pdf->Cell(350,14,$message,0,'C',0);



$pdf->SetFont('Arial','I',34);
$pdf->SetXY(480,280);
$pdf->Cell(200,25,$subject,"B",0,'C',0);


$pdf->SetFont('Arial','B',16);
$pdf->SetXY(370,470);
$signataire = "Team Phoenix";
$pdf->Cell(350,19,$signataire,"B",0,'C');

$pdf->Output();


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