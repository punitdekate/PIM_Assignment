<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_K1DZBBYService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.K1DZBBY' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.K1DZBBY'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'localeService' => ['services', 'Pimcore\\Localization\\LocaleServiceInterface', 'getLocaleServiceInterfaceService', false],
            'longRunningHelper' => ['services', 'Pimcore\\Helper\\LongRunningHelper', 'getLongRunningHelperService', true],
            'modelFactory' => ['services', 'pimcore.model.factory', 'getPimcore_Model_FactoryService', true],
            'service' => ['services', 'Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service', 'getService2Service', true],
        ], [
            'localeService' => 'Pimcore\\Localization\\LocaleServiceInterface',
            'longRunningHelper' => 'Pimcore\\Helper\\LongRunningHelper',
            'modelFactory' => '?',
            'service' => 'Pimcore\\Bundle\\DataHubBundle\\GraphQL\\Service',
        ]);
    }
}