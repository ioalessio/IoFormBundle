<?php

/**
 * TODO
 */

namespace Io\FormBundle\Form\Extension\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilder;

class JqueryRadioType extends ChoiceType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jquery_radio';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
      $options['expanded'] = true;
      $options['multiple'] = false;
      parent::buildForm($builder, $options);
    }
}
