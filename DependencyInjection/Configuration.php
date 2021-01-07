<?php

namespace Evp\Bundle\WebToPayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        if (method_exists(TreeBuilder::class, 'getRootNode')) {
            $treeBuilder = new TreeBuilder('evp_web_to_pay');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('evp_web_to_pay');
        }

        $rootNode
            ->children()
                ->arrayNode('credentials')
                    ->children()
                        ->scalarNode('project_id')->isRequired()->end()
                        ->scalarNode('sign_password')->isRequired()->end()
                    ->end()
                ->end()
                ->booleanNode('use_sandbox')
                    ->defaultFalse()
            ->end();

        return $treeBuilder;
    }
}
