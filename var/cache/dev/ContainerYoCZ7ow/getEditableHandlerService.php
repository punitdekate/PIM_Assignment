<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getEditableHandlerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\Document\Editable\EditableHandler' shared autowired service.
     *
     * @return \Pimcore\Document\Editable\EditableHandler
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Document/Editable/EditableHandler.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/HttpKernel/BundleLocator/BundleLocatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/HttpKernel/BundleLocator/BundleLocator.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/HttpKernel/WebPathResolver.php';

        $a = ($container->services['pimcore.templating.engine.delegating'] ?? $container->getPimcore_Templating_Engine_DelegatingService());

        if (isset($container->services['Pimcore\\Document\\Editable\\EditableHandler'])) {
            return $container->services['Pimcore\\Document\\Editable\\EditableHandler'];
        }
        $b = ($container->privates['twig.runtime.httpkernel'] ?? $container->getTwig_Runtime_HttpkernelService());

        if (isset($container->services['Pimcore\\Document\\Editable\\EditableHandler'])) {
            return $container->services['Pimcore\\Document\\Editable\\EditableHandler'];
        }
        $c = ($container->privates['fragment.renderer.inline'] ?? $container->getFragment_Renderer_InlineService());

        if (isset($container->services['Pimcore\\Document\\Editable\\EditableHandler'])) {
            return $container->services['Pimcore\\Document\\Editable\\EditableHandler'];
        }

        $container->services['Pimcore\\Document\\Editable\\EditableHandler'] = $instance = new \Pimcore\Document\Editable\EditableHandler(($container->services['Pimcore\\Extension\\Document\\Areabrick\\AreabrickManagerInterface'] ?? $container->load('getAreabrickManagerInterfaceService')), $a, new \Pimcore\HttpKernel\BundleLocator\BundleLocator(($container->services['kernel'] ?? $container->get('kernel', 1))), new \Pimcore\HttpKernel\WebPathResolver(), ($container->services['Pimcore\\Http\\RequestHelper'] ?? $container->getRequestHelperService()), ($container->privates['Pimcore\\Bundle\\AdminBundle\\Translation\\AdminUserTranslator'] ?? $container->load('getAdminUserTranslatorService')), ($container->privates['Pimcore\\Http\\ResponseStack'] ?? ($container->privates['Pimcore\\Http\\ResponseStack'] = new \Pimcore\Http\ResponseStack())), ($container->services['Pimcore\\Http\\Request\\Resolver\\EditmodeResolver'] ?? $container->getEditmodeResolverService()), $b, $c, ($container->services['request_stack'] ?? ($container->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack())));

        $d = ($container->services['monolog.logger.pimcore'] ?? $container->load('getMonolog_Logger_PimcoreService'));

        $instance->setLogger($d);
        $instance->setLogger($d);

        return $instance;
    }
}
