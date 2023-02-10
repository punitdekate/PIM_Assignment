<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_0lgAUV9Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.0lgAUV9' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.0lgAUV9'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'messengerBusPimcoreCore' => ['services', 'messenger.default_bus', 'getMessenger_DefaultBusService', false],
        ], [
            'messengerBusPimcoreCore' => '?',
        ]);
    }
}
