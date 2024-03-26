<?php

namespace App\Form;

use App\Modele\PersonneModele;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            -> add('prenom', TextType::class, [
                    "label" => "1er prénom",
                    "attr" => [
                        "placeholder" => "Saisissez entre 3 et 50 caractères"
                    ]
                ]
            )
            -> add('nom', TextType::class, [
                    "label" => "Nom de famille",
                    "attr" => [
                        "placeholder" => "Saisissez entre 3 et 50 caractères"
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver -> setDefaults([
            "data_class" => PersonneModele::class
        ]);
    }
}
