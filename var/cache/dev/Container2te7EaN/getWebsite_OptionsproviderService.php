<?php

namespace Container2te7EaN;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getWebsite_OptionsproviderService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'Website.optionsprovider' shared autowired service.
     *
     * @return \App\DynamicDropdown
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->services['Website.optionsprovider'] = new \App\DynamicDropdown();
    }
}
