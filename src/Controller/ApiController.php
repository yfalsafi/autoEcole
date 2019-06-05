<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use App\Form\CarType;
use App\Form\PatchUserForm;
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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
     * @Rest\Delete("/api/delete/user/{id}", name="delete_user")
     * @Rest\View(StatusCode = Response::HTTP_NO_CONTENT)
     */
    public function deleteCandidates($id, ObjectManager $manager)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(
            ["id" => $id]
        );

        $manager->remove($user);
        $manager->flush();

    }

    /**
     * @Rest\Patch("api/user/{id}", name = "app_candidate_update")
     * @Rest\View(StatusCode = 202)
     */
    public function updateCandidate ($id, Request $request, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $candidate = $repo->findOneBy(["id" => $id]);
        if(empty($candidate)){
            $message = "Voiture inexistante";
            throw new ResourceValidationException($message);
        }
        $form = $this->createForm( PatchUserForm::class, $candidate);

        $data = json_decode($request->getContent(),true);

        if ($data['is_instructor'] === true ) {
            $data['isInstructor'] = 1;
        } else {
            $data['isInstructor'] = 0;
        }
        $data['firstName'] =  $data['first_name'];
        //dump($car);die;
        $form->submit($data);
        //if($form->isValid()){
        $manager->persist($candidate);
        $manager->flush();

        return $candidate;
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
     * @Rest\Post("api/instructor", name = "app_instructor_create")
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("instructor", converter="fos_rest.request_body")
     */
    public function addInstructor(User $instructor, ConstraintViolationList $violations, ObjectManager $manager, UserPasswordEncoderInterface $encode)
    {
        if(count($violations)){
            $message ="The JSON sent contains invalid data. Here are the errors you need to correct :";

            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }
        $instructor->setPassword($encode->encodePassword($instructor, $instructor->getPassword()));
        $manager->persist($instructor);
        $manager->flush();

        return $instructor;

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
    public function getAllCar()
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
        $form = $this->createForm( CarType::class, $car);

        $data = json_decode($request->getContent(),true);

        if ($data['is_available'] === true ) {
            $data['isAvailable'] = 1;
        } else {
            $data['isAvailable'] = 0;
        }
        //dump($data);die;
        //dump($car);die;
        $form->submit($data);
        //if($form->isValid()){
            $manager->persist($car);
            $manager->flush();

            return $car;
        //}else{
        //    return $form;
        //}
    }

    /**
     * @Rest\Delete("/api/delete/car/{id}", name="delete_car")
     * @Rest\View(StatusCode = Response::HTTP_NO_CONTENT)
     */
    public function deleteCar($id, ObjectManager $manager)
    {
        $car = $this->getDoctrine()->getRepository(Car::class)->findOneBy(
            ["id" => $id]
        );

        $manager->remove($car);
        $manager->flush();

    }


}