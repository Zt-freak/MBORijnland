<?php

namespace App\Controller;

use App\Form\CheckoutFormType;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $cart = $this->session->get("Cart", array());
        $Products = array();

        foreach($cart as $id => $product){
            array_push($Products, ["Amount" => $product["Amount"], "Product" => $productRepository->find($id)]);
        }


        return $this->render('cart/index.html.twig', [
            "Products" => $Products,
        ]);
    }

    /**
     * @Route("/checkout", name="checkout")
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER') or is_granted('ROLE_SUPER_ADMIN')")
     */
    public function checkout (Request $request, ProductRepository $productRepository, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(CheckoutFormType::class);

        $form->handleRequest($request);

        $cart = $this->session->get("Cart", array());
        $Products = array();

        foreach($cart as $id => $product){
            array_push($Products, ["Amount" => $product["Amount"], "Product" => $productRepository->find($id)]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $message = (new \Swift_Message('Bevestegings Email!'))
                ->setFrom('info@webshop.com')
                ->setReplyTo('1031858@mborijnland.nl')
                ->setTo($formData['Email'])
                ->setBody(
                    $this->renderView(
                        'emails/checkout.html.twig',
                        ["Naam" => $formData["Naam"], "Products" => $Products]
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);

            $this->session->set("Cart", array());

            return $this->redirectToRoute('product_index');
        }

        return $this->render('cart/checkout.html.twig', [
            "submitForm" => $form->createView(),
            "Products" => $Products,
        ]);
    }
}
