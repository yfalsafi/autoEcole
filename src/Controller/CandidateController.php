<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Instructor;
use App\Entity\Planning;
use App\Entity\User;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;


class CandidateController extends AbstractController
{

    private $months=['Janvier','Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decémbre'];

    private $securityContext;

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo= $this->getDoctrine()->getRepository(Candidate::class);
        $user = $this->getUser();
        //$candidate=$repo->findOneByIdCandidate($user->getId());
            dump($this->getUser());


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


    /**
     * @Route("/candidate/instructor", name="set_instructor")
     */
    public function displayRequest(Request $request, EntityManagerInterface $manager)
    {

        $repo= $this->getDoctrine()->getRepository(User::class);
        $instructor=$repo->findInstructor();
        $form = $this->createFormBuilder($instructor)
            ->add('name', EntityType::class, array(
                'class' => User::class,
                'query_builder' =>  function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.isInstructor = true'); },
                'choice_label' => 'name',
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            dump($form->getViewData()['name']);
            /**
             * @var User $user
             */
            $user= $this->getUser();
            $user->setInstructor($form->getViewData()['name']);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('planning');
        }
        return $this->render('candidate/setInstructor.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
