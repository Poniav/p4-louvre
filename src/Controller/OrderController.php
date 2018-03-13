<?php
namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\TicketCollectionType;
use App\Services\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends Controller {

    /**
     * @Route("/", name="app_commande")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function commande(Request $request, OrderManager $orderManager)
    {
//        $this->get('session')->remove('booking');
//        $this->get('session')->remove('billets');
//        $this->get('session')->remove('tickets');
//        $this->get('session')->clear();
//        exit();

        $booking = $orderManager->booking();
        $orderManager->ticketSession($booking);

        var_dump($booking);

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $orderManager->setSession($booking);

            return $this->redirectToRoute('app_billet');
        }
        return $this->render('pages/booking.html.twig', [
            'booking' => $form->createView(),
        ]);
    }

    /**
     * @Route("/billet", name="app_billet")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function billet(Request $request, OrderManager $orderManager)
    {
        $booking = $orderManager->tickets();

        $form = $this->createForm(TicketCollectionType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $orderManager->setPriceTickets($booking);

            foreach($booking->getTickets() as $tickets){
                var_dump($tickets);
            }

            $orderManager->setSession($booking);

//            return $this->redirectToRoute('app_paiement');
        }

        return $this->render('pages/tickets.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/paiement", name="app_paiement")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paiement(Request $request, OrderManager $orderManager)
    {
        $booking = $orderManager->booking();
        var_dump($booking);

//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($booking);
//        $entityManager->flush();

        return $this->render('pages/checkout.html.twig');
    }
}