<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findInstructor()
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isInstructor = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function countCandidate()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = false')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function countCandidateByInstructor($instructor)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = false')
            ->andWhere('u.instructor = :instructor')
            ->setParameter('instructor', $instructor)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function countInstructor()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = true')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findByIda($user)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = (:user)')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function countCandidateByMonth($date)
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = false')
            ->andWhere('u.IsAdmin = false')
            ->andWhere('month(u.registerAt) = month(:start) ')
            ->andWhere('year(u.registerAt) = year(:start) ')
            ->setParameter('start', $date)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
    public function findCandidateByMonth($date)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.isInstructor = false')
            ->andWhere('u.IsAdmin = false')
            ->andWhere('month(u.registerAt) = month(:start) ')
            ->andWhere('year(u.registerAt) = year(:start) ')
            ->setParameter('start', $date)
            ->getQuery()
            ->getScalarResult()
            ;
    }

    public function getStatusCode()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = false')
            ->andWhere('u.IsAdmin = false')
            ->andWhere("u.status = 'code' ")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function getStatusDriving()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u)')
            ->andWhere('u.isInstructor = false')
            ->andWhere('u.IsAdmin = false')
            ->andWhere("u.status = 'driving'")
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findAllByYear($start,$end)
    {
        return $this->createQueryBuilder('c')
            ->select('count(c)')
            ->Where('c.registrationAt BETWEEN (:start) AND (:end)')
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
