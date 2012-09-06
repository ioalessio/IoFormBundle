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
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * TODO:
 *  - add a configuration for tinymce source path
 *  - tinymce options are configurable in fields.html.twig file
 */

class JqueryTinymceType extends TextareaType
{
  public $tinymce;

    public function __construct($tinymce, Session $session)
    {
      $this->tinymce = $tinymce;
      $this->session = $session;
    }
    /**
     * {@inheritdoc}
     */
    public function getParent()
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
		parent::setDefaultOptions ($resolver);
        $resolver->setDefaults (array (
			'theme' => isset($this->tinymce['theme']) ? $this->tinymce['theme'] : 'simple',
			'required' => false //disable required option because html5 dind't parse tinymce input
		));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      parent::buildForm($builder, $options);

       $builder
            ->setAttribute('theme', $options['theme'])
       ;
    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view
            ->set('jquery_tinymce_asset', $this->tinymce['source'])
            ->set('theme', $form->getAttribute('theme'))
            ->set('locale', $this->session->getLocale())
        ;
    }
}
