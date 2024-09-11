<?php

namespace App\Form\XGSB;

use App\Entity\XGSB\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email",
                'required' => true,
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => true,
            ])
            ->add('roles', ChoiceType::class, [
                "label" => "Roles",
                "choices" => [
                    "Utilisateur" => "ROLE_USER",
                    "Editeur" => "ROLE_EDITEUR",
                    "Administrateur" => "ROLE_ADMIN",
                    "SuperAdmin" => "ROLE_SUPERADMIN"
                ],
                "expanded"  => true,
                "multiple"  => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
