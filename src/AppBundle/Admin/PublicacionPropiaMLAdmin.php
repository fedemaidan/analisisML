<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class PublicacionPropiaMLAdmin extends AbstractAdmin
{


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
            ->add('categoriaML')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
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
            ->add('categoriaML')
            ->add('atributos', null, array('label' => 'Atributos', 'expanded' => true, 'by_reference' => true, 'multiple' => true))
        ;
    }
}
