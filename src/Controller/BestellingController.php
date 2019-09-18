<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\OrdersListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrdersRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;

class BestellingController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/bestelling", name="bestelling")
     */
    public function index(OrdersRepository $ordersRepository)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return $this->render('bestelling/index.html.twig', [
                'Orders' => $ordersRepository->findAll(),
            ]);
        } else {
            return $this->render('bestelling/index.html.twig', [
                'Orders' => $ordersRepository->findBy(['user' => $this->getUser()]),
            ]);
        }
    }

    /**
     * @Route("/bestelling/{id}", name="bestelling_producten")
     */
    public function showProducten(OrdersListRepository $ordersListRepository, Orders $orders)
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $Orders = $ordersListRepository->findBy(['orders' => $orders->getId()]);
        } else {
            if ($orders->getUser() === $this->getUser()) {
                $Orders = $ordersListRepository->findBy(['orders' => $orders->getId()]);
            } else {
                throw new AccessDeniedException('U heeft geen toegang tot deze bestelling!');
            }
        }
        return $this->render('bestelling/products.html.twig', [
            'Orders' => $Orders
        ]);
    }
}
