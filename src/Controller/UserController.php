<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/account", name="user_account")
     */
    public function index()
    {

        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
