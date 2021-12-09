<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Empleado;

class Mailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function notificarAlta(Empleado $empleado) {
        $email = (new Email())
            ->from('notificaciones@pruebabackend.com')
            ->to($empleado->getEmail())
            ->subject('Alta en club')
            ->text('has sido dado de alta en el club ' . $empleado->getClub()->getNombre() . ' satisfactoriamente.');

        $this->mailer->send($email);
    }
}