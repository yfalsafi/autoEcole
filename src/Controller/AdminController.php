<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Purchase;
use App\Entity\User;
use App\Service\candidateInformations;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    public function getInstructorsInformation()
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);


        $numbers['nbInstructor'] = $repoUser->countInstructor();
        $numbers['instructors'] = $repoUser->findBy([ 'isInstructor' => true]);



        return $numbers;
    }

    public function getCarsInformation()
    {
        $repoCar = $this->getDoctrine()->getRepository(Car::class);

        $numbers['nbCar'] = $repoCar->countCar();
        $numbers['Cars'] = $repoCar->findAll();

        return $numbers;
    }

    public function getPurchaseInformation()
    {
        $repoPurchase = $this->getDoctrine()->getRepository(Purchase::class);

        $numbers['turnoverByInstructor'] = $repoPurchase->findTurnOverByInstructorAndMonth(new \DateTime());
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

    /**
     * @Route("/admin/dashboard", name="admin")
     */
    public function index(candidateInformations $candidates)
    {

        $numbers = $candidates->getCandidatesInformation();
        $numbers += $this->getInstructorsInformation();
        $numbers += $this->getPurchaseInformation();
        $numbers += $this->getCarsInformation();

        //dd($number);

        return $this->render('admin/index.html.twig', [
            'numbers' => $numbers,
            'currentDate' =>new \DateTime()
        ]);
    }



    /**
     * @Route("/admin/dashboard/instructor", name="admin_instructor_details")
     */
    public function instructorDetails()
    {
        $instructor = $this->getInstructorsInformation();


        return $this->render('admin/instructor.html.twig', [
           'numbers' =>$instructor
        ]);
    }

    /**
     * @Route("/admin/dashboard/newCandidate", name="admin_new_candidate_details")
     */
    public function newCandidates(candidateInformations $candidates)
    {
        return $this->render('admin/newCandidates.html.twig', [
            'numbers' =>$candidates->getCandidatesInformation()
        ]);
    }

    /**
     * @Route("/admin/dashboard/cars", name="admin_cars_details")
     */
    public function cars()
    {
        $cars = $this->getCarsInformation();


        return $this->render('admin/car.html.twig', [
            'numbers' =>$cars
        ]);
    }
}



