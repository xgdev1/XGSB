<?php

namespace App\Form\XGSB;

use App\Entity\XGSB\Page;
use App\Entity\XGSB\SectionPage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, [
                "label"     => "Nom",
                "required"  => true,
                "help"      => "Merci de mettre un nom sans espace (les remplacer par des -)",
            ])
            ->add('BGColor', ChoiceType::class, [
                'required'  =>  false,
                'label'     =>  "Couleur de la section",
                'help'      =>  "Laisser vide pour laisser par défaut",
                "choices"   => [
                    "Transparent"           => "bg-transparent",
                    "Couleur primaire"      => "text-bg-primary",
                    "Couleur secondaire"    => "text-bg-secondary",
                    "Couleur succès"        => "text-bg-success",
                    "Couleur danger"        => "text-bg-danger",
                    "Couleur alerte"        => "text-bg-warning",
                    "Couleur info"          => "text-bg-info",
                    "Couleur claire"        => "text-bg-light",
                    "Couleur foncée"         => "text-bg-dark",
                ],
                'choice_attr' => function ($choice, $key, $value){
                    return ['class' => $value];
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SectionPage::class,
        ]);
    }
}
