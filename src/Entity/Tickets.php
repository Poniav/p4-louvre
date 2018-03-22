<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Tickets as CVTAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketsRepository")
 */
class Tickets
{

    /**
     * @const int
     */
    public const FULLDAY = 10;

    /**
     * @const int
     */
    public const HALFDAY = 5;

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
     * @Assert\NotBlank(message="Veuillez ajouter votre prénom.")
     */
    private $firstname;


    /**
     * @var string $lastname
     *
     * @ORM\Column(name="co_lastname", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter votre nom.")
     */
    private $lastname;


    /**
     * @var Booking $booking
     *
     * @ORM\ManyToOne(targetEntity="Booking", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking;

    /**
     * @var boolean $discount
     *
     * @ORM\Column(name="co_discount", type="boolean", nullable=false)
     */
    private $discount;

    /**
     * @var \DateTime $birth
     *
     * @ORM\Column(name="co_birth", type="datetime", nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter une date de naissance.")
     * @Assert\DateTime(
     *     message="Veuillez ajouter la date de naissance du visiteur."
     * )
     * @CVTAssert\NextDay(message="Vous ne pouvez choisir qu'une date pour les jours passés.")
     */
    private $birth;


    /**
     * @var string $country
     *
     * @ORM\Column(name="co_country", type="string", nullable=false)
     * @Assert\NotBlank(message="Veuillez ajouter votre pays.")
     * @Assert\Country(message="Ce n'est pas un code pays valide.")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="co_price", type="decimal", precision=2, scale=0)
     */
    private $price;

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
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * @param Booking $booking
     */
    public function setBooking(Booking $booking = null): void
    {
        $this->booking = $booking;
    }

    /**
     * @return bool
     */
    public function isDiscount()
    {
        return $this->discount;
    }

    /**
     * @param bool $discount
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return \DateTime
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * @param \DateTime $birth
     */
    public function setBirth($birth): void
    {
        $this->birth = $birth;
    }

    /**
     * @param \DateTime $date
     * @return int
     */
    public function getAge(\DateTime $date)
    {
        return date_diff($this->getBirth(), $date)->y;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }


}
