<?php

namespace ContainerNMOfb9G;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getInternalMigrationHelpersCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'console.command.public_alias.Pimcore\Bundle\CoreBundle\Command\InternalMigrationHelpersCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\Command\InternalMigrationHelpersCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/Command/InternalMigrationHelpersCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/migrations/lib/Doctrine/Migrations/Metadata/Storage/MetadataStorage.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Migrations/FilteredTableMetadataStorage.php';

        return $container->services['console.command.public_alias.Pimcore\\Bundle\\CoreBundle\\Command\\InternalMigrationHelpersCommand'] = new \Pimcore\Bundle\CoreBundle\Command\InternalMigrationHelpersCommand(($container->privates['doctrine.migrations.dependency_factory'] ?? $container->load('getDoctrine_Migrations_DependencyFactoryService')), ($container->services['Pimcore\\Migrations\\FilteredTableMetadataStorage'] ?? ($container->services['Pimcore\\Migrations\\FilteredTableMetadataStorage'] = new \Pimcore\Migrations\FilteredTableMetadataStorage())));
    }
}
