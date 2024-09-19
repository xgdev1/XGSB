<?php

namespace App\Form\XGSB\ParamModuleType;


use App\Form\XGSB\Type\ChooseMediaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParamCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ClassCard', ChoiceType::class, [
                'required'  =>  false,
                'label'     =>  "Couleur de la carte",
                'help'      =>  "Laisser vide pour laisser par défaut",
                'choices'   => [
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
            ->add('VideoMP4', ChooseMediaType::class, array(
                'required' => false,
                'label' => "Video au format MP4",
                'help' => 'Choisir la video sur le serveur au format mp4 attention la video youtube est prioritaire',
            ))
            ->add('VideoYT', TextType::class, array(
                'required' => false,
                'label' => "Video Youtube",
                'help' => 'Entrer l\'id de la video si vous cliquez sur partager est que l\'adresse ressemble à ça : 
                            https://youtu.be/u3ST8eSSAt8?si=eAZJ3EIcRrX1_1VQ => id=u3ST8eSSAt8  ',
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