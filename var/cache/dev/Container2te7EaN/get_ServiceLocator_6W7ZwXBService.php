<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_6W7ZwXBService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.6W7ZwXB' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.6W7ZwXB'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'configurationPreparationService' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService', 'getConfigurationPreparationServiceService', true],
            'interpreterFactory' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\InterpreterFactory', 'getInterpreterFactoryService', true],
            'translator' => ['services', 'Symfony\\Contracts\\Translation\\TranslatorInterface', 'getTranslatorInterfaceService', false],
        ], [
            'configurationPreparationService' => 'Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService',
            'interpreterFactory' => 'Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\InterpreterFactory',
            'translator' => '?',
        ]);
    }
}