<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getPimcore_Security_EncoderFactoryService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'pimcore.security.encoder_factory' shared autowired service.
     *
     * @return \Pimcore\Security\Encoder\EncoderFactory
     *
     * @deprecated Since pimcore/pimcore 10.1: The "pimcore.security.encoder_factory" service is deprecated, use "pimcore.security.user_password_hasher" instead.
     */
    public static function do($container, $lazyLoad = true)
    {
        trigger_deprecation('pimcore/pimcore', '10.1', 'The "pimcore.security.encoder_factory" service is deprecated, use "pimcore.security.user_password_hasher" instead.');

        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-core/Encoder/EncoderFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Security/Encoder/Factory/AbstractEncoderFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Security/Encoder/Factory/UserAwareEncoderFactory.php';

        return $container->privates['pimcore.security.encoder_factory'] = new \Pimcore\Security\Encoder\EncoderFactory($container->load('getSecurity_EncoderFactory_GenericService'), ['Pimcore\\Bundle\\AdminBundle\\Security\\User\\User' => new \Pimcore\Security\Encoder\Factory\UserAwareEncoderFactory('Pimcore\\Bundle\\AdminBundle\\Security\\Encoder\\AdminPasswordEncoder')]);
    }
}
