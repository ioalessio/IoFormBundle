# JqueryEntityAutocompleteType

## Intro

This type is meant to show an autocomplete text field linked to specific entities in your DB. If you have a list of "Bands" containing:

- Metallica
- The Black Eyed Peas
- Black Sabbath
- Deep Purple
- Led Zeppelin

for example. Then if you start typing `bla` in the text field, you'll see a list containing only:

- The Black Eyed Peas
- Black Sabbath

And you can chose from it.

## Warning

So far there is no default search action for this widget. The widget requires a url as one of its parameters, the url is where jQuery will send what is being typed in the field, and then receive the filtered data from. This url is for the developer to create himself.

## How to use

### The Form Class

In the form class, you add this field like "any other" and pass it the needed parameters:

    class AlbumType extends AbstractType
    {
      public function buildForm(FormBuilder $builder, array $options)
      {
          $builder
              ->add('band', 'jquery_entity_autocomplete', array(
                  'class' => 'AcmeMusicBundle:Band',  
                  'property' => 'id',
                  'url' => $router->generateUrl('band_search', array('search_term', '$$term$$')),
                  'callback' => 'acme.callback'
              ))
      }
      // ...
    }
              
Arguments:
- class: Similar to what you'd do for a standard EntityType
- property: the class property that will be hidden in the form with its value in order to be able to retrieve the entity when the form is submitted. It should absolutely be a UNIQUE field.
- url: The url where the search term will be sent and the filtered data retrieved. It MUST include '$$term$$' which will be replaced by the actual search content.
- callback: If you wish to customize what jQuery will do with the data retrieved from the url, you can write your own JS callback function. Put its name here to reference it. A default callback is provided if the 

### Search / Filter action

For this to work you'll need a search action. In your controller, it could be as simple as:

    /**
     * @Route("/search/{search}.{_format}", name="band_search")
     * @Template()
     * @param $search
     */
    public function searchAction($search){
        $em = $this->getDoctrine()->getEntityManager();
        $qb = $em->getRepository('AcmeMusicBundle:Band')->createQueryBuilder('b');
        $qb->add('where', $qb->expr()->like('b.name', ':search'));
        $qb->setParameter('search', '%'.$search.'%');
        $bands = $qb->getQuery()->getResult();

        return array('bands' => $bands);
    }
    
### Result format

If you did not provide your own callback function, then the default callback expects to retrieve data as a JSON string.
The JSON should be an array of objects where each object should provide:
- label
- property specified in the form class

Example:

      [
      {% for band in bands %}
          { "label": "{{ band.name }}", "id": "{{ band.id }}" } {{ loop.last ? '' : ',' }}
      {% endfor %}
      ]