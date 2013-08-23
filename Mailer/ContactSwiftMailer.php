<?php

namespace Manhattan\PublicBundle\Mailer;

/**
 * ContactSwiftMailer
 *
 * Provides email functionality
 */
class ContactSwiftMailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, array $parameters)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->parameters = $parameters;
    }

    /**
     * Sends am email
     *
     * @param array $parameters
     * @param mixed $data       Data that is used within the email body
     */
    private function sendSystemMessage($parameters, $data)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($parameters['subject'])
            ->setFrom($parameters['from'])
            ->setTo($parameters['to'])
            ->setBody($this->twig->render($parameters['txt_template'], array('data' => $data)), 'text/plain');
        ;
        $message->getHeaders()->addTextHeader('X-SMTPAPI', '{"to": ["Contact <'. $parameters['to'] .'>"], "category": "'. $parameters['category'] .'"}');

        $this->mailer->send($message);
    }

    /**
     * Shortcut method for sending a contact email
     *
     * @param  array   $data
     * @return integer
     */
    public function sendContactEmail($data)
    {
        $parameters = $this->parameters['emails']['contact'];
        $parameters['from'] = $this->parameters['emails']['from'];

        return $this->sendSystemMessage($parameters, $data);
    }

}
