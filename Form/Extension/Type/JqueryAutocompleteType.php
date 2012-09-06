<?php

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JqueryAutocompleteType extends AbstractType
{

    public function __construct(Session $session, Router $router)
    {
      $this->session = $session;
      $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('url', $options['url']);
        $builder->setAttribute('url_params', $options['url_params']);
        $builder->setAttribute('callback', $options['callback']);
        $builder->setAttribute('select_callback', $options['select_callback']);

        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
		parent::setDefaultOptions ($resolver);
        $resolver->setDefaults (array (
			'url' => false,
			'url_params' => array(),
			'callback' => false,
			'select_callback' => false,
			'empty_value' => ''
		));
    }

    public function getParent()
    {
        return "text";
    }

    public function getName()
    {
        return 'jquery_autocomplete';
    }

    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        parent::buildViewBottomUp($view, $form);

        $params = $form->getAttribute('url_params');

        $view->set('url', $this->router->generate($form->getAttribute('url'), $params) );
        $view->set('callback', $form->getAttribute('callback'));
        $view->set('select_callback', $form->getAttribute('select_callback'));
    }
}