<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSchebTwoFactor_Security_Listener_CheckTwoFactorCodeService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'scheb_two_factor.security.listener.check_two_factor_code' shared service.
     *
     * @return \Scheb\TwoFactorBundle\Security\Http\EventListener\CheckTwoFactorCodeListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/Http/EventListener/AbstractCheckCodeListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/Http/EventListener/CheckTwoFactorCodeListener.php';

        $a = ($container->privates['scheb_two_factor.provider_registry'] ?? $container->getSchebTwoFactor_ProviderRegistryService());

        if (isset($container->privates['scheb_two_factor.security.listener.check_two_factor_code'])) {
            return $container->privates['scheb_two_factor.security.listener.check_two_factor_code'];
        }

        return $container->privates['scheb_two_factor.security.listener.check_two_factor_code'] = new \Scheb\TwoFactorBundle\Security\Http\EventListener\CheckTwoFactorCodeListener(($container->privates['scheb_two_factor.provider_preparation_recorder'] ?? $container->getSchebTwoFactor_ProviderPreparationRecorderService()), $a);
    }
}
