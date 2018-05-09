<?php

namespace BtcTrip\HotelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchHotelsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         /* $builder->add('ajax_simple', 'genemu_jqueryautocomplete_text', array(
            'route_name' => 'getHotelsByAjax'
        ));*/
         $builder
        ->add('hotels', 'genemu_jqueryselect2_hidden', array(
            'configs' => array(
                'multiple' => true // Wether or not multiple values are allowed (default to false)
            )
        ))
        
        
        ->add('createdAt', 'genemu_jquerydate')
        ->add('updatedAt', 'genemu_jquerydate');
    
        
    }

    public function getName()
    {
        return 'searchHotels';
    }
}
