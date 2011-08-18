<?php

/**
 * Render a Jquery Combobox Select of an entity
 */

namespace Io\FormBundle\Form\Extension\Type;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class JqueryEntityComboboxType extends EntityType
{
  public function getName()
  {
    return "jquery_entity_combobox";
  }

  public function getDefaultOptions(array $options)
  {
    $options = parent::getDefaultOptions($options);
    $options['multiple'] = false;

    //DEFAULT VALUE = NULL
    $options['empty_value'] = "";
    return $options;
  }
}
