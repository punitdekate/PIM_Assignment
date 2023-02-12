<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getStorageService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\Tool\Storage' shared autowired service.
     *
     * @return \Pimcore\Tool\Storage
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Tool/Storage.php';

        return $container->services['Pimcore\\Tool\\Storage'] = new \Pimcore\Tool\Storage(($container->privates['.service_locator.cGsrLpB'] ?? $container->load('get_ServiceLocator_CGsrLpBService')));
    }
}