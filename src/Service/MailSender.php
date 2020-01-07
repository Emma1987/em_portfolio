<?php

namespace App\Service;

use App\CustomInterface\TemplatedMailInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Class MailSender
 * @package App\Service
 */
class MailSender
{
    /**
     * @var MailerInterface 
     */
    private $mailer;

    /**
     * MailerSender constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param TemplatedMailInterface $mail
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendTemplatedEmail(TemplatedMailInterface $mail)
    {
        $email = (new TemplatedEmail())
            ->from('contact@e-mercadal.com')
            ->to('contact@e-mercadal.com')
            ->subject($mail->getSubject())
            ->htmlTemplate($mail->getTemplate())
            ->context($mail->getContext());

        $this->mailer->send($email);
    }
}