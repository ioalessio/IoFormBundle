<?php

/**
 * TODO
 */

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class JqueryDateType extends DateType
{

    public function getDefaultOptions(array $options)
    {
      $options = parent::getDefaultOptions($options);
      //Works only with single text
      $options['widget'] = 'single_text';

      return $options;
    }

   /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'jquery_date';
    }

    /**
     * {@inheritdoc}
     */
    public function buildViewBottomUp(FormView $view, FormInterface $form)
    {
        $view->set('widget', $form->getAttribute('widget'));
        $pattern = $form->getAttribute('formatter')->getPattern();
        $format = $pattern;
        if ($view->hasChildren()) {

        // set right order with respect to locale (e.g.: de_DE=dd.MM.yy; en_US=M/d/yy)
            // lookup various formats at http://userguide.icu-project.org/formatparse/datetime
            if (preg_match('/^([yMd]+).+([yMd]+).+([yMd]+)$/', $pattern)) {
                $pattern = preg_replace(array('/y+/', '/M+/', '/d+/'), array('{{ year }}', '{{ month }}', '{{ day }}'), $pattern);
            } else {
                // default fallback
                $pattern = '{{ year }}-{{ month }}-{{ day }}';
            }
        }

        //jquery use a different syntax, have to replace
        $format = str_replace("LLL", "M", $format);
        $format = str_replace("y", "yy", $format);


        $view->set('date_pattern', $pattern);
        $view->set('date_format', $format);
    }

}
