<?php

namespace App\Controller;

use App\Entity\Planning;
use App\Service\planningInformation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityRepository;
use App\Entity\Lesson;
use App\Entity\Constant;


class PlanningController extends AbstractController
{

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];


    /**
     * @Route("/planning", name="planning")
     * @Route("/planning/{month}/{year}", name="planningByM")
     */
    public function index($month = null, $year = null, planningInformation $planningInformation)
    {
        $date = new \DateTime();
        if ($month == null) {
            $month = $date->format('m');
        }
        dump($month);
        if ($month && !$year) {
            $test = \DateTime::createFromFormat('m', $month);
            $monthString = $test->format('F');
            $idy = $date->format('Y');
        } else if ($month && $year) {
            $test = \DateTime::createFromFormat('m', $month);
            $monthString = $test->format('F');
        } else {
            $test = \DateTime::createFromFormat('m', date('m'));
            $monthString = $date->format('F');
            $idy = $date->format('Y');
        }
        $start = $planningInformation->getFirstDay($month, $year);
        dump($start, $start->format('N'));
        $start = $start->format('N') === "1" ? $start : $planningInformation->getFirstDay($month, $year)->modify('last monday');
        dump($start);
        $end = (clone $start)->modify('+' . (6 + 7 * ($planningInformation->getWeeks() - 1)) . 'days');
        $days = $planningInformation->getEvent($this->getUser(), $start, $end);
        $result = $planningInformation->getUserInformation($this->getUser());
        return $this->render('planning/index.html.twig', [
            'user' => $this->getUser(),
            'id' => $month,
            'isToday' => date('Y-m-d'),
            'idy' => $year,
            'days' => $days,
            'start' => $start,
            'weeks' => $planningInformation->getWeeks(),
            'daysInMonth' => $this->days,
            'month_string' => $monthString,
            'result' => $result,

        ]);
    }


}
