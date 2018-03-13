<?php

namespace App\Services;

use App\Entity\Tickets;
use App\Entity\Booking;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderManager {

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var integer
     */
    private $price;

    /**
     * OrderManager constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Init Booking with new instance or get the current booking from session
     * @return Booking
     */
    public function booking() : Booking
    {

        $booking = new Booking();

        if($this->session->get('booking'))
        {
            $booking = $this->session->get('booking');
        }

        return $booking;

    }

    /**
     * @param Booking $booking
     */
    public function ticketSession(Booking $booking)
    {
        if($booking->getTickets() !== null)
        {
            foreach ($booking->getTickets() as $ticket)
            {
                $booking->removeTicket($ticket);
            }
        }
    }

    /**
     * Init Tickets with new instance of number tickets
     */
    public function tickets()
    {
        $booking = $this->getSession('booking');

        if(count($booking->getTickets()) == 0)
        {
            for ($i = 0; $i < $booking->getNumber(); $i++)
            {
                $booking->addTicket(new Tickets());
            }
        }

        return $booking;
    }

    /**
     * @param Booking $booking
     */
    public function setPriceTickets(Booking $booking)
    {

         foreach ($booking->getTickets() as $ticket)
         {
            // half day
             if($booking->isType() == false)
             {
                 $this->price = $this->getPriceRange($ticket->getAge()) / 2;

                 if($ticket->getAge() > 17 && $ticket->isDiscount() == true)
                 {
                     $this->price = 5;
                 }

             }

             if($booking->isType() == true)
             {
                 $this->price = $this->getPriceRange($ticket->getAge());

                 if($ticket->getAge() > 17 && $ticket->isDiscount() == true)
                 {
                     $this->price = 10;
                 }
             }

           $ticket->setPrice($this->price);
//             $ticket->setBooking($booking);
         }

         $booking->setTotal(25.25);
    }

    /**
     * @param $ticket
     * @return int
     */
    public function getPriceRange(int $ticket) : int
    {
        switch ($ticket) {
            case $ticket > 0 && $ticket <= 4 :
                $price = 0;
                break;
            case $ticket > 4 && $ticket <= 12:
                $price = 8;
                break;
            case $ticket >= 60:
                $price = 12;
                break;
            default:
                $price = 16;
                break;
        }

        return $price;
    }

    /**
     * @param Booking $booking
     * @return mixed
     */
    public function setSession(Booking $booking)
    {
        return $this->session->set('booking', $booking);
    }

    /**
     * @param string $session
     * @return mixed
     */
    public function getSession(string $session)
    {
        return $this->session->get($session);
    }

    /**
     * @param $booking
     */
    public function bookingNotFound($booking)
    {
        if($booking == null)
        {
            throw new NotFoundHttpException('Désolé mais vous n\'êtes pas autorisé à accéder à cette page');
        }
    }



}