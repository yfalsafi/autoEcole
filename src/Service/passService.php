<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 17:46
 */
namespace App\Service;


use App\Entity\Pass;
use App\Entity\Planning;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class passService
{

    private $doctrine;
    private $manager;

    public function __construct(EntityManagerInterface $doctrine, ObjectManager $manager)
    {
        $this->doctrine = $doctrine;
        $this->manager = $manager;
    }


    /**
     *
     * @param User $user
     * @param $error
     */
    public function addPass(User $user, $error){

        $pass = new Pass();
        $pass->setUser($user);
        $pass->setPassAt(new \DateTime());
        $pass->setErrors($error);
        $this->manager->persist($pass);
        $this->manager->flush();

    }

}