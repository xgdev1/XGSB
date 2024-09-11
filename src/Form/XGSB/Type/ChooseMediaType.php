<?php
namespace App\Form\XGSB\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseMediaType extends AbstractType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'choosemedia';
    }

}