<?php

namespace App\Controller\XGSB\BO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/BO', name:"xgsb_bo_")]
class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('xgsb/bo/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
