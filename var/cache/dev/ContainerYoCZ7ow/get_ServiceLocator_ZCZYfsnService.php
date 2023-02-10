<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_ZCZYfsnService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.ZCZYfsn' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ZCZYfsn'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'pimcoreDataImporterUploadStorage' => ['privates', 'pimcore.dataImporter.upload.storage', 'getPimcore_DataImporter_Upload_StorageService', true],
            'translator' => ['services', 'Symfony\\Contracts\\Translation\\TranslatorInterface', 'getTranslatorInterfaceService', false],
        ], [
            'pimcoreDataImporterUploadStorage' => '?',
            'translator' => '?',
        ]);
    }
}
