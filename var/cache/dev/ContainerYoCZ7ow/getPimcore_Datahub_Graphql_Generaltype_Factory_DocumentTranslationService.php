<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_Generaltype_Factory_DocumentTranslationService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.generaltype.factory.document_translation' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\GeneralTypeFactory
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/GeneralTypeFactory.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.generaltype.factory.document_translation'])) {
            return $container->privates['pimcore.datahub.graphql.generaltype.factory.document_translation'];
        }

        return $container->privates['pimcore.datahub.graphql.generaltype.factory.document_translation'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\GeneralTypeFactory($a, 'Pimcore\\Bundle\\DataHubBundle\\GraphQL\\DocumentType\\DocumentTranslationType');
    }
}
