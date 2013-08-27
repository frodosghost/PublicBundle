<?php

namespace Manhattan\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Manhattan\PublicBundle\Entity\Contact;
use Manhattan\PublicBundle\Form\ContactType;

class PublicController extends Controller
{
    public function homeAction()
    {
        return $this->render('ManhattanPublicBundle:Public:home.html.twig');
    }

    /**
     * Contact Us Page
     *
     * @param  Request $request
     * @return Response
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact;

        $form = $this->createForm(new ContactType(), $contact, array(
            'render_fieldset' => false
        ));

        return $this->render('ManhattanPublicBundle:Contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function contactSendAction(Request $request)
    {
        $contact = new Contact;

        $form = $this->createForm(new ContactType(), $contact, array(
            'render_fieldset' => false
        ));

        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();

            // Check the Honeypot field is not set.
            if ($data->isHuman()) {
                $this->get('manhattan.mailer')->sendContactEmail($data);

                $this->get('session')->getFlashBag()->add('notice', 'Your contact email has been sent.');
                return $this->redirect($this->generateUrl('contact_success'));
            }
        }

        return $this->render('ManhattanPublicBundle:Contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Displays Success Page
     *
     * @return Response
     */
    public function contactSuccessAction()
    {
        if (!$this->get('session')->getFlashBag()->has('notice')) {
            return $this->redirect($this->generateUrl('contact'));
        }

        return $this->render('ManhattanPublicBundle:Contact:success.html.twig');
    }
}
