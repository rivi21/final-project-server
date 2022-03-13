<?php

namespace App\Controller\Api;

use App\Entity\Order;
use App\Entity\ShoppingCartItem;
use App\Repository\CustomerRepository;
use App\Repository\InvoicesRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    //ÚLTIMO PEDIDO
    /**
     * @Route("/api/order", methods={"GET"})
     */
    public function allOrdersID(OrderRepository $orderRepository)
    {
        $orders = $orderRepository->findBy([], ['id' => 'DESC'], 1);
        foreach ($orders as $order) {
            $id = $order->getId();
        }
        return new JsonResponse($id);
    }


    //CONSULTA PARA LAS VENTAS
    /**
     * @Route("/api/sales", methods={"GET"})
     */
    public function salesData(OrderRepository $or): Response
    {
        $orders = $or->findAll();
        $response = [];
        foreach ($orders as $order) {
            $customer = $order->getCustomer();
            $agent = $customer->getAgent();
            $response[] = [
                'agentEmail' => $agent->getEmail(),
                'orderId' => $order->getId(),
                'customerId' => $customer->getId(),
                'customerName' => $customer->getName(),
                'date' => $order->getDate(),
                'shippingDate' => $order->getShippingDate(),
                'deliveryDate' => $order->getDeliveryDate(),
                'isPreparing' => $order->getIsPreparing(),
                'isPrepared' => $order->getIsPrepared(),
                'isShipped' => $order->getShippingDate(),
                'isDelivered' => $order->getIsDelivered(),
                $invoice = $order->getInvoice(),
                "invoiceId" => $invoice->getId(),
                'paymentTerm' => $invoice->getPaymentTerm(),
                'totalPrice' => $invoice->getTotalPrice(),
                'dueDate' => $invoice->getDueDate()->format('Y-m-d'),
                'isPaid' => $invoice->getIsPaid(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()
            ];
        }
        return new JsonResponse($response);
    }

    //LISTA DE PEDIDOS Y SUS FACTURAS
    /**
     * @Route("/api/orderinvoices", methods={"GET"})
     */
    public function recover(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        $response = [];
        foreach ($orders as $order) {
            $response[] = [
                'orderId' => $order->getId(),
                'date' => $order->getDate(),
                'shippingDate' => $order->getShippingDate(),
                'deliveryDate' => $order->getDeliveryDate(),
                $invoice = $order->getInvoice(),
                "invoiceId" => $invoice->getId(),
                'paymentTerm' => $invoice->getPaymentTerm(),
                'totalPrice' => $invoice->getTotalPrice(),
                'dueDate' => $invoice->getDueDate()->format('Y-m-d'),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()

            ];
        }
        return new JsonResponse($response);
    }

    //LISTA DE PEDIDOS, PRODUCTOS Y FACTURAS RELACIONADAS PARA 
    //TODOS LOS CLIENTES DE UN AGENTE
    /**
     * @Route("/api/all_agent_orders", methods={"GET"})
     */
    public function orderByCustomer(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        $response = [];
        foreach ($orders as $order) {
            $customer = $order->getCustomer();
            $agent = $customer->getAgent();
            $cartItems = $order->getShoppingCartItems();
            $invoice = $order->getInvoice();
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->getProduct();
                $totalAmount = ($product->getPrice()) * ($cartItem->getQuantity());
                $response[] = [
                    'agent' => $agent->getName(),
                    'customerId' => $customer->getId(),
                    'customerName' => $customer->getName(),
                    'orderId' => $order->getId(),
                    'orderDate' => $order->getDate(),
                    'deliveryDate' => $order->getDeliveryDate(),
                    'productId' => $product->getId(),
                    'type' => $product->getType(),
                    'model' => $product->getModel(),
                    'price' => $product->getPrice(),
                    'quantity' => $cartItem->getQuantity(),
                    'productAmount' => $totalAmount,
                    'invoiceId' => $invoice->getId(),
                    'totalPrice' => $invoice->getTotalPrice()
                ];
            }
        }
        return new JsonResponse($response);
    }

    //NUEVO PEDIDO
    /**
     * @Route("/api/order", methods={"POST"})
     */
    public function add(
        Request $request,
        EntityManagerInterface $em,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository
    ) {
        $content = json_decode($request->getContent(), true);

        $order = new Order();
        $customer = $customerRepository->findOneBy(['id' => $content['customer']]);
        $order->setCustomer($customer);
        $order->setDate($content['date']);

        /* $product= $order->addShoppingCartItem(); */
        /*  $product = $productRepository->findOneBy(['model' => $content['product']]); */
        /* $order->setProduct($product); */
        /* $order->setShippingDate(\DateTime::createFromFormat('Y-m-d', $content["shippingDate"]));
        $order->setDeliveryDate(\DateTime::createFromFormat('Y-m-d', $content["deliveryDate"])); */

        $em->persist($order);

        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $order
        ]);
    }

    //MODIFICAR ESTADO DE PREPARACIÓN
    /**
     * @Route("api/order" methods={"PUT"})
     */
    /* public function updateStatus()
    {

    } */
}
