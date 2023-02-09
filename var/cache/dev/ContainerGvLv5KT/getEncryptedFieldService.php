<?php

namespace ContainerGvLv5KT;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getEncryptedFieldService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\DataObject\FielddefinitionMarshaller\BlockDataMarshaller\EncryptedField' shared autowired service.
     *
     * @return \Pimcore\DataObject\BlockDataMarshaller\EncryptedField
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Marshaller/MarshallerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/DataObject/BlockDataMarshaller/EncryptedField.php';

        $a = ($container->services['Pimcore\\Element\\MarshallerService'] ?? $container->load('getMarshallerServiceService'));

        if (isset($container->services['Pimcore\\DataObject\\FielddefinitionMarshaller\\BlockDataMarshaller\\EncryptedField'])) {
            return $container->services['Pimcore\\DataObject\\FielddefinitionMarshaller\\BlockDataMarshaller\\EncryptedField'];
        }

        return $container->services['Pimcore\\DataObject\\FielddefinitionMarshaller\\BlockDataMarshaller\\EncryptedField'] = new \Pimcore\DataObject\BlockDataMarshaller\EncryptedField($a);
    }
}