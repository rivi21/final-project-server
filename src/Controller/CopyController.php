<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CopyController extends AbstractController
{
    /**
     * @Route("/copy", name="copy")
     */
    public function index(): Response
    {
        return $this->render('copy/index.html.twig', [
            'controller_name' => 'CopyController',
        ]);
    }
    //-------------------------AQUI LO DE ORDER CONTROLLER----------------------
    /**
     * @Route("/api/order", name="api_order", methods={"GET"})
     */
    /*  public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        $response = [];
        foreach ($orders as $order) {
            $response[] = [
                'date' => $order->getDate()->format('d-m-Y')
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => 'http://localhost:3000'
        ]);
    } */
    /**
     * @Route("/api/order", methods={"POST"})
     */
    /*  public function add(Request $request, EntityManagerInterface $em, CustomerRepository $customerRepository, ProductRepository $productRepository)
    {
        $content = json_decode($request->getContent(), true);

        $order = new Order();
        $customer = $customerRepository->findOneBy(['name' => $content['customer']]);
        $order->setCustomer($customer);
        $product = $productRepository->findOneBy(['model' => $content['product']]);
        $order->setProduct($product);
        $order->setDate(\DateTime::createFromFormat('d-m-Y', $content['date']));

        $em->persist($order);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $order
        ]);
    } */
    // ------------------------AQUI LO DE DELIVERY CONTROLLER---------------------

    /**
     * @Route("/api/delivery", name="api_delivery", methods={"GET"})
     */
    /* public function delivery(DeliveryRepository $deliveryRepository): Response
    {
        $deliverys = $deliveryRepository->findAll();
        $response = [];
        foreach ($deliverys as $delivery) {
            $response[] = [
                'relatedOrder' => $delivery->getRelatedOrder(),
                'shippingDate' => $delivery->getShippingDate(),
                'deliveryDate' => $delivery->getDeliveryDate(),
                'shippingConditions' => $delivery->getShippingConditions()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => 'http://localhost:3000'
        ]);
    } */
    /**
     * @Route("/api/delivery", methods={"POST"})
     */
    /* public function add2(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        $content = json_decode($request->getContent(), true);

        $delivery = new Delivery();
        $order = $orderRepository->findOneBy(['id' => $content['order']]);
        $delivery->setRelatedOrder($order);
        $delivery->setShippingDate(\DateTime::createFromFormat('d-m-Y', $content['shippingDate']));
        $delivery->setDeliveryDate(\DateTime::createFromFormat('d-m-Y', $content['DeliveryDate']));
        $delivery->setShippingConditions($content['shippingConditions']);
        $em->persist($delivery);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $delivery
        ]);
    } */


    // -------------------------AQUÍ LO DE INVOICE CONTROLLER-------------------------
    /**
     * @Route("/api/invoice", name="api_invoice", methods={"OPTIONS"})
     */
    /* public function options(): Response
    {
        return new Response(
            '',
            200,
            [
                'Access-Control-Allow-Origin' => 'http://localhost:3000',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'Authorization, Content-Type'
            ]
        );
    } */

    /**
     * @Route("/api/invoice", name="api_invoice", methods={"GET"})
     */
    /* public function index(InvoiceRepository $invoiceRepository): Response
    {
        $invoices = $invoiceRepository->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'id' => $invoice->getId(),
                'paymentTerms' => $invoice->getPaymentTerms(),
                'totalPrice' => $invoice->getTotalPrice(),
                'dueDate' => $invoice->getDueDate()->format('d-m-Y'),
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    } */

    /**
     * @Route("/api/comission", methods={"GET"})
     */
    /*  public function showComissions(InvoiceRepository $invoiceRepository, OrderRepository $orderRepository): Response
    {
        
        $invoices = $invoiceRepository->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'order' => $invoice->getRelatedOrder(),
                'id' => $invoice->getId(),
                'totalPrice' => $invoice->getTotalPrice(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    } */

    /**
     * @Route("/api/invoice", methods={"POST"})
     */
    /* public function add3(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        $content = json_decode($request->getContent(), true);

        $invoice = new Invoice();
        $order = $orderRepository->findOneBy(['id' => $content['order']]);
        $invoice->setRelatedOrder($order);
        $invoice->setPaymentTerms($content['paymentTerms']);
        $invoice->setTotalPrice($content['totalPrice']);
        $invoice->setDueDate($content['dueDate']);

        $invoice->setSalesComission($content['salesComission']);
        $invoice->setComissionAmount($content['comissionAmount']);

        $em->persist($invoice);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $invoice
        ]);
    } */
    // LISTADO DE FACTURAS PARA UN CLIENTE
    /**
     * @Route("/dueBalance/{idCustomer}",  methods={"GET"})
     */
    /* public function dueBalance($idCustomer, InvoiceRepository $ir, CustomerRepository $cr): Response
    {
        //consulta para obtener el customer
        $customer = $cr->find($idCustomer);
        // consulta para obtener las invoices de ese customer
        $invoices = $ir->findByCustomer($customer);
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'id' => $invoice->getId(),
                'name' => $customer->getName(),
                'due_date' => $invoice->getDueDate()->format('d-m-Y'),
                'totalPrice' => $invoice->getTotalPrice(),
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    } */

    //LISTADO DE PEDIDOS POR CLIENTES
    /**
     * @Route("/totalBalance",  methods={"GET"})
     */
    /* public function totalBalance(InvoiceRepository $ir, CustomerRepository $cr): Response
    {

        $customers = $cr->findAll();   
        $invoices = $ir->findByCustomers($customers);
       
        for ($i = 0; $i < sizeof($customers); $i++){          
            foreach ($invoices as $invoice) {
                $response[] = [
                    'id' => $invoice->getId(),               
                    'due_date' => $invoice->getDueDate()->format('d-m-Y'),
                    'totalPrice' => $invoice->getTotalPrice(),
                    'name'=> $invoice->getRelatedOrder()
                ];               
            }            
        }
       
        return new JsonResponse([
            'content' => $response
        ]);
    } */


    /**
     * @Route("/api/invoice/{id}", methods={"PUT"})
     */
    /*  public function update($id, Request $request, invoiceRepository $invoiceRepository, EntityManagerInterface $em)
    {
        $content = json_decode($request->getContent(), true);
        $invoice = $invoiceRepository->find($id);

        if (isset($content['name'])) {
            $invoice->setName($content['name']);
        }
        if (isset($content['address'])) {
            $invoice->setAddress($content['address']);
        }
        if (isset($content['country'])) {
            $invoice->setCountry($content['country']);
        }
        if (isset($content['phoneNumber'])) {
            $invoice->setPhoneNumber($content['phoneNumber']);
        }
        if (isset($content['email'])) {
            $invoice->setEmail($content['email']);
        }
        if (isset($content['web'])) {
            $invoice->setWeb($content['web']);
        }

        $em->flush();

        return new JsonResponse([
            'result' => 'update con PUT ok',
            'content' => $invoice
        ]);
    } */

    /**
     * @Route("/api/customer/{id}", methods={"DELETE"})
     */
    /*  public function delete($id, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $customer = $customerRepository->find($id);
        $em->remove($customer);
        $em->flush();

        return new jsonResponse([
            'result' => 'delete ok',
        ]);
    } */

    public function __toString()
    {
        return $this->payment_terms;
    }

}
