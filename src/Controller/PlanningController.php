<?php

namespace App\Controller;

use App\Entity\Planning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityRepository;
use App\Entity\Lesson;


class PlanningController extends AbstractController
{

    public $days= ['Lundi', 'Mardi','Mercredi', 'Jeudi','Vendredi', 'Samedi', 'Dimanche'];

    private $month;
    private $year;


    /**
     * Return First Day
     * @return \DateTime
     */
    public function getFirstDay(): \DateTime{
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * return weeks in month
     * @return int
     */
    public function getWeeks(): int {
        $date=new \DateTime();
        if($this->month== null){
            $this->month= $date->format('m');
        }
        $start = $this->getFirstDay();
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
     * Return all the hours take between this time
     * @param \DateTime $start
     * @param \DateTime $end
     * @return array
     */
    public function getEventBetween(\DateTime $start, \DateTime $end):array{

        return [];

    }

    /**
     * @Route("/planning", name="planning")
     * @Route("/planning/{id}/{idy}", name="planningByM")
     */
    public function index($id =null,$idy = null)
    {
        $date=new \DateTime();
        if($this->month== null){
            $this->month= $date->format('m');
        }
        if($id && !$idy)
        {
            $test= \DateTime::createFromFormat('m',$id);
            $month = $test->format('F');
            $idy=$date->format('Y');
        }
        else if($id && $idy){
            $test= \DateTime::createFromFormat('m',$id);
            $month=\DateTime::createFromFormat('m',$id.'-'.$idy);
        }
        else
        {
            $test= \DateTime::createFromFormat('m',date('m'));
            $month = $date->format('F');
            $idy= $date->format('Y');
        }
        $this->year=$idy;
        $month_int = $test->format('m');
        $user=$this->getUser();
        $start = $this->getFirstDay();
        $start = $start->format('N') === 1 ? $start : $this->getFirstDay()->modify('last monday');
        $end = (clone $start)->modify('+'.(6 + 7 * ($this->getWeeks() -1)) .'days');
        //$hours = $month->getEventBetween($start,$end,1);
        $repo= $this->getDoctrine()->getRepository(Planning::class);
        $days=[];
        if($this->getUser()->getIsInstructor())
        {
            $events = $repo->findAllInstructorHourBetween($user->getId(),$start,$end);
        }else
        {
            $events = $repo->findAllCandidateHourBetween($user->getId(),$start,$end);
        }


        $isToday= date('Y-m-d');
        dump($days);
        foreach ($events as $event){
            $date= $event->getIdl()->getStartAt()->format('Y-m-d');
            if(isset($days[$date]))
            {
                $days[$date][]= $event;
            }
            else
            {
                $days[$date][] =$event;
            }



        }
        dump($days);
        return $this->render('planning/index.html.twig', [
            'id' => $id,
            'isToday' => $isToday,
            'idy' => $idy,
            'days' => $days,
            'start' => $start,
            'weeks' => $this->getWeeks(),
            'daysInMonth' => $this->days,
            'month_string' => $month,

        ]);
    }



}
