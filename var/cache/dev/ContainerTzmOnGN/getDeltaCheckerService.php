<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDeltaCheckerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\DataImporterBundle\DataSource\Interpreter\DeltaChecker\DeltaChecker' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataImporterBundle\DataSource\Interpreter\DeltaChecker\DeltaChecker
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-importer/src/DataSource/Interpreter/DeltaChecker/DeltaChecker.php';

        $a = ($container->services['doctrine.dbal.default_connection'] ?? $container->getDoctrine_Dbal_DefaultConnectionService());

        if (isset($container->privates['Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\DeltaChecker\\DeltaChecker'])) {
            return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\DeltaChecker\\DeltaChecker'];
        }

        return $container->privates['Pimcore\\Bundle\\DataImporterBundle\\DataSource\\Interpreter\\DeltaChecker\\DeltaChecker'] = new \Pimcore\Bundle\DataImporterBundle\DataSource\Interpreter\DeltaChecker\DeltaChecker($a);
    }
}
