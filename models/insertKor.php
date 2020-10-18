<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/PHPMailer/src/SMTP.php';

if(isset($_POST['insertKor'])){  
    $ime = $_POST['ime']; 
    $prezime = $_POST['prezime']; 
    $grad = $_POST['grad']; 
    $brojP = $_POST['brojP']; 
    $brojT = $_POST['brojT']; 
    $brojS = $_POST['brojS']; 
    $ulica = $_POST['ulica']; 
    $mejl = $_POST['mejl']; 
    $narudzbe=$_POST['narudzbe'];
    $napomena=$_POST["napomena"];
    $vreme= time();
    // $provera=serverskaProvera($ime,$prezime,$mejl,$grad,$ulica,$brojP,$brojS,$brojT);
    // echo $provera;
    // die();
    include "../config/connection.php";
    $upisi = "INSERT INTO narudzbina(ime,prezime,grad,zip,ulica,broj,email,brojStana,napomena,vreme)
    values(:ime, :pre , :grad , :zip, :ulica, :broj, :email, :brojS, :napomena,:vreme)"; 
    $prep = $conn->prepare($upisi); 
    $prep->execute([ 
        ":ime" => $ime,
        ":pre" => $prezime,
        ":grad" => $grad, 
        ":zip" => $brojP,
        ":ulica" => $ulica, 
        ":broj" => $brojT,
        ":email" => $mejl,
        ":brojS" => $brojS,
        ":napomena" => $napomena,
        ":vreme" => $vreme
         ]); 
        $idNar=$conn->lastInsertId();
        if($idNar){
            foreach($narudzbe as $n){
                $upisKorpu="INSERT INTO korpa(idProizvoda, kolicina, idNar) values(:idp,:kolicina,:idnar);";
                $prep = $conn->prepare($upisKorpu); 
                $ok=$prep->execute([ 
                    ":idp" => $n['idProizovda'],
                    ":kolicina" => $n['kolicina'],
                    ":idnar" => $idNar, 
                    ]); 
                
            }
            
            if($ok){
                $subject = "Nova porudzbina";
                $message = "Novu porudzbina sa viking spirit <br>";
                $message.= "Email korisnika: {$mejl} <br>
                Ime korisnika: {$ime} <br>
                Prezime korisinka  : {$prezime} <br>
                Grad : {$grad} <br>
                Postanski broj : {$brojP} <br>
                Ulica : {$ulica} <br>
                Broj stana : {$brojS} <br>
                Broj telefona : {$brojT} <br>
                Napomena: <br>
                {$napomena}";
                foreach($narudzbe as $n){
                    $message.= "Porudzbina : {$n['nazivProizvoda']}, broj ovog prouzvoda: {$n['kolicina']} <br>";       
                }
                //echo $message;
                $to='vikingspirit.team@gmail.com'; //kome se salje
                $mail = new PHPMailer(true);
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true; // authentication enabled
                $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587; // or 587
                $mail->IsHTML(true);
                $mail->Username = "anjazubac@gmail.com";
                $mail->Password = "starke123";
                $mail->SetFrom("no-reply@viking.rs");
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->AddAddress($to);

                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    
                } 
            }

            http_response_code(200);
        }else{
            http_response_code(500);
        }
}

function serverskaProvera($ime,$prezime,$mejl,$grad,$ulica,$brojP,$brojS,$brojT){
    //ime
    $regUser="/^[ČĆŠĐŽA-zčćšđž]{1,40}$/";
    /*EMAIL */
    $regEmail="/^\w+[\w\-\.]*\@\w+((\-\w+)|(\w*))\.[a-z]{2,3}$/";
    /* Grad */
    $regCty="/^[ČĆŠĐŽA-zčćšđž]+([\s-]?[ČĆŠĐŽA-zčćšđž]+)*$/";
    /* Ulica i broj*/
    $regAdr="/^[ČĆŠĐŽA-zčćšđž]+(\s+[ČĆŠĐŽA-zčćšđž0-9]+)*$/";
    /*ZIP CODE */
    $regZip="/^\d{5}(?:[-\s]\d{4})?$/";
    /*Apartman*/
    $regApt="/^[A-z\d\s]+$/";   
    /*Telefon*/
    $regTel="/^(\(?\+?[0-9]*\)?)?[0-9_\- \(\)]+$/";

    $resUser = preg_match($regUser,$ime);
    $resSurname = preg_match($regUser,$prezime);
    $resEmail=preg_match($regEmail,$mejl);
    $resGrad=preg_match($regCty,$grad);
    $resAdr=preg_match($regAdr,$ulica);
    $resZip= preg_match($regZip,$brojP);
    $resApt=preg_match($regApt,$brojS);
    $resTel= preg_match($regTel,$brojT);

 

    if($resUser==false || $resSurname==false || $resEmail==false || $resGrad==false || $resGrad==false || $resAdr==false || $resZip==false || $resApt==false || $resTel==false){
        $error=false;  
    }
    else{
        $error=true;
    }

    return $error;

}