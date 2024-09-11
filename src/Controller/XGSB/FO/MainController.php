<?php

namespace App\Controller\XGSB\FO;

use App\Entity\XGSB\Page;
use App\Repository\XGSB\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'xgsb_fo_home')]
    public function index(PageRepository $pageRepository): Response
    {
        $page=$pageRepository->find(1);
        return $this->render('xgsb/fo/main/page.html.twig', [
            "page"  => $page,
        ]);
    }

    #[Route('/page/{slug}', name: 'xgsb_fo_base_page', methods: ['GET'])]
    public function basepage(string $slug, PageRepository $pageRepository): Response{
        $page=$pageRepository->findOneBy(['slug' => $slug]);
        if($page->getId()==1){
            return $this->redirectToRoute('xgsb_fo_home');
        }
        return $this->render('xgsb/fo/main/page.html.twig', [
            "page" => $page,
        ]);
    }

    public function menu(PageRepository $pageRepository){
        return $this->render("xgsb/fo/helper/_menu.html.twig",[
            "pages" =>  $pageRepository->findBy(["parent"=>null],["Ordre" => "ASC"]),
        ]);
    }

}
