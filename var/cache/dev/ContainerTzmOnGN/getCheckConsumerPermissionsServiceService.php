<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCheckConsumerPermissionsServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\Bundle\DataHubBundle\Service\CheckConsumerPermissionsService' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\Service\CheckConsumerPermissionsService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/Service/CheckConsumerPermissionsService.php';

        return $container->services['Pimcore\\Bundle\\DataHubBundle\\Service\\CheckConsumerPermissionsService'] = new \Pimcore\Bundle\DataHubBundle\Service\CheckConsumerPermissionsService();
    }
}
