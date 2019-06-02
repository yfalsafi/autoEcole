<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use App\Form\CarType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\ConstraintViolationList;
use App\Exception\ResourceValidationException;

class ApiController extends AbstractController
{
    /**
     * @Rest\Get("/api/candidates", name="get_all_candidate")
     * @Rest\View(StatusCode = 200)
     */
    public function getAllCandidates()
    {
        $candidates = $this->getDoctrine()->getRepository(User::class)->findBy(
            ["isInstructor" => false]
        );

        return $candidates;
    }

    /**
     * @Rest\Patch("api/candidate/{id}", name = "app_candidate_update")
     * @Rest\View(StatusCode = 202)
     */
    public function updateCandidate ($id, Request $request, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $car = $repo->findOneBy(["id" => $id]);
        if(empty($car)){
            $message = "Candidat inexistante";
            throw new ResourceValidationException($message);
        }
        $form = $this->createForm(RegistrationType::class,$car);
        $form->submit($request->request->all(), false);
        if($form->isValid()){
            $manager->persist($car);
            $manager->flush();
            return $car;
        }else{
            return $form;
        }
    }


    /**
     * @Rest\Get("/api/instructors", name="get_all_instructor")
     * @Rest\View(StatusCode = 200)
     */
    public function getAllInstructor()
    {
        $instructors = $this->getDoctrine()->getRepository(User::class)->findBy(
            ["isInstructor" => true]
        );

        return $instructors;
    }

    /**
     * @Rest\Patch("api/instructor/{id}", name = "app_instructor_update")
     * @Rest\View(StatusCode = 202)
     */
    public function updateInstructor ($id, Request $request, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $car = $repo->findOneBy(["id" => $id]);
        if(empty($car)){
            $message = "Moniteur inexistante";
            throw new ResourceValidationException($message);
        }
        $form = $this->createForm(RegistrationType::class,$car);
        $form->submit($request->request->all(), false);
        if($form->isValid()){
            $manager->persist($car);
            $manager->flush();
            return $car;
        }else{
            return $form;
        }
    }


    /**
     * @Rest\Get("/api/cars", name="get_all_car")
     * @Rest\View(StatusCode = 200, serializerGroups={"car"})
     */
    public function getAllCar(SerializerInterface $serializer)
    {
        $cars = $this->getDoctrine()->getRepository(Car::class)->findAll();
        return $cars;
    }

    /**
     * @Rest\Post("api/car", name = "app_car_create")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("car", converter="fos_rest.request_body")
     */
    public function addCar(Car $car, ConstraintViolationList $violations, ObjectManager $manager)
    {
        if(count($violations)){
            $message ="The JSON sent contains invalid data. Here are the errors you need to correct :";

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $manager->persist($car);
        $manager->flush();

        return $car;

    }

    /**
     * @Rest\Patch("api/car/{id}", name = "app_car_update")
     * @Rest\View(StatusCode = 202)
     */
    public function updateCar ($id, Request $request, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Car::class);
        $car = $repo->findOneBy(["id" => $id]);
        if(empty($car)){
            $message = "Voiture inexistante";
            throw new ResourceValidationException($message);
        }
        $form = $this->createForm(CarType::class,$car);
        $form->submit($request->request->all(), false);
        if($form->isValid()){
            $manager->persist($car);
            $manager->flush();
            return $car;
        }else{
            return $form;
        }
    }

    /**
     * @Rest\Post("api/admin", name = "app_user_check")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function createAction(User $user, ConstraintViolationList $violations, EncoderFactoryInterface $factory)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        if(count($violations)){
            $message ="The JSON sent contains invalid data. Here are the errors you need to correct :";

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $userDB = $repo->findOneBy([ "username" => $user->getUsername(), "IsAdmin"=> true ]);
        $notAdmin = $repo->findOneBy([ "username" => $user->getUsername(), "IsAdmin"=> false ]);
        if($notAdmin){
            $message = "Vous n'avez pas les droits necessaires";
            throw new ResourceValidationException($message);
        }
        else if($userDB == ""){
            $message = "username ou password incorrect";
            throw new ResourceValidationException($message);
        }

        $encoder = $factory->getEncoder($userDB);

        $bool = ($encoder->isPasswordValid($userDB->getPassword(), $user->getPassword(), $userDB->getSalt()));
        if ($bool){
            return $userDB;
        }else{
            $message =  "Le username ou le password est incorrect";
            throw new ResourceValidationException($message);
        }


    }


    /**
     * @Rest\Post("api/login_check", name = "app_user_check")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("user", converter="fos_rest.request_body")
     */
    public function aaaaa()
    {
//        $repo = $this->getDoctrine()->getRepository(User::class);
//        if(count($violations)){
//            $message ="The JSON sent contains invalid data. Here are the errors you need to correct :";
//
//            foreach ($violations as $violation) {
//                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
//            }
//
//            throw new ResourceValidationException($message);
//        }
//
//        $userDB = $repo->findOneBy([ "username" => $user->getUsername(), "IsAdmin"=> true ]);
//        if($userDB == ""){
//            $message = "Vous n'avez pas les droits necessaires";
//            throw new ResourceValidationException($message);
//        }
//
//        $encoder = $factory->getEncoder($userDB);
//
//        $bool = ($encoder->isPasswordValid($userDB->getPassword(), $user->getPassword(), $userDB->getSalt()));
//        if ($bool){
//            return $userDB;
//        }else{
//            $message =  "Le username ou le password est incorrect";
//            throw new ResourceValidationException($message);
//        }


    }
}