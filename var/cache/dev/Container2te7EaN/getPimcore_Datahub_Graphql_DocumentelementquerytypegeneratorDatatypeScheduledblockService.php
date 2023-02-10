<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DocumentelementquerytypegeneratorDatatypeScheduledblockService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_scheduledblock' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementQueryFieldConfigGenerator\Scheduledblock
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementQueryFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementQueryFieldConfigGenerator/Scheduledblock.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/Type.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/HasFieldsType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/TypeWithFields.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/OutputType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/CompositeType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/NullableType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/NamedType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/ImplementingType.php';
        include_once \dirname(__DIR__, 4).'/vendor/webonyx/graphql-php/src/Type/Definition/ObjectType.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementType/ScheduledblockDataType.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_scheduledblock'])) {
            return $container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_scheduledblock'];
        }

        return $container->privates['pimcore.datahub.graphql.documentelementquerytypegenerator_datatype_scheduledblock'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementQueryFieldConfigGenerator\Scheduledblock($a, new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementType\ScheduledblockDataType($a));
    }
}