<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class PublicacionMLAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('crearProducto', $this->getRouterIdParameter().'/crearProducto');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('idMl')
            ->add('titulo')
            ->add('precioCompra')
            ->add('link')
            ->add('vendedor')
            ->add('producto.marca')
            ->add('producto.modelo')
            ->add('producto','doctrine_orm_model_autocomplete',[], null, ['property'=>'nombre', 'multiple' => true])
            ->add('cantidadVendidos')
            ->add('categoriaML')
            ->add('brand')
            ->add('model')
            ->add('mpn')
            ->add('upc')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('imagenPrincipal','html')
            ->add('titulo')
            ->add('precioCompra')
            ->add('link','url')
            ->add('vendedor',null, ["label" => "Id Vendedor"])
            ->add('cantidadVendidos')
            ->add('cantidadVistas')
            ->add('categoriaML')
            ->add('brand')
            ->add('model')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    'crearProducto' => array(
                        'template' => 'AppBundle:CRUD:crearProducto.html.twig'
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
            ->add('idMl')
            ->add('titulo')
            ->add('precioCompra')
            ->add('link')
            ->add('vendedor')
            ->add('imagenes')
            ->add('cantidadVendidos')
            ->add('categoriaML')
            ->add('brand')
            ->add('model')
            ->add('mpn')
            ->add('upc')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('idMl')
            ->add('titulo')
            ->add('precioCompra')
            ->add('link')
            ->add('vendedor')
            ->add('imagenesFoto','html')
            ->add('cantidadVendidos')
            ->add('cantidadVistas')
            ->add('categoriaML')
            ->add('brand')
            ->add('model')
            ->add('mpn')
            ->add('upc')
            ->add('atributos', null, array('label' => 'Atributos', 'expanded' => true, 'by_reference' => true, 'multiple' => true))
        ;
    }
}
