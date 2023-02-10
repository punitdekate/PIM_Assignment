<?php

namespace ContainerFQOrvfZ;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getStateMachine_Workflow_Listener_GuardService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'state_machine.workflow.listener.guard' shared service.
     *
     * @return \Symfony\Component\Workflow\EventListener\GuardListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/workflow/EventListener/GuardListener.php';

        $a = ($container->services['.container.private.security.authorization_checker'] ?? $container->get_Container_Private_Security_AuthorizationCheckerService());

        if (isset($container->privates['state_machine.workflow.listener.guard'])) {
            return $container->privates['state_machine.workflow.listener.guard'];
        }

        return $container->privates['state_machine.workflow.listener.guard'] = new \Symfony\Component\Workflow\EventListener\GuardListener(['workflow.workflow.guard.add_base_attributes' => 'is_fully_authenticated() and (is_granted(\'ROLE_DATAENTRY\') or is_granted(\'ROLE_PIMCORE_ADMIN\'))', 'workflow.workflow.guard.add_features' => 'is_fully_authenticated() and (is_granted(\'ROLE_DATAENTRY\')  or is_granted(\'ROLE_PIMCORE_ADMIN\'))', 'workflow.workflow.guard.add_mf_sl' => 'is_fully_authenticated() and (is_granted(\'ROLE_MEDIA\')  or is_granted(\'ROLE_PIMCORE_ADMIN\'))', 'workflow.workflow.guard.add_media' => 'is_fully_authenticated() and (is_granted(\'ROLE_REVIEWER\') or is_granted(\'ROLE_PIMCORE_ADMIN\'))', 'workflow.workflow.guard.accept_transition' => 'is_fully_authenticated() and (is_granted(\'ROLE_REVIEWER\')  or is_granted(\'ROLE_PIMCORE_ADMIN\'))', 'workflow.workflow.guard.reject_transition' => 'is_fully_authenticated() and (is_granted(\'ROLE_REVIEWER\') or is_granted(\'ROLE_PIMCORE_ADMIN\'))'], ($container->privates['workflow.security.expression_language'] ?? $container->load('getWorkflow_Security_ExpressionLanguageService')), ($container->services['.container.private.security.token_storage'] ?? $container->get_Container_Private_Security_TokenStorageService()), $a, ($container->privates['scheb_two_factor.security.authentication.trust_resolver'] ?? $container->getSchebTwoFactor_Security_Authentication_TrustResolverService()), ($container->privates['security.role_hierarchy'] ?? $container->getSecurity_RoleHierarchyService()), ($container->services['.container.private.validator'] ?? $container->get_Container_Private_ValidatorService()));
    }
}
