<?php

namespace App\Form\XGSB;

use App\Entity\XGSB\Page;
use App\Entity\XGSB\TypePage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
            ->add('Title')
            ->add('parent', EntityType::class, [
                'class'         => Page::class,
                'choice_label'  => 'Name',
                'required'      => false,
            ])
            ->add('Type', EntityType::class, [
                'class'         => TypePage::class,
                'choice_label'  => 'Name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
