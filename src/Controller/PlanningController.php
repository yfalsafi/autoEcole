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
    private $months=['Janvier','Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decémbre'];

    private $month;
    private $year;

    /**
     * PlanningController constructor.
     * @param null $month 1-12
     * @param null $year
     * @throws null \Exception
     */
    public function __construct(?int $month = null,?int $year = null)
    {
        if($month === null)
            $month = intval(date('m'));
        if($year === null)
            $year = intval(date('Y'));
        if($month < 1 || $month > 12)
            throw new \Exception("Month $month not valid");

        $this->month=$month;
        $this->year=$year;
    }

    /**
     * Return month in string (ex: Janvier 2019)
     * @return string
     */
    public function toString(): string {
        return $this->months[$this->month -1].' '.$this->year;
    }

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
        if($id && !$idy)
        {
            $month = new PlanningController($id, null);
            $idy=$month->year;
        }
        else if($id && $idy)
            $month = new PlanningController($id, $idy);
        else
        {
            $month = new PlanningController();
            $idy= $month->year;
        }
        $user=$this->getUser();
        $start = $month->getFirstDay();
        $start = $start->format('N') === 1 ? $start : $month->getFirstDay()->modify('last monday');
        $end = (clone $start)->modify('+'.(6 + 7 * ($month->getWeeks() -1)) .'days');
        //$hours = $month->getEventBetween($start,$end,1);
        $repo= $this->getDoctrine()->getRepository(Lesson::class);
        $days=[];
        $events = $repo->findAllBetween($user->getIdUser(),$start,$end);
        dump($events);
        $isToday= date('Y-m-d');
        foreach ($events as $event){
            $date= $event->getStartAt()->format('Y-m-d');
            if(isset($days[$date]))
            {
                $days[$date][]= $event;
            }
            else
            {
                $days[$date][] =$event;
            }

            dump($days);

        }
        return $this->render('planning/index.html.twig', [
            'id' => $id,
            'isToday' => $isToday,
            'idy' => $idy,
            'days' => $days,
            'start' => $start,
            'weeks' => $month->getWeeks(),
            'daysInMonth' => $month->days,
            'month_string' => $month->toString(),

        ]);
    }



}
