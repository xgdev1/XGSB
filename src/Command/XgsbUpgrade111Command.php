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
    name: 'xgsb:upgrade:1-1-1',
    description: 'Add a short description for your command',
)]
class XgsbUpgrade111Command extends Command
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
        $typeModule = new TypeModule();
        $typeModule->setName("Flip card");
        $typeModule->setCode("flipcard");
        $typeModule->setDescription("Permet l'affichage d'une carte qui se retourne");
        $this->em->persist($typeModule);

        $this->em->flush();
        return Command::SUCCESS;
    }
}
