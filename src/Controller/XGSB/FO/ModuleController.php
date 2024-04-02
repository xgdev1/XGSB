<?php

namespace App\Controller\XGSB\FO;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleController extends AbstractController
{
    #[Route('/x/g/s/b/f/o/module', name: 'app_x_g_s_b_f_o_module')]
    public function index(): Response
    {
        return $this->render('xgsb/fo/module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }
}
