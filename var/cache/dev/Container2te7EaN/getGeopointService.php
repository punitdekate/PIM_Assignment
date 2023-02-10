<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getGeopointService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\DataObject\BlockDataMarshaller\Geopoint' shared autowired service.
     *
     * @return \Pimcore\DataObject\BlockDataMarshaller\Geopoint
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Marshaller/MarshallerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/DataObject/BlockDataMarshaller/Geopoint.php';

        return $container->services['Pimcore\\DataObject\\BlockDataMarshaller\\Geopoint'] = new \Pimcore\DataObject\BlockDataMarshaller\Geopoint();
    }
}
