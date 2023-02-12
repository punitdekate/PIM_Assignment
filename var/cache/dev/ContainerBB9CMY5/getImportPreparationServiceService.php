<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getImportPreparationServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\DataImporterBundle\Processing\ImportPreparationService' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataImporterBundle\Processing\ImportPreparationService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Processing/ImportPreparationService.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Queue/QueueService.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Settings/ConfigurationPreparationService.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Processing/ExecutionService.php';

        $a = ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Resolver\\ResolverFactory'] ?? $container->load('getResolverFactoryService'));

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'];
        }
        $b = ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\InterpreterFactory'] ?? $container->load('getInterpreterFactoryService'));

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'];
        }
        $c = ($container->services['Pimcore\\Log\\ApplicationLogger'] ?? $container->load('getApplicationLoggerService'));

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'];
        }
        $d = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'];
        }

        $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService'] = $instance = new \Pimcore\Bundle\DataImporterBundle\Processing\ImportPreparationService($a, $b, ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Loader\\DataLoaderFactory'] ?? $container->load('getDataLoaderFactoryService')), ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Queue\\QueueService'] ?? ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Queue\\QueueService'] = new \Pimcore\Bundle\DataImporterBundle\Queue\QueueService())), $c, ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService'] ?? ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService'] = new \Pimcore\Bundle\DataImporterBundle\Settings\ConfigurationPreparationService())), ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ExecutionService'] ?? ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ExecutionService'] = new \Pimcore\Bundle\DataImporterBundle\Processing\ExecutionService())), $d);

        $instance->setLogger(($container->services['monolog.logger.DATA-IMPORTER'] ?? $container->load('getMonolog_Logger_DATAIMPORTERService')));

        return $instance;
    }
}
