<?php
namespace App\Service;
use Symfony\Component\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
/**
 * service qui permet de generer un mail
 */
class MailerService{

   public function __construct( private  MailerInterface $mailer){
       $this->mailer=$mailer;
    }
    public function send(
        string $to,
        string $subject,
        string $templatetwig,
        array $context):void
        {

            $email = (new TemplatedEmail())
            ->from(new Address('noreplay@monsite.fr','monsite'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("mails/$templatetwig")
            ->context($context);

            try{
                
                $this->mailer->send($email);

            }catch(TransportExeptionInterface $transportExeption){
                throw $transportExeption;
            }

    }
}