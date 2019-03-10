<?php

namespace App\Repository;

use App\Entity\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function findTurnOverByMonth($date)
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(pa.price * p.quantity)')
            ->join('p.package', 'pa')
            ->andWhere('month(p.buyAt) = month(:date)')
            ->andWhere('year(p.buyAt) = year(:date)')
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findTurnOverByInstructorAndMonth($date)
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(pa.price * p.quantity)')
            ->addSelect('u.name')
            ->join('p.package', 'pa')
            ->join('p.user','user')
            ->join('user.instructor','u')
            ->andWhere('month(p.buyAt) = month(:date)')
            ->andWhere('year(p.buyAt) = year(:date)')
            ->groupBy('u.name')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findMoneySpent($date)
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(pa.price * p.quantity)')
            ->addSelect('user.name')
            ->join('p.package', 'pa')
            ->join('p.user','user')
            ->andWhere('month(p.buyAt) = month(:date)')
            ->andWhere('year(p.buyAt) = year(:date)')
            ->groupBy('user.name')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }




    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
