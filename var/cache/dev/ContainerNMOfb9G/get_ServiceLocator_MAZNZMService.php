<?php

namespace ContainerNMOfb9G;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_MAZNZMService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.MAZ_NZM' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.MAZ_NZM'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'config' => ['services', 'Pimcore\\Config', 'getConfigService', false],
            'eventDispatcher' => ['services', 'event_dispatcher', 'getEventDispatcherService', false],
        ], [
            'config' => 'Pimcore\\Config',
            'eventDispatcher' => '?',
        ]);
    }
}
