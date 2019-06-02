<?php

namespace App\Repository;

use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Planning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planning[]    findAll()
 * @method Planning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
{
    parent::__construct($registry, Planning::class);
}

    public function findAllBetween($user, $start, $end ):array
    {
        return $this->createQueryBuilder('p')
            ->from('App\Entity\Lesson', 'l')
            ->andWhere('l.id = p.idl')
            ->andWhere('p.idc = (:user)')
            ->andWhere('l.startAt BETWEEN (:start) AND (:end)')
            ->addOrderBy('l.startAt')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllCandidateHourBetween($user,$start,$end)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idl', 'l')
            ->addSelect('l')
            ->andWhere('p.idl = l.id')
            ->leftJoin('p.idc', 'u')
            ->addSelect('u')
            ->andWhere('p.idc = u.id')
            ->andWhere('l.endAt BETWEEN (:start) AND (:end)')
            ->andWhere('p.idc = :user')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllInstructorHourBetween($user,$start,$end)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idl', 'l')
            ->addSelect('l')
            ->andWhere('p.idl = l.id')
            ->leftJoin('p.idc', 'u')
            ->addSelect('u')
            ->andWhere('p.idc = u.id')
            ->andWhere("l.status != 'D'")
            ->andWhere('l.endAt BETWEEN (:start) AND (:end)')
            ->andWhere('p.idi = :user')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByInstructor($instructor,$date)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idl', 'l')
            ->addSelect('l')
            ->andWhere('p.idl = l.id')
            ->leftJoin('p.idc', 'u')
            ->addSelect('u')
            ->andWhere('p.idc = u.id')
            ->andWhere('l.startAt > :start')
            ->andWhere('p.idi = :user')
            ->setParameter('user', $instructor)
            ->setParameter('start', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIdLessonWithPlanning($lesson)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idl', 'l')
            ->addSelect('l')
            ->andWhere('p.idl = l.id')
            ->andWhere('l.id = :lesson')
            ->setParameter('lesson', $lesson)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findNbLessonByUser($user,$date)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->join('App\Entity\Lesson', 'l')
            ->andWhere('p.idl = l.id')
            ->andWhere('l.startAt < (:date)')
            ->andWhere('p.idc = (:user)')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findNbLessonByInstructor($user,$date)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->join('App\Entity\Lesson', 'l')
            ->andWhere('p.idl = l.id')
            ->andWhere('l.startAt < (:date)')
            ->andWhere('p.idi = (:user)')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    public function findOneByIdl($idl)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.idl = (:idl)')
            ->setParameter('idl', $idl)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findHoursDoneByInstructor($user,$month)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idl', 'l')
            ->addSelect('l')
            ->andWhere('p.idl = l.id')
            ->leftJoin('p.idi', 'i')
            ->addSelect('i')
            ->andWhere('MONTH(l.startAt) = (:start)')
            ->andWhere('p.idi = :user')
            ->setParameter('user', $user)
            ->setParameter('start', $month)
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
