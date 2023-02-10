<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DocumentelementquerytypegeneratorDatatypeEmbedService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_embed' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementQueryFieldConfigGenerator\Embed
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementQueryFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementQueryFieldConfigGenerator/Embed.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_embed'])) {
            return $container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_embed'];
        }

        return $container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_embed'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementQueryFieldConfigGenerator\Embed($a);
    }
}
