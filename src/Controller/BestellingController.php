<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BestellingController extends AbstractController
{
    /**
     * @Route("/bestelling", name="bestelling")
     */
    public function index()
    {
        return $this->render('bestelling/index.html.twig', [
            'controller_name' => 'BestellingController',
        ]);
    }
}
