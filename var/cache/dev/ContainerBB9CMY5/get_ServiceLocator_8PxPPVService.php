<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_8PxPPVService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator._8PxPPV' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator._8PxPPV'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'redirectHandler' => ['privates', 'Pimcore\\Routing\\RedirectHandler', 'getRedirectHandlerService', false],
        ], [
            'redirectHandler' => 'Pimcore\\Routing\\RedirectHandler',
        ]);
    }
}
