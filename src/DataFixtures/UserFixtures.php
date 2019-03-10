<?php

namespace App\DataFixtures;

use App\Entity\Package;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;


class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct( UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder= $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for($i=0;$i<3;$i++) {
            /**
             * @var $user User
             */
            $user=  new User();
            $user->setFirstName($faker->firstName)
                ->setUsername($faker->userName)
                ->setName($faker->name)
                ->setBirth($faker->dateTimeBetween('-45 years','-23 years'))
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setEmail(sprintf('instructor%d@gmail.com',$i))
                ->setRoles(['ROLE_INSTRUCTOR'])
                ->setPassword($this->passwordEncoder->encodePassword($user, '123'))
                ->setIsInstructor(true)
                ->setEnabled(true)
                ->setIsAdmin(false)
                ->setRegisterAt($faker->dateTimeBetween('-3years'));
            $package = new Package();

            if($i!=0)
            {
                $package->setTitle(sprintf('Formation %d0H',$i+1))
                        ->setNbHours($i*10);
            }
            else{
                $package->setTitle(sprintf('Formation Accelere',$i))
                        ->setNbHours(20);
            }
            $package->setContent($faker->paragraph(6))
                ->setPrice($faker->randomNumber(6))
                ->setIsPackage(1);

            $manager->persist($user);
            $manager->persist($package);
            $manager->flush();

        }
        for($i=0;$i<10;$i++){
            $user=  new User();
            $user->setFirstName($faker->firstName)
                ->setUsername($faker->userName)
                ->setName($faker->name)
                ->setBirth($faker->dateTimeBetween('-45 years','-18 years'))
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setEmail(sprintf('candidate%d@gmail.com',$i))
                ->setRoles(['ROLE_CANDIDATE'])
                ->setPassword($this->passwordEncoder->encodePassword($user, '123'))
                ->setIsInstructor(false)
                ->setEnabled(true)
                ->setIsAdmin(false)
                ->setRegisterAt($faker->dateTimeBetween('-3years'));
             if($faker->boolean){
                 $user->setStatus('code');
             }else{
                 $user->setStatus('driving');
             }
            $manager->persist($user);
            $manager->flush();
        }

        $user=  new User();
        $user->setFirstName('Admin')
            ->setUsername('Admin')
            ->setName('Admin')
            ->setBirth($faker->dateTimeBetween('-45 years','-23 years'))
            ->setAddress($faker->address)
            ->setCity($faker->city)
            ->setEmail('admin@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword($user, '123'))
            ->setIsAdmin(true)
            ->setEnabled(true)
            ->setRegisterAt($faker->dateTimeBetween('-3years'));
        $manager->persist($user);
        $manager->flush();

/*            $package = new Package();


            $package->setTitle('Formation 20H')
                    ->setContent('Code illimité valable 1 an
                            frais d\'accompagnemen examen code
                            Pochette pédagogique B
                            21 heures de conduite
                            frais d\'accompagnement examen pratique')
                    ->setPrice(95000);

            $package->setTitle('Formation 30H')
                ->setContent('- Code illimité valable 1 an
                - frais d\'accompagnemen examen code
                - Pochette pédagogique B
                - 31 heures de conduite
                 -frais d\'accompagnement examen pratique')
                ->setPrice(125000);

            $package->setTitle('Formation accelere')
                ->setContent('Code illimité valable 1 an
                            frais d\'accompagnemen examen code
                            Pochette pédagogique B
                            21 heures de conduite
                            frais d\'accompagnement examen pratique')
                ->setPrice(110000);*/

    }
}
