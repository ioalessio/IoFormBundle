<?php

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Render a Jquery autocomplete input to populate a  Select of an entity
 */
class JqueryEntityComboboxType extends EntityType {

    public function getName() {
        return "jquery_entity_autocomplete";
    }

    public function getDefaultOptions(array $options) {
        $options = parent::getDefaultOptions($options);
        $options['source'] = '';
        $options['minlength'] = 0;

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

        parent::buildForm($builder, $options);
    }

}