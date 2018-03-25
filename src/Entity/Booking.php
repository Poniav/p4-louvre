<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Infos as CVIAssert;

/**
 * @ORM\Table(name="booking")
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @CVIAssert\TypeTicket(message="Billet 'Journée' seulement possible avant 14h.", groups={"Booking"})
 * @CVIAssert\MaxTicket(message="Le nombre de 1000 billets maximum à été atteint pour aujourd'hui. Veuillez choisir une autre date. ", groups={"Booking"})
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $firstname
     *
     * @ORM\Column(name="co_firstname", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter votre prénom.", groups={"Booking"})
     */
    private $firstname;

    /**
     * @var string $lastname
     *
     * @ORM\Column(name="co_lastname", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter votre nom.", groups={"Booking"})
     */
    private $lastname;

    /**
     * @var string $email
     *
     * @ORM\Column(name="co_email", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter votre adresse email.", groups={"Booking"})
     * @Assert\Email(
     *      message = "'{{ value }}' n'est pas une adresse email valide.",
     *      checkMX = true,
     *      groups={"Booking"}
     * )
     */
    private $email;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="co_date", type="datetime", nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter une date de réservation.", groups={"Booking"})
     * @Assert\DateTime(
     *     message="Veuillez ajouter une date de réservation valide.",
     *     groups={"Booking"}
     * )
     * @CVIAssert\CloseDay(message="Le musée est fermé le Mardi et le Dimanche.", groups={"Booking"})
     * @CVIAssert\DayOff(message="Réservation impossible lors des jours fériés.", groups={"Booking"})
     * @CVIAssert\PastDay(message="Vous ne pouvez pas réserver pour les jours passés.", groups={"Booking"})
     * @CVIAssert\CloseHour(message="Désolé, le musée est fermé après 21h.", groups={"Booking"})
     */
    private $date;

    /**
     * @var boolean $type
     *
     * @ORM\Column(name="co_type", type="boolean", nullable=false)
     */
    private $type;

    /**
     * @var int $number
     * @ORM\Column(name="co_number", type="integer", nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir le nombre de billets.", groups={"Booking"})
     */
    private $number;

    /**
     * @var object $tickets
     * @ORM\OneToMany (targetEntity="Tickets", mappedBy="booking", cascade={"persist"})
     * @Assert\Valid()
     */
    private $tickets;


    /**
     * @var string $code
     * @ORM\Column(name="co_code", type="string", length=50, nullable=false)
     */
    private $code;

    /**
     * @var $total
     *
     * @ORM\Column(name="co_total", type="decimal", precision=2, scale=0)
     */
    private $total;

    /**
     * Booking constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime;
        $this->tickets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDateFormat(string $format)
    {
        return $this->getDate()->format($format);
    }

    /**
     * @param $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isType()
    {
        return ($this->type == 1) ? true : false;
    }

    /**
     * @param bool $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param int $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return ArrayCollection | Tickets[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     *
     */
    public function removeTickets()
    {
        $this->tickets = new ArrayCollection();
    }

    /**
     * @param Tickets $tickets
     */
    public function removeTicket(Tickets $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * @param Tickets $tickets
     */
    public function addTicket(Tickets $tickets)
    {
        $this->tickets[] = $tickets;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param Booking $booking
     */
    public function setTotal(Booking $booking): void
    {
        foreach ($booking->getTickets() as $ticket)
        {
            $total[] = $ticket->getPrice();
        }
        /** @var Booking[] $total */
        $this->total = array_sum($total);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set Random Code Reservation
     */
    public function setCode()
    {
        $alph = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $code = substr(str_shuffle($alph), 0, rand(5,25));
        $this->code = $code;
    }


}
