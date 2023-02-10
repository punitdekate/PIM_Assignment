<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_OpXJ0VBService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.opXJ0VB' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.opXJ0VB'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'configurationPreparationService' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService', 'getConfigurationPreparationServiceService', true],
            'dataLoaderFactory' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Loader\\DataLoaderFactory', 'getDataLoaderFactoryService', true],
        ], [
            'configurationPreparationService' => 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService',
            'dataLoaderFactory' => 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Loader\\DataLoaderFactory',
        ]);
    }
}
