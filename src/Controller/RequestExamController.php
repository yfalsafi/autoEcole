<?php

namespace App\Controller;

use App\Entity\RequestExam;
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
    public function checkCode(Request $request, $type)
    {
        $request = new RequestExam();
        $request->setCandidate($this->getUser());
        $request->setType($type);



        return $this->json('ok', 200);
    }
}
