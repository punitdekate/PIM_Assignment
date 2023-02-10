<?php

namespace Container2te7EaN;

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
        include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/Registry.php';

        $a = ($container->services['Pimcore\\Workflow\\ExpressionService'] ?? $container->load('getExpressionServiceService'));

        if (isset($container->services['Pimcore\\Workflow\\Manager'])) {
            return $container->services['Pimcore\\Workflow\\Manager'];
        }
        $b = ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService());

        if (isset($container->services['Pimcore\\Workflow\\Manager'])) {
            return $container->services['Pimcore\\Workflow\\Manager'];
        }

        return $container->services['Pimcore\\Workflow\\Manager'] = new \Pimcore\Workflow\Manager(($container->privates['workflow.registry'] ?? ($container->privates['workflow.registry'] = new \Symfony\Component\Workflow\Registry())), ($container->privates['Pimcore\\Workflow\\EventSubscriber\\NotesSubscriber'] ?? $container->load('getNotesSubscriberService')), $a, $b);
    }
}
