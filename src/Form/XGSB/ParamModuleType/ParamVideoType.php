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

class ParamVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, array(
                "required" => false,
                'label' => "Titre",
                'help' => "Entrer un texte si vous voulez afficher un titre sinon laisser vide",
            ))
            ->add('media', TextareaType::class, array(
                "required" => false,
                'label' => "Code de la video",
                'help' => "Copier le code donné par la plateforme de video à partir de la balise embed ou iframe",
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