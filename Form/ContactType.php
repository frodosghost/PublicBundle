<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label' => 'Name',
                'attr' => array(
                    'class' => 'text'
                )
            ))
            ->add('company', 'text', array(
                'required' => true,
                'label' => 'Company',
                'attr' => array(
                    'class' => 'text'
                )
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'Email',
                'attr' => array(
                    'class' => 'text'
                )
            ))
            ->add('phone', 'telephone', array(
                'required' => true,
                'label' => 'Phone',
                'attr' => array(
                    'class' => 'text'
                )
            ))
            ->add('subject', 'subject', array(
                'attr' => array(
                    'class' => 'custom radio'
                ),
                'expanded' => true,
                'required' => true,
                'label' => 'Subject'
            ))
            ->add('message', 'textarea', array(
                'required' => true,
                'label' => 'Message',
                'attr' => array(
                    'class' => 'input-text'
                )
            ))
            ->add('knowledge', 'text', array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'input-text'
                )
            ))
            ->add('happens', 'datetime', array(
                'required' => true,
                'read_only' => true,
                'label' => false,
                'widget' => 'single_text'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Manhattan\PublicBundle\Entity\Contact',
            'error_mapping' => array(
                'contactValid' => 'email'
            ),
        ));
    }

    public function getName()
    {
        return 'contact';
    }
}
