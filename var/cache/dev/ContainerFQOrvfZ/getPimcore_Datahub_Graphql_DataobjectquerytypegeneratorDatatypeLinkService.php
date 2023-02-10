<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DataobjectquerytypegeneratorDatatypeLinkService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.dataobjectquerytypegenerator_datatype_link' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectQueryFieldConfigGenerator\Link
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectQueryFieldConfigGeneratorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/TypeDefinitionInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectQueryFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectQueryFieldConfigGenerator/Link.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_datatype_link'])) {
            return $container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_datatype_link'];
        }

        return $container->privates['pimcore.datahub.graphql.dataobjectquerytypegenerator_datatype_link'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectQueryFieldConfigGenerator\Link($a);
    }
}
