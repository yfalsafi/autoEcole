<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Users;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();
        $form= $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $hash=$encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('candidate_registration', ['id'=>$user->getIdUser()]);
        }
        return $this->render('security/index.html.twig', [
            'form' =>$form->createView()
        ]);
    }


    /**
     * @Route("/registration/{id}", name="candidate_registration")
     */
    public function candidateRegistration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder, Users $user)
    {
        $candidate = new Candidate();
        $form= $this->createFormBuilder($candidate)
                    ->add('surname')
                    ->add('firstname')
                    ->add('adress')
                    ->add('city')
                    ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $candidate->setIdCandidate($user->getIdUser());
            $candidate->setIdl(1);
            $candidate->setStatus('code');
            $candidate->setRegistrationDate(new \DateTime());
            $manager->persist($candidate);
            $manager->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('security/candidate.html.twig', [
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error =$authenticationUtils->getLastAuthenticationError();
        $lastUsername= $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username'=>$lastUsername,
            'error'=>$error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }




/*        if($planning->getIdC() == $this->getUser()->getIdUser()){
           $manager->remove($lesson);
            $manager->flush();
        }
        $this->redirectToRoute('planning');*/

}
