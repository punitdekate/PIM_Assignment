<?php

namespace ContainerPzx5FUJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDeviceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Targeting\DataProvider\Device' shared autowired service.
     *
     * @return \Pimcore\Targeting\DataProvider\Device
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Targeting/DataProvider/DataProviderInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Targeting/DataProvider/Device.php';

        $container->privates['Pimcore\\Targeting\\DataProvider\\Device'] = $instance = new \Pimcore\Targeting\DataProvider\Device(($container->privates['monolog.logger'] ?? $container->getMonolog_LoggerService()));

        $instance->setCache(($container->services['Pimcore\\Cache\\Core\\CoreCacheHandler'] ?? $container->getCoreCacheHandlerService()));
        $instance->setCachePool(($container->services['pimcore.cache.pool'] ?? $container->getPimcore_Cache_PoolService()));

        return $instance;
    }
}
