<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DataobjectquerytypegeneratorOperatorThumbnailhtmlService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.dataobjectquerytypegenerator_operator_thumbnailhtml' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectQueryOperatorConfigGenerator\ThumbnailHtml
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/OperatorTypeDefinitionInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectQueryOperatorConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectQueryOperatorConfigGenerator/ThumbnailHtml.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_operator_thumbnailhtml'])) {
            return $container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_operator_thumbnailhtml'];
        }

        return $container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_operator_thumbnailhtml'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectQueryOperatorConfigGenerator\ThumbnailHtml($a);
    }
}
