<?php

namespace ContainerPzx5FUJ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSchebTwoFactor_Security_GoogleAuthenticatorService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'scheb_two_factor.security.google_authenticator' shared service.
     *
     * @return \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-google-authenticator/Security/TwoFactor/Provider/Google/GoogleAuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-google-authenticator/Security/TwoFactor/Provider/Google/GoogleAuthenticator.php';
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-google-authenticator/Security/TwoFactor/Provider/Google/GoogleTotpFactory.php';

        return $container->services['scheb_two_factor.security.google_authenticator'] = new \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticator(new \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleTotpFactory('Pimcore', 'Pimcore 2 Factor Authentication', 6), 1);
    }
}
