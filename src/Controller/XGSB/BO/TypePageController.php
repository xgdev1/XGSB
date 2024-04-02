<?php

namespace App\Controller\XGSB\BO;

use App\Entity\XGSB\TypePage;
use App\Form\XGSB\TypePageType;
use App\Repository\XGSB\TypePageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/x/g/s/b/b/o/type/page')]
class TypePageController extends AbstractController
{
    #[Route('/', name: 'app_x_g_s_b_b_o_type_page_index', methods: ['GET'])]
    public function index(TypePageRepository $typePageRepository): Response
    {
        return $this->render('xgsb/bo/type_page/index.html.twig', [
            'type_pages' => $typePageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_x_g_s_b_b_o_type_page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typePage = new TypePage();
        $form = $this->createForm(TypePageType::class, $typePage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typePage);
            $entityManager->flush();

            return $this->redirectToRoute('app_x_g_s_b_b_o_type_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_page/new.html.twig', [
            'type_page' => $typePage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_x_g_s_b_b_o_type_page_show', methods: ['GET'])]
    public function show(TypePage $typePage): Response
    {
        return $this->render('xgsb/bo/type_page/show.html.twig', [
            'type_page' => $typePage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_x_g_s_b_b_o_type_page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypePage $typePage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypePageType::class, $typePage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_x_g_s_b_b_o_type_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_page/edit.html.twig', [
            'type_page' => $typePage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_x_g_s_b_b_o_type_page_delete', methods: ['POST'])]
    public function delete(Request $request, TypePage $typePage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePage->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typePage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_x_g_s_b_b_o_type_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
