<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;


class PublicacionPropiaMLAdmin extends AbstractAdmin
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
            ->add('destacado')
            ->add('producto','doctrine_orm_model_autocomplete',[], null, ['property'=>'nombre', 'multiple' => true])
            ->add('cantidadVendidos')
            ->add('cantidadVistas')
            ->add('categoriaML')
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
            ->add('cantidadVistas')
            ->add('publicacion_ebay.cantidadVendidosEbay', null, ["label" => "Vendidos Ebay"])
            ->add('destacado',null, ["editable" => true])
            ->add('linkHTML','html')
            ->add('linkEbayHTML','html')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
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
            ->add('cuenta')
            ->add('publicacion_ebay', 'sonata_type_model_autocomplete', array(
                    'property' => 'id',
                    'minimum_input_length' => 1
                ))
            ->add('titulo')
            ->add('estado', 'choice', ['choices' => [ "active"=> "Activo", "closed" => "Cerrada", "paused" => "Pausada" ]])
            ->add('precioCompra','number', array( 'precision' => 2))
            ->add('link')
            ->add('categoriaML')
            ->add('descripcion')
            ->add('imagenes')

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
            ->add('cuenta')
            ->add('publicacion_ebay')
            ->add('titulo')
            ->add('precioCompra')
            ->add('link')
            ->add('imagenesFoto','html')
            ->add('cantidadVendidos')
            ->add('cantidadVistas')
            ->add('categoriaML')
            ->add('atributos', null, array('label' => 'Atributos', 'expanded' => true, 'by_reference' => true, 'multiple' => true))
        ;
    }

    /**
     * Overriden from (AbstractAdmin)
     */
    public function configureActionButtons($action, $object = null)
    {
        $list = parent::configureActionButtons($action, $object);
        $list['custom_action'] = array(
            'template' =>  'AppBundle:Productos:woocommerce_csv.html.twig',
    );
        return $list;
    }

    public function preUpdate($publicacion)
    {
        $publicacion->cancelSinc();
    }    
}
