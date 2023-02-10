<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_Security_Firewall_Authenticator_PimcoreAdminWebdavService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.security.firewall.authenticator.pimcore_admin_webdav' shared service.
     *
     * @return \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticatorManagerListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/Debug/TraceableAuthenticatorManagerListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Firewall/AuthenticatorManagerListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/AuthenticatorManagerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/UserAuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authentication/AuthenticatorManager.php';

        return $container->privates['debug.security.firewall.authenticator.pimcore_admin_webdav'] = new \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticatorManagerListener(new \Symfony\Component\Security\Http\Firewall\AuthenticatorManagerListener(new \Symfony\Component\Security\Http\Authentication\AuthenticatorManager([0 => ($container->privates['security.authenticator.http_basic.pimcore_admin_webdav'] ?? $container->load('getSecurity_Authenticator_HttpBasic_PimcoreAdminWebdavService'))], ($container->services['.container.private.security.token_storage'] ?? $container->get_Container_Private_Security_TokenStorageService()), ($container->privates['security.event_dispatcher.pimcore_admin_webdav'] ?? $container->getSecurity_EventDispatcher_PimcoreAdminWebdavService()), 'pimcore_admin_webdav', ($container->services['monolog.logger.security'] ?? $container->getMonolog_Logger_SecurityService()), true, true, [])));
    }
}
