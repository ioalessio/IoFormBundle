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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Session;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Io\FormBundle\Form\Extension\Type\JqueryDateType;

class DateRangeType extends AbstractType
{
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
      $this->session = $session;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options) {

        $type = $options['date_type'];
//        unset($options['date_type']);


        $opt = $this->defDateOption();
        $opt['format'] = $options['format'];

           $builder
                ->add('start', $type, $opt )
                ->add('end',   $type, $opt )
                   ;


        $builder->setAttribute('widget', $options['widget']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view->set('widget', $form->getAttribute('widget'));
    }


    public function getDefaultOptions(array $options) {

        return array(
            'years'          => range(date('Y') - 5, date('Y') + 5),
            'months'         => range(1, 12),
            'days'           => range(1, 31),
            'widget'         => 'single_text',
            'input'          => 'datetime',
            'format'         => \IntlDateFormatter::MEDIUM,
            'data_timezone'  => null,
            'user_timezone'  => null,
            'empty_value'    => null,
            // Don't modify \DateTime classes by reference, we treat
            // them like immutable value objects
            'by_reference'   => false,
            'error_bubbling' => false,
            'date_type' => 'jquery_date'
        );

    }

    protected function defDateOption()
    {
        return array(
            'years'          => range(date('Y') - 5, date('Y') + 5),
            'months'         => range(1, 12),
            'days'           => range(1, 31),
            'widget'         => 'single_text',
            'input'          => 'datetime',
            'format'         => \IntlDateFormatter::MEDIUM,
            'data_timezone'  => null,
            'user_timezone'  => null,
            'empty_value'    => null,
            // Don't modify \DateTime classes by reference, we treat
            // them like immutable value objects
            'by_reference'   => false,
            'error_bubbling' => false
            );
    }

   /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'date_range';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'form';
    }


}