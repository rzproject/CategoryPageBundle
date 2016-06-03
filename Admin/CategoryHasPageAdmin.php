<?php


namespace Rz\CategoryPageBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CategoryHasPageAdmin extends Admin
{

    protected $parentAssociationMapping = 'category';

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     *
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('enabled', null, array('required' => false))
            ->add('position', 'hidden')
        ;

        if (interface_exists('Sonata\PageBundle\Model\PageInterface')) {
            $formMapper->add('page', 'sonata_type_model_list', array('btn_delete' => false, 'btn_add' => false), array(
                'link_parameters' => array('context' => 'news', 'hide_context' => false, 'mode' => 'list'),
            ));
        }

        if (interface_exists('Sonata\ClassificationBundle\Model\CategoryInterface')) {
            $formMapper->add('category', 'sonata_type_model_list', array('btn_delete' => false, 'btn_add' => false), array(
                'link_parameters' => array('context' => 'news', 'hide_context' => false, 'mode' => 'list'),
            ));
        }
    }

    /**
     * @param  \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('page', null, array('associated_property' => 'url'))
            ->add('category', null, array('associated_property' => 'name', 'footable'=>array('attr'=>array('data-breakpoints'=>array('xs', 'sm')))))
            ->add('enabled', null, array('footable'=>array('attr'=>array('data-breakpoints'=>array('xs', 'sm'))), 'editable' => false))
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'Show' => array('template' => 'SonataAdminBundle:CRUD:list__action_show.html.twig'),
//                    'Edit' => array('template' => 'SonataAdminBundle:CRUD:list__action_edit.html.twig'),
//                    'Delete' => array('template' => 'SonataAdminBundle:CRUD:list__action_delete.html.twig')),
//                'footable'=>array('attr'=>array('data_hide'=>'phone,tablet')),
//            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('category')
            ->add('page')
            ->add('enabled');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit', 'create', 'show'));
    }
}
