<?php

/*
 * This file is part of the IoFormBundle package
 *
 * (c) Alessio Baglio <io.alessio@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Io\FormBundle\Form\Extension\Type;
use Symfony\Component\Form\AbstractType;

class JqueryEntityRemoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jquery_entity_remote';
    }
}
