<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('marca')
            ->add('modelo')
            ->add('categoriaMl')
            ->add('categoriaEbay')
            ->add('descripcion')
            ->add('precioReferencia')
            ->add('cantidad')
            ->add('upc')
            ->add('mpn')
            ->add('destacado')
            
            ->add('ean')
            ->add('modelo2')
            ->add('modelo3')
            ->add('modelo4')
            ->add('modelo5');
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nombre')
            ->add('marca')
            ->add('modelo')
            ->add('destacado',null, ["editable" => true])
            ->add('cantidadCompetidores')
            ->add('ventasCompetidores')
            ->add('precioCompra')
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
            ->tab("Principal")
                ->with('Principal')
                    ->add('destacado')
                    ->add('marca')
                    ->add('modelo')
                    ->add('nombre')
                    ->add('descripcion')
                    ->add('precioReferencia')
                    ->add('cantidad')
                ->end()
                ->with('Codigos')
                    ->add('upc')
                    ->add('mpn')
                    ->add('ean')
                    ->add('modelo2')
                    ->add('modelo3')
                    ->add('modelo4')
                    ->add('modelo5')
                ->end()
            ->end()
            ->tab("MercadoLibre")
                ->with('Datos')
                    ->add('categoriaMl')
                    ->add('competencia')
                ->end()
                ->with('Atributos')
                    //->add('atributos')
                    ->add('atributos', 'sonata_type_model_autocomplete', array(
                    'property' => 'valueName',
                    'minimum_input_length' => 2,
                    'multiple' => true
                ))
                ->end()
            ->end()
            ->tab("Ebay")
                ->with('Datos')
                    ->add('categoriaEbay')
                    ->add('proveedores')
                ->end()
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('marca')
            ->add('modelo')
            ->add('categoriaMl')
            ->add('categoriaEbay')
            ->add('descripcion')
            ->add('precioReferencia')
            ->add('cantidad')
            ->add('upc')
            ->add('mpn')
            ->add('ean')
            ->add('modelo2')
            ->add('modelo3')
            ->add('modelo4')
            ->add('modelo5');
        ;
    }
}
