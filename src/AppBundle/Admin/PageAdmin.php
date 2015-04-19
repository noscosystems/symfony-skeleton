<?php

namespace AppBundle\Admin;

use Sonata\DoctrinePHPCRAdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class PageAdmin extends Admin
{
    /**
     * Configure List Fields
     *
     * @access protected
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', 'text')
        ;
    }

    /**
     * Configure Side Menu
     *
     * @access public
     * @param \Knp\Menu\ItemInterface $menu
     * @param string $action
     * @param \Sonata\AdminBundle\Admin\AdminInterface $childAdmin
     * @return void
     */
    protected function configureSideMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        if ($action === 'edit') {
            $page = $this->getSubject();
            $menu->addChild('make-homepage', array(
                'label' => 'Make Homepage',
                'attributes' => array('class' => 'btn'),
                'route' => 'make_homepage',
                'routeParameters' => array(
                    'id' => $page->getId(),
                ),
            ));
        }
    }

    /**
     * Configure Form Fields
     *
     * @access protected
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @return void
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('form.group_general')
            ->add('title', 'text')
            ->add('content', 'textarea')
        ->end();
    }

    /**
     * Pre-Persist
     *
     * @access public
     * @param \AppBundle\Document\Page $document
     * @return void
     */
    public function prePersist($document)
    {
        $parent = $this->getModelManager()->find(null, '/cms/pages');
        $document->setParentDocument($parent);
    }

    /**
     * Configure Datagrid Filters
     *
     * @access protected
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     * @return void
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title', 'doctrine_phpcr_string');
    }

    /**
     * Get Export Formats
     *
     * @access public
     * @return array
     */
    public function getExportFormats()
    {
        return [];
    }
}
