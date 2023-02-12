<?php

namespace ContainerBB9CMY5;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_Authenticator_HttpBasic_PimcoreAdminWebdavService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.authenticator.http_basic.pimcore_admin_webdav' shared service.
     *
     * @return \Symfony\Component\Security\Http\Authenticator\HttpBasicAuthenticator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/AuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/EntryPoint/AuthenticationEntryPointInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/HttpBasicAuthenticator.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/User/UserProviderInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/AdminBundle/Security/User/UserProvider.php';

        return $container->privates['security.authenticator.http_basic.pimcore_admin_webdav'] = new \Symfony\Component\Security\Http\Authenticator\HttpBasicAuthenticator('Secured Area', ($container->services['pimcore_admin.security.user_provider'] ?? ($container->services['pimcore_admin.security.user_provider'] = new \Pimcore\Bundle\AdminBundle\Security\User\UserProvider())), ($container->services['monolog.logger.security'] ?? $container->getMonolog_Logger_SecurityService()));
    }
}
