<?php

namespace App\Form\XGSB\ParamModuleType;


use App\Form\XGSB\Type\ChooseMediaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParamCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, array(
                "required" => false,
                'label' => "Titre",
                'help' => "Titre à afficher dans le header de la carte",
            ))
            ->add('SubTitle', TextType::class, array(
                "required" => false,
                'label' => "Sous-titre",
                'help' => "Sous titre ou titre principale dans la carte",
            ))
            ->add('Image', ChooseMediaType::class, array(
                'required' => false,
                'label' => "Image",
                'help' => 'Choisir l\'image sur le serveur si vous souhaitez en afficher une dans la carte',
            ))
            ->add('ImagePosition', ChoiceType::class, [
                'choices' => [
                    'Image en haut' => 'top',
                    'Image à gauche' => 'left',
                    'Image à droite' => 'right',
                    'Image en bas'  => 'bottom'
                ],
                'label' => "Position de l'image" ,
                'help' => 'Permet de choisir la position de l\'image par rapport au texte'
            ])
            ->add('Texte', CKEditorType::class, array(
                "required" => false,
                'label' => "Contenu du module",
                'help' => "Ne pas insérer d'image directement dans le contenu afin d'assurer une cohérence de présentation au site",
                'config_name' => 'base_config',
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