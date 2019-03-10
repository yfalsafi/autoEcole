<?php
/**
 * Created by PhpStorm.
 * User: yfalsafi
 * Date: 08/03/2019
 * Time: 15:17
 */
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckDatetime extends Constraint
{
    public $notSameDay = 'The Beginning and the end must be at the same day';
    public $weekend = 'Can\'t Take hours during the Week end';
    public $outOfTime = 'The start doesn\'t respect the  opening hours 7h -> 21h';
    public $hoursInRow = 'Can‘t take more than 2 hours in row';
    public $missingHours = 'You don\'t have enough hours. You have {{hoursLeft}} hours left.';
    public $notExactlyHour = 'You can only reserve exactly 1 or 2 hours ';


}