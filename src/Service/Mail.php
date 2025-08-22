<?php

/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 07/01/2022
 * Time: 12:53
 */

namespace App\Service;


use App\Entity\Contact;
use App\Entity\DbCarriers;
use App\Entity\DbUserNewsLetters;
use App\Entity\Job;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\BodyRendererInterface;

class Mail
{
    private  $mailer;
    private $render;


    public function __construct(MailerInterface $mailer, BodyRendererInterface $bodyRender)
    {
        $this->mailer = $mailer;
        $this->render = $bodyRender;
    }

    public function hr(Job $msg, DbCarriers $job) :void
    {
        $mail = (new TemplatedEmail())
            ->subject('OFFRE N° : ' . $job->getNumber())
            ->from(new Address('noreplay@kwetugroup.com'))
            ->to('recrument@kwetugroup.com')
            ->replyTo($msg->getEmail())
            ->attachFromPath($msg->getCv())
            ->attachFromPath($msg->getLetter())
            ->htmlTemplate('mail/hr.html.twig')
            ->context([
                'msg' => $msg,
                'job' => $job
            ]);
        $this->render->render($mail);
        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $e) {
            //return $e;
        }
    }

    public function jobNotification(Job $msg, DbCarriers $job) :void
    {
        $mail = (new TemplatedEmail())
            ->subject('Accusé de réception de votre candidature spontanée')
            ->from(new Address('noreplay@kwetugroup.com'))
            ->to($msg->getEmail())
            ->htmlTemplate('mail/job_notification.html.twig')
            ->context([
                'msg' => $msg,
                'job' => $job
            ]);
        $this->render->render($mail);
        try {
            $this->mailer->send($mail);
        } catch (TransportExceptionInterface $e) {
            //return $e;
        }
    }

    public function newsLetter(DbUserNewsLetters $user, DbCarriers $newsletter) :void
    {
        $email = (new TemplatedEmail())
            ->from('noreplay@kwetugroup.com')
            ->to($user->getEmail())
            ->subject('Job alert from KWETUGROUP SARL')
            ->htmlTemplate('mail/newsletter.html.twig')
            ->context([
                'data' => $newsletter,
                'user' => $user
            ]);
        $this->render->render($email);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            //return $e;
        }
    }

    public function contact(Contact $contact) :void
    {
        $email = (new TemplatedEmail())
            ->from('noreplay@kwetugroup.com')
            ->replyTo($contact->getEmail())
            ->to('contact@kwetugroup.com')
            ->subject($contact->getName() . ' : ' . $contact->getSubject())
            ->htmlTemplate('mail/contact.html.twig')
            ->context([
                'data' => $contact,
            ]);
        $this->render->render($email);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            //return $e;
        }
    }
}