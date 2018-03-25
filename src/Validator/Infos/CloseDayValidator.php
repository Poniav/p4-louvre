<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CloseDayValidator extends ConstraintValidator
{
    /**
     * If day date pick is equal to Sunday and Tuesday
     * @param mixed $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {
        /* @var CloseDay $constraint  */

        if(in_array($date->format('D'),['Sun', 'Tue'], true))
        {
            $this->context->buildViolation($constraint->message)
                          ->addViolation();
        }
    }
}
