<?php

namespace App\Form;

use App\Modele\PersonneModele;
use App\Modele\UserModele;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            -> add('email', TextType::class, [
                    "label" => "Email",
                    "attr" => [
                        "placeholder" => "Saisissez votre email"
                    ]
                ]
            )
            -> add('password', TextType::class, [
                    "label" => "Mot de passe",
                    "attr" => [
                        "placeholder" => "Un mot de passe (minimum 8 caractères, une minuscule, une majuscule, un caractère spécial et un chiffre)"
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver -> setDefaults([
            "data_class" => UserModele::class
        ]);
    }
}
