<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    // LISTADO DE PEDIDOS PARA UN CLIENTE

    public function findOrdersByCustomer(Customer $customer)
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.customer = :customer')
            ->orderBy('o.date', 'ASC')
            ->setParameter('customer', $customer);
        return $qb->getQuery()->execute();
    }
   
    //LISTADO DE TODAS LAS FACTURAS 

    /*  public function findByCustomers($customers)
     {
         $qb = $this->createQueryBuilder('i')
             ->select('i, o') 
             ->join('i.related_order', 'o')
             ->where('o.customer in (:customers)')
             ->setParameter('customers', $customers)
         ;
         return $qb->getQuery()->execute();
     } */

    // LISTADO DE Pedidos PARA UNA LISTA DE CLIENTES
    
   /*  public function findByCustomers2($customers)
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.customer in (:customers)')
            ->setParameter('customers', $customers);
        return $qb->getQuery()->getSQL();
    } */


    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
