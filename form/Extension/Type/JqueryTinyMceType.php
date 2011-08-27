<?php

/**
 * TODO:
 *  - add a configuration for tinymce source path
 *  - tinymce options are configurable in fields.html.twig file
 */

namespace Io\FormBundle\Form\Extension\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class JqueryTinymceType extends TextareaType
{
    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'textarea';
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jquery_tinymce';
    }

    public function getDefaultOptions(array $options)
    {
      $options = parent::getDefaultOptions($options);
      //disable required option because html5 dind't parse tinymce input
      $options['required'] = false;
      return $options;
    }

}
