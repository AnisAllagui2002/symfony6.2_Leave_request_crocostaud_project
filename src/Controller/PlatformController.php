<?php

namespace App\Controller;


use App\Entity\TypesConges;
use App\Repository\ArticlesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlatformController extends AbstractController
{
    #[Route('/about', name: 'app_Aboutcompany')]
    public function Aboutcompany(): Response
    {
        return $this->render('platform/index.html.twig', [
            'controller_name' => 'PlatformController',
        ]);
    }

    #[Route('/', name: 'app_platform_home')]
    public function home()
    {
        return $this->render('platform/home.html.twig');
    }

    #[Route('/request', name: 'app_platform_holidayrequest')]
    public function holidayrequest()
    {
        return $this->render('platform/Holidayrequest.html.twig');
    }


    #[Route('/consult', name: 'app_platform_tableconsulting')]
    public function Tableconsulting()
    {
        return $this->render('platform/tableconsulting.html.twig');
    }

    #[Route('/welcome', name: 'app_platform_welcome')]
    public function welcome()
    {
        return $this->render('platform/welcome.html.twig');
    }





}
