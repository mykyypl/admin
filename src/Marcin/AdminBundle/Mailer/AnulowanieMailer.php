<?php
namespace Marcin\AdminBundle\Mailer;

use Marcin\SiteBundle\Entity\Username;

class AnulowanieMailer {
    
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
    
    public function send($userEmail, $subject, $htmlBody) {
                                    foreach ($userEmail as $email)
                        {
                          
                            $wyslanie = $email;
                        }
        $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($this->fromEmail, $this->fromName)
                        ->setTo($wyslanie)
                        ->setCc('sklep@grupamagnum.eu')
                        ->setBody($htmlBody, 'text/html');
        
        $this->swiftMailer->send($message);
    }
}