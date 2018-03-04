<?php
namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller {

    /**
     * @Route("/contact", name="app_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.mailer')->contactSend($form->getData());

            $this->addFlash('success', 'Votre message a bien été envoyé. Vous recevrez une réponse sous un délai de 24 heures.');

            return $this->redirectToRoute('app_confirmation');
        }
        return $this->render('pages/contact.html.twig', [
            'contact' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmation", name="app_confirmation")
     * @param Session $session
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmation(Session $session)
    {
        if($session->getFlashBag()->has('success') == null)
        {
//            return $this->redirectToRoute('app_contact');
              throw new NotFoundHttpException('La page est inexistante');
        }

        return $this->render('pages/confirmation.html.twig');
    }
}