<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getParallelProcessQueueCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'console.command.public_alias.Pimcore\Bundle\DataImporterBundle\Command\ParallelProcessQueueCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataImporterBundle\Command\ParallelProcessQueueCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/webmozarts/console-parallelization/src/Parallelization.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/Traits/Parallelization.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Command/ParallelProcessQueueCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Queue/QueueService.php';

        return $container->services['console.command.public_alias.Pimcore\\Bundle\\DataImporterBundle\\Command\\ParallelProcessQueueCommand'] = new \Pimcore\Bundle\DataImporterBundle\Command\ParallelProcessQueueCommand(($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportProcessingService'] ?? $container->load('getImportProcessingServiceService')), ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Queue\\QueueService'] ?? ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Queue\\QueueService'] = new \Pimcore\Bundle\DataImporterBundle\Queue\QueueService())));
    }
}
