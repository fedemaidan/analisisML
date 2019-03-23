<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AtributoMLAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('idMl')
            ->add('name')
            ->add('valueId')
            ->add('valueName')
            ->add('attributeGroupId')
            ->add('attributeGroupName')
            ->add('ebayName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('idMl')
            ->add('name')
            ->add('valueId')
            ->add('valueName')
            ->add('attributeGroupId')
            ->add('attributeGroupName')
            ->add('ebayName')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('id')
            ->add('idMl')
            ->add('name')
            ->add('valueId')
            ->add('valueName')
            ->add('attributeGroupId')
            ->add('attributeGroupName')
            ->add('ebayName')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('idMl')
            ->add('name')
            ->add('valueId')
            ->add('valueName')
            ->add('attributeGroupId')
            ->add('attributeGroupName')
            ->add('ebayName')
        ;
    }
}
