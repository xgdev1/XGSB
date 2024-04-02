<?php

namespace App\Controller\XGSB\FO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'xgsb_fo_main')]
    public function index(): Response
    {
        return $this->render('xgsb/fo/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
