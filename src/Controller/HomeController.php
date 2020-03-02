<?php

namespace App\Controller;

use App\Entity\OrdersList;
use App\Repository\OrdersListRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(OrdersListRepository $ordersListRepository, ProductRepository $productRepository)
    {
        $mostBought = $ordersListRepository->mostBought();
        $products = array();

        foreach ($mostBought as $product) {
            $productId = $product["product"];

            array_push($products, $productRepository->find($productId));
        }

        return $this->render('home/index.html.twig', [
            'MostBought' => $products,
        ]);
    }
}
