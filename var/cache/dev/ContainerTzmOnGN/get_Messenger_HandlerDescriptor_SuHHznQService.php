<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Messenger_HandlerDescriptor_SuHHznQService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.messenger.handler_descriptor.SuHHznQ' shared service.
     *
     * @return \Symfony\Component\Messenger\Handler\HandlerDescriptor
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/HandlerDescriptor.php';

        $a = ($container->privates['Pimcore\\Bundle\\DataImporterBundle\\Messenger\\DataImporterHandler'] ?? $container->load('getDataImporterHandlerService'));

        if (isset($container->privates['.messenger.handler_descriptor.SuHHznQ'])) {
            return $container->privates['.messenger.handler_descriptor.SuHHznQ'];
        }

        return $container->privates['.messenger.handler_descriptor.SuHHznQ'] = new \Symfony\Component\Messenger\Handler\HandlerDescriptor($a, []);
    }
}