<?php

namespace App\Controller\Api;

use App\Entity\Invoices;
use App\Repository\CustomerRepository;
use App\Repository\InvoicesRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{
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
    public function index(InvoicesRepository $invoiceRepository): Response
    {
        $invoices = $invoiceRepository->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'id' => $invoice->getId(),
                'paymentTerms' => $invoice->getPaymentTerm(),
                'totalPrice' => $invoice->getTotalPrice(),
                'dueDate' => $invoice->getDueDate()->format('d-m-Y'),
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /**
     * @Route("/api/comission", methods={"GET"})
     */
    public function showComissions(InvoicesRepository $invoiceRepository, OrderRepository $orderRepository): Response
    {

        $invoices = $invoiceRepository->findAll();
        $response = [];
        foreach ($invoices as $invoice) {
            $response[] = [
                'order' => $invoice->getOrderRelated(),
                'id' => $invoice->getId(),
                'totalPrice' => $invoice->getTotalPrice(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()
            ];
        }
        return new JsonResponse([
            $response,

        ]);
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
        $invoice->setDueDate(\DateTime::createFromFormat('d-m-Y', $content['dueDate']));
        $invoice->setSalesComission($content['salesComission']);
        $invoice->setComissionAmount($content['comissionAmount']);

        $em->persist($invoice);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $invoice
        ]);
    }

    // LISTADO DE FACTURAS PARA UN CLIENTE
    /**
     * @Route("/api/invoices/{idCustomer}",  methods={"GET"})
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
                'id' => $invoice->getId(),
                'name' => $customer->getName(),
                'due_date' => $invoice->getDueDate()->format('d-m-Y'),
                'totalPrice' => $invoice->getTotalPrice(),
                'salesComission' => $invoice->getSalesComission(),
                'comissionAmount' => $invoice->getComissionAmount()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    //LISTADO DE FACTURAS POR CLIENTES
    /**
     * @Route("/totalBalance",  methods={"GET"})
     */
    public function totalBalance(InvoicesRepository $ir, CustomerRepository $cr, OrderRepository $or): Response
    {

        $customers = $cr->findAll();
        $response = [];
        foreach ($customers as $customer) {
            $invoices = $ir->findByCustomer($customer);
            foreach ($invoices as $invoice) {
                $response[] = [
                    'id' => $invoice->getId(),
                    'name' => $customer->getName(),
                    'due_date' => $invoice->getDueDate()->format('d-m-Y'),
                    'totalPrice' => $invoice->getTotalPrice(),
                    'salesComission' => $invoice->getSalesComission(),
                    'comissionAmount' => $invoice->getComissionAmount()
                ];
            }
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
