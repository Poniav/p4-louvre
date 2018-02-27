<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController {

    /**
     * @Route("/cgv", name="app_cgv")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgv(){
        return $this->render('pages/cgv.html.twig');
    }

    /**
     * @Route("/cgu", name="app_cgu")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cgu(){
        return $this->render('pages/cgu.html.twig');
    }

    /**
     * @Route("/", name="app_booking")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function booking(){
        return $this->render('pages/booking.html.twig');
    }

    /**
     * @Route("/tickets", name="app_tickets")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tickets(){
        return $this->render('pages/tickets.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(){
        return $this->render('pages/contact.html.twig');
    }

}