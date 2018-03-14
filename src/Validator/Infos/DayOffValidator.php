<?php

namespace App\Validator\Infos;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DayOffValidator extends ConstraintValidator
{
    /**
     * Validate If date pick is equal to specific date
     * @param mixed $date
     * @param Constraint $constraint
     */
    public function validate($date, Constraint $constraint)
    {

        /* @var DayOff $constraint  */

        if(in_array($date->format('d/m'), $constraint->dayoff, true))
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }
}
