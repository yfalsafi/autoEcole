<?php

namespace App\Repository;

use App\Entity\RequestExam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RequestExam|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequestExam|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequestExam[]    findAll()
 * @method RequestExam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestExamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RequestExam::class);
    }

    // /**
    //  * @return RequestExam[] Returns an array of RequestExam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RequestExam
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
