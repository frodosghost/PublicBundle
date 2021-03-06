<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ManhattanPublicExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Configure Mailer
        $container->setParameter('manhattan.emails.from', $config['emails']['from']);
        $container->setParameter('manhattan.analytics.property', $config['analytics']['property']);
        $container->setParameter('manhattan.analytics.domain', $config['analytics']['domain']);

        $this->loadContact($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * Loads Welcome Configuration Variables
     */
    private function loadContact($config, ContainerBuilder $container)
    {
        $container->setParameter('manhattan.emails.contact.to', $config['emails']['contact']['to']);
        $container->setParameter('manhattan.emails.contact.subject', $config['emails']['contact']['subject']);
        $container->setParameter('manhattan.emails.contact.template_html', $config['emails']['contact']['template_html']);
        $container->setParameter('manhattan.emails.contact.template_txt', $config['emails']['contact']['template_txt']);
        $container->setParameter('manhattan.emails.contact.category', $config['emails']['contact']['sendgrid_category']);

        $container->setParameter('manhattan.contact.subjects', $config['emails']['contact']['subjects']);
    }
}
