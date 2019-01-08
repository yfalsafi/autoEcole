<?php

namespace App\Repository;

use App\Entity\Instructor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Instructor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instructor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instructor[]    findAll()
 * @method Instructor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstructorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Instructor::class);
    }

    public function findOneByIdUser($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idCandidate = (:val)')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    public function findAllByYear($start,$end)
    {
        return $this->createQueryBuilder('c')
            ->select('count(c)')
            ->Where('c.registrationDate BETWEEN (:start) AND (:end)')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
