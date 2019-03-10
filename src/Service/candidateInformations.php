<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 17:46
 */
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class candidateInformations
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
}