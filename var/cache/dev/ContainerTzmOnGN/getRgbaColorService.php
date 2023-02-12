<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getRgbaColorService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\DataObject\BlockDataMarshaller\RgbaColor' shared autowired service.
     *
     * @return \Pimcore\DataObject\BlockDataMarshaller\RgbaColor
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Marshaller/MarshallerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/DataObject/FielddefinitionMarshaller/Traits/RgbaColorTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/DataObject/BlockDataMarshaller/RgbaColor.php';

        return $container->services['Pimcore\\DataObject\\BlockDataMarshaller\\RgbaColor'] = new \Pimcore\DataObject\BlockDataMarshaller\RgbaColor();
    }
}
