<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 07/03/2019
 * Time: 15:54
 */

namespace App\DataFixtures;


use App\Entity\Instructor;
use Doctrine\Common\Persistence\ObjectManager;

class InstructorFixtures
{
    public function load(ObjectManager $manager)
    {
        $instructor = new Instructor();

    }
}