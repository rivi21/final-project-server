<?php

namespace App\Controller\Api;

use App\Entity\Agent;
use App\Repository\AgentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AgentController extends AbstractController
{
    /**
     * @Route("/api/login_check", methods={"OPTIONS"})
     */
    public function options(): Response
    {
        return new Response("", 200, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, DELETE, PUT',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization'
        ]);
    }

    /**
     * @Route("/api/agent", name="api_agent", methods={"GET"})
     */
    public function index(AgentRepository $agentRepository): Response
    {
        $agents = $agentRepository->findAll();
        $response = [];
        foreach ($agents as $agent) {
            $response[] = [
                'name' => $agent->getName(),
                'last name' => $agent->getLastName(),
                'address' => $agent->getAddress(),
                'country' => $agent->getCountry(),
                'phone number' => $agent->getPhoneNumber(),
                'email' => $agent->getEmail()
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /**
     * @Route("/api/agent", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $content = json_decode($request->getContent(), true);

        $agent = new Agent();
        $agent->setEmail($content['email']);
        $agent->setRoles($content['roles']);
        $plaintextPassword = $content['password'];
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $agent,
            $plaintextPassword
        );
        $agent->setPassword($hashedPassword);
        /*  $agent->setPassword($content['password']); */
        $agent->setName($content['name']);
        $agent->setLastName($content['lastName']);
        $agent->setAddress($content['address']);
        $agent->setCountry($content['country']);
        $agent->setPhoneNumber($content['phoneNumber']);

        $em->persist($agent);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $content
        ]);
    }
}
