<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\Twig;

use Symfony\Component\Form\FormFactory;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Twig Extension for displaying shared content
 *
 * @author James Rickard <james@frodosghost.com>
 */
class PublicTwigExtension extends \Twig_Extension
{
    /**
     * @var Twig_Environment
     */
    private $environment;

    /**
     * @var Twig_Template
     */
    private $twigTemplate;

    /**
     * @var Symfony\Bridge\Doctrine\RegistryInterface
     */
    private $doctrine;

    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $analyticsProperty = null;

    /**
     * @param \Twig_Environment $environment
     * @param RegistryInterface $doctrine
     * @param string            $template
     */
    public function __construct(\Twig_Environment $environment, RegistryInterface $doctrine, $template)
    {
        $this->environment = $environment;
        $this->doctrine    = $doctrine;
        $this->template    = $template;
    }

    public function getFunctions()
    {
        return array(
            'analytics'   => new \Twig_Function_Method($this, 'analytics', array('is_safe' => array('html'))),
            'file_exists' => new \Twig_Function_Function('file_exists')
        );
    }

    /**
     * Builds and returns Twig Template
     */
    public function getTemplate()
    {
        if (!$this->twigTemplate instanceof \Twig_Template) {
            $this->twigTemplate = $this->environment->loadTemplate($this->template);
        }

        return $this->twigTemplate;
    }

    /**
     * Renders analytics javascript
     *
     * @param  array $options
     * @return string
     */
    public function analytics(array $options = array())
    {
        $html = $this->getTemplate()->renderBlock('analytics', array(
            'property' => $this->getAnalyticsProperty(),
            'options'  => $options
        ));

        return $html;
    }

    /**
     * Sets analytics property to be rendered in view
     *
     * @param String $property
     */
    public function setAnalyticsProperty($property)
    {
        $this->analyticsProperty = $property;
    }

    /**
     * @return String
     */
    public function getAnalyticsProperty()
    {
        return $this->analyticsProperty;
    }

    /**
     * @return RegistryInterface
     */
    public function getDoctrine()
    {
        return $this->doctrine;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'manhattan_public_twig';
    }
}
