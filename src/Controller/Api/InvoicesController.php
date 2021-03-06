<?php

namespace App\Controller\Api;

use App\Entity\Invoices;
use App\Repository\CustomerRepository;
use App\Repository\InvoicesRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ShoppingCartItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{
    /*
     * @Route("/api/comission", name="api_comission",  methods={"OPTIONS"})
     */
    public function options(): Response
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
    }

    //CONSULTA PARA LAS COMISIONES
    /**
     * @Route("/api/comission", name="api_comission", methods={"GET"})
     */
    public function index(InvoicesRepository $invoiceRepository): Response
    {
        $invoices = $invoiceRepository->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $order = $invoice->getOrderRelated();
            $customer = $order->getCustomer();
            $agent = $customer->getAgent();
            if (($invoice->getIsPaidDate()) != null) {
                $isPaidDate = $invoice->getIsPaidDate()->format('Y-m-d');
            } else {
                $isPaidDate = "";
            }
            $response[] = [
                'agentEmail' => $agent->getEmail(),
                'agentName' => $agent->getName(),
                'agentLastName' => $agent->getLastName(),
                'invoiceId' => $invoice->getId(),
                'customerId' => $customer->getId(),
                'customerName' => $customer->getName(),
                'isPaidDate' => $isPaidDate,
                'totalPrice' => $invoice->getTotalPrice(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount(),

            ];
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/api/invoice", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        $content = json_decode($request->getContent(), true);

        $invoice = new Invoices();
        $order = $orderRepository->findOneBy(['id' => $content['order']]);
        $invoice->setOrderRelated($order);
        $invoice->setPaymentTerm($content['paymentTerm']);
        $invoice->setTotalPrice($content['totalPrice']);
        $invoice->setDueDate(\DateTime::createFromFormat('Y-m-d', $content['dueDate']));
        $invoice->setSalesComission($content['salesComission']);
        $invoice->setComissionAmount($content['comissionAmount']);
        $invoice->setIsPaid($content['isPaid']);
        $invoice->setIsPaidDate(\DateTime::createFromFormat('Y-m-d', $content['isPaidDaate']));

        $em->persist($invoice);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $invoice
        ]);
    }

    // LISTADO DE FACTURAS DE UN CLIENTE
    /**
     * @Route("/api/invoices/{idCustomer}", methods={"GET"})
     */
    public function dueBalance($idCustomer, InvoicesRepository $ir, CustomerRepository $cr): Response
    {
        //consulta para obtener el customer
        $customer = $cr->find($idCustomer);
        // consulta para obtener las invoices de ese customer
        $invoices = $ir->findByCustomer($customer);
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'invoiceId' => $invoice->getId(),
                'customerName' => $customer->getName(),
                'dueDate' => $invoice->getDueDate()->format('Y-m-d'),
                'totalPrice' => $invoice->getTotalPrice(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
    //SUMATORIO DE FACTURAS POR CLIENTE
    /**
     * @Route("/api/amount", methods={"GET"})
     */
    public function invoicesSum(CustomerRepository $customerRepository, InvoicesRepository $invoicesRepository)
    {
        $customers = $customerRepository->findAll();
        $response = [];
        foreach ($customers as $customer) {
            $agent = $customer->getAgent();
            $invoices = $invoicesRepository->findInvoiceByCustomer($customer);
            $sum = 0;
            foreach ($invoices as $invoice) {
                $sum += $invoice->getTotalPrice();
            }
            $response[] = [
                'agentEmail' => $agent->getEmail(),
                'customerId' => $customer->getId(),
                'customerName' => $customer->getName(),
                'totalAmount' => $sum,
            ];
        }
        return new JsonResponse($response, 200);
    }
    //LISTADO DE PRODUCTOS Y CANTIDADES POR FACTURA
    /**
     * @Route("/api/products_invoice/{id}",  methods={"GET"})
     */
    public function invoiceProductsList($id, InvoicesRepository $ir, ProductRepository $pr)
    {
        $invoice = $ir->find($id);

        $order = $invoice->getOrderRelated();
        $products = $pr->findByOrder($order);
        $response = [];
        foreach ($products as $product) {
            $item = $product->getShoppingCartItems();
            /* $totalAmount = ($product->getPrice()) * ($shoppingCartItem->getQuantity()); */
            $response[] = [
                'orderId' => $order->getId(),
                'invoiceId' => $invoice->getId(),
                'productId' => $product->getId(),
                'type' => $product->getType(),
                'model' => $product->getModel(),
                'price' => $product->getPrice(),
                /* 'amount' =>  */
                /* 'quantity' => $shoppingCartItem->getQuantity(),
                'productAmount' => $totalAmount, */
            ];
        }
        return new JsonResponse($response);
    }
    //LISTADO DE FACTURAS POR CLIENTES 
    /**
     * @Route("/api/invoices",  methods={"GET"})
     */
    public function invoicesAndCustomers(InvoicesRepository $ir, CustomerRepository $cr, ShoppingCartItemRepository $scir): Response
    {
        $invoices = $ir->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $order = $invoice->getOrderRelated();
            $customer = $order->getCustomer();
            $agent = $customer->getAgent();
            $response[] = [
                'agentEmail' => $agent->getEmail(),
                'invoiceId' => $invoice->getId(),
                'customerId' => $customer->getId(),
                'customerName' => $customer->getName(),

                /* 'address' => $customer->getAddress(), */
                'orderId' => $order->getId(),
                /* 'orderDate' => $order->getdate()->format('d-m-Y'), */
                'deliveryDate' => $order->getDeliveryDate(),
                'totalPrice' => $invoice->getTotalPrice(),

            ];
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/api/invoice/{id}", methods={"PUT"})
     */
    /* public function update($id, Request $request, InvoicesRepository $invoicesRepository, EntityManagerInterface $em)
    {
        $content = json_decode($request->getContent(), true);
        $invoice = $invoicesRepository->find($id);

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
}
