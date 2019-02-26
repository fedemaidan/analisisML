<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
class BusquedaEbayAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('buscarEnEbay', $this->getRouterIdParameter().'/buscarEnEbay');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('vendedorEbayId')
            ->add('filtrarNew')
            ->add('precioMinimo')
            ->add('precioMaximo')
            ->add('categoriaEbay')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('vendedorEbayId')
            ->add('filtrarNew')
            ->add('precioMinimo')
            ->add('precioMaximo')
            ->add('categoriaEbay')
            ->add('estadoActual')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'buscarEnEbay' => array(
                        'template' => 'AppBundle:CRUD:list__action_buscar.html.twig'
                    )   
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('vendedorEbayId')
            ->add('filtrarNew')
            ->add('precioMinimo')
            ->add('precioMaximo')
            ->add('categoriaEbay')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('vendedorEbayId')
            ->add('filtrarNew')
            ->add('precioMinimo')
            ->add('precioMaximo')
            ->add('categoriaEbay')
            ->add('estadoActual')
        ;
    }
}
