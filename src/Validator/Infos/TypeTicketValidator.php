<?php

namespace App\Validator\Infos;

use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TypeTicketValidator extends ConstraintValidator
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
     * If date pick is equal to current date / if hour is superior to 14 and Type is true
     * @param mixed $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {
        /* @var TypeTicket $constraint  */

        if($booking->getDateFormat('d/m/Y') == $this->date->format('d/m/Y'))
        {
            if($this->date->format('H') >= $constraint::LIMITHOUR && $booking->isType())
            {
                $this->context->buildViolation($constraint->message)
                    ->atPath('type')
                    ->addViolation();
            }
        }

    }
}
