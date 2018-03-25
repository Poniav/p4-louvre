<?php

namespace App\Services;

use App\Entity\Tickets;
use App\Entity\Booking;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OrderManager {

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var FlashBagInterface
     */
    private $flashbag;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UrlGeneratorInterface
     */
    private $route;

    /**
     * @var string $stripekey
     */
    private $stripekey;

    /**
     * OrderManager constructor.
     * @param SessionInterface $session
     * @param FlashBagInterface $flashBag
     * @param UrlGeneratorInterface $route
     * @param EntityManagerInterface $em
     * @param $stripekey
     */
    public function __construct(SessionInterface $session, FlashBagInterface $flashBag, UrlGeneratorInterface $route, EntityManagerInterface $em, $stripekey)
    {
        $this->session = $session;
        $this->stripekey = $stripekey;
        $this->flashbag = $flashBag;
        $this->em = $em;
        $this->route = $route;
    }

    /**
     * Init Booking with new instance or get the current booking from session
     * @return Booking
     */
    public function initBooking() : Booking
    {

        $booking = new Booking();

        if($this->session->get('booking'))
        {
            $booking = $this->session->get('booking');
            $booking->removeTickets();
        }

        return $booking;

    }

    /**
     * Init Tickets with new instance of number tickets
     * @param Booking $booking
     * @return Booking
     */
    public function initTickets(Booking $booking)
    {

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
             if(!$booking->isType())
             {
                 $price = $this->getPriceRange($ticket->getAge($booking->getDate())) / 2;

                 if($ticket->isDiscount())
                 {
                     $price = $ticket::HALFDAY;
                 }

             }

             if($booking->isType())
             {
                 $price = $this->getPriceRange($ticket->getAge($booking->getDate()));

                 if($ticket->isDiscount())
                 {
                     $price = $ticket::FULLDAY;
                 }
             }

             /** @var int $price */
             $ticket->setPrice($price);
             $ticket->setBooking($booking);
         }
         $booking->setCode();
         $booking->setTotal($booking);
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
     * @param $token
     * @return boolean
     */
    public function payment(Booking $booking, $token) : bool
    {
        Stripe::setApiKey($this->stripekey);

        try {
            Charge::create(array(
                "amount" => $booking->getTotal() * 100,
                "currency" => "eur",
                "source" => $token,
                "description" => "Musée du Louvre - Réservation"
            ));
            return true;
        } catch (\Stripe\Error\Card $e) {
            $this->flashbag->add('error', 'Votre carte a été refusée.');
            return false;
        } catch (\Stripe\Error\RateLimit $e) {
            $this->flashbag->add('error', 'Le serveur de gestion de paiement est saturé. Veuillez réessayer dans quelques instants.');
            return false;
        } catch (\Stripe\Error\InvalidRequest $e) {
            $this->flashbag->add('error', 'Erreur dans la transmission des informations au serveur de paiement.');
            return false;
        } catch (\Stripe\Error\Authentication $e) {
            $this->flashbag->add('error', 'Authentification avec le serveur de paiement impossible.');
            return false;
        } catch (\Stripe\Error\ApiConnection $e) {
            $this->flashbag->add('error', 'Communication avec le serveur de paiement Stripe impossible.');
            return false;
        } catch (\Stripe\Error\Base $e) {
            $body = $e->getJsonBody();
            $err  = $body['error'];
            $this->flashbag->add('error', $err['message']);
            return false;
        } catch (Exception $e) {
            $this->flashbag->add('error', 'Une erreur est survenue dans le traitement de votre paiement.');
            return false;
        }
    }

    /**
     * @param Booking $booking
     * @param MailerManager $mailerManager
     * @return bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function receipt(Booking $booking, MailerManager $mailerManager)
    {
        try {
            $this->em->persist($booking);
            $this->em->flush();
            $mailerManager->receiptSend($booking);
            return true;
        } catch (DBALException $e)
        {
            $this->flashbag->add('error', 'Une erreur est survenue dans le traitement des informations.');
        }

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
        if(!$booking)
        {
            throw new NotFoundHttpException('Désolé mais vous n\'êtes pas autorisé à accéder à cette page');
        }

    }

    /**
     * @param string $id
     * @return mixed
     */
    public function confirmIdBySession(string $id)
    {
        $bookingId = $this->session->get('id');

        if($bookingId != $id)
        {
            throw new NotFoundHttpException('La page de confirmation n\'est pas accessible pour cette commande.');
        }

        return $bookingId;

    }

    /**
     * @param string $id
     * @return Booking|null|object
     */
    public function findBookingById(string $id)
    {

        $booking = $this->em->getRepository(Booking::class)->find($id);

        if(!$booking)
        {
            throw new NotFoundHttpException('La page de confirmation n\'est pas accessible pour cette commande.');
        }

        $this->session->clear();

        return $booking;
    }



}