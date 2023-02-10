<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Ui4sMLService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Ui4sML_' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Ui4sML_'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'service' => ['privates', 'Pimcore\\Bundle\\AdminBundle\\GDPR\\DataProvider\\DataObjects', 'getDataObjectsService', true],
        ], [
            'service' => 'Pimcore\\Bundle\\AdminBundle\\GDPR\\DataProvider\\DataObjects',
        ]);
    }
}
