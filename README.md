A set of Form Types for symfony2 framework using JQuery

How to Install
==============
  1. Add this bundle to your vendor/ dir
    * Vendor Mode
      Add the following lines in your deps file::

        [IoFormBundle]
        git=git://github.com/ioalessio/IoFormBundle.git
        target=/bundles/Io/FormBundle


      Run the vendor script:

        ./bin/vendors install

    * Submodule Mode
       $ git submodule add git://github.com/ioalessio/IoFormBundle.git vendor/bundles/Io/FormBundle



  2. Add the "Io" namespace to your autoloader:

        // app/autoload.php
        $loader->registerNamespaces(array(
        'Io' => __DIR__.'/../vendor/bundles',
        // your other namespaces
        ));

  3. Add the "Io" namespace to your autoloader:

        // app/ApplicationKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Io\FormBundle\IoFormBundle(),
                // ...
            );
        }

  4. Add the twig form configuration:

        // app/config/config.yml
        twig:
            form:
                resources:
                    - 'IoFormBundle:Form:fields.html.twig'

        io_form:
            jquery_tinymce:
              source: /bundles/yourbundle/js/tiny_mce/tiny_mce.js
              theme:  simple


How to use Form Type
====================
  Build your form:

    ...
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('user', 'jquery_entity_combobox', array('class' => 'Io\MyBundle\Entity\MyEntity'))
            ->add('date', 'jquery_date', array('format' => 'dd/MM/y')
            ->add('int_field', 'jquery_range', array('min' => 0, 'max' => 50, 'step' => 2)
            ->add('note', 'jquery_tinymce')
        );
    }

 Several options are available on jquery_date widget
  'format' => 'dd/MM/y'  'dd.MM.yy' 'd MMM, y'
  'changeMonth'=> 'true',
  'changeYear' => true,
  'minDate'=> '-1y',
  'maxDate'=> '+1y'

More details on some types:

- [JqueryEntityAutocompleteType](docs/JqueryEntityAutocompleteType.md)

THAT'S ALL
==========

WARNINGS:
    Form Types uses last version of Jquery v1.6 and JQueryUI v1.8 Libraries
    You must have jquery and jquery ui already loaded in your template
    You must include jquery tinymce library (v3.4.4) in your project ( http://www.tinymce.com/download/download.php )

    #yourlayout.html.twig
    <body>
      ...
      {% block js %}
      <script type="text/javascript" src="{{ asset('path/js/jquery-ui-1.8.15.custom.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('path/js/js/combobox.js') }}"></script>
      <script type="text/javascript" src="{{ asset('path/js/js/tiny_mce/jquery.tinymce.js') }}"></script>
      {% endblock %}
    </body>
