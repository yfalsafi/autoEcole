<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 17:46
 */
namespace App\Service;


use App\Entity\Planning;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class planningInformation
{

    private $month;
    private $year;
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Return First Day
     * @return \DateTime
     */
    public function getFirstDay($month, $year): \DateTime{

        return new \DateTime("{$year}-{$month}-01");
    }

    /**
     * return weeks in month
     * @return int of week
     */
    public function getWeeks(): int {
        $date=new \DateTime();
        if($this->month== null){
            $this->month= $date->format('m');
        }
        $start = $this->getFirstDay($this->month,$this->year);
        $end = (clone $start)->modify('+1 month -1 day');
        $startWeek= intval($start->format('W'));
        $endWeek= intval($end->format('W'));
        if($endWeek === 1)
            $endWeek=intval((clone $end)->modify('-7 days')->format('W')) +1;
        $weeks= $endWeek - $startWeek +1;
        if($weeks < 0)
            $weeks = intval($end->format('W'));

        return $weeks;
    }

    /**
     *
     * @param User $user
     * @param $start
     * @param $end
     * @return array of event in a month
     */
    public function getEvent(User $user, $start, $end){
        $repo = $this->doctrine->getRepository(Planning::class);
        $days = [];
        if ($user->getIsInstructor()) {
            $events = $repo->findAllInstructorHourBetween($user->getId(), $start, $end);
        } else {
            $events = $repo->findAllCandidateHourBetween($user->getId(), $start, $end);
        }

        foreach ($events as $event) {
            $date = $event->getIdl()->getStartAt()->format('Y-m-d');
            if (isset($days[$date])) {
                $days[$date][] = $event;
            } else {
                $days[$date][] = $event;
            }


        }

        return $days;
    }

    public function getUserInformation(User $user){
        $repo = $this->doctrine->getRepository(User::class);
        if($user->getIsInstructor()){
            $result = $repo->countCandidateByInstructor($user->getId());
        }
        else{
            $result = $user->getHoursLeft();
        }

        return $result;
    }
}