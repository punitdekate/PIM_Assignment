<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_FEFKK36Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.FEFKK36' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.FEFKK36'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'configurationLoaderService' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService', 'getConfigurationPreparationServiceService', true],
            'dataLoaderFactory' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Loader\\DataLoaderFactory', 'getDataLoaderFactoryService', true],
            'importPreparationService' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService', 'getImportPreparationServiceService', true],
        ], [
            'configurationLoaderService' => 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService',
            'dataLoaderFactory' => 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Loader\\DataLoaderFactory',
            'importPreparationService' => 'Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService',
        ]);
    }
}
