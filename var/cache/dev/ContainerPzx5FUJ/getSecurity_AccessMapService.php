<?php

namespace ContainerPzx5FUJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_AccessMapService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.access_map' shared service.
     *
     * @return \Symfony\Component\Security\Http\AccessMap
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/AccessMapInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/AccessMap.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcherInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-foundation/RequestMatcher.php';

        $container->privates['security.access_map'] = $instance = new \Symfony\Component\Security\Http\AccessMap();

        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin/settings/display-custom-logo'), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin/login/2fa-verify'), [0 => 'IS_AUTHENTICATED_2FA_IN_PROGRESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin/login/2fa'), [0 => 'IS_AUTHENTICATED_2FA_IN_PROGRESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin/login$'), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin/login/(login|lostpassword|deeplink|csrf-token)$'), [0 => 'PUBLIC_ACCESS'], NULL);
        $instance->add(new \Symfony\Component\HttpFoundation\RequestMatcher('^/admin'), [0 => 'ROLE_PIMCORE_USER'], NULL);

        return $instance;
    }
}