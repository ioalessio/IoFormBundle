<?php

/**
 * TODO
 */

namespace Io\FormBundle\Form\Extension\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Session;
class JqueryDateType extends DateType
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

        $changemonth = $options['changeMonth'];
        $changeyear = $options['changeYear'];
        $mindate = $options['minDate'];
        $maxdate = $options['maxDate'];

        $builder->setAttribute('changemonth', $changemonth);
        $builder->setAttribute('changeyear', $changeyear);
        $builder->setAttribute('mindate', $mindate);
        $builder->setAttribute('maxdate', $maxdate);

        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options) {
        $options = parent::getDefaultOptions($options);
        //Works only with single text
        $options['widget'] = 'single_text';
        $options['changeMonth'] = 'false';
        $options['changeYear'] = 'false';
        $options['minDate'] = null;
        $options['maxDate'] = null;
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


        $view->set('date_pattern', $pattern);
        $view->set('date_format', $this->convertJqueryDate($pattern));
        $view->set('change_month', $form->getAttribute('changemonth'));
        $view->set('change_year', $form->getAttribute('changeyear'));
        $view->set('min_date', $form->getAttribute('mindate'));
        $view->set('max_date', $form->getAttribute('maxdate'));
        $view->set('locale',  $this->session->getLocale() );
    }

    protected function convertJqueryDate($pattern)
    {
      $format = $pattern;
        //jquery use a different syntax, have to replace
        //  php    jquery
        //  MM      mm
        //  MMM     M
        //  MMMM    MM
        //  y       yy

        if (strpos($format, "MMM") > 0) {
            $format = str_replace("MMM", "M", $format);
        } else {
            $format = str_replace("MM", "mm", $format);
        }
        $format = str_replace("LLL", "M", $format);
        $format = str_replace("y", "yy", $format);

       return $format;
    }

}