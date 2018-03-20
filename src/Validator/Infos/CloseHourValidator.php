<?php

namespace App\Validator\Infos;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CloseHourValidator extends ConstraintValidator
{
    /**
     * @var DateTime
     */
    private $date;

    /**
     * CloseHourValidator constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime();
    }

    /**
     * Validate if date pick is equal to current day and hour is superior to 9pm
     * @param DateTime $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {
        /* @var CloseHour $constraint  */

        if($date->format('d/m/Y') == $this->date->format('d/m/Y'))
        {
            if($date->format('H') >= $constraint::CLOSEHOUR)
            {
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }
    }
}
