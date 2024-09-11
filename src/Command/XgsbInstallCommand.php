<?php

namespace App\Command;

use App\Entity\XGSB\Page;
use App\Entity\XGSB\TypeModule;
use App\Entity\XGSB\TypePage;
use App\Entity\XGSB\User;
use App\Form\XGSB\ModuleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[AsCommand(
    name: 'xgsb:install',
    description: "Permet l'installation des données minimums pour le fonctionnement de XGSB",
)]
class XgsbInstallCommand extends Command
{
    /** @var EntityManagerInterface */
    private $em;

    private $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em=$entityManager;
        $this->passwordHasher=$passwordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title("Installation de XGSB");

        $io->section("Création des types de page de base");
        $typePage=new TypePage();
        $typePage->setName('Contenu');
        $typePage->setCode('content');
        $typePage->setIsSpecial(false);
        $this->em->persist($typePage);
        $typePage2= new TypePage();
        $typePage2->setName("Entete sous menu");
        $typePage2->setCode("#");
        $typePage2->setIsSpecial(false);
        $this->em->persist($typePage2);
        $io->success("Les types de page de base ont été installé");

        $io->section("Création des types de module");

        $moduleType1 = new TypeModule();
        $moduleType1->setName('Métier');
        $moduleType1->setCode('metier');
        $moduleType1->setDescription("Permet l'affichage des contenus spécifiques");
        $this->em->persist($moduleType1);

        $moduleType2 = new TypeModule();
        $moduleType2->setName('Titre');
        $moduleType2->setCode('title');
        $moduleType2->setDescription("Sert à insérer un titre");
        $this->em->persist($moduleType2);

        $moduleType3 = new TypeModule();
        $moduleType3->setName('Image et texte');
        $moduleType3->setCode('imageText');
        $moduleType3->setDescription("Permet d'insérer un texte avec/sans images et de choisir ou elle s'affiche (haut/gauche/droite/bas)");
        $this->em->persist($moduleType3);

        $moduleType4 = new TypeModule();
        $moduleType4->setName('Carte');
        $moduleType4->setCode('card');
        $moduleType4->setDescription("Permet de créer une carte configurer comme vous le souhaitez. Elle peut contenir jusqu'à quatre éléments : Titre, Sous-titre, Texte, Image");
        $this->em->persist($moduleType4);

        $moduleType5 = new TypeModule();
        $moduleType5->setName('Vidéo');
        $moduleType5->setCode('video');
        $moduleType5->setDescription("Permet d'insérer une video mise sur un service de streaming");
        $this->em->persist($moduleType5);

        $moduleType6 = new TypeModule();
        $moduleType6->setName('bannière');
        $moduleType6->setCode('banner');
        $moduleType6->setDescription("Permet d'afficher une bannière");
        $this->em->persist($moduleType6);
        $io->success("Les types de modules de base ont bien été installé");

        $io->section("Installation des pages de base");
        $homepage=new Page();
        $homepage->setOrdre(100);
        $homepage->setName("Home");
        $homepage->setTitle('Accueil');
        $homepage->setType($typePage);
        $slugger=new AsciiSlugger('fr');
        $homepage->setSlug($homepage->getTitle());
        $homepage->setDateCreation(new \DateTime());
        $this->em->persist($homepage);
        $io->success('Les pages de base ont bien été installé');

        $admin=new User();
        $admin->setEmail("admin@xgdev.fr");
        $hash=$this->passwordHasher->hashPassword($admin,"4dm1n!p455");
        $admin->setPassword($hash);
        $roles=["ROLE_ADMIN","ROLE_SUPERADMIN"];
        $admin->setRoles($roles);
        $this->em->persist($admin);
        $io->success('Le compte admin a bien été installé');
        $this->em->flush();
        $io->success("L'installation est réussi, vous pouvez maintenant configurer votre site");
        return Command::SUCCESS;
    }
}
