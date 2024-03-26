<?php

namespace App\Service;

use App\Form\UserType;
use App\Modele\UserModele;
use Symfony\Component\Form\Form;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService
{
    private HttpClientInterface $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this -> httpClient = $httpClient;
    }

    /**
     * @param UserModele $form
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getUser(UserModele $form)
    {
        $link = Constants::API_LINK . "/login_check";
        $reponseAPI = $this -> httpClient -> request(
            'POST',
            $link,
            [
                'json' => ['username' => $form -> email, 'password' => $form -> password]
            ]
        );
        dd($reponseAPI -> toArray());
        return $reponseAPI -> toArray();
    }

}