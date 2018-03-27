<?php

namespace App\Validator\Infos;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PastDayValidator extends ConstraintValidator
{

    /**
     * @var DateTime
     */
    private $date;

    /**
     * PastDayValidator constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime();
    }

    /**
     * If date pick is inferior of the current date
     * @param mixed $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {

        /* @var PastDay $constraint  */

        if($date < $this->date)
        {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}
