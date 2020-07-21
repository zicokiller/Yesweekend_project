<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            // Ici j'enverrai le mail
            $message = (new \Swift_Message('Nouveau Contact'))

                // J'attribue l'expéditeur
                ->setFrom($contact['email'])

                // J'attribue le destinatire
                ->setTo('cecilemorhain@gmail.com')

                // Je crée le message avec la vue twig
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        compact('contact')
                    ),
                    'text/html'
                );

            // J'envoi le message
            $mailer->send($message);

            $this->addFlash('success', 'Le message a bien été envoyé, 
            nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
