<?php

namespace App\Repository;

use App\Entity\Lesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lesson[]    findAll()
 * @method Lesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    /**
     * @param $user
     * @param $start
     * @param $end
     * @return array
     */
    public function findAllHourCandidateBetween($user, $start, $end ):array
    {
        return $this->createQueryBuilder('l')
            ->from('App\Entity\Planning', 'p')
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



    /**
     * @param $user
     * @param $start
     * @param $end
     * @return array
     */
    public function findAllHourInstructorBetween($user, $start, $end ):array
    {
        return $this->createQueryBuilder('l')
            ->from('App\Entity\Planning', 'p')
            ->andWhere('l.id = p.idl')
            ->andWhere('p.idi = (:user)')
            ->andWhere('l.startAt BETWEEN (:start) AND (:end)')
            ->addOrderBy('l.startAt')
            ->setParameter('user', $user)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }


    public function findByDateAndId($candidate,$instructor, $start, $end ):array
    {
        return $this->createQueryBuilder('l')
            ->from('App\Entity\Planning', 'p')
            ->andWhere('l.id = p.idl')
            ->andWhere('p.idc = (:candidate)')
            ->andWhere('p.idi = (:instructor)')
            ->andWhere('l.endAt BETWEEN (:start) AND (:end)')
            ->andWhere('l.status != \'D\'')
            ->addOrderBy('l.startAt')
            ->setParameter('candidate', $candidate)
            ->setParameter('instructor', $instructor)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByInstructor($instructor,$date)
    {
        return $this->createQueryBuilder('l')
            ->join('App\Entity\Planning', 'p')
            ->Where('p.idl = l.id')
            ->andWhere('l.startAt > (:start)')
            ->andWhere('p.idi = (:user)')
            ->setParameter('user', $instructor)
            ->setParameter('start', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findHoursDoneByInstructor($user,$month)
    {
        return $this->createQueryBuilder('l')
            ->join('p.idl', 'p')
            ->addSelect('p')
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
