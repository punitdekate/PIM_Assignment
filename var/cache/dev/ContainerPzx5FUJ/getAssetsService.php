<?php

namespace ContainerPzx5FUJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAssetsService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\AdminBundle\GDPR\DataProvider\Assets' shared autowired service.
     *
     * @return \Pimcore\Bundle\AdminBundle\GDPR\DataProvider\Assets
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/GDPR/DataProvider/DataProviderInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/GDPR/DataProvider/Elements.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/GDPR/DataProvider/Assets.php';

        return $container->privates['Pimcore\\Bundle\\AdminBundle\\GDPR\\DataProvider\\Assets'] = new \Pimcore\Bundle\AdminBundle\GDPR\DataProvider\Assets($container->parameters['pimcore.gdpr-data-extrator.assets']);
    }
}
