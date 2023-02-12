<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getStructuredTableService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\DataObject\BlockDataMarshaller\StructuredTable' shared autowired service.
     *
     * @return \Pimcore\DataObject\BlockDataMarshaller\StructuredTable
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Marshaller/MarshallerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/DataObject/BlockDataMarshaller/StructuredTable.php';

        return $container->services['Pimcore\\DataObject\\BlockDataMarshaller\\StructuredTable'] = new \Pimcore\DataObject\BlockDataMarshaller\StructuredTable();
    }
}
