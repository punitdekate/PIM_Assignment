<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Datahub_Graphql_DocumentelementmutationtypegeneratorDatatypeImageService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_image' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementMutationFieldConfigGenerator\Image
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/Traits/ServiceTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementMutationFieldConfigGenerator/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementMutationFieldConfigGenerator/Image.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementInputProcessor/Base.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/GraphQL/DocumentElementInputProcessor/Image.php';

        $a = ($container->services['Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service'] ?? $container->load('getService2Service'));

        if (isset($container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_image'])) {
            return $container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_image'];
        }

        return $container->privates['pimcore.datahub.graphql.documentelementmutationtypegenerator_datatype_image'] = new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementMutationFieldConfigGenerator\Image($a, new \Pimcore\Bundle\DataHubBundle\GraphQL\DocumentElementInputProcessor\Image(($container->services['Pimcore\\Model\\Document\\Editable\\Loader\\EditableLoader'] ?? $container->getEditableLoaderService()), $a));
    }
}
