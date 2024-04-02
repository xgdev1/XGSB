<?php

namespace App\Controller\XGSB\BO;

use App\Entity\XGSB\TypeModule;
use App\Form\XGSB\TypeModuleType;
use App\Repository\XGSB\TypeModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/x/g/s/b/b/o/type/module')]
class TypeModuleController extends AbstractController
{
    #[Route('/', name: 'app_x_g_s_b_b_o_type_module_index', methods: ['GET'])]
    public function index(TypeModuleRepository $typeModuleRepository): Response
    {
        return $this->render('xgsb/bo/type_module/index.html.twig', [
            'type_modules' => $typeModuleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_x_g_s_b_b_o_type_module_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeModule = new TypeModule();
        $form = $this->createForm(TypeModuleType::class, $typeModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeModule);
            $entityManager->flush();

            return $this->redirectToRoute('app_x_g_s_b_b_o_type_module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_module/new.html.twig', [
            'type_module' => $typeModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_x_g_s_b_b_o_type_module_show', methods: ['GET'])]
    public function show(TypeModule $typeModule): Response
    {
        return $this->render('xgsb/bo/type_module/show.html.twig', [
            'type_module' => $typeModule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_x_g_s_b_b_o_type_module_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeModule $typeModule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeModuleType::class, $typeModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_x_g_s_b_b_o_type_module_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_module/edit.html.twig', [
            'type_module' => $typeModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_x_g_s_b_b_o_type_module_delete', methods: ['POST'])]
    public function delete(Request $request, TypeModule $typeModule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeModule->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeModule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_x_g_s_b_b_o_type_module_index', [], Response::HTTP_SEE_OTHER);
    }
}
