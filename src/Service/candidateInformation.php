<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 17:46
 */
namespace App\Service;

use App\Entity\Car;
use App\Entity\Planning;
use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class candidateInformation
{

    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getCandidatesInformation()
    {
        $repoUser = $this->doctrine->getRepository(User::class);


        $numbers['allCandidates'] = $repoUser->findBy([
            'isInstructor'=>false
        ]);
        $numbers['candidate'] = $repoUser->countCandidate();
        $numbers['drivingCandidate'] = $repoUser->getStatusDriving();
        $numbers['codeCandidate'] = $repoUser->getStatusCode();
        $numbers['nbRegistration'] = $repoUser->countCandidateByMonth(new \DateTime());
        $numbers['registration'] = $repoUser->findCandidateByMonth(new \DateTime());

        return $numbers;
    }


    public function getInstructorsInformation()
    {
        $repoUser = $this->doctrine->getRepository(User::class);
        $repoPlanning = $this->doctrine->getRepository(Planning::class);


        $numbers['nbInstructor'] = $repoUser->countInstructor();
        $numbers['instructors'] = $repoUser->findBy([ 'isInstructor' => true]);
        $repoPurchase = $this->doctrine->getRepository(Purchase::class);
        foreach ($numbers['instructors'] as $i=>$instructor){
            $test[$instructor->getId()] = $repoPlanning->findHoursDoneByInstructor($instructor, date('m') );
            $a=0;
            foreach ($test[$instructor->getId()] as $planning){

                $a += $planning->getIdl()->getEndAt()->getTimeStamp() - $planning->getIdl()->getStartAt()->getTimeStamp();

            }
            $a = new \DateTime("@$a");
            $numbers[$instructor->getId()] = $a->format("H");
        }


        $numbers['turnoverByInstructor'] = $repoPurchase->findTurnOverByInstructorAndMonth(new \DateTime());

        return $numbers;
    }

    public function getCarsInformation()
    {
        $repoCar = $this->doctrine->getRepository(Car::class);

        $numbers['nbCar'] = $repoCar->countCar();
        $numbers['Cars'] = $repoCar->findAll();

        return $numbers;
    }

    public function getPurchaseInformation()
    {
        $repoPurchase = $this->doctrine->getRepository(Purchase::class);

        for($i=4;$i>=0;$i--)
        {
            $numbers['turnoverByMonth'][$i] = $repoPurchase->findTurnOverByMonth(new \DateTime(sprintf('-%d months',$i)));
            if(!isset($numbers['turnoverByMonth'][$i]))
            {
                $numbers['turnoverByMonth'][$i]=0;
                dump($repoPurchase->findTurnOverByMonth(new \DateTime(sprintf('-%d months',$i))));
            }

        }
        $numbers['moneySpent'] = $repoPurchase->findMoneySpent(new \DateTime());

        return $numbers;
    }
}