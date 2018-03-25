<?php

namespace App\Validator\Tickets;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NextDayValidator extends ConstraintValidator
{

    /**
     * @var DateTime
     */
    private $date;

    /**
     * TypeTicketValidator constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime();
    }

    /**
     * If birth date picked is superior of current date
     * @param mixed $birth
     * @param Constraint $constraint
     */
    public function validate($birth, Constraint $constraint)
    {
        /* @var NextDay $constraint  */

        if($birth > $this->date)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }
}
