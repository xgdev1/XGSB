<?php

namespace App\Controller\XGSB\BO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/x/g/s/b/b/o/main', name: 'app_x_g_s_b_b_o_main')]
    public function index(): Response
    {
        return $this->render('xgsb/bo/main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
