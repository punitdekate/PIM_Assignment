<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DataobjectmutationtypegeneratorDatatypeAdvancedManyToManyRelationService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectMutationFieldConfigGenerator\AdvancedManyToManyRelation
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectMutationFieldConfigGeneratorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectMutationFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DataObjectMutationFieldConfigGenerator/AdvancedManyToManyRelation.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation'])) {
            return $container->privates['pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation'];
        }
        $b = ($container->privates['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\DataObjectType\\ElementDescriptorInputType'] ?? $container->load('getElementDescriptorInputTypeService'));

        if (isset($container->privates['pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation'])) {
            return $container->privates['pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation'];
        }

        return $container->privates['pimcore.datahub.graphql.dataobjectmutationtypegenerator_datatype_advancedManyToManyRelation'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DataObjectMutationFieldConfigGenerator\AdvancedManyToManyRelation($a, $b);
    }
}
