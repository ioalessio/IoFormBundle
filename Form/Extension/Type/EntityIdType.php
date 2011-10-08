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
use Symfony\Component\Form\FormBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Exception\FormException;

use Io\FormBundle\DataTransformer\OneEntityToIdTransformer;

/**
* Entity identitifer
*
* @author Gregwar <g.passault@gmail.com>
*/
class EntityIdType extends AbstractType
{
    protected $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->prependClientTransformer(new OneEntityToIdTransformer(
            $this->registry->getEntityManager($options['em']),
            $options['class'],
            $options['property'],
            $options['query_builder']
        ));
    }

    public function getDefaultOptions(array $options)
    {
        $defaultOptions = array(
            'em' => null,
            'class' => null,
            'property' => null,
            'query_builder' => null,
            'type' => 'hidden',
            'hidden' => true,
        );

        $options = array_replace($defaultOptions, $options);

        if (null === $options['class']) {
            throw new FormException('You must provide a class option for the entity identifier field');
        }

        return $options;
    }

    public function getParent(array $options)
    {
        return $options['hidden'] ? 'hidden' : 'text';
    }

    public function getName()
    {
        return 'entity_id';
    }
}

