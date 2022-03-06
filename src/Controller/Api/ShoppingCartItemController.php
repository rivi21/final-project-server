<?php

namespace App\Controller\Api;

use App\Entity\ShoppingCartItem;
use App\Repository\CustomerRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ShoppingCartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingCartItemController extends AbstractController
{
    // LISTA DE PRODUCTOS Y CANTIDADES POR PEDIDO
    /**
     * @Route("/api/order_items/{id}",  methods={"GET"})
     */
    public function index($id, ShoppingCartItemRepository $scir, OrderRepository $or): Response
    {
        $order = $or->find($id);
        $items = $scir->findByOrderItems($order);
        $customer = $order->getCustomer();
        $agent = $customer->getAgent();
        $invoice = $order->getInvoice();
        $response = [];
        foreach ($items as $item) {
            $product = $item->getProduct();
            $totalAmount = ($product->getPrice()) * ($item->getQuantity());
            $response[] = [
                'agent' => $agent->getName(),
                'customerId' => $customer->getId(),
                'customerName' => $customer->getName(),
                'customerAddress' => $customer->getAddress(),
                'orderId' => $order->getId(),
                'orderDate' => $order->getDate()->format('d-m-Y'),
                'deliveryDate' => $order->getDeliveryDate()->format('d-m-Y'),
                'invoiceId' => $invoice->getId(),
                'totalPrice' => $invoice->getTotalPrice(),
                'productId' => $product->getId(),
                'type' => $product->getType(),
                'model' => $product->getModel(),
                'price' => $product->getPrice(),
                'quantity' => $item->getQuantity(),
                'amount' => $totalAmount
            ];
        }
        return new JsonResponse($response);
    }

    // NUEVO ITEM EN EL CARRITO
    /**
     * @Route("/api/order_items", methods={"POST"})
     */
    public function add(
        Request $request,
        EntityManagerInterface $em,
        OrderRepository $orderRepository,
        ProductRepository $productRepository
    ) {
        $content = json_decode($request->getContent(), true);

        $item = new ShoppingCartItem();
        $order = $orderRepository->findOneBy(['id' => $content['orderId']]);
        $product = $productRepository->findOneBy(['id' => $content['productId']]);
        $item->setOrderRelated($order);
        $item->setProduct($product);
        $item->setQuantity($content['quantity']);

        $em->persist($item);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $content
        ]);
    }
}
