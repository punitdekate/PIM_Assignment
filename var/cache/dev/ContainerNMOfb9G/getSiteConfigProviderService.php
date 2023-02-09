<?php

namespace ContainerNMOfb9G;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSiteConfigProviderService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Analytics\Google\Config\SiteConfigProvider' shared autowired service.
     *
     * @return \Pimcore\Analytics\Google\Config\SiteConfigProvider
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Analytics/Google/Config/SiteConfigProvider.php';

        return $container->privates['Pimcore\\Analytics\\Google\\Config\\SiteConfigProvider'] = new \Pimcore\Analytics\Google\Config\SiteConfigProvider(($container->privates['Pimcore\\Analytics\\SiteId\\SiteIdProvider'] ?? $container->getSiteIdProviderService()), ($container->privates['Pimcore\\Analytics\\Google\\Config\\ConfigProvider'] ?? ($container->privates['Pimcore\\Analytics\\Google\\Config\\ConfigProvider'] = new \Pimcore\Analytics\Google\Config\ConfigProvider())));
    }
}
