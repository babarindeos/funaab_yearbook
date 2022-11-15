<?php

class Mail implements MailInterface{

    private $sender;
    private $sender_email;
    private $recipient_email;
    private $recipient_name;
    private $subject;
    private $message;

    public function __construct(){
      $this->sender = null;
      $this->sender_email = null;
      $this->recipient_email = null;
      $this->recipient_name = null;
      $this->subject = null;
      $this->message = null;
    }

    public function compose_email($recipient_name, $recipient_email, $subject, $message){
        $this->recipient_name = $recipient_name;
        $this->recipient_email = $recipient_email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function sendMail(){

          $this->message = "<html><head><title>FUNAAB YearBook</title></head><body>".$this->message."</body></html>";

          $headers[] = 'MIME-Version: 1.0';
          $headers[] = 'Content-type: text/html; charset=iso-8859-1';

          // Additional headers
          $headers[] = 'To: '.$this->recipient_name.' <'.$this->recipient_email.'>';
          $headers[] = 'From: '.$this->subject.' <service@servicebill.unaab.edu.ng>';

          $response = mail($this->recipient_email, $this->subject, $this->message, implode("\r\n", $headers));

          return $response;
    }

    public function sendMailFox($sender, $sender_email, $recipient, $subject, $message)
    {
       $to = $recipient;
       $subject = $subject;
       $from = $sender_email;

       //setting content header
       $headers = 'MIME-Version: 1.0' . "\r\n";
       $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

       // create email headers
       $headers .= 'From: '.$from."\r\n".
                   'Reply-To: '.$from."\r\n".
                   'Return-Path: service@servicebill.unaab.edu.ng'."\r\n".
                   'CC: service@servicebill.unaab.edu.ng'."\r\n".
                   'BCC: service@servicebill.unaab.edu.ng'."\r\n".
                   'X-Mailer: PHP/'.phpversion();

      $body = '<html><body>';
      $body .= $message;
      $body .= '</body></html>';


      if (mail($to, $subject, $body, $headers)){
        return 'sent';
      }else{
        return 'failed';
      }

    }


}


?>
