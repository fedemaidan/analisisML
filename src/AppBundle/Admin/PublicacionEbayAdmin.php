<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


class PublicacionEbayAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            
                ->add('id')
                ->add('idEbay')
                ->add('titulo')
                ->add('precio_compra')
                ->add('linkPublicacion')
                ->add('vendedor')
                ->add('cantidadVendidosEbay')
                ->add('categoriaEbay',null, array(), null, ['multiple' => true] )
                ->add('brand')
                ->add('model')
                ->add('mpn')
                ->add('upc')
                ->add('estado_ebay')
                ->add('especificaciones','doctrine_orm_model_autocomplete',[], null, ['property'=>'value', 'multiple' => true])
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
            ->add('precio_compra','number')
            ->add('linkPublicacion','url')
            ->add('vendedor')
            ->add('cantidadVendidosEbay','number')
            ->add('categoriaEbay')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
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
            ->with('General')
                ->add('id')
                ->add('idEbay')
                ->add('titulo')
                ->add('precio_compra')
                ->add('linkPublicacion')
                ->add('vendedor')
                ->add('brand')
                ->add('model')
                ->add('mpn')
                ->add('upc')
                ->add('imagenes')
                ->add('cantidadVendidosEbay')
                ->add('categoriaEbay')
                ->add('estado_ebay')
            ->end()
          /*  ->with('Especificaciones')
                ->add('especificaciones')
            ->end()*/

        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('idEbay')
            ->add('titulo')
            ->add('precio_compra')
            ->add('linkPublicacion','url')
            ->add('vendedor')
            ->add('imagenesFoto','html')
            ->add('cantidadVendidosEbay')
            ->add('categoriaEbay')
            ->add('estado_ebay')
            ->add('brand')
            ->add('model')
            ->add('mpn')
            ->add('upc')
            ->add('especificaciones', null, array('label' => 'Especificaciones', 'expanded' => true, 'by_reference' => true, 'multiple' => true))
        ;
    }

    public function getExportFields()
    {
        $results = $this->getModelManager()->getExportFields($this->getClass()); 

        // Need to add again our foreign key field here
        /*
        $results[] = 'categoriaEbay';
        $results[] = 'imagen1';
        $results[] = 'imagen2';
        $results[] = 'imagen3';
        $results[] = 'imagen4';
        $results[] = 'imagen5';
        $results[] = 'imagen6';
        $results[] = 'imagen7';
        */
        
        $results = array();
        $results[] = 'id';
        $results[] = 'titulo';
        $results[] = 'categoriaEbay';
        $results[] = 'descripcion';
        $results[] = 'precio_compra';
        $results[] = 'imagen0';
        $results[] = 'imagen1';
        $results[] = 'imagen2';
        $results[] = 'imagen3';
        $results[] = 'imagen4';
        $results[] = 'imagen5';

        $results[] = 'cantidadVendidosEbay';
        $results[] = 'vendedor';
        $results[] = 'brand';
        $results[] = 'model';
        $results[] = 'mpn';
        $results[] = 'upc';
        
        return $results;
    }
}
