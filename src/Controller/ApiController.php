<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Rest\Get("/api/cars", name="get_all_car")
     * @Rest\View(StatusCode = 200)
     */
    public function getAllCar()
    {
        $cars = $this->getDoctrine()->getRepository(Car::class)->findAll();
        return $cars;
    }
}
