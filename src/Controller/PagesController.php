<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController {

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

}