<?php

namespace App\Validator;

use App\Entity\Booking;
use DateTime;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateCheckerValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * DateCheckerValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->date = new DateTime();
    }

    /**
     * @param mixed $booking
     * @param Constraint $constraint
     */
    public function validate($booking, Constraint $constraint)
    {

        /*
         * If day date pick is equal to Sunday and Tuesday
         */

        if(in_array($booking->getDates('D'),['Sun', 'Tue'], true))
        {
            $this->context->buildViolation('Le musée est fermé le Mardi et le Dimanche.')
                ->atPath('date')
                ->addViolation();
        }

        /*
         * If date pick is equal to specific date
         */

        if(in_array($booking->getDates('d/m'), ['01/05', '01/11', '25/12'], true))
        {
            $this->context->buildViolation('Le musée est fermé le Mardi et le Dimanche.')
                ->atPath('date')
                ->addViolation();
        }

        /*
         * If date pick is inferior of the current date
         */

        if($booking->getDates('d/m/Y') < $this->date->format('d/m/Y'))
        {
            $this->context->buildViolation('Vous ne pouvez pas réserver pour les jours passés.')
                ->atPath('date')
                ->addViolation();
        }

        /*
         * If date pick is equal to current date / if hour is superior to 14 and Type is true
         */

        if($booking->getDates('d/m/Y') == $this->date->format('d/m/Y'))
        {
            if($this->date->format('H') >= '14' && $booking->isType() == true)
            {
                $this->context->buildViolation('Billet "Journée" seulement possible avant 14h.')
                    ->atPath('type')
                    ->addViolation();
            }
        }

        /*
         * if date pick is equal to current day and hour is superior to 9pm
         */

        if($booking->getDates('d/m/Y') == $this->date->format('d/m/Y'))
        {
            if($this->date->format('H') >= '21')
            {
                $this->context->buildViolation('Désolé, le musée est fermé après 21h.')
                    ->atPath('date')
                    ->addViolation();
            }
        }


        /*
         * If date pick is equal to specific date
         */

//          var_dump($booking->getDate());

//          $this->em->getRepository(Booking::class)->findTotalOrder($booking->getDate());
//            $repository = $this->em->getRepository(Booking::class);
//            $order = $repository->find('2');
//            if($order)
//            {
//                exit();
//            }


    }


}
