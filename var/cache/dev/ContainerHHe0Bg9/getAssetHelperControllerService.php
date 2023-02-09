<?php

namespace ContainerHHe0Bg9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAssetHelperControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\Bundle\AdminBundle\Controller\Admin\Asset\AssetHelperController' shared autowired service.
     *
     * @return \Pimcore\Bundle\AdminBundle\Controller\Admin\Asset\AssetHelperController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Controller/Controller.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Controller/DoubleAuthenticationControllerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Controller/AdminControllerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Controller/AdminController.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Controller/Admin/Asset/AssetHelperController.php';

        $container->services['Pimcore\\Bundle\\AdminBundle\\Controller\\Admin\\Asset\\AssetHelperController'] = $instance = new \Pimcore\Bundle\AdminBundle\Controller\Admin\Asset\AssetHelperController();

        $instance->setContainer(($container->privates['.service_locator.oafe0zm'] ?? $container->load('get_ServiceLocator_Oafe0zmService'))->withContext('Pimcore\\Bundle\\AdminBundle\\Controller\\Admin\\Asset\\AssetHelperController', $container));

        return $instance;
    }
}
