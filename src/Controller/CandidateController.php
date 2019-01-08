<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Instructor;
use App\Entity\Planning;
use App\Entity\Users;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;


class CandidateController extends AbstractController
{

    private $months=['Janvier','Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decémbre'];

    private $securityContext;
    public function __construct(Security $securityContext)
    {
        $this->securityContext = $securityContext;
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Candidate::class);
        $users =new Users();
        if($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            $user = $this->securityContext->getToken()->getUser();
            $candidate=$repo->findOneByIdCandidate($user->getIdUser());
            dump($candidate);
        }


        return $this->render('candidate/index.html.twig', [
        ]);
    }
//    /**
//     * @Route("/candidate", name="candidate")
//     */
//    public function index()
//    {
//        return $this->render('candidate/index.html.twig', [
//            'controller_name' => 'CandidateController',
//        ]);
//    }


    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('users/login.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function signin()
    {
        return $this->render('users/signin.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
    /**
     * @Route("/exo/{id}", name="exo")
     */
    public function exo($id){
        $nbHoursCandidate= array();
        $nbHoursInstructor= array();
        $repo=$this->getDoctrine()->getRepository(Candidate::class);
        for($month=1;$month<=12;$month++){
            $start=date($id.'-'.$month.'-01');
            $end=date($id.'-'.$month.'-31');
            $results[$month]=$repo->findAllByYear($start,$end);
        }
        $rep = $this->getDoctrine()->getRepository(Planning::class);
        $repI = $this->getDoctrine()->getRepository(Instructor::class);
        $candidate= $repo->findAll();
        $instructor= $repI->findAll();
        for($i=0;$i<sizeof($candidate);$i++){
            $nbHoursCandidate[$i] = $rep->findNbLessonByUser($candidate[$i]->getIdCandidate(),new \DateTime());
        }
        for($i=0;$i<sizeof($instructor);$i++){
            $nbHoursInstructor[$i] = $rep->findNbLessonByInstructor($instructor[$i]->getIdInstructor(),new \DateTime());
        }
        dump($nbHoursInstructor);
        return $this->render('exo/index.html.twig', [
            'results'=>$results,
            'months'=>$this->months,
            'id'=>$id,
            'candidates'=>$candidate,
            'instructors'=>$instructor,
            'nbHC'=>$nbHoursCandidate,
            'nbHI'=>$nbHoursInstructor,
        ]);
    }


}
