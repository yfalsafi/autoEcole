<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Purchase;
use App\Entity\User;
use App\Service\candidateInformation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/dashboard", name="admin")
     */
    public function index(candidateInformation $candidates)
    {

        $numbers = $candidates->getCandidatesInformation();
        $numbers += $candidates->getInstructorsInformation();
        $numbers += $candidates->getPurchaseInformation();
        $numbers += $candidates->getCarsInformation();

        //dd($number);

        return $this->render('admin/index.html.twig', [
            'numbers' => $numbers,
            'currentDate' =>new \DateTime()
        ]);
    }



    /**
     * @Route("/admin/dashboard/instructor", name="admin_instructor_details")
     */
    public function instructorDetails(candidateInformation $candidates)
    {
        $instructor = $candidates->getInstructorsInformation();


        return $this->render('admin/instructor.html.twig', [
           'numbers' =>$instructor
        ]);
    }

    /**
     * @Route("/admin/dashboard/newCandidate", name="admin_new_candidate_details")
     */
    public function newCandidates(candidateInformation $candidates)
    {
        return $this->render('admin/newCandidates.html.twig', [
            'numbers' =>$candidates->getCandidatesInformation()
        ]);
    }

    /**
     * @Route("/admin/dashboard/cars", name="admin_cars_details")
     */
    public function cars(candidateInformation $candidates)
    {
        $cars = $candidates->getCarsInformation();


        return $this->render('admin/car.html.twig', [
            'numbers' =>$cars
        ]);
    }
}


