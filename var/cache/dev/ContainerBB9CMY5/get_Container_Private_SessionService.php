<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Container_Private_SessionService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public '.container.private.session' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\Session\Session
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/SessionInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/Session/Session.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Session/SessionConfigurator.php';

        $a = ($container->privates['session.factory'] ?? $container->load('getSession_FactoryService'));

        if (isset($container->services['.container.private.session'])) {
            return $container->services['.container.private.session'];
        }

        $container->services['.container.private.session'] = $instance = $a->createSession();

        $b = new \Pimcore\Session\SessionConfigurator();
        $b->addConfigurator(($container->privates['Pimcore\\Bundle\\AdminBundle\\Session\\AdminSessionBagConfigurator'] ?? $container->getAdminSessionBagConfiguratorService()));

        $b->configure($instance);

        return $instance;
    }
}
