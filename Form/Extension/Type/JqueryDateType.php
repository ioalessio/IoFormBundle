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

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Session;

class JqueryDateType extends DateType
{
    // only items in $valid_jquery_options will be added to the datepicker() call naturally
    // prepend extra options with "jqd." to add extra options
    // Example:
    //     ... assuming changeMonth was not a standard option ...
    //     $builder->addadd('dob', 'jquery_date', array('format' => 'dd/MM/y','jqd.changeMonth' => 'true')
    //          this wil strip off the 'jqd.' and add to $valid_jquery_options

    protected $valid_jquery_options = array(
        'changeMonth', 'changeYear', 'minDate', 'maxDate', 'showOn', 'yearRange'
    );

    protected $default_jquery_options = array(
        'changeMonth'       => 'false',
        'changeYear'        => 'false',
        'showOn'            => 'focus',
    );

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

        foreach ($options as $okey => $ovalue)
        {
            // if the option starts with "jqd." add it to the valid list and set an attribute
            if ( strlen($okey) >=4 && substr($okey, 0, 4) == 'jqd.' )
            {
                $this->valid_jquery_options[] = $okey;
                $builder->setAttribute($okey, $ovalue);
            }

            // if the option is in the valid list, add/set an attribute
            if (array_search($okey, $this->valid_jquery_options))
            {
                $builder->setAttribute($okey, $ovalue);
            }
        }

        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options) {
        $originaloptions = $options;
        $options = parent::getDefaultOptions($options);
        //Works only with single text
        $options['widget'] = 'single_text';

        // loop through our defined defaults and set them
        foreach ($this->default_jquery_options as $dkey=>$dvalue)
        {
            $options[$dkey] = $dvalue;
        }

        // set a default for any passed options that do not have defaults - prevents kaboom for on-the-fly options
        foreach ($originaloptions as $key=>$value)
        {
            if (!isset($options[$key]))
            {
                $options[$key] = null;
            }
        }

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
        $view->set('dateFormat', $this->convertJqueryDate($pattern));

        // initialize an empty array for jqdate options (except dateFormat -- that's handled above)
        $jqdate_options = array();

        foreach ( $this->valid_jquery_options as $okey )
        {
            if ($form->hasAttribute( $okey ))
            {
                // if the option starts with "jqd." strip it off and just use the rest
                if ( strlen($okey) >= 4 && substr($okey, 0, 4) == 'jqd.' )
                {
                    $jqdate_options[substr($okey,4)] = $form->getAttribute($okey);
                }
                else
                {
                    $jqdate_options[$okey] = $form->getAttribute( $okey );
                }

            }

        }

        // add our options array to the view.  we'll loop through this and add all of it to the datepicker() call
        $view->set('jqdate_options', $jqdate_options);

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