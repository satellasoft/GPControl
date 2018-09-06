<?php

namespace App\Util;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSend {

    const host = "";
    const port = "";
    const user = "";
    const pass = "";
    
    const from = "";
    const applicationName = "SatellaSoft Project";

    function SendMessageMultipleUser(array $mailsTo, string $title, $message, string $subject) {
               
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Host = self::host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = self::user;                 // SMTP username
            $mail->Password = self::pass;                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = self::port;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom(self::from, self::applicationName);

            foreach ($mailsTo as $m) {
                $mail->addBCC($m); // Name is optional   
            }
            
            //Imagens anexadas
            $mail->AddEmbeddedImage("img/icon.png", "logo", "Logo project SatellaSoft");
            $mail->AddEmbeddedImage("img/mail-icon/facebook-icon.png", "facebook", "Facebook");
            $mail->AddEmbeddedImage("img/mail-icon/twitter-icon.png", "twitter", "Twitter");
            $mail->AddEmbeddedImage("img/mail-icon/instagram-icon.png", "instagram", "Instagram");
            $mail->AddEmbeddedImage("img/mail-icon/youtube-icon.png", "youtube", "Youtube");

            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $this->MailHTMLBody($title, $message);
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    private function MailHTMLBody(string $title,  $message) {
        $message = html_entity_decode($message);
        $str = "<style>" .
                "@import url('https://fonts.googleapis.com/css?family=Open+Sans');" .
                "</style>" .
                "<div style='max-width: 800px; width:100%; margin: 0 auto; padding: 0; font-family: Open Sans, sans serif; font-size: 1.2em;'>" .
                "<div style='background-color: #DF4949; padding: 10px; box-sizing: border-box;'>" .
                "<div style='width: 150px; float: left;'>" .
                "<a href='https://www.satellasoft.com/'><img src='cid:logo' alt='Logo SatellaSoft' style='max-width: 30px; width:100%;' /></a>" .
                "</div>" .
                "<div style='width: 200px; text-align: right; float: right;'>" .
                "<a style='padding:5px;' href='https://www.facebook.com/pages/SatellaSoft/382499698505476?ref=ts&fref=ts'><img src='cid:facebook' alt='Facebook SatellaSoft' style='max-width: 25px; width:100%;' /></a>" .
                "<a style='padding:5px;' href='https://twitter.com/satellasoft'><img src='cid:twitter' alt='Twitter SatellaSoft' style='max-width: 25px; width:100%;' /></a>" .
                "<a style='padding:5px;' href='https://www.youtube.com/user/satellasoft1'><img src='cid:youtube' alt='Youtube SatellaSoft' style='max-width: 25px; width:100%;' /></a>" .
                "<a style='padding:5px;' href='https://www.instagram.com/satellasoft/'><img src='cid:instagram' alt='Instagram SatellaSoft' style='max-width: 25px; width:100%;' /></a>" .
                "</div>" .
                "<div style='clear:both;'></div>" .
                "</div>" .
                "<div>" .
                "<div style='text-align: center;'><h1 style='color: #111; font-size: 1.5em;'>{$title}</h1></div>" .
                "<div>{$message}</div>" .
                "</div>" .
                "<div style='background-color: #243141; padding: 10px; text-align: center;'>" .
                "<p><a href='https://satellasoft.com' style='text-decoration: none; color: #FFF; font-weight:bold;'>&copy; SatellaSoft - All Right Reserved</a></p>" .
                "<p><a href='https://www.satellasoft.com/?contato=satellasoft' style='text-decoration: none; color: #FFF; font-weight:bold;'> Contact</a></p>" .
                "</div>" .
                "</div>";
                
                return $str;
    }

}
