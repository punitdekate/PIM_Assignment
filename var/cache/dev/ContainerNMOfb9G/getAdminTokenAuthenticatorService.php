<?php

namespace ContainerNMOfb9G;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAdminTokenAuthenticatorService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\AdminBundle\Security\Authenticator\AdminTokenAuthenticator' shared autowired service.
     *
     * @return \Pimcore\Bundle\AdminBundle\Security\Authenticator\AdminTokenAuthenticator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/AuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/AbstractAuthenticator.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Security/Authenticator/AdminAbstractAuthenticator.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Security/Authenticator/AdminTokenAuthenticator.php';

        $a = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Authenticator\\AdminTokenAuthenticator'])) {
            return $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Authenticator\\AdminTokenAuthenticator'];
        }
        $b = ($container->services['router'] ?? $container->getRouterService());

        if (isset($container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Authenticator\\AdminTokenAuthenticator'])) {
            return $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Authenticator\\AdminTokenAuthenticator'];
        }

        $container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Authenticator\\AdminTokenAuthenticator'] = $instance = new \Pimcore\Bundle\AdminBundle\Security\Authenticator\AdminTokenAuthenticator($a, $b, ($container->services['Symfony\\Contracts\\Translation\\TranslatorInterface'] ?? $container->getTranslatorInterfaceService()));

        $c = ($container->services['monolog.logger.security'] ?? $container->getMonolog_Logger_SecurityService());

        $instance->setLogger($c);
        $instance->setLogger($c);

        return $instance;
    }
}
