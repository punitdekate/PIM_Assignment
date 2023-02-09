<?php

namespace ContainerPzx5FUJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getExportServiceInterfaceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Translation\ExportService\ExportServiceInterface' shared autowired service.
     *
     * @return \Pimcore\Translation\ExportService\ExportService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportService/ExportServiceInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportService/ExportService.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/ExportDataExtractorServiceInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/ExportDataExtractorService.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/DataExtractor/DataExtractorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/DataExtractor/AbstractElementDataExtractor.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/DataExtractor/DataObjectDataExtractor.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Translation/ExportDataExtractorService/DataExtractor/DocumentDataExtractor.php';

        $a = ($container->services['Pimcore\\Document\\Editable\\EditableUsageResolver'] ?? $container->load('getEditableUsageResolverService'));

        if (isset($container->privates['Pimcore\\Translation\\ExportService\\ExportServiceInterface'])) {
            return $container->privates['Pimcore\\Translation\\ExportService\\ExportServiceInterface'];
        }
        $b = new \Pimcore\Translation\ExportDataExtractorService\ExportDataExtractorService();
        $b->registerDataExtractor('object', new \Pimcore\Translation\ExportDataExtractorService\DataExtractor\DataObjectDataExtractor());
        $b->registerDataExtractor('document', new \Pimcore\Translation\ExportDataExtractorService\DataExtractor\DocumentDataExtractor($a));

        return $container->privates['Pimcore\\Translation\\ExportService\\ExportServiceInterface'] = new \Pimcore\Translation\ExportService\ExportService($b, ($container->privates['Pimcore\\Translation\\ExportService\\Exporter\\ExporterInterface'] ?? $container->load('getExporterInterfaceService')));
    }
}
