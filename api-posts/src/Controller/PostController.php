<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Post;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api/posts")]
class PostController extends AbstractController
{
    #[OA\Tag("Post")]
    #[OA\Get(
        path: '/api/posts',
        description: 'Permet de récuperer la liste des posts',
        summary: 'Lister tout les posts',
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste des posts au formats Json",
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(
                            type: Post::class,
                            groups: ["list_post"]
                        )
                    )
                )
            )
        ]
    )]
    #[Route('', name: 'api_post_index', methods: ["GET"])]
    public function index(PostRepository $postRepository, SerializerInterface $serializer): Response
    {
        $arrayPosts = $serializer -> serialize($postRepository -> findAll(), "json", ['groups' => 'list_posts']);
        return new Response($arrayPosts, Response::HTTP_OK, ["content-type" => "application/json"]);
    }

    #[OA\Tag("Post")]
    #[OA\Get(
        path: "/api/posts/{id}",
        description: "Permet de récupérer un post par son id",
        summary: "Récupérer un Post",
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: "Id du post à rechercher",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Détail du Post au format Json",
                content: new OA\JsonContent(
                    ref: new Model(type: Post::class, groups: ["show_post"])
                )
            )
        ]
    )]
    #[Route('/{id}', name: 'api_post_show', requirements: ['id' => '\d+'], methods: ["GET"])]
    public function show(PostRepository $postRepository, SerializerInterface $serializer, $id): Response
    {
        $arrayPosts = $serializer -> serialize($postRepository -> find($id), "json", ['groups' => 'show_post']);
        return new Response($arrayPosts, Response::HTTP_OK, ["content-type" => "application/json"]);
    }

    #[Route('', name: 'api_post_create', methods: ["POST"])]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $bodyRequest = $request -> getContent();
        $parameters = json_decode($request -> getContent(), true);
        $post = $serializer -> deserialize($bodyRequest, Post::class, 'json');
        $post -> setCreatedAt(new DateTime());
        $post -> setUser($this -> getUser());
        $categorie = $entityManager->getRepository(Categorie::class)->find($parameters['idCategorie']);
        $post->setCategorie($categorie);
        $entityManager -> persist($post);
        $entityManager -> flush();
        return new Response(
            $serializer->serialize(
                $post,
                'json',
                ['groups' => 'list_posts']),
            Response::HTTP_CREATED,
            ["content-type" => "application/json"]);
    }

    #[Route('/{id}', name: 'api_post_delete', requirements: ['id' => '\d+'], methods: ["DELETE"])]
    public function delete(PostRepository $postRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer, $id)
    {
//        todo peut crasher
        $entityManager -> remove($postRepository -> find($id));
        $entityManager -> flush();
        return new Response(
            "",
            Response::HTTP_NO_CONTENT
        );
    }

    #[Route('/{id}', name: 'api_post_update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(int $id, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $bodyRequest = $request -> getContent();
        $post = $entityManager -> find(Post::class, $id);
        $serializer -> deserialize(
            $bodyRequest,
            Post::class,
            'json',
            ['object_to_populate' => $post]
        );
        $entityManager -> flush();
        return new Response(null, Response::HTTP_NO_CONTENT, ["content-type" => "application/json"]);
    }

    #[Route('/publies-apres', name: 'api_post_getAllAfterDate', requirements: ['date' => '/\d{4}-\d{2}-\d{2}/'], methods: ['GET'])]
    public function getAllAfter(
        Request             $request,
        SerializerInterface $serializer,
        PostRepository      $postRepository
    ): Response
    {
        $date = $request -> query -> get("date");
        $dateButoir = DateTime ::createFromFormat("Y-m-d", $date);
        $arrayPosts = $postRepository -> findAllByGreaterThanDate($dateButoir);
        $jsonPosts = $serializer -> serialize($arrayPosts, "json");
        return new Response($jsonPosts, Response::HTTP_OK, ["content-type" => "application/json"]);
    }

}
