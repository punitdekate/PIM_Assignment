<?php

namespace ContainerGvLv5KT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getClassesDefinitionsBuildCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'console.command.public_alias.Pimcore\Bundle\CoreBundle\Command\ClassesDefinitionsBuildCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\Command\ClassesDefinitionsBuildCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/Command/ClassesDefinitionsBuildCommand.php';

        return $container->services['console.command.public_alias.Pimcore\\Bundle\\CoreBundle\\Command\\ClassesDefinitionsBuildCommand'] = new \Pimcore\Bundle\CoreBundle\Command\ClassesDefinitionsBuildCommand(($container->services['Pimcore\\DataObject\\ClassBuilder\\PHPClassDumperInterface'] ?? $container->load('getPHPClassDumperInterfaceService')), ($container->services['Pimcore\\DataObject\\ClassBuilder\\PHPFieldCollectionClassDumperInterface'] ?? $container->load('getPHPFieldCollectionClassDumperInterfaceService')), ($container->services['Pimcore\\DataObject\\ClassBuilder\\PHPObjectBrickClassDumperInterface'] ?? $container->load('getPHPObjectBrickClassDumperInterfaceService')), ($container->services['Pimcore\\DataObject\\ClassBuilder\\PHPObjectBrickContainerClassDumperInterface'] ?? $container->load('getPHPObjectBrickContainerClassDumperInterfaceService')));
    }
}
