<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/r/{topicName}", name="post_index", methods={"GET"})
     */
    public function index(Request $request, PostRepository $postRepository, $topicName, TopicRepository $topicRepository): Response
    {
        $topic = $topicRepository->findBy(['Path' => $topicName]);

        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findBy(['Topic' => $topic]),
        ]);
    }

    /**
     * @Route("post/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $post->setUser($this->getUser());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('post_index', ['topicName' => $post->getTopic()->getPath()]));
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("post/search/{param}", defaults={"param"="empty"}, name="post_search", methods={"GET"})
     */
    public function searchPostst (Request $request, PostRepository $postRepository)
    {
        $parameter = $request->query->get('param');

        return $this->json(["Test" => $parameter]);
    }

    /**
     * @Route("post/{id}", name="post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comments' => $post->getComments()
        ]);
    }

    /**
     * @Route("post/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index', array('topicName' => $post->getTopic()->getPath()));
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("post/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        $topicPath = $post->getTopic()->getPath();

        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index', array('topicName' => $topicPath));
    }

    /**
     * @Route("post/{id}/comment", name="post_comment", methods={"POST"})
     */
    public function comment(Request $request, Post $post): Response
    {
        $commentContent = $request->request->get('commentContent');

        $comment = new Comment();
        $comment->setPost($post);
        $comment->setUser($this->getUser());
        $comment->setContent($commentContent);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('post_show', array('id' => $post->getId())));
    }
}
