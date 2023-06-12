 <?php
 require_once $_SERVER['DOCUMENT_ROOT'].'/school/core/init.php';
 require_once $_SERVER['DOCUMENT_ROOT'].'/school/PHPMAiler/PHPMailerAutoload.php';//the connection mailer class for enabling sedning of emails

 if(isset($_POST['submit'])){
     $address  = trim(clean(((isset($_POST['address'])? $_POST['address'] : ''))));
     $subject  = trim(clean(((isset($_POST['subject'])? strtupper($_POST['subject']) : ''))));
     $message  = trim(clean(((isset($_POST['message'])? $_POST['message'] : ''))));


    $mail = new PHPMailer();
    //$mail->SMTPDebug = 4; 
    $mail->isSMTP();
    $mail->SMTPAuth =true;
    $mail->SMTPSecure='ssl';
    $mail->Host='smtp.gmail.com';
    $mail->Port='465';
    $mail->isHTML();
    $mail->Username='rossonditi@gmail.com'; //$configurationData['school_email']
    $mail->Password='@Zawadiaf2020';

    $mail->SetFrom("rossonditi@gmail.com","School Management System");
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress($address);

    // Add Static Attachment
    /*$attachment = '/path/to/your/file.pdf';
    $mail->AddAttachment($attachment , 'RenamedFile.pdf');*/

    $mail->send();
 }
 ?>