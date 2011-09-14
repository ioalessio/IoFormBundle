<?php

/**
 * TODO:
 *  - add a configuration for tinymce source path
 *  - tinymce options are configurable in fields.html.twig file
 */

namespace Io\FormBundle\Form\Extension\Type;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class JqueryTinymceType extends TextareaType
{
  public $tinymce;

    public function __construct($tinymce)
    {
      $this->tinymce = $tinymce;
    }
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
      $options['theme'] = isset($this->tinymce['theme']) ? $this->tinymce['theme'] : 'simple';
      //disable required option because html5 dind't parse tinymce input
      $options['required'] = false;
      return $options;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
      parent::buildForm($builder, $options);

       $builder
            ->setAttribute('theme', $options['theme'])
       ;
    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view
            ->set('jquery_tinymce_asset', $this->tinymce['source'])
            ->set('theme', $form->getAttribute('theme'))
        ;
    }
}
