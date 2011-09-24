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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;


class JqueryRangeType extends IntegerType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jquery_range';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
      parent::buildForm($builder, $options);

       $builder
            ->setAttribute('min', $options['min'])
            ->setAttribute('max', $options['max'])
            ->setAttribute('step', $options['step'])
       ;
    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $view
            ->set('min', $form->getAttribute('min'))
            ->set('max', $form->getAttribute('max'))
            ->set('step', $form->getAttribute('step'))
        ;
    }
    public function getDefaultOptions(array $options)
    {
        return array(
            // default precision is locale specific (usually around 3)
            'precision'     => null,
            'grouping'      => false,
            // Integer cast rounds towards 0, so do the same when displaying fractions
            'rounding_mode' => \NumberFormatter::ROUND_DOWN,
            //Min value
            'min' => 1,
            //max value
            'max' => 100,
            //step value (for jquery slide)
            'step' => 1
        );
    }


}
