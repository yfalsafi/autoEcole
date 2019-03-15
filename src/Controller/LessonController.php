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

    /**
     * @Route("/lesson/new", name="addRequest")
     * @Route("/lesson/edit/{id}", name="editLesson")
     * @Route("/lesson/new/{date}", name="newLesson")
     */
    public function AddRequest(Lesson $lesson = null, Request $request, ObjectManager $manager, $id = null, $date = null)
    {
        $user = $this->getUser();

        if ($lesson == null) {
            $edit = false;
            $lesson = new Lesson();
            if ($date != null && $id == null) {
                $lesson->setStartAt(new \DateTime($date));
                $lesson->setEndAt(new \DateTime($date));
            } else {
                $lesson->setStartAt(new \DateTime());
                $lesson->setEndAt(new \DateTime());
            }

        } else
            $edit = true;

        if ($user->getInstructor() == null) {
            return $this->redirectToRoute('set_instructor');
        }


        $errors = array();
        $form = $this->createFormBuilder($lesson)
            ->add('startAt', DateTimeType::class, array(
                'years' => array('2019'),
                'minutes' => range(0, 30, 30),
                'error_bubbling' => true
            ))
            ->add('endAt', DateTimeType::class, array(
                'years' => array('2019'),
                'minutes' => range(0, 30, 30),
                'error_bubbling' => true,
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setStatus('W');
            $manager->persist($lesson);
            if (!$edit) {
                $planning = new Planning();
                $planning->setIdi($user->getInstructor());
                $planning->setIdc($user);
                $planning->setIdl($lesson);
                $manager->persist($planning);
            }
            $manager->flush();
            return $this->redirectToRoute('planning');
        }
        return $this->render('planning/addRequest.html.twig', [
            'errors' => $errors,
            'lesson' => $lesson,
            'form' => $form->createView(),
            'editMode' => $edit
        ]);


    }


    /**
     * @Route("/delete/{id}", name="deleteLesson")
     */
    public function deleteLesson(Lesson $lesson, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Planning::class);
        $planning = $repo->findOneByIdl($lesson);
        if ($planning->getIdC()->getId() == $this->getUser()->getId()) {
            $manager->remove($planning);
            $manager->remove($lesson);
            $manager->flush();
            return $this->redirectToRoute('planning');
        }

        return $this->render('lesson/edit.html.twig', [
        ]);
    }


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
            'id' => $id
        ]);
        $repoPlanning = $this->getDoctrine()->getRepository(Planning::class);
        $planning = $repoPlanning->findOneBy([
            'idl' => $lesson->getId()
        ]);

        if ($request->query->get('status') == 'A') {
            $hours = $lesson->getEndAt()->diff($lesson->getStartAt());
            $planning->getIdc()->setHoursLeft($planning->getIdc()->getHoursLeft() - $hours->format('%H'));
            $user = $planning->getIdc();
            $user->setHoursDone($user->getHoursDone() + $hours->format('%H'));
            $manager->persist($user);
        }

        $lesson->setStatus($request->query->get('status'));

        $manager->persist($lesson);
        $manager->flush();

        return $this->json('ok', 200);
    }

}
