<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getLogoutListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\AdminBundle\Security\Event\LogoutListener' shared autowired service.
     *
     * @return \Pimcore\Bundle\AdminBundle\Security\Event\LogoutListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Security/Event/LogoutListener.php';

        $a = ($container->services['router'] ?? $container->getRouterService());

        if (isset($container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'])) {
            return $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'];
        }
        $b = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'])) {
            return $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'];
        }

        $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'] = $instance = new \Pimcore\Bundle\AdminBundle\Security\Event\LogoutListener(($container->services['.container.private.security.token_storage'] ?? $container->get_Container_Private_Security_TokenStorageService()), $a, $b);

        $instance->setLogger(($container->privates['monolog.logger'] ?? $container->getMonolog_LoggerService()));

        return $instance;
    }
}