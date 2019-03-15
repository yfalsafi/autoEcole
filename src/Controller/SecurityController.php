<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends BaseController
{

    /**
     * @Route("/register/candidate", name="registration_candidate")
     * @Route("/register/instructor", name="registration_instructor")
     * @param Request $request
     * @param UserManagerInterface $userManager
     * @param EventDispatcherInterface $dispatcher
     * @param TokenStorageInterface $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request, UserManagerInterface $userManager, EventDispatcherInterface $dispatcher, TokenStorageInterface $security)
    {
        /** @var User $user */
        $user = $userManager->createUser();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->get('_route') == "registration_instructor") {
                $user->setRoles(["ROLE_INSTRUCTOR"]);
                $user->setIsInstructor(true);
            } else {
                $user->addRole("ROLE_CANDIDATE");
                $user->setIsInstructor(false);
            }
            $user->setRegisterAt(new \DateTime());
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $token = new UsernamePasswordToken($user, $user->getPassword(), "main", $user->getRoles());
            $security->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $dispatcher->dispatch("security.interactive_login", $event);
            return $this->redirectToRoute('home');
        }
        return $this->render('bundles/FOSUserBundle/Registration/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
