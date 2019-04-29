<?php

namespace App\Controller;

use App\Entity\RequestExam;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RequestExamController extends AbstractController
{
    /**
     * @Route("/candidate/code/exam/{type}", name="candidate_exam", options={"expose"=true})
     * @return JsonResponse
     */
    public function checkCode(ObjectManager $manager, $type)
    {
        $requestExam = new RequestExam();
        $requestExam->setCandidate($this->getUser());
        $requestExam->setType($type);
        $requestExam->setRequestAt(new \DateTime());
        $requestExam->setStatus('W');

        $manager->persist($requestExam);
        $manager->flush();

        return $this->json('ok', 200);
    }

    /**
     * @Route("/admin/request/update/{id}/{status}", name="admin_update_request", options={"expose"=true})
     * @return JsonResponse
     */
    public function updateAdminRequest(ObjectManager $manager, $id, $status)
    {
        $repo = $this->getDoctrine()->getRepository(RequestExam::class);

        $requestExam = $repo->findOneBy(['id'=>$id]);
        $requestExam->setStatus($status);

        $manager->persist($requestExam);
        $manager->flush();

        return $this->json('ok', 200);
    }
}
