<?php

namespace App\Controller;

use App\Form\UserType;
use App\Modele\UserModele;
use App\Service\UserService;
use phpDocumentor\Reflection\Type;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/login', name: 'app_user_login')]
    public function login(Request $request,UserService$userService): Response
    {
//        $request->getSession()
        $user = new UserModele();
        $userForm = $this -> createForm(UserType::class, $user);
        $userForm -> handleRequest($request);
        if ($userForm -> isSubmitted() && $userForm -> isValid()) {
            try {
                $userService->getUser($user);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $this -> addFlash("success", "Vous êtes connecté");
            return $this -> redirectToRoute("app_accueil");
        }
        return $this -> render('user/index.html.twig', [
            'userForm' => $userForm,
        ]);
    }
}
