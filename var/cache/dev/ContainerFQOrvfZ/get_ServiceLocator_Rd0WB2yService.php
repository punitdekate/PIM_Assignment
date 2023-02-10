<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Rd0WB2yService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Rd0WB2y' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Rd0WB2y'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'importPreparationService' => ['privates', 'Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService', 'getImportPreparationServiceService', true],
        ], [
            'importPreparationService' => 'Pimcore\\Bundle\\DataImporterBundle\\Processing\\ImportPreparationService',
        ]);
    }
}
