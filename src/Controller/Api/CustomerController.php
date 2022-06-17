<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Repository\AgentRepository;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/api/customers", name="api_customer", methods={"GET"})
     */
    public function index(CustomerRepository $customerRepository): Response
    {
        $customers = $customerRepository->findAll();
        $response = [];
        foreach ($customers as $customer) {
            $agent = $customer->getAgent();
            $response[] = [
                'agentEmail' => $agent->getEmail(),
                'id' => $customer->getId(),
                'name' => $customer->getName(),
                'address' => $customer->getAddress(),
                'country' => $customer->getCountry(),
                'phoneNumber' => $customer->getPhoneNumber(),
                'email' => $customer->getEmail(),
                'web' => $customer->getWeb()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
    //RUTA PARA OBTENER UN CUSTOMER POR SU ID
    /**
     * @Route("/api/customer/{id}", methods={"GET"})
     */
    public function oneCustomer($id, CustomerRepository $customerRepository): Response
    {
        $customer = $customerRepository->findOneBy(['id' =>$id]);

        return new JsonResponse([
            'id' => $customer->getId(),
            'name' => $customer->getName(),
            'address' => $customer->getAddress(),
            'country' => $customer->getCountry(),
            'phoneNumber' => $customer->getPhoneNumber(),
            'email' => $customer->getEmail(),
            'web' => $customer->getWeb()
        ]);
    }
    //NUECO CLIENTE
    /**
     * @Route("/api/customer", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, AgentRepository $agentRepository)
    {
        $content = json_decode($request->getContent(), true);

        $customer = new Customer();
        $agent = $agentRepository->findOneBy(['name' => $content['agentName']]);
        $customer->setAgent($agent);
        $customer->setName($content['name']);
        $customer->setAddress($content['address']);
        $customer->setCountry($content['country']);
        $customer->setPhoneNumber($content['phoneNumber']);
        $customer->setEmail($content['email']);
        $customer->setWeb($content['web']);

        $em->persist($customer);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $customer
        ]);
    }
    /**
     * @Route("/api/customer", methods={"OPTIONS"})
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

    /**
     * @Route("/api/customer/{id}", methods={"PUT"})
     */
    public function update($id, Request $request, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $content = json_decode($request->getContent(), true);
        $customer = $customerRepository->find($id);

        if (isset($content['name'])) {
            $customer->setName($content['name']);
        }
        if (isset($content['address'])) {
            $customer->setAddress($content['address']);
        }
        if (isset($content['country'])) {
            $customer->setCountry($content['country']);
        }
        if (isset($content['phoneNumber'])) {
            $customer->setPhoneNumber($content['phoneNumber']);
        }
        if (isset($content['email'])) {
            $customer->setEmail($content['email']);
        }
        if (isset($content['web'])) {
            $customer->setWeb($content['web']);
        }

        $em->flush();

        return new JsonResponse([
            'result' => 'update con PUT ok',
            'content' => $customer
        ]);
    }

    /**
     * @Route("/api/customer/{id}", methods={"DELETE"})
     */
    public function delete($id, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $customer = $customerRepository->find($id);
        $em->remove($customer);
        $em->flush();

        return new jsonResponse([
            'result' => 'delete ok',
        ]);
    }
}
