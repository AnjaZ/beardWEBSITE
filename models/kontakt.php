<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php';

    if(isset($_POST["posalji"])){
        $ime = $_POST["ime"];
        $email = $_POST["email"];
        $subject = $_POST["naslov"];
        $poruka = $_POST["poruka"];

            $message = "Novi mejl sa viking spirit <br>";
            $message.= "Email korisnika: {$email} <br>
            Poruka: <br>
            {$poruka}";
            //echo $message;
            $to='anjazubac@gmail.com';
            $mail = new PHPMailer(true);
            $mail->IsSMTP(); // enable SMTP
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;  
            $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPSecure = ''; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = 'smtpout.secureserver.net';         
            $mail->SMTPAuth   = true;    
            $mail->Port = 80; // or 587
            $mail->IsHTML(true);
            $mail->Username = "anjazubac@gmail.com";
            $mail->Password = "starke123";
            $mail->SetFrom("no-reply@bojanjica.rs");
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->AddAddress($to);
           
            if(!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                //header("Location:index.php?page=home&mail=false");
            } else {
                echo "radii";
                //header("Location:index.php?page=Kontakt");
            } 
    }