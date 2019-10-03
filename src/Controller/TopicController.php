<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\TopicWhitelist;
use App\Entity\User;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use App\Repository\TopicWhitelistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/topic")
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/", name="topic_index", methods={"GET"})
     */
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('topic/index.html.twig', [
            'topics' => $topicRepository->activatedTopics(),
        ]);
    }

    /**
     * @Route("/populair", options={"expose"=true}, name="populair_category", methods={"GET"})
     */
    public function populairCategory(TopicRepository $topicRepository)
    {
        $topics = $topicRepository->activatedTopics();
        $result = [];

        foreach ($topics as $topic) {
            array_push($result, ["Name" => $topic->getName(), "Path" => $topic->getPath()]);
        }

        $response = new JsonResponse();

        $response->setData($result);

        return $response;
    }

    /**
     * @Route("/new", name="topic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            return $this->redirectToRoute('topic_index');
        }

        return $this->render('topic/new.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="topic_show", methods={"GET"})
     */
    public function show(Topic $topic): Response
    {
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="topic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Topic $topic): Response
    {
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_index');
        }

        return $this->render('topic/edit.html.twig', [
            'topic' => $topic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="topic_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Topic $topic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('topic_index');
    }

    /**
     * @Route("/{id}/view/whitelist", name="topic_whitelist", methods={"GET"}
     */
    public function whitelistView(Topic $topic, TopicWhitelistRepository $topicWhitelistRepository)
    {
        return $this->render('topic/whitelist.html.twig', [
            'users' =>
        ]);
    }

    /**
     * @Route("/{id}/remove/whitelist", name="topic_whitelist_remove", methods={"DELETE"})
     */
    public function removeFromWhiteList(TopicWhitelist $topicWhitelist)
    {
        if ($this->isCsrfTokenValid('delete'.$topicWhitelist->getId(), $topicWhitelist->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($topicWhitelist);
            $entityManager->flush();
        }
    }

    /**
     * @Route("/{topicId}/{userId}/whitelist", name="topic_whitelist_add)
     */
    public function addToWhiteList(Topic $topic, User $user)
    {
        $whitelist = new TopicWhitelist();
        $whitelist->setTopic($topic);
        $whitelist->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($whitelist);
        $entityManager->flush();
    }

}
