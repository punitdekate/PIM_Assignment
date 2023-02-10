<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDataImporterListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\DataImporterBundle\EventListener\DataImporterListener' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataImporterBundle\EventListener\DataImporterListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/EventListener/DataImporterListener.php';

        $a = ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Messenger\\DataImporterHandler'] ?? $container->load('getDataImporterHandlerService'));

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\EventListener\\DataImporterListener'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\EventListener\\DataImporterListener'];
        }

        return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\EventListener\\DataImporterListener'] = new \Pimcore\Bundle\DataImporterBundle\EventListener\DataImporterListener($a, false);
    }
}
