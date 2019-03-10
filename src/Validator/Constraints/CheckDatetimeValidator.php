<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 15:19
 */
namespace App\Validator\Constraints;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Entity\Constant;

class CheckDatetimeValidator extends ConstraintValidator
{

    private $user;

    public function __construct(Security $token)
    {
        $this->user = $token->getUser();
    }

    public function validate($start, Constraint $constraint)
    {

        $end = $this->context->getRoot()->get('endAt')->getData();

        $startDay = $start->format('Y-m-d');
        $endDay = $end->format('Y-m-d');

        $startTime = $start->format('H:i');
        $endTime = $end->format('H:i');

        $hoursLeft = $this->user->getHoursLeft();

        if (null === $start || '' === $start) {
            return;
        }

        if ($startDay != $endDay) {
            $this->context->buildViolation($constraint->notSameDay)
                ->addViolation();
        }

        if ($start->format('N') == Constant::DAY_OFF || $start->format('N') == Constant::SECOND_DAY_OFF) {
            $this->context->buildViolation($constraint->weekend)
                ->addViolation();
        }

        if (strtotime($startTime) < strtotime(Constant::OPENING_HOUR) || strtotime($startTime) > strtotime(Constant::CLOSING_HOUR))
        {
            $this->context->buildViolation($constraint->outOfTime)
                ->addViolation();
        }

        if (strtotime($endTime) > strtotime(Constant::CLOSING_HOUR))
        {
            $this->context->buildViolation($constraint->outOfTime)
                ->addViolation();
        }

        if (strtotime(date("H:i", strtotime($startTime) + strtotime(Constant::LIMIT))) < strtotime($endTime))
        {
            $this->context->buildViolation($constraint->hoursInRow)
                ->addViolation();
        }

        if ($hoursLeft - date('H', strtotime($endTime) - strtotime($startTime)) < 0 || $hoursLeft == null)
        {
            $this->context->buildViolation($constraint->missingHours)
                ->setParameter('hoursLeft', $hoursLeft)
                ->addViolation();
        }
        $startTime = $start->format('i');
        $endTime = $end->format('i');
        if ($endTime != $startTime || $startTime != 0 && $startTime != 30)
        {
            $this->context->buildViolation($constraint->notExactlyHour)
                ->addViolation();
        }

    }
}