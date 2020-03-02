<?php

namespace App\Controller;

use App\Entity\VAT;
use App\Form\VATType;
use App\Repository\VATRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vat")
 *
 * @Security("is_granted('ROLE_ADMIN')")
 */
class VATController extends AbstractController
{
    /**
     * @Route("/", name="vat_index", methods={"GET"})
     */
    public function index(VATRepository $vatRepository): Response
    {
        return $this->render('vat/index.html.twig', [
            'vats' => $vatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vat = new VAT();
        $form = $this->createForm(VATType::class, $vat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vat);
            $entityManager->flush();

            return $this->redirectToRoute('vat_index');
        }

        return $this->render('vat/new.html.twig', [
            'vat' => $vat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vat_show", methods={"GET"})
     */
    public function show(VAT $vat): Response
    {
        return $this->render('vat/show.html.twig', [
            'vat' => $vat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VAT $vat): Response
    {
        $form = $this->createForm(VATType::class, $vat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vat_index');
        }

        return $this->render('vat/edit.html.twig', [
            'vat' => $vat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VAT $vat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vat_index');
    }
}
