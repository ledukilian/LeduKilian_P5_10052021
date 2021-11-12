<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Services\MessageHandler;
use App\Models\User;

class Mailer {
   private PHPMailer $mailer;
   private $config;
   private static $owner;

   public function __construct() {
      $this->config = yaml_parse_file(CONF_DIR . '/mail.yml');
      $this->mailer = (new PHPMailer(true));
      $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
      $this->mailer->isSMTP();
      $this->mailer->Host = $this->config['mailer']['host'];
      $this->mailer->SMTPAuth = $this->config['mailer']['smtp'];
      $this->mailer->Username = $this->config['mailer']['username'];
      $this->mailer->Password = $this->config['mailer']['password'];
      $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      $this->mailer->Port = $this->config['mailer']['port'];
      $this->mailer->setFrom($this->config['from']['mail'], $this->config['from']['name']);
   }

   public function registered(User $user) {
      return $this->send([
         'mail' => $user->getEmail(),
         'name' => $user->getFirstname().' '.$user->getLastname(),
         'reply-mail' => $this->config['contact-to']['mail'],
         'reply-name' => $this->config['contact-to']['name'],
         'subject' => 'KLD Blog - Inscription',
         'message' => 'Bonjour '.$user->getFirstname().', Vous venez de vous inscrire sur KLD Blog.'
      ]);
   }

   public function contact($data) {
      return $this->send([
         'mail' => $this->config['contact-to']['mail'],
         'name' => $this->config['contact-to']['name'],
         'reply-mail' => $data['email'],
         'reply-name' => $data['name'],
         'subject' => 'KLD Blog - '.$data['subject'],
         'message' => $data['subject']
      ]);
   }

   public function send(array $mailData) {
      try {
          $this->mailer->addAddress($mailData['mail'], $mailData['name']);
          $this->mailer->addReplyTo($mailData['reply-mail'], $mailData['reply-name']);
          $this->mailer->isHTML(true);
          $this->mailer->Subject = $mailData['subject'];
          $this->mailer->Body = $mailData['message'];
          $this->mailer->AltBody = htmlspecialchars($mailData['message']);
          $this->mailer->send();
          return true;
      } catch (Exception $e) {
         return false;
      }
   }

   public function getMailer() {
      return $this->_mailer;
   }

   public function setMailer(PHPMailer $value) {
      $this->_mailer = $value;
   }

}