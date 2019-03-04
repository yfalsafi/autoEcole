<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Planning;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Candidate;
use App\Entity\User;
use App\Repository\CandidateRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class LessonController extends AbstractController
{
    private $oppening = '07:00';
    private $closing = '21:00';
    private $limit = '02:00';


    /**
     * @Route("/lesson/new", name="addRequest")
     * @Route("/lesson/edit/{id}", name="editLesson")
     * @Route("/lesson/new/{id1}", name="newLesson")
     */
    public function AddRequest(Lesson $lesson = null, Request $request, ObjectManager $manager,$id1 = null)
    {
        $user= $this->getUser();
        $edit=true;
        dump($user);
        if(!$lesson)
        {
            $edit=false;
            $lesson= new Lesson();
            if ($id1 != null){
                $lesson->setStartAt(new \DateTime($id1));
                $lesson->setEndAt(new \DateTime($id1));
            }else
            {
                $lesson->setStartAt(new \DateTime());
                $lesson->setEndAt(new \DateTime());
            }

        }
        if($user->getInstructor()== null){
            return $this->redirectToRoute('set_instructor');
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
                $lesson->setStatus('W');
                $manager->persist($lesson);
                dump($edit);
               if(!$edit)
               {
                   $planning =new Planning();
                   $planning->setIdi($user->getInstructor());
                   $planning->setIdc($user);
                   $planning->setIdl($lesson);
                   $manager->persist($planning);
               }
                $manager->flush();
            }

        }
        return $this->render('planning/addRequest.html.twig', [
            'errors'=>$errors,
            'lesson'=>$lesson,
            'form' =>$form->createView(),
            'editMode'=>$lesson->getId()!== null
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
        $hoursLeft = $this->getUser()->getHoursLeft();
        if(!$hoursLeft)
            $hoursLeft=0;
        $repo=$this->getDoctrine()->getRepository(Lesson::class);
        $result = $repo->findByDateAndId($this->getUser(),$this->getUser()->getInstructor(),$start,$end);

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
        if($hoursLeft - date('H',strtotime($end)-strtotime($start)) < 0)
            $errors[]="You don't have enough hours. You have ".$hoursLeft. " hours left.";
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
     * @param User $user
     * @param $repo
     */
    public function setPlanning(Lesson $lesson, User $user, $repo, ObjectManager $manager){
        $planning= new Planning();
        $planning->setIdc($user->getId());
        $planning->setIdl($lesson->getIdl());
        $result = $repo->findOneByIdUser($user->getId());

        $planning->setIdi($result->getIdI());
        $manager->persist($planning);
        $manager->flush();
    }


   /* public function newLesson($id,Request $request, ObjectManager $manager)
    {

        $user= $this->getUser();
        if($user->getInstructor()== null){
            return $this->redirectToRoute('set_instructor');
        }

        $lesson= new Lesson();

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
                $planning =new Planning();
                $month =$lesson->getStartAt()->format('m');
                $year =$lesson->getStartAt()->format('Y');

                $lesson->setStatus('W');


                $planning->setIdi($user->getInstructor());
                $planning->setIdc($user);
                $planning->setIdl($lesson);
                dump($lesson);
                dump($planning);

                try{
                    $manager->persist($lesson);
                    $manager->persist($planning);
                    $manager->flush();
                }catch (\Exception $e){
                    $errors= $e->getMessage();
                }


 //               return $this->redirectToRoute('planningByM');
            }

        }
        return $this->render('planning/addRequest.html.twig', [
            'id'=>$id,
            'errors'=>$errors,
            'lesson'=>$lesson,
            'form' =>$form->createView(),
            'editMode'=>$lesson->getId()!== null,
        ]);


    }*/

    /**
     * @param $id
     * @Route("/instructor/update-status/{id}",name="update_status", options={"expose"=true})
     * @return JsonResponse
     */
    public function UpdateStatus(ObjectManager $manager, Request $request, $id)
    {
        // traitement en DB
        // Changer le status de la lesson
        // $request->query->get('status')
        $repo = $this->getDoctrine()->getRepository(Lesson::class);
        $lesson = $repo->findOneBy([
            'id'=>$id
        ]);

        $lesson->setStatus($request->query->get('status'));

        $manager->persist($lesson);
        $manager->flush();

       return $this->json('ok', 200);
    }

}
