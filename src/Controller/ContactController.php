<?php
namespace App\Controller;

use App\Form\ContactType;
use App\Services\MailerManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends Controller {

    /**
     * @Route("/contact", name="app_contact")
     * @param Request $request
     * @param MailerManager $mailerManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contact(Request $request, MailerManager $mailerManager)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mailerManager->contactSend($form->getData());

            $this->addFlash('success', 'Votre message a bien été envoyé. Vous recevrez une réponse sous un délai de 24 heures.');

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
              throw new NotFoundHttpException('La page est inexistante');
        }

        return $this->render('pages/confirmation.html.twig');
    }
}