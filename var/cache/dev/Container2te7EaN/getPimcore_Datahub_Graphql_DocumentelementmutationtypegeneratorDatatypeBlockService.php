<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DocumentelementmutationtypegeneratorDatatypeBlockService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_block' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementMutationFieldConfigGenerator\Block
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementMutationFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementMutationFieldConfigGenerator/Block.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementInputProcessor/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementInputProcessor/EditablesTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementInputProcessor/Block.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_block'])) {
            return $container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_block'];
        }

        return $container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_block'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementMutationFieldConfigGenerator\Block($a, new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementInputProcessor\Block(($container->services['Pimcore\\Model\\Document\\Editable\\Loader\\EditableLoader'] ?? $container->getEditableLoaderService()), $a));
    }
}
