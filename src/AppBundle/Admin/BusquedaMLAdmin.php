<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class BusquedaMLAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('buscarEnML', $this->getRouterIdParameter().'/buscarEnML');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('precioMaximo')
            ->add('precioMinimo')
            ->add('categoriaML','doctrine_orm_model_autocomplete',[], null, ['property'=>'id', 'multiple' => true, 'minimum_input_length' => 2])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('precioMinimo')
            ->add('precioMaximo')
            ->add('categoriaML')
            ->add('estadoActual')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'buscarEnML' => array(
                        'template' => 'AppBundle:CRUD:list__action_buscar_ML.html.twig'
                    )
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('categoriaML', 'sonata_type_model_autocomplete', array(
                    'property' => 'nombre',
                    'minimum_input_length' => 2
                ))
            ->add('precioMinimo')
            ->add('precioMaximo')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('precioMaximo')
            ->add('precioMinimo')
            ->add('categoriaML')
        ;
    }
}
