<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adapter PHP</title>
</head>
<body>
<?php

//classe EmailSender qui envoie des e-mails :

class EmailSender
{
    public function sendEmail($to, $subject, $body)
    {
        // Code pour envoyer un e-mail
    }
}

//classe SMSSender qui envoie des messages SMS :
class SMSSender
{
    public function sendSMS($number, $message)
    {
        // Code pour envoyer un SMS
    }
}

//nous avons une fonctionnalité qui doit envoyer des messages, mais qui ne sait pas si elle doit envoyer des e-mails ou des SMS. 
//on un adaptateur pour créer une classe intermédiaire MessageSender qui implémente une interface SenderInterface et 
//utilise les classes EmailSender ou SMSSender en fonction des besoins :
interface SenderInterface
{
    public function send($to, $subjectOrMessage, $body = null);
}

class MessageSender implements SenderInterface
{
    private $sender;

    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    public function send($to, $subjectOrMessage, $body = null)
    {
        if ($this->sender instanceof EmailSender) {
            $this->sender->sendEmail($to, $subjectOrMessage, $body);
        } elseif ($this->sender instanceof SMSSender) {
            $this->sender->sendSMS($to, $subjectOrMessage);
        } else {
            throw new Exception('Unsupported sender type');
        }
    }
}

//nous pouvons utiliser MessageSender pour envoyer des messages, sans avoir à se soucier de savoir si nous envoyons des e-mails ou des SMS :
$emailSender = new EmailSender();
$messageSender = new MessageSender($emailSender);
$messageSender->send('johndoe@example.com', 'Hello', 'How are you?');

$smsSender = new SMSSender();
$messageSender = new MessageSender($smsSender);
$messageSender->send('123456789', 'Hello');
//nous avons créé un adaptateur MessageSender qui permet à nos classes d'envoi de messages incompatibles d'être utilisées de manière interchangeable, 
//en utilisant une interface commune. 
?>
</body>
</html>