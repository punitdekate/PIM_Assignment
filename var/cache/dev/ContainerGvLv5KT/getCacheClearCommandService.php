<?php

namespace ContainerGvLv5KT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCacheClearCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\CoreBundle\Command\CacheClearCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\Command\CacheClearCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/Command/CacheClearCommand.php';

        $container->privates['Pimcore\\Bundle\\CoreBundle\\Command\\CacheClearCommand'] = $instance = new \Pimcore\Bundle\CoreBundle\Command\CacheClearCommand(($container->services['event_dispatcher'] ?? $container->getEventDispatcherService()));

        $instance->setName('pimcore:cache:clear');

        return $instance;
    }
}
