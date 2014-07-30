<?php

namespace Stc\Bundle\MapBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Stc\Bundle\MapBundle\Entity\Coordinate;

use Ivory\GoogleMapBundle\Entity\Coordinate as GMapsCoordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Helper\MapHelper;

class CoordinateType extends AbstractType
{
    protected $map;

    public function __construct($map = null)
    {
        $this->map = $map;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'label' => 'stc.map.coordinate.label',
            'required' => true,
        ]);

    }

    public function getName()
    {
        return 'stc_coordinate';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'coordinate',
            'compound' => false,
            'data_class' => 'Stc\Bundle\MapBundle\Entity\Geo\Coordinate'
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $map = new Map();
        $marker = new Marker();
        $mapHelper = new MapHelper();

        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition(0, 0, true);
        $marker->setAnimation(Animation::DROP);

        $marker->setOption('clickable', false);
        $marker->setOption('flat', true);
        $marker->setOptions([
            'clickable' => false,
            'flat'      => true
        ]);
        $map->addMarker($marker);

        //render the map:
        echo $mapHelper->render($map);

        /*$center = new Coordinate(39.3987338, 116.234234);
        $this->map->setCenter($center);
        $this->map->setMapOption('zoom', 10);
        $view->vars['map'] = $this->map;*/
    }
}