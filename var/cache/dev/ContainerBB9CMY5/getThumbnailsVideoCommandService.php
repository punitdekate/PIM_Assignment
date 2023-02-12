<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getThumbnailsVideoCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'console.command.public_alias.Pimcore\Bundle\CoreBundle\Command\ThumbnailsVideoCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\Command\ThumbnailsVideoCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/webmozarts/console-parallelization/src/Parallelization.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/Traits/Parallelization.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/Command/ThumbnailsVideoCommand.php';

        return $container->services['console.command.public_alias.Pimcore\\Bundle\\CoreBundle\\Command\\ThumbnailsVideoCommand'] = new \Pimcore\Bundle\CoreBundle\Command\ThumbnailsVideoCommand();
    }
}
