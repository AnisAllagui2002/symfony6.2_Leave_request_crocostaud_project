<?php

namespace App\Controller;


//use PharIo\Manifest\Email;
use App\Entity\User;
use App\Form\SignupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class MailerController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/mailer')]
    public function sendEmail(MailerInterface $mailer, $to = 'allaguianis7@hotmail.com',
                                              $from = 'allagui.anis@gmail.com'): Response
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject('youre new Adress Mail')
            ->text('we wish to inform that you have an adress mail and password to access the platform')
            ->html('<p>With all my love .</p>');

        $mailer->send($email);


        return $this->render('mailer/email.html.twig');
    }


}
