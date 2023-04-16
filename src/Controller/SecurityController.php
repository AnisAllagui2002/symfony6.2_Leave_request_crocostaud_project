<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignupType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/email", name="security_register")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $encoder
     * @param MailerInterface $mailer
     * @param $to
     * @param $from
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, MailerInterface $mailer): Response
    {
        $to = 'allaguianis7@hotmail.com';
        $from = 'allagui.anis@gmail.com';

        $user = new User();
        $emaill = strval($user->getEmail());
        $form = $this->createForm(SignupType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject("Youre adress mail :".$user->getEmail() . " --Password--" . $user->getPassword() . "--youre role--" . $user->getRole())
                ->text('we wish to inform that you have an adress mail and password to access the platform')
                ->html('<p>With all my love .</p>');

            $mailer->send($email);

            $hashedPasword = $encoder->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPasword);
            $manager->persist($user);
            $manager->flush();
//            return $this->redirectToRoute('security_login');
        }
        return $this->render('platform/email.html.twig', [
            'form' => $form->createView()
        ]);


    }

    #[Route('/login', name: 'security_login')]
    public function login()
    {
        $user = new User();

        return $this->render('security/login.html.twig', [
            'user' => $user->getUserIdentifier(),
            'User' => $user->getUsername()
        ]);
    }

    public function show($id, UserRepository $user)
    {

        $product = $user->find($id);
        return $this->render('platform/home.html.twig', [
            'app.user' => $product
        ]);
    }

    #[Route('/logout', name: 'security_logout')]
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }
}
