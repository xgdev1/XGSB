<?php

namespace App\Controller\XGSB\BO;

use App\Entity\XGSB\Module;
use App\Entity\XGSB\Page;
use App\Entity\XGSB\SectionPage;
use App\Entity\XGSB\TypeModule;
use App\Form\XGSB\ModuleType;
use App\Form\XGSB\PageType;
use App\Form\XGSB\SectionPageType;
use App\Repository\XGSB\ModuleRepository;
use App\Repository\XGSB\PageRepository;
use App\Repository\XGSB\TypeModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Stopwatch\Section;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/BO/page', name:"xgsb_bo_page_")]
class PageController extends AbstractController
{

    /**
     * @param Page                   $page
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    #[Route('/{id}/add-section', name: 'addSection')]
    public function addSection(Page $page, Request $request, EntityManagerInterface $manager){
        $sectionPage=new SectionPage();
        $sectionPage->setPage($page);
        $form = $this->createForm(SectionPageType::class,$sectionPage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $last_ordre=100;
            foreach($page->getSectionsPages() as $s){
                $last_ordre=$s->getOrdre()+100;
            }
            $sectionPage->setOrdre($last_ordre);
            $manager->persist($sectionPage);
            $manager->flush();
            return $this->redirectToRoute('xgsb_bo_page_show', ['id'=>$sectionPage->getPage()->getId()]);
        }
        return $this->render('xgsb/bo/page/addSection.html.twig', [
            'form' => $form->createView(),
            'page'=>$page,
        ]);
    }

    /**
     * @param SectionPage            $sectionPage
     * @param Request                $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    #[Route('/{id}/edit-section', name: 'editSection')]
    public function editSection(SectionPage $sectionPage, Request $request, EntityManagerInterface $manager){{
        $form = $this->createForm(SectionPageType::class,$sectionPage);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            return $this->redirectToRoute('xgsb_bo_page_show', ['id'=>$sectionPage->getPage()->getId()]);
        }
        return $this->render('xgsb/bo/page/editSection.html.twig', [
            'form'      => $form->createView(),
            'page'      => $sectionPage->getPage(),
            'section'   => $sectionPage,
        ]);
    }}
    #[Route('/{id}/add-module/{tm}', name: 'addModule')]
    public function addModule(Page $page, TypeModule $tm,Request $request, EntityManagerInterface $manager,
                              ModuleRepository $moduleRepository){
            $module=new Module();
            $module->setPage($page);
            $module->setType($tm);
            $form= $this->createForm(ModuleType::class, $module);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $nOrder=0;
                $section=$module->getSectionPage();
                if($section->getModules()->count()==1)
                {
                    $lOrder=0;
                }
                else
                {
                    $lOrder=0;
                    foreach($section->getModules() as $module){
                        $lOrder=$module->getOrdre();
                    }
                }
                if(empty($lOrder)){
                    $nOrder=10;
                }else{
                    $nOrder=$lOrder+10;
                }
                $module->setOrdre($nOrder);
                $module->setDateCreation(new \DateTime());
                $manager->persist($module);
                $manager->flush();
                return $this->redirectToRoute('xgsb_bo_page_show', ['id'=>$page->getId()]);
            }
            return $this->render('xgsb/bo/page/addModule.html.twig', [
                'form' => $form->createView(),
                'page'=>$page,
                'TypeModule'=>$tm,
            ]);
    }

    #[Route('/edit-module/{id}', name: 'editmodule')]
    public function editModule(Module $module,Request $request, EntityManagerInterface $manager,){
        $form= $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            return $this->redirectToRoute('xgsb_bo_page_show', ['id'=>$module->getPage()->getId()]);
        }
        return $this->render('xgsb/bo/page/editModule.html.twig', [
            'form' => $form->createView(),
            'page'=>$module->getPage(),
            'module'=>$module,
        ]);
    }
    #[Route('/del-module/{id}', name: 'delmodule', methods: ['GET'])]
    public function delModule(Module $module, EntityManagerInterface $manager, ModuleRepository $moduleRepository){
        $delOrdre=$module->getOrdre();
        $manager->remove($module);
        $modules=$moduleRepository->findModuleWithOrdre($module->getPage(),$delOrdre);
        foreach($modules as $module){
            $module->setOrdre($module->getOrdre()-10);
        }
        $manager->flush();
        return $this->redirectToRoute('xgsb_bo_page_show', ['id'=>$module->getPage()->getId()]);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('xgsb/bo/page/index.html.twig', [
            'pages' => $pageRepository->findBy(["parent" => null], ["Ordre" => "ASC"]),
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
            }else {
                $page->setOrdre($pageLast->getOrdre() + 100);
            }
            $slugger=new AsciiSlugger('fr');
            $page->setSlug($slugger->slug($page->getTitle()));
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
    public function show(Page $page, TypeModuleRepository $typeModuleRepository): Response
    {
        return $this->render('xgsb/bo/page/show.html.twig', [
            'page' => $page,
            'typeModules' => $typeModuleRepository->findAll(),
        ]);
    }

    #[Route('/upmodule/{id}', name: 'upmodule', methods: ['GET'])]
    public function upModule(Module $module, ModuleRepository $moduleRepository, EntityManagerInterface $entityManager): Response
    {
        $oldOrder=$module->getOrdre();
        $newOrder=$oldOrder-10;
        $upModule=$moduleRepository->findModuleByOrdrePage($module->getPage(),$newOrder);
        $module->setOrdre($newOrder);
        $upModule->setOrdre($oldOrder);
        $entityManager->flush();
        return $this->redirectToRoute('xgsb_bo_page_show', ["id"=>$module->getPage()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/upmodule/{id}', name: 'downmodule', methods: ['GET'])]
    public function downModule(Module $module, ModuleRepository $moduleRepository, EntityManagerInterface $entityManager): Response
    {
        $oldOrder=$module->getOrdre();
        $newOrder=$oldOrder+10;
        $upModule=$moduleRepository->findModuleByOrdrePage($module->getPage(),$newOrder);
        $module->setOrdre($newOrder);
        $upModule->setOrdre($oldOrder);
        $entityManager->flush();
        return $this->redirectToRoute('xgsb_bo_page_show', ["id"=>$module->getPage()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $page, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugger=new AsciiSlugger('fr');
            $page->setSlug($slugger->slug($page->getTitle()));
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
