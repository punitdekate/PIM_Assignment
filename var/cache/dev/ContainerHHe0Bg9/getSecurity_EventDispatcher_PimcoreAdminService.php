<?php

namespace ContainerHHe0Bg9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_EventDispatcher_PimcoreAdminService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.event_dispatcher.pimcore_admin' shared service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public static function do($container, $lazyLoad = true)
    {
        $container->privates['security.event_dispatcher.pimcore_admin'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.pimcore_admin.user_provider'] ?? $container->load('getSecurity_Listener_PimcoreAdmin_UserProviderService'));
        }, 1 => 'checkPassport'], 2048);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LogoutEvent', [0 => function () use ($container) {
            return ($container->privates['security.logout.listener.default.pimcore_admin'] ?? $container->load('getSecurity_Logout_Listener_Default_PimcoreAdminService'));
        }, 1 => 'onLogout'], 64);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.login_throttling.pimcore_admin'] ?? $container->load('getSecurity_Listener_LoginThrottling_PimcoreAdminService'));
        }, 1 => 'checkPassport'], 2080);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LoginSuccessEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.login_throttling.pimcore_admin'] ?? $container->load('getSecurity_Listener_LoginThrottling_PimcoreAdminService'));
        }, 1 => 'onSuccessfulLogin'], 0);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\AuthenticationTokenCreatedEvent', [0 => function () use ($container) {
            return ($container->privates['security.authentication.token_created_listener.two_factor.pimcore_admin'] ?? $container->load('getSecurity_Authentication_TokenCreatedListener_TwoFactor_PimcoreAdminService'));
        }, 1 => 'onAuthenticationTokenCreated'], 0);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.user_checker.pimcore_admin'] ?? $container->load('getSecurity_Listener_UserChecker_PimcoreAdminService'));
        }, 1 => 'preCheckCredentials'], 256);
        $instance->addListener('security.authentication.success', [0 => function () use ($container) {
            return ($container->privates['security.listener.user_checker.pimcore_admin'] ?? $container->load('getSecurity_Listener_UserChecker_PimcoreAdminService'));
        }, 1 => 'postCheckCredentials'], 256);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.user_provider'] ?? $container->load('getSecurity_Listener_UserProviderService'));
        }, 1 => 'checkPassport'], 1024);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.check_authenticator_credentials'] ?? $container->load('getSecurity_Listener_CheckAuthenticatorCredentialsService'));
        }, 1 => 'checkPassport'], 0);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LoginSuccessEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.password_migrating'] ?? $container->load('getSecurity_Listener_PasswordMigratingService'));
        }, 1 => 'onLoginSuccess'], 0);
        $instance->addListener('security.authentication.success', [0 => function () use ($container) {
            return ($container->privates['security.authentication.provider_preparation_listener.two_factor.pimcore_admin'] ?? $container->getSecurity_Authentication_ProviderPreparationListener_TwoFactor_PimcoreAdminService());
        }, 1 => 'onLogin'], 9223372036854775807);
        $instance->addListener('security.authentication.success', [0 => function () use ($container) {
            return ($container->privates['scheb_two_factor.security.authentication_success_event_suppressor'] ?? ($container->privates['scheb_two_factor.security.authentication_success_event_suppressor'] = new \Scheb\TwoFactorBundle\Security\TwoFactor\Event\AuthenticationSuccessEventSuppressor()));
        }, 1 => 'onLogin'], 9223372036854775806);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['scheb_two_factor.security.listener.check_two_factor_code'] ?? $container->load('getSchebTwoFactor_Security_Listener_CheckTwoFactorCodeService'));
        }, 1 => 'checkPassport'], 0);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LoginSuccessEvent', [0 => function () use ($container) {
            return ($container->privates['scheb_two_factor.security.listener.suppress_remember_me'] ?? ($container->privates['scheb_two_factor.security.listener.suppress_remember_me'] = new \Scheb\TwoFactorBundle\Security\Http\EventListener\SuppressRememberMeListener()));
        }, 1 => 'onSuccessfulLogin'], -63);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LogoutEvent', [0 => function () use ($container) {
            return ($container->privates['Pimcore\\Bundle\\AdminBundle\\Security\\Event\\LogoutListener'] ?? $container->load('getLogoutListenerService'));
        }, 1 => 'onLogout'], 0);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\CheckPassportEvent', [0 => function () use ($container) {
            return ($container->privates['security.listener.csrf_protection'] ?? $container->load('getSecurity_Listener_CsrfProtectionService'));
        }, 1 => 'checkPassport'], 512);
        $instance->addListener('Symfony\\Component\\Security\\Http\\Event\\LogoutEvent', [0 => function () use ($container) {
            return ($container->privates['security.logout.listener.csrf_token_clearing'] ?? $container->load('getSecurity_Logout_Listener_CsrfTokenClearingService'));
        }, 1 => 'onLogout'], 0);

        return $instance;
    }
}
