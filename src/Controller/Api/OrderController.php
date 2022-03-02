<?php

namespace App\Controller\Api;

use App\Entity\Order;
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
                'orderNumber'=> $order->getId(),
                'date' => $order->getDate()->format('d-m-Y'),
                'shippingDate' => $order->getShippingDate()->format('d-m-Y'),
                'deliveryDate' => $order->getDeliveryDate()->format('d-m-Y'),
                $invoice = $order->getInvoice(),
                "invoiceNumber" => $invoice->getId(),         
                'paymentTerm'=> $invoice->getPaymentTerm(), 
                'totalPrice'=> $invoice->getTotalPrice(),
                'dueDate'=> $invoice->getDueDate()->format('d-m-Y'),
                'salesComission'=> $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()

            ];
        }
        return new JsonResponse($response);
    }
    //PEDIDOS Y FACTURAS PARA UNA LISTA DE CLIENTES
    /**
     * @Route("/api/customersorders",  methods={"GET"})
     */
    public function customerOrderInvoice(OrderRepository $or, CustomerRepository $cr): Response
    {
        $customers = $cr->findAll();
        $response = [];
        foreach ($customers as $customer) {
            $orders = $or->findOrdersByCustomer($customer);
            foreach ($orders as $order) {          
                $response[] = [
                    'orderId'=> $order->getId(),
                    'customerId' => $customer->getId(),
                    'customerName' => $customer->getName(),                   
                    'date' => $order->getDate()->format('d-m-Y'),
                    'shippingDate' => $order->getShippingDate()->format('d-m-Y'),
                    'deliveryDate' => $order->getDeliveryDate()->format('d-m-Y'),
                    $invoice = $order->getInvoice(),
                    "invoiceNumber" => $invoice->getId(),         
                    'paymentTerm'=> $invoice->getPaymentTerm(), 
                    'totalPrice'=> $invoice->getTotalPrice(),
                    'dueDate'=> $invoice->getDueDate()->format('Y-m-d'),
                    'salesComission'=> $invoice->getSalesComission(),
                    'comissionAmount' => $invoice->getComissionAmount()
    
                ];
            }          
        }
        return new JsonResponse($response);
    }

    //Lista de pedidos para un cliente
    /**
     * @Route("/api/customer_orders", name="api_order", methods={"GET"})
     */
    public function orderByCustomer(OrderRepository $orderRepository, CustomerRepository $customerRepository): Response
    {
        $customer = $customerRepository->findOneBy(['name' => 'KINGFISHER Ltd.']);
        /* $orders = $orderRepository->findBy(['customer'=> $customer]); */
        $orders = $customer->getOrders();
        $response = [];
        foreach ($orders as $order) {
            $response[] = [
                'name' => $customer->getName(),
                'date' => $order->getDate()->format('d-m-Y'),
                'shippingDate' => $order->getShippingDate()->format('d-m-Y'),
                'deliveryDate' => $order->getDeliveryDate()->format('d-m-Y'),
            ];
        }
        return new JsonResponse([
            $response
        ]);
    }

    //Nuevo pedido
    /**
     * @Route("/api/order", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, CustomerRepository $customerRepository, ProductRepository $productRepository)
    {
        $content = json_decode($request->getContent(), true);

        $order = new Order();
        $customer = $customerRepository->findOneBy(['id' => $content['customer']]);
        $order->setCustomer($customer);
        /* $product = $productRepository->findOneBy(['model' => $content['product']]);
        $order->setProduct($product); */
        $order->setDate(\DateTime::createFromFormat('d-m-Y', $content['date']));
        $order->setShippingDate(\DateTime::createFromFormat('d-m-Y', $content["shippingDate"]));
        $order->setDeliveryDate(\DateTime::createFromFormat('d-m-Y', $content["deliveryDate"]));

        $em->persist($order);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $order
        ]);
    }
}
