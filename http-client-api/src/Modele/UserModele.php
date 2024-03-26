<?php

namespace App\Modele;

use Symfony\Component\Validator\Constraints as Assert;

class UserModele
{
    #[Assert\Length(
        min: 4,
        max: 150,
        minMessage: "L'email est trop court",
        maxMessage: "L'email est trop long"
    ),Assert\Email(message:"Veuillez respecter le format des emails")]
    public ?string $email = null;
    #[Assert\Length(
        min: 8,
        max: 20,
        minMessage: "Le mot de passe est trop court",
        maxMessage: "Le mot de passe est trop long"
    ),
//        Assert\Regex("/=.*?[A-Z]+/",message: "Le mot de passe doit contenir une majuscule"),
//        Assert\Regex("/=.*?[a-z]+/",message: "Le mot de passe doit contenir une minuscule"),
//        Assert\Regex("/\d+/",message: "Le mot de passe doit contenir un chiffre"),
//        Assert\Regex("/[#?!@$%^&*\-])/",message: "Le mot de passe doit contenir un symbole spécial"),
    ]
    public ?string $password = null;
}