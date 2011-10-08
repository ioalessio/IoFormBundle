<?php

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Exception\FormException;


/**
 * Render a Jquery autocomplete input to populate a  Select of an entity
 */
class JqueryEntityAutocompleteType extends EntityType {

    public function getName() {
        return "jquery_entity_autocomplete";
    }

    public function getDefaultOptions(array $options) {
        $options = parent::getDefaultOptions($options);
        $options['source'] = '';
        $options['minlength'] = 1;

        //DEFAULT VALUE = NULL
        $options['empty_value'] = "";
        return $options;
    }

    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options) {
        $source = $options['source'];
        $minlength = $options['minlength'];

        $builder->setAttribute('source', $source);
        $builder->setAttribute('minlength', $minlength);

        if ('' == $source) {
            throw new FormException(sprintf('The option "%s" can not be empty and must be a valid route', 'source'));
        }
        
        parent::buildForm($builder, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function buildViewBottomUp(FormView $view, FormInterface $form) {

        $view->set('source', $form->getAttribute('source'));
        $view->set('minlength', $form->getAttribute('minlength'));
    }

}