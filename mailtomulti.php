<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/PHPMailer/src/SMTP.php';


//Load Composer's autoloader
require 'C:/xampp/phpMyAdmin/vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->SMTPDebug = 1;                                           //Alternative to above constant
    $mail->Debugoutput = 'html';                        //Ask for HTML-friendly debug output
    $mail->Debugoutput = function($str, $level) {
    file_put_contents('smtp.log', gmdate('Y-m-d H:i:s'). "\t$level\t$str\n", FILE_APPEND | LOCK_EX);
    };
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'consecutive.development@gmail.com';                     //SMTP username
    $mail->Password   = 'CbDevGmailCB!23!';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->SMTPSecure = 'ssl';
    //$mail->Port       = 587; 
   // $mail->SMTPSecure = 'tls';
    $mail->SMTPKeepAlive = true;                         // add it to keep SMTP connection open after each email sent
    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    
    $users = [
        ['email' => 'max@example.com', 'name' => 'Max'],
        ['email' => 'box@example.com', 'name' => 'box'],
        ['email' => 'joe@example.net', 'name' => 'Joe User']
      ];
    
    foreach ($users as $user) {
        
        
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
       // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        $mail->addAddress($user['email'], $user['name']);

        $mail->Body = "<h2>Hello, {$user['name']}!</h2> <p>How are you?</p>";
        $mail->AltBody = "Hello, {$user['name']}! \n How are you?";

        try {
            $mail->send();
            echo "Message sent to: ({$user['email']})\n";
        } catch (Exception $e) {
            echo "Mailer Error ({$user['email']}) {$mail->ErrorInfo}\n";
        }

        $mail->clearAddresses();
      }
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
//$mail->smtpClose(); //use for multi users
$mail->smtpClose();