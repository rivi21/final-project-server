<?php

namespace App\Controller\Api;

use App\Entity\Delivery;
use App\Repository\DeliveryRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliveryController extends AbstractController
{
    /**
     * @Route("/api/delivery", name="api_delivery", methods={"GET"})
     */
    public function index(DeliveryRepository $deliveryRepository): Response
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
    }

    /**
     * @Route("/api/invoice/{id}", name="api_invoice", methods={"GET"})
     */
    /* public function showComissions(Request $request, deliveryRepository $deliveryRepository, OrderRepository $orderRepository): Response
    {
        $content = json_decode($request->getContent(), true);
        $order = $orderRepository->findOneBy(['id' => $content['order']]);
        $deliverys = $deliveryRepository->findAll();
        $response = [];
        foreach ($deliverys as $delivery) {
            $response[] = [
                'order' => $delivery->getRelatedOrder(),
                'id' => $delivery->getId(),
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
    public function add(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository)
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
    }
}
