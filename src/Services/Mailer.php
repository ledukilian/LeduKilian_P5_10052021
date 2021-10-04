<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mailer {
   private PHPMailer $mailer;
   private Array $config;

   public function __construct() {
      $config = yaml_parse_file(CONF_DIR . '/mail.yml');
      $this->setMailer(new PHPMailer(true));
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->Host = $config['mailer']['host'];
      $mail->SMTPAuth = $config['mailer']['smtp'];
      $mail->Username = $config['mailer']['username'];
      $mail->Password = $config['mailer']['password'];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $mail->Port = $config['mailer']['port'];
      $mail->setFrom($config['from']['mail'], $config['from']['name']);
   }

   public function send($arrayDaya) {
      try {
          $mail->addAddress('joe@example.net', 'Joe User');
          $mail->addReplyTo('info@example.com', 'Information');
          $mail->isHTML(true);
          $mail->Subject = 'Here is the subject';
          $mail->Body = 'This is the HTML message body <b>in bold!</b>';
          $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
          $mail->send();
          echo 'Message has been sent';
      } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   }

   public function getMailer() {
      return $this->_mailer;
   }

   public function setMailer(PHPMailer $value) {
      $this->_mailer = $value;
   }

}