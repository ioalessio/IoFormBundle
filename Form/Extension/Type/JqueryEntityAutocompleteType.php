<?php

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Bridge\Doctrine\RegistryInterface;

class JqueryEntityAutocompleteType extends EntityIdType
{

    public function __construct(RegistryInterface $registry, Session $session, Router $router)
    {
      $this->registry = $registry;
      $this->session = $session;
      $this->router = $router;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->setAttribute('url', $options['url']);
        $builder->setAttribute('url_params', $options['url_params']);
        $builder->setAttribute('callback', $options['callback']);
        $builder->setAttribute('property', $options['property']);

        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['multiple'] = false;
        $options['url'] = false;
        $options['url_params'] = array();
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

        $params = $form->getAttribute('url_params');
        $params['search'] = '$$term$$';
        $view->set('url', $this->router->generate($form->getAttribute('url'), $params) );
        $view->set('callback', $form->getAttribute('callback'));
        $view->set('property', $form->getAttribute('property'));
    }
}