<?php

namespace App\Command;

use App\Entity\XGSB\Menu;
use App\Entity\XGSB\SectionPage;
use App\Entity\XGSB\TypeModule;
use App\Repository\XGSB\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'xgsb:upgrade:1-1',
    description: 'Add a short description for your command',
)]
class XgsbUpgrade11Command extends Command
{
    /** @var EntityManagerInterface */
    private $em;

    private $pageRepository;

    public function __construct(EntityManagerInterface $entityManager, PageRepository $pageRepository)
    {
        $this->em=$entityManager;
        $this->pageRepository=$pageRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title("Upgrade de XGSB 1.0.x à 1.1");
        $io->section("Création des menus par défaut");
        $menu_principal=new Menu();
        $menu_principal->setName('Menu Principal');
        $this->em->persist($menu_principal);
        $menu_footer=new Menu();
        $menu_footer->setName('Menu Footer');
        $this->em->persist($menu_footer);
        $io->success("Tous les menus ont bien été créer");
        $io->section("Affectation des pages existante au menu principale");
        $pages=$this->pageRepository->findAll();
        foreach($pages as $page){
            $page->setMenu($menu_principal);
            $section[$page->getId()]=new SectionPage();
            $section[$page->getId()]->setName('Section 1' . $page->getTitle());
            $section[$page->getId()]->setPage($page);
            $section[$page->getId()]->setOrdre(10);
            $this->em->persist($section[$page->getId()]);
            foreach($page->getModules() as $module){
                $section[$page->getId()]->addModule($module);
            }
        }
        $moduleType1 = new TypeModule();
        $moduleType1->setName('Widget');
        $moduleType1->setCode('widget');
        $moduleType1->setDescription("Permet l'affichage d'un widget externe (iframe/code javascript...)");
        $this->em->persist($moduleType1);

        $this->em->flush();
        $io->success("Toutes les pages ont bien été affectée");
        return Command::SUCCESS;
    }
}
