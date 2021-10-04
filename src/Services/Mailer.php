<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Services\MessageHandler;

class Mailer {
   private PHPMailer $mailer;

   public function __construct() {
      $config = yaml_parse_file(CONF_DIR . '/mail.yml');
      $this->mailer = (new PHPMailer(true));
      $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
      $this->mailer->isSMTP();
      $this->mailer->Host = $config['mailer']['host'];
      $this->mailer->SMTPAuth = $config['mailer']['smtp'];
      $this->mailer->Username = $config['mailer']['username'];
      $this->mailer->Password = $config['mailer']['password'];
      $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $this->mailer->Port = $config['mailer']['port'];
      $this->mailer->setFrom($config['from']['mail'], $config['from']['name']);
   }

   public function send(array $mailData) {
      try {
          $config = yaml_parse_file(CONF_DIR . '/mail.yml');
          $this->mailer->addAddress($mailData['mail'], $mailData['name']);
          $this->mailer->addReplyTo($config['from']['mail'], $config['from']['name']);
          $this->mailer->isHTML(true);
          $this->mailer->Subject = $mailData['subject'];
          $this->mailer->Body = $mailData['message'];
          $this->mailer->AltBody = htmlspecialchars($mailData['message']);
          $this->mailer->send();
          echo MessageHandler::MAIL_SENT;
      } catch (Exception $e) {
          echo MessageHandler::MAIL_ERROR.' Erreur : '.$this->mailer->ErrorInfo;
      }
   }

   public function getMailer() {
      return $this->_mailer;
   }

   public function setMailer(PHPMailer $value) {
      $this->_mailer = $value;
   }

}