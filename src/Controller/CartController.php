<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function index(ProductRepository $productRepository)
    {
        $cart = $this->session->get("Cart");
        $Products = array();

        foreach($cart as $id => $product){
            array_push($Products, ["Amount" => $product["Amount"], "Product" => $productRepository->find($id)]);
        }


        return $this->render('cart/index.html.twig', [
            "Products" => $Products,
        ]);
    }

    /**
     * @Route("/{id}/{value}/cart", name="cart_set")
     */
    public function setCart (Request $request, ProductRepository $productRepository)
    {
        $id = $request->getParameter('id');
        $value = $request->getParameter('value');
        return $this->redirectToRoute('cart');
    }
}
