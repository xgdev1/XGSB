<?php

namespace App\Form\XGSB\ParamModuleType;


use App\Form\XGSB\Type\ChooseMediaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParamTitleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TypeTitre', ChoiceType::class, [
                'choices' => [
                    'Titre 1' => 'h1',
                    'Titre 2' => 'h2',
                    'Titre 3' => 'h3',
                    'Titre 4' => 'h4',
                    'Titre 5' => 'h5',
                    'Titre 6' => 'h6',
                ],
                'label' => "Type de titre" ,
                'help' => 'Permet de choisir la position de l\'image par rapport au texte'
            ])
            ->add('Titre', TextType::class, array(
                "required" => false,
                'label' => "Titre",
                'help' => "Texte que vous voulez afficher",
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}