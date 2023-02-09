<?php

namespace ContainerHHe0Bg9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_FgT9UAtService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.fgT9UAt' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.fgT9UAt'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'blockStateStack' => ['services', 'Pimcore\\Document\\Editable\\Block\\BlockStateStack', 'getBlockStateStackService', false],
            'definitionCollector' => ['privates', 'Pimcore\\Document\\Editable\\EditmodeEditableDefinitionCollector', 'getEditmodeEditableDefinitionCollectorService', false],
            'documentResolver' => ['services', 'Pimcore\\Http\\Request\\Resolver\\DocumentResolver', 'getDocumentResolverService', false],
            'editableRenderer' => ['services', 'Pimcore\\Templating\\Renderer\\EditableRenderer', 'getEditableRendererService', false],
            'localeService' => ['services', 'Pimcore\\Localization\\LocaleServiceInterface', 'getLocaleServiceInterfaceService', false],
            'twig' => ['services', '.container.private.twig', 'get_Container_Private_TwigService', false],
        ], [
            'blockStateStack' => 'Pimcore\\Document\\Editable\\Block\\BlockStateStack',
            'definitionCollector' => 'Pimcore\\Document\\Editable\\EditmodeEditableDefinitionCollector',
            'documentResolver' => 'Pimcore\\Http\\Request\\Resolver\\DocumentResolver',
            'editableRenderer' => 'Pimcore\\Templating\\Renderer\\EditableRenderer',
            'localeService' => '?',
            'twig' => '?',
        ]);
    }
}
