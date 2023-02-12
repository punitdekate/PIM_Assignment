<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getConfigurationPreparationServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\DataImporterBundle\Settings\ConfigurationPreparationService' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataImporterBundle\Settings\ConfigurationPreparationService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/Settings/ConfigurationPreparationService.php';

        return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\Settings\\ConfigurationPreparationService'] = new \Pimcore\Bundle\DataImporterBundle\Settings\ConfigurationPreparationService();
    }
}
