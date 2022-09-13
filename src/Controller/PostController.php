<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\ManagerRegistry as DoctrineManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostController extends AbstractController
{
    #[Route('/')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Post::class);
        $posts = $repository->findAll(); // SELECT * FROM `post`;
        // dump($posts);
        return $this->render(
            'post/index.html.twig',
            [
                "posts" => $posts
            ]
        );
    }

    #[Route('/post/new')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($post);
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
        }
        return $this->render('post/form.html.twig', [
            "post_form" => $form->createView()
        ]);
    }
}




?>
<!-- terminal composer self-update -->
<!-- terminal php bin/console make:controller "nom du controler" -->

<!-- dump($post); line 26 - 28 -30 -->