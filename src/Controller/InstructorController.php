<?php

namespace App\Controller;


use App\Entity\Lesson;
use App\Entity\Planning;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    /**
     * @Route("/instructor", name="instructor")
     */
    public function index()
    {
        return $this->render('instructor/index.html.twig', [
            'controller_name' => 'InstructorController',
        ]);
    }


    /**
     * @Route("/instructor/request", name="instructor_request" ,options={"expose"=true})
     */
    public function displayRequest(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Planning::class);
        $plannings = $rep->findAllByInstructor($this->getUser(), new \DateTime());

        return $this->render('instructor/request.html.twig', [
                'plannings'=>$plannings,
                //'lessons'=>$lessons,
        ]);
    }


}
