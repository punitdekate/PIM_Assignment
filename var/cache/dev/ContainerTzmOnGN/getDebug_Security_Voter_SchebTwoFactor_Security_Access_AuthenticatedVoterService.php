<?php

namespace ContainerTzmOnGN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_Security_Voter_SchebTwoFactor_Security_Access_AuthenticatedVoterService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.security.voter.scheb_two_factor.security.access.authenticated_voter' shared service.
     *
     * @return \Symfony\Component\Security\Core\Authorization\Voter\TraceableVoter
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/Authorization/Voter/VoterInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/Authorization/Voter/CacheableVoterInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/Authorization/Voter/TraceableVoter.php';
        include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/Authorization/Voter/TwoFactorInProgressVoter.php';

        $a = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->privates['debug.security.voter.scheb_two_factor.security.access.authenticated_voter'])) {
            return $container->privates['debug.security.voter.scheb_two_factor.security.access.authenticated_voter'];
        }

        return $container->privates['debug.security.voter.scheb_two_factor.security.access.authenticated_voter'] = new \Symfony\Component\Security\Core\Authorization\Voter\TraceableVoter(new \Scheb\TwoFactorBundle\Security\Authorization\Voter\TwoFactorInProgressVoter(), $a);
    }
}