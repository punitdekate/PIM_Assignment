<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getRebuildDefinitionsCommandService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'console.command.public_alias.Pimcore\Bundle\DataHubBundle\Command\GraphQL\RebuildDefinitionsCommand' shared autowired service.
     *
     * @return \Pimcore\Bundle\DataHubBundle\Command\GraphQL\RebuildDefinitionsCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Console/AbstractCommand.php';
        include_once \dirname(__DIR__, 4).'/vendor/pimcore/data-hub/src/Command/GraphQL/RebuildDefinitionsCommand.php';

        return $container->services['console.command.public_alias.Pimcore\\Bundle\\DataHubBundle\\Command\\GraphQL\\RebuildDefinitionsCommand'] = new \Pimcore\Bundle\DataHubBundle\Command\GraphQL\RebuildDefinitionsCommand();
    }
}
