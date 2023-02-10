<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getResponseExceptionListenerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'Pimcore\Bundle\CoreBundle\EventListener\ResponseExceptionListener' shared autowired service.
     *
     * @return \Pimcore\Bundle\CoreBundle\EventListener\ResponseExceptionListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/bundles/CoreBundle/EventListener/ResponseExceptionListener.php';

        $a = ($container->services['Pimcore\\Document\\Renderer\\DocumentRenderer'] ?? $container->getDocumentRendererService());

        if (isset($container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\ResponseExceptionListener'])) {
            return $container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\ResponseExceptionListener'];
        }
        $b = ($container->services['doctrine.dbal.default_connection'] ?? $container->getDoctrine_Dbal_DefaultConnectionService());

        if (isset($container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\ResponseExceptionListener'])) {
            return $container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\ResponseExceptionListener'];
        }

        $container->privates['Pimcore\\Bundle\\CoreBundle\\EventListener\\ResponseExceptionListener'] = $instance = new \Pimcore\Bundle\CoreBundle\EventListener\ResponseExceptionListener($a, $b, ($container->services['Pimcore\\Config'] ?? ($container->services['Pimcore\\Config'] = new \Pimcore\Config())), ($container->services['Pimcore\\Model\\Document\\Service'] ?? ($container->services['Pimcore\\Model\\Document\\Service'] = new \Pimcore\Model\Document\Service())), ($container->services['Pimcore\\Http\\Request\\Resolver\\SiteResolver'] ?? $container->getSiteResolverService()));

        $instance->setLogger(($container->privates['monolog.logger'] ?? $container->getMonolog_LoggerService()));
        $instance->setPimcoreContextResolver(($container->services['Pimcore\\Http\\Request\\Resolver\\PimcoreContextResolver'] ?? $container->getPimcoreContextResolverService()));

        return $instance;
    }
}
