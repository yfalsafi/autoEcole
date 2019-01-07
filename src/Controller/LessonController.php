<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Planning;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Candidate;
use App\Entity\Users;
use App\Repository\CandidateRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class LessonController extends AbstractController
{
    private $oppening = '07:00';
    private $closing = '21:00';
    private $limit = '02:00';


    /**
     * @Route("/new", name="addRequest")
     * @Route("/edit/{id}", name="editLesson")
     */
    public function AddRequest(Lesson $lesson = null,Request $request, ObjectManager $manager)
    {
        $edit=true;
        if(!$lesson)
        {
            $edit=false;
            $lesson= new Lesson();
            $lesson->setStartAt(new \DateTime());
            $lesson->setEndAt(new \DateTime());
        }


        $errors=array();
        $form= $this->createFormBuilder($lesson)
            ->add('startAt',DateTimeType::class, array(
                'years' => array('2019')))
            ->add('endAt',DateTimeType::class, array(
        'years' => array('2019')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

           $errors = $this->CheckDatetime($lesson);
           if(!$errors)
            {
                $month =$lesson->getStartAt()->format('m');
                $year =$lesson->getStartAt()->format('Y');
                $lesson->setStatus('Waiting');
                $manager->persist($lesson);
                $manager->flush();
               if(!$edit)
               {
                   $repo= $this->getDoctrine()->getRepository(Candidate::class);
                   $lessonController = new LessonController();
                  $lessonController->setPlanning($lesson, $this->getUser(),$repo,$manager);
               }
                return $this->redirectToRoute('planningByM', array('id'=>$month, 'idy'=>$year)
                );
            }

        }
        return $this->render('planning/addRequest.html.twig', [
            'errors'=>$errors,
            'lesson'=>$lesson,
            'form' =>$form->createView(),
            'editMode'=>$lesson->getIdl()!== null
        ]);


    }

    /**
     * Check if the form is Valid and return the error if they have no error, return an empty array
     * @param Lesson $lesson
     * @return array|string
     */
    public function CheckDatetime(Lesson $lesson){
        $errors= array();
        $start=$lesson->getStartAt()->format('Y-m-d');
        $end=$lesson->getEndAt()->format('Y-m-d');
        if($start != $end)
            $errors[]='The Beginning and the end must be at the day';
        if($lesson->getStartAt()->format('N') == 6 || $lesson->getStartAt()->format('N') == 7)
            $errors[]="Can't Take hours during the Week end";
        $start=$lesson->getStartAt()->format('H:i');
        $end=$lesson->getEndAt()->format('H:i');
        if(strtotime($start )< strtotime($this->oppening) || strtotime($start)>strtotime($this->closing))
            $errors[]='The start doesn\'t respect the  opening hours 7h -> 21h';
        if(strtotime($end)>strtotime($this->closing))
            $errors[]='The end doesn\'t respect the  opening hours 7h -> 21h';
        if(strtotime(date("H:i", strtotime($start) +strtotime($this->limit))) < strtotime($end))
            $errors[]="Can‘t take more than 2 hours in row";

        dump($lesson->getStartAt()->format('N'));
        return $errors;
    }

    /**
     * @Route("/delete/{id}", name="deleteLesson")
     */
    public function deleteLesson(Lesson $lesson, ObjectManager $manager){
        $repo= $this->getDoctrine()->getRepository(Planning::class);
        $planning = $repo->findOneByIdl($lesson);
        if($planning->getIdC() == $this->getUser()->getIdUser()){
           $manager->remove($planning);
           $manager->remove($lesson);
           $manager->flush();
            return $this->redirectToRoute('planning');
        }

        return $this->render('lesson/edit.html.twig', [
        ]);
    }

    /**
     * Insert Data on Planning table
     * @param Lesson $lesson
     * @param Users $user
     * @param $repo
     */
    public function setPlanning(Lesson $lesson, Users $user,$repo, ObjectManager $manager){
        $planning= new Planning();
        $planning->setIdc($user->getIdUser());
        $planning->setIdl($lesson->getIdl());
        $result = $repo->findOneByIdUser($user->getIdUser());
        $planning->setIdi($result->getIdI());
        $manager->persist($planning);
        $manager->flush();
    }

    /**
     * @Route("/lesson/new/{id}", name="newLesson")
     */
    public function newLesson($id,Request $request, ObjectManager $manager)
    {
        $lesson= new Lesson();
        $lesson->setStartAt(new \DateTime($id));
        dump($lesson->getStartAt());
        $lesson->setEndAt(new \DateTime($id));
        $errors=array();
        $form= $this->createFormBuilder($lesson)
            ->add('startAt',DateTimeType::class, array(
                'years' => array('2019')))
            ->add('endAt',DateTimeType::class, array(
                'years' => array('2019')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $errors = $this->CheckDatetime($lesson);
            if(!$errors)
            {
                $month =$lesson->getStartAt()->format('m');
                $year =$lesson->getStartAt()->format('Y');
                $lesson->setStatus('Waiting');
                $manager->persist($lesson);
                $manager->flush();
                $repo= $this->getDoctrine()->getRepository(Candidate::class);
                $lessonController = new LessonController();
                $lessonController->setPlanning($lesson, $this->getUser(),$repo,$manager);
                return $this->redirectToRoute('planningByM', array('id'=>$month, 'idy'=>$year)
                );
            }

        }
        return $this->render('planning/addRequest.html.twig', [
            'id'=>$id,
            'errors'=>$errors,
            'lesson'=>$lesson,
            'form' =>$form->createView(),
            'editMode'=>$lesson->getIdl()!== null,
        ]);


    }


}
