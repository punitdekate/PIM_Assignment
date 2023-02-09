<?php

namespace ContainerNMOfb9G;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSearchBackendListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\CoreBundle\EventListener\SearchBackendListener' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\EventListener\SearchBackendListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/EventListener/SearchBackendListener.php';

        $a = ($container->services['messenger.default_bus'] ?? $container->getMessenger_DefaultBusService());

        if (isset($container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\SearchBackendListener'])) {
            return $container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\SearchBackendListener'];
        }

        return $container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\SearchBackendListener'] = new \Pimcore\Bundle\CoreBundle\EventListener\SearchBackendListener($a);
    }
}
