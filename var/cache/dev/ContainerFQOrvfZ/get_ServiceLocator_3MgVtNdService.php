<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_3MgVtNdService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.3MgVtNd' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.3MgVtNd'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'collection' => ['privates', '.errored..service_locator.3MgVtNd.Pimcore\\HttpKernel\\BundleCollection\\BundleCollection', NULL, 'Cannot autowire service ".service_locator.3MgVtNd": it references class "Pimcore\\HttpKernel\\BundleCollection\\BundleCollection" but no such service exists.'],
        ], [
            'collection' => 'Pimcore\\HttpKernel\\BundleCollection\\BundleCollection',
        ]);
    }
}