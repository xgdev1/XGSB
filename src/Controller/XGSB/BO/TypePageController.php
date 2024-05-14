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

#[Route('/BO/type_page', name:"xgsb_bo_type_page_")]
class TypePageController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TypePageRepository $typePageRepository): Response
    {
        return $this->render('xgsb/bo/type_page/index.html.twig', [
            'type_pages' => $typePageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typePage = new TypePage();
        $form = $this->createForm(TypePageType::class, $typePage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typePage);
            $entityManager->flush();

            return $this->redirectToRoute('xgsb_bo_type_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_page/new.html.twig', [
            'type_page' => $typePage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(TypePage $typePage): Response
    {
        return $this->render('xgsb/bo/type_page/show.html.twig', [
            'type_page' => $typePage,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypePage $typePage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypePageType::class, $typePage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('xgsb_bo_type_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/type_page/edit.html.twig', [
            'type_page' => $typePage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, TypePage $typePage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePage->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typePage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('xgsb_bo_type_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
