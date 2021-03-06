<?php
namespace Marcin\AdminBundle\Mailer;

use Marcin\SiteBundle\Entity\Username;

class NewsletterMailer {
    
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;
    
    private $fromEmail;
    
    private $fromName;
    
    
    function __construct(\Swift_Mailer $swiftMailer, $fromEmail, $fromName) {
        $this->swiftMailer = $swiftMailer;
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
    }
    
    public function send($email_send, $subject, $htmlBody) {
        $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($this->fromEmail, $this->fromName)
                        ->setTo($email_send)
                        //->setCc('sklep@grupamagnum.eu')
                        ->setBody($htmlBody, 'text/html');
        
        $this->swiftMailer->send($message);
    }
}