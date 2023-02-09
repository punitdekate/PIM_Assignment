<?php

namespace ContainerHHe0Bg9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCmfRouting_Persistence_Doctrine_RouteConditionMetadataListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'cmf_routing.persistence.doctrine.route_condition_metadata_listener' shared service.
     *
     * @return \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\RouteConditionMetadataListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/event-manager/src/EventSubscriber.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony-cmf/routing-bundle/src/Doctrine/RouteConditionMetadataListener.php';

        return $container->privates['cmf_routing.persistence.doctrine.route_condition_metadata_listener'] = new \Symfony\Cmf\Bundle\RoutingBundle\Doctrine\RouteConditionMetadataListener();
    }
}
