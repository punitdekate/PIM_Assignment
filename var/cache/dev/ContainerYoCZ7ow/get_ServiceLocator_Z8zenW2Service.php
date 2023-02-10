<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Z8zenW2Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Z8zenW2' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Z8zenW2'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'pimcoreDataImporterUploadStorage' => ['privates', 'pimcore.dataImporter.upload.storage', 'getPimcore_DataImporter_Upload_StorageService', true],
        ], [
            'pimcoreDataImporterUploadStorage' => '?',
        ]);
    }
}
