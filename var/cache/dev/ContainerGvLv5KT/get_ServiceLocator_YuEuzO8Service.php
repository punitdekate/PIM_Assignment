<?php

namespace ContainerGvLv5KT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_YuEuzO8Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.YuEuzO8' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.YuEuzO8'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'documentRouteHandler' => ['privates', 'Pimcore\\Routing\\Dynamic\\DocumentRouteHandler', 'getDocumentRouteHandlerService', false],
            'eventDispatcher' => ['services', 'event_dispatcher', 'getEventDispatcherService', false],
        ], [
            'documentRouteHandler' => 'Pimcore\\Routing\\Dynamic\\DocumentRouteHandler',
            'eventDispatcher' => '?',
        ]);
    }
}
