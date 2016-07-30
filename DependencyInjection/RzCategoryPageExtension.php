<?php

namespace Rz\CategoryPageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzCategoryPageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('orm.xml');
        $loader->load('admin.xml');
        $this->configureManagerClass($config, $container);
        $this->configureClass($config, $container);
        $this->configureAdminClass($config, $container);
        $this->configureController($config, $container);
        $this->configureTranslationDomain($config, $container);

        $container->setParameter('rz.category_page.slugify_service',    $config['slugify_service']);

        $loader->load('page_service.xml');
        $this->configureServices($container, $config);
        $this->registerDoctrineMapping($config);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.category_page.admin.category_has_page.entity', $config['class']['category_has_page']);
        $container->setParameter('rz.category_page.category_has_page.entity',       $config['class']['category_has_page']);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function configureManagerClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.category_page.entity.manager.category_has_page.class',     $config['manager_class']['orm']['category_has_page']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureAdminClass($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.category_page.admin.category_has_page.class',              $config['admin']['category_has_page']['class']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureTranslationDomain($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.category_page.admin.category_has_page.translation_domain', $config['admin']['category_has_page']['translation']);
    }

    /**
     * @param array                                                   $config
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @return void
     */
    public function configureController($config, ContainerBuilder $container)
    {
        $container->setParameter('rz.category_page.admin.category_has_page.controller',         $config['admin']['category_has_page']['controller']);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array                                                   $config
     */
    public function configureServices(ContainerBuilder $container, $config)
    {
        $container->setParameter('rz.category_page.block.template.catgory_post_list.default',   $config['block']['template']);
        $container->setParameter('rz.category_page.block.template.templates',                   array($config['block']['template']));
        $container->setParameter('rz.category_page.block.catgory_post_list.service',            $config['block']['service']);

        # Page Service
        $container->setParameter('rz.category_page.page.service.category.class',                $config['page_service']['category']['class']);
        $container->setParameter('rz.category_page.page.service.category_canonical.class',      $config['page_service']['category_canonical']['class']);

        $container->setParameter('rz.category_page.page.service.category.name',                 $config['page_service']['category']['name']);
        $container->setParameter('rz.category_page.page.service.category_canonical.name',       $config['page_service']['category_canonical']['name']);

        $pageService = [];
        $pageService['category'] = $config['page']['services']['category']['service'];
        $pageService['category_canonical'] = $config['page']['services']['category_canonical']['service'];
        $container->setParameter('rz.category_page.page.services',                          $pageService);

        if (!$config['page']['templates']) {
            throw new \RuntimeException(sprintf('Please define a default `page_templates` value for the class `%s`', get_class($this)));
        }

        $pageTemplates = [];
        foreach ($config['page']['templates'] as $key=>$value) {
            $pageTemplates[$value['template_code']] = $value['name'];
        }

        $container->setParameter('rz.category_page.page.templates', $pageTemplates);
        $container->setParameter('rz.category_page.page.template.default', key($pageTemplates));
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        foreach ($config['class'] as $type => $class) {
            if (!class_exists($class)) {
                return;
            }
        }

        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['category_has_page'], 'mapManyToOne', array(
            'fieldName' => 'category',
            'targetEntity' => $config['class']['category'],
            'cascade' => array(
                'persist',
            ),
            'mappedBy' => null,
            'inversedBy' => 'categoryHasPage',
            'joinColumns' => array(
                array(
                    'name' => 'category_id',
                    'referencedColumnName' => 'id',
                ),
            ),
            'orphanRemoval' => false,
        ));

        if (interface_exists('Sonata\PageBundle\Model\PageInterface')) {
            $collector->addAssociation($config['class']['category_has_page'], 'mapManyToOne', array(
                'fieldName'     => 'page',
                'targetEntity'  => $config['class']['page'],
                'cascade'       => array(
                    'persist',
                ),
                'mappedBy'      => null,
                'inversedBy'    => null,
                'joinColumns'   => array(
                    array(
                        'name'                 => 'page_id',
                        'referencedColumnName' => 'id',
                    ),
                ),
                'orphanRemoval' => false,
            ));
        }

        if (interface_exists('Sonata\ClassificationBundle\Model\CategoryInterface')) {
            $collector->addAssociation($config['class']['category_has_page'], 'mapManyToOne', array(
                'fieldName'     => 'block',
                'targetEntity'  => $config['class']['block'],
                'cascade'       => array(
                    1 => 'detach',
                ),
                'mappedBy'      => null,
                'inversedBy'    => null,
                'joinColumns'   => array(
                    array(
                        'name'                 => 'block_id',
                        'referencedColumnName' => 'id',
                        'onDelete' => 'SET NULL',
                    ),
                ),
                'orphanRemoval' => false,
            ));
        }
    }
}
