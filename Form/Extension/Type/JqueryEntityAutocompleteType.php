<?php

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class JqueryEntityAutocompleteType extends EntityIdType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('url', $options['url']);
        $builder->setAttribute('callback', $options['callback']);
        $builder->setAttribute('property', $options['property']);

        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['multiple'] = false;
        // jQuery will pass a single "term" variable. This url should include '$$term$$' that will be replaced while querying
        $options['url'] = false;
        $options['callback'] = false;

        //DEFAULT VALUE = NULL
        $options['empty_value'] = "";
        return $options;
    }

    public function getName()
    {
        return 'jquery_entity_autocomplete';
    }

    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        parent::buildViewBottomUp($view, $form);
        $view->set('url', $form->getAttribute('url'));
        $view->set('callback', $form->getAttribute('callback'));
        $view->set('property', $form->getAttribute('property'));
    }
}