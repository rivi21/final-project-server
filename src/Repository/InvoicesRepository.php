<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Invoices;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invoices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoices[]    findAll()
 * @method Invoices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoices::class);
    }

    // LISTADO DE FACTURAS PARA UN CLIENTE
    public function findInvoiceByCustomer(Customer $customer)
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i, o')
            ->join('i.orderRelated', 'o')
            ->where('o.customer = :customer')
            ->orderBy('i.dueDate', 'DESC')
            ->setParameter('customer', $customer);
        return $qb->getQuery()->execute();
    }

    // LISTADO DE Pedidos PARA UNA LISTA DE CLIENTES
    public function findByCustomers2($customers)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('i, o')
            ->join('i.orderRelated', 'o')
            ->where('o.customer in (:customers)')
            ->setParameter('customers', $customers);
        return $qb->getQuery()->getSQL();
    }
   

    // /**
    //  * @return Invoices[] Returns an array of Invoices objects
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
    public function findOneBySomeField($value): ?Invoices
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
