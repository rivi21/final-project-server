<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    // LISTADO DE FACTURAS PARA UN CLIENTE
 
    public function findByCustomer(Customer $customer)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i, o') 
            ->join('i.related_order', 'o')
            ->where('o.customer = :customer')
            ->orderBy('i.due_date', 'DESC')
            ->setParameter('customer', $customer)   
        ;
        return $qb->getQuery()->execute();
    }
   
    //LISTADO DE FACTURAS TOtales
    public function findByCustomers($customers)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i, o') 
            ->join('i.related_order', 'o')
            ->where('o.customer in (:customers)')
            ->setParameter('customers', $customers)
        ;
        return $qb->getQuery()->execute();
    }


   /*  public function findOneBySomeField()
    {
        $qb = $this->createQueryBuilder('i')
            ->where('i.')
        return $qb->getQuery()->execute();
    } */



    // /**
    //  * @return Invoice[] Returns an array of Invoice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invoice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
