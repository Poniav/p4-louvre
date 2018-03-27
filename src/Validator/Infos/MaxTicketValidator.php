<?php

namespace App\Validator\Infos;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MaxTicketValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * MaxTicketValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * If date pick is equal to specific date
     * @param Booking $booking
     * @param Constraint $constraint
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($booking, Constraint $constraint)
    {

        /* @var MaxTicket $constraint  */
        $result = $this->getTotalTickets($booking->getDate());

        if($result + $booking->getNumber() >= $constraint::MAXTICKET)
        {
                $this->context->buildViolation($constraint->message)
                    ->atPath('number')
                    ->addViolation();
        }
    }

    /**
     * @param \DateTime $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function getTotalTickets(\DateTime $date)
    {
        /* @var EntityManagerInterface | Booking */
        $result = $this->em->getRepository(Booking::class)->findNumberOfTicketsByDate($date);
        return $result;
    }

}
