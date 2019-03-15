<?php

namespace App\Controller;

use App\Entity\Pass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PassController extends AbstractController
{
    /**
     * @Route("/candidate/pass", name="pass")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Pass::class);
        $pass = $repo->findBy([
            'user' => $this->getUser()
        ]);
        $exam = false;
        if(sizeof($pass)>10){
            $exam = true;
        }else{
            $exam = false;
        }

        return $this->render('pass/index.html.twig', [
            'pass' => $pass,
            'exam' => $exam,
        ]);
    }


}
