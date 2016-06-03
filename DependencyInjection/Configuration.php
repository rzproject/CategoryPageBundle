<?php

namespace Rz\CategoryPageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('rz_category_page');
        $this->addSettingsSection($node);
        $this->addCategoryPageSection($node);
        return $treeBuilder;
    }

    /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addSettingsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('slugify_service')
                    ->info('You should use: sonata.core.slugify.cocur, but for BC we keep \'sonata.core.slugify.native\' as default')
                    ->defaultValue('sonata.core.slugify.cocur')
                ->end()
            ->end()
        ;
    }

   /**
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $node
     */
    private function addCategoryPageSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('page')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('templates')
                            ->useAttributeAsKey('id')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')->isRequired()->end()
                                    ->scalarNode('template_code')->isRequired()->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('services')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('category')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('service')->defaultValue('rz.category_page.page.service.category')->end()
                                    ->end()
                                ->end()
                                ->arrayNode('category_canonical')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('service')->defaultValue('rz.category_page.page.service.category_canonical')->end()
                                        ->arrayNode('settings')
                                            ->addDefaultsIfNotSet()
                                            ->children()
                                                ->scalarNode('name')->defaultValue('Category Canonical')->end()
                                                ->scalarNode('class')->defaultValue('Rz\\CategoryPageBundle\\Page\\Service\\CategoryCanonicalPageService')->end()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('manager_class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('orm')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('category_has_page')->defaultValue('Rz\\CategoryPageBundle\\Entity\\CategoryHasPageManager')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                    ->addDefaultsIfNotSet()
                    ->children()
                       ->arrayNode('category_has_page')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue('Rz\\CategoryPageBundle\\Admin\\CategoryHasPageAdmin')->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue('RzCategoryPageBundle:CategoryHasPageAdmin')->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue('RzCategoryPageBundle')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('category_has_page')->defaultValue('AppBundle\\Entity\\CategoryPage\\CategoryHasPage')->end()
                        ->scalarNode('category')->defaultValue('AppBundle\\Entity\\Classification\\Category')->end()
                        ->scalarNode('page')->defaultValue('AppBundle\\Entity\\Page\\Page')->end()
                        ->scalarNode('block')->defaultValue('AppBundle\\Entity\\Page\\Block')->end()
                    ->end()
                ->end()
                ->arrayNode('block')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')->cannotBeEmpty()->end()
                        ->arrayNode('template')
                            ->isRequired()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('template')->isRequired()->cannotBeEmpty()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('page_service')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('category')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('Category')->end()
                                ->scalarNode('class')->defaultValue('Rz\\CategoryPageBundle\\Page\\Service\\CategoryPageService')->end()
                            ->end()
                        ->end()
                        ->arrayNode('category_canonical')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('name')->defaultValue('Category')->end()
                                ->scalarNode('class')->defaultValue('Rz\\CategoryPageBundle\\Page\\Service\\CategoryPageService')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
