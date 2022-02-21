<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/product", name="api_product", methods={"GET"})
     */
    
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $response = [];
        foreach($products as $product) {
            $response[] = [
                'type'=> $product->getType(),
                'model'=> $product->getModel(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock(),
            ];
        }
        return new JsonResponse($response, 200, [
            'Access-Control-Allow-Origin'=> '*'
        ]);
    }
    /**
     * @Route("/api/product", methods={"POST"})
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $content = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setType($content['type']);
        $product->setModel($content['model']);
        $product->setPrice($content['price']);
        $product->setStock($content['stock']);

        $em->persist($product);
        $em->flush();

        return new JsonResponse([
            'result' => 'add con POST ok',
            'content' => $content
        ]);
    }
}
