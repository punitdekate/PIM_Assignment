<?php

namespace ContainerHHe0Bg9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_Z3eEsyjService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.Z3eEsyj' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.Z3eEsyj'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'Pimcore\\Http\\Request\\Resolver\\DocumentResolver' => ['services', 'Pimcore\\Http\\Request\\Resolver\\DocumentResolver', 'getDocumentResolverService', false],
            'Pimcore\\Http\\Request\\Resolver\\EditmodeResolver' => ['services', 'Pimcore\\Http\\Request\\Resolver\\EditmodeResolver', 'getEditmodeResolverService', false],
            'Pimcore\\Http\\Request\\Resolver\\ResponseHeaderResolver' => ['services', 'Pimcore\\Http\\Request\\Resolver\\ResponseHeaderResolver', 'getResponseHeaderResolverService', false],
            'Pimcore\\Templating\\Renderer\\EditableRenderer' => ['services', 'Pimcore\\Templating\\Renderer\\EditableRenderer', 'getEditableRendererService', false],
            'doctrine' => ['services', 'doctrine', 'getDoctrineService', false],
            'form.factory' => ['services', '.container.private.form.factory', 'get_Container_Private_Form_FactoryService', false],
            'http_kernel' => ['services', 'http_kernel', 'getHttpKernelService', false],
            'message_bus' => ['services', 'messenger.default_bus', 'getMessenger_DefaultBusService', false],
            'messenger.default_bus' => ['services', 'messenger.default_bus', 'getMessenger_DefaultBusService', false],
            'parameter_bag' => ['privates', 'parameter_bag', 'getParameterBagService', false],
            'pimcore.templating' => ['services', 'pimcore.templating.engine.delegating', 'getPimcore_Templating_Engine_DelegatingService', false],
            'request_stack' => ['services', 'request_stack', 'getRequestStackService', false],
            'router' => ['services', 'router', 'getRouterService', false],
            'security.authorization_checker' => ['services', '.container.private.security.authorization_checker', 'get_Container_Private_Security_AuthorizationCheckerService', false],
            'security.csrf.token_manager' => ['services', '.container.private.security.csrf.token_manager', 'get_Container_Private_Security_Csrf_TokenManagerService', true],
            'security.token_storage' => ['services', '.container.private.security.token_storage', 'get_Container_Private_Security_TokenStorageService', false],
            'serializer' => ['services', '.container.private.serializer', 'get_Container_Private_SerializerService', true],
            'session' => ['privates', '.session.deprecated', 'get_Session_DeprecatedService', true],
            'twig' => ['services', '.container.private.twig', 'get_Container_Private_TwigService', false],
        ], [
            'Pimcore\\Http\\Request\\Resolver\\DocumentResolver' => 'Pimcore\\Http\\Request\\Resolver\\DocumentResolver',
            'Pimcore\\Http\\Request\\Resolver\\EditmodeResolver' => 'Pimcore\\Http\\Request\\Resolver\\EditmodeResolver',
            'Pimcore\\Http\\Request\\Resolver\\ResponseHeaderResolver' => 'Pimcore\\Http\\Request\\Resolver\\ResponseHeaderResolver',
            'Pimcore\\Templating\\Renderer\\EditableRenderer' => 'Pimcore\\Templating\\Renderer\\EditableRenderer',
            'doctrine' => '?',
            'form.factory' => '?',
            'http_kernel' => '?',
            'message_bus' => '?',
            'messenger.default_bus' => '?',
            'parameter_bag' => '?',
            'pimcore.templating' => '?',
            'request_stack' => '?',
            'router' => '?',
            'security.authorization_checker' => '?',
            'security.csrf.token_manager' => '?',
            'security.token_storage' => '?',
            'serializer' => '?',
            'session' => '.session.deprecated',
            'twig' => '?',
        ]);
    }
}