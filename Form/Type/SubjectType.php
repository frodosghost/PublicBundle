<?php

/*
 * This file is part of the Manhattan Public Bundle
 *
 * (c) James Rickard <james@frodosghost.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Manhattan\PublicBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubjectType extends AbstractType
{
    private $subjects;

    /**
     * Constructor
     *
     * @param array $subjects Array of subjects to be included with type
     */
    public function __construct(array $subjects)
    {
        $this->subjects = $subjects;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->subjects
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'subject';
    }
}
