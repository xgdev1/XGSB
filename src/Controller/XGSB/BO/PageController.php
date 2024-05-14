<?php

namespace App\Controller\XGSB\BO;

use App\Entity\XGSB\Page;
use App\Form\XGSB\PageType;
use App\Repository\XGSB\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/BO/page', name:"xgsb_bo_page_")]
class PageController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('xgsb/bo/page/index.html.twig', [
            'pages' => $pageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, PageRepository $pageRepository): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page->setDateCreation(new \DateTime());
            $pageLast=$pageRepository->findLastOrdre($page->getParent());
            if(empty($pageLast)){
                $page->setOrdre(100);
            }else{
                $page->setOrdre($pageLast->getOrdre()+100);
            }
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('xgsb_bo_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Page $page): Response
    {
        return $this->render('xgsb/bo/page/show.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('xgsb_bo_page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('xgsb/bo/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('xgsb_bo_page_index', [], Response::HTTP_SEE_OTHER);
    }
}
