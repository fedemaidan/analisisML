<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AtributoMLAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('clone', $this->getRouterIdParameter().'/clone');
    }

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
                    'edit' => [],
                    'clone' => array(
                        'template' => 'AppBundle:CRUD:list__action_clone.html.twig'
                    )
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
