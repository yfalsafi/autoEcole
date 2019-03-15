<?php

namespace App\Controller;

use App\Entity\Code;
use App\Entity\Constant;
use App\Entity\Pass;
use App\Service\passService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CodeController extends AbstractController
{
    /**
     * @Route("/candidate/code", name="code")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Code::class);
        $codes = $repo->findAll();

        return $this->render('code/index.html.twig', [
            'codes' => $codes,
        ]);
    }

    /**
     * @Route("/candidate/code/check/{id}", name="check_code", options={"expose"=true})
     * @return JsonResponse
     */
    public function checkCode(Request $request, $id,Session $session, passService $passService)
    {

        if($session->get('nbQuestion') < 3 || !$session->get('nbQuestion')){
            $repo = $this->getDoctrine()->getRepository(Code::class);

            $codes = $repo->findTwoById([$id,$id+1]);
            $answerCandidate = $request->query->get('a');
            $answer = $codes[0]['answer'];
            if(!($session->get('nbQuestion'))){
                $session->set('error',0);
                $session->set('nbQuestion',0);
            }
            $nbQuestion = $session->get('nbQuestion') + 1;
            if($answerCandidate != $answer){
                $error = $session->get('error') + 1;
                $session->set('error',$error);
            }
            $session->set('nbQuestion',$nbQuestion);
            $data= [
                'id' =>$codes[1]['id'],
                'question' =>$codes[1]['question'],
                'img' => Constant::PATH_IMAGE . $codes[1]['image'],
                'response'=> [ $codes[1]['A'], $codes[1]['B'], $codes[1]['C'], $codes[1]['D']]
            ];
        }else{

            if($session->get('error') >1){
                $data= [
                    'nbErrors'=>$session->get('error'),
                    'img'=>Constant::PATH_IMAGE . Constant::FAILED_IMAGE,
                ];

            }else{
                $data= [
                    'nbErrors'=>$session->get('error'),
                    'img'=>Constant::PATH_IMAGE . Constant::COMPLETED_IMAGE,
                ];

            }

            $passService->addPass($this->getUser(), $session->get('error'));

            $session->remove('error');
            $session->remove('nbQuestion');
        }

        return $this->json([$data ], 200);
    }


}
