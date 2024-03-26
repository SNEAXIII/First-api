<?php

namespace App\Controller;

use App\Form\PersonneType;
use App\Modele\PersonneModele;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    #[Route('/register', name: 'app_personne_register')]
    public function register(Request $request): Response
    {
        $personne = new PersonneModele();
        $personneForm = $this -> createForm(PersonneType::class, $personne);
        $personneForm -> handleRequest($request);
        if ($personneForm -> isSubmitted() && $personneForm -> isValid()) {
            $this -> addFlash("success", "La personne a bien été ajoutée");
            return $this -> redirectToRoute("app_accueil");
        }
        return $this -> render('personne/index.html.twig', [
            'personneForm' => $personneForm,
        ]);
    }
}
