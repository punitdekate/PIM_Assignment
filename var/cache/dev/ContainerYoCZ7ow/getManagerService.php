<?php

namespace ContainerYoCZ7ow;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getManagerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Pimcore\Workflow\Manager' shared autowired service.
     *
     * @return \Pimcore\Workflow\Manager
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Workflow/Manager.php';

        $a = ($container->privates['workflow.registry'] ?? $container->load('getWorkflow_RegistryService'));

        if (isset($container->services['Pimcore\\Workflow\\Manager'])) {
            return $container->services['Pimcore\\Workflow\\Manager'];
        }
        $b = ($container->services['Pimcore\\Workflow\\ExpressionService'] ?? $container->load('getExpressionServiceService'));

        if (isset($container->services['Pimcore\\Workflow\\Manager'])) {
            return $container->services['Pimcore\\Workflow\\Manager'];
        }
        $c = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->services['Pimcore\\Workflow\\Manager'])) {
            return $container->services['Pimcore\\Workflow\\Manager'];
        }

        $container->services['Pimcore\\Workflow\\Manager'] = $instance = new \Pimcore\Workflow\Manager($a, ($container->privates['Pimcore\\Workflow\\EventSubscriber\\NotesSubscriber'] ?? $container->load('getNotesSubscriberService')), $b, $c);

        $instance->registerWorkflow('workflow', ['label' => 'Product Workflow', 'priority' => 0, 'type' => 'state_machine']);
        $instance->addPlaceConfig('workflow', 'base', ['label' => 'Base Attributes', 'color' => '#377ea9', 'permissions' => [0 => ['objectLayout' => 1]], 'title' => '', 'colorInverted' => false, 'visibleInHeader' => true]);
        $instance->addPlaceConfig('workflow', 'features', ['label' => 'features', 'title' => 'Updating content step', 'color' => '#d9ef36', 'permissions' => [0 => ['objectLayout' => 2]], 'colorInverted' => false, 'visibleInHeader' => true]);
        $instance->addPlaceConfig('workflow', 'set manufacturer and seller', ['label' => 'Update Manufacturer + Seller', 'title' => 'Update Manufacturer + Seller', 'color' => '#d9ef36', 'permissions' => [0 => ['objectLayout' => 4]], 'colorInverted' => false, 'visibleInHeader' => true]);
        $instance->addPlaceConfig('workflow', 'media', ['label' => 'media', 'title' => 'Image gallery', 'color' => '#d9ef36', 'permissions' => [0 => ['objectLayout' => 3]], 'colorInverted' => false, 'visibleInHeader' => true]);
        $instance->addPlaceConfig('workflow', 'content_prepared', ['label' => 'Content Prepared', 'title' => 'Content ready to publish', 'color' => '#28a013', 'colorInverted' => false, 'visibleInHeader' => true, 'permissions' => []]);
        $instance->addPlaceConfig('workflow', 'accepted', ['label' => 'Accepted product', 'color' => '#28a013', 'title' => '', 'colorInverted' => false, 'visibleInHeader' => true, 'permissions' => []]);
        $instance->addPlaceConfig('workflow', 'reject', ['label' => 'Reject product', 'color' => '#28a013', 'title' => '', 'colorInverted' => false, 'visibleInHeader' => true, 'permissions' => []]);

        return $instance;
    }
}