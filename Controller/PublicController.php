<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
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

    /**
     * Displays the Sitemap
     */
    public function sitemapAction(Request $request)
    {
        $format = $request->getRequestFormat();

        if (!in_array($format, array('html', 'xml'))) {
            throw $this->createNotFoundException(sprintf('Exception: 404 Page Not Found. Unable to find page with URI: "%s"', $this->getRequest()->getUri()));
        }

        $em = $this->getDoctrine()->getManager();
        $controller = $this;

        $htmlTree = $em->getRepository('ManhattanPublicBundle:Page')
            ->setPublishState($this->container->getParameter('manhattan.constant.publish'))
            ->findPublishedNodesForDisplay(array('decorate' => false));

        $articles = $em->getRepository('ManhattanPublicBundle:Article\Article')->findAllArticles();

        if ($format == 'html') {
            return $this->render('ManhattanPublicBundle:Sitemap:sitemap.html.twig', array(
                'tree'        => $htmlTree,
                'articles'    => $articles,
            ));
        }

        $xml_content = $this->renderView('ManhattanPublicBundle:Sitemap:sitemap.xml.twig', array(
            'tree'        => $htmlTree,
            'articles'    => $articles,
        ));

        $response = new Response($xml_content);
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
