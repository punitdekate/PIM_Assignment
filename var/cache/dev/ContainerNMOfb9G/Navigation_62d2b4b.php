<?php

namespace ContainerNMOfb9G;
include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Twig/Extension/Templating/Navigation.php';

class Navigation_62d2b4b extends \Pimcore\Twig\Extension\Templating\Navigation implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Pimcore\Twig\Extension\Templating\Navigation|null wrapped object, if the proxy is initialized
     */
    private $valueHolder33f7d = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer9d56b = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0a12f = [
        
    ];

    public function build(array $params) : \Pimcore\Navigation\Container
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'build', array('params' => $params), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->build($params);
    }

    public function getRenderer(string $alias) : \Pimcore\Navigation\Renderer\RendererInterface
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getRenderer', array('alias' => $alias), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getRenderer($alias);
    }

    public function render(\Pimcore\Navigation\Container $container, string $rendererName = 'menu', string $renderMethod = 'render', ... $rendererArguments)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'render', array('container' => $container, 'rendererName' => $rendererName, 'renderMethod' => $renderMethod, 'rendererArguments' => $rendererArguments), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->render($container, $rendererName, $renderMethod, ...$rendererArguments);
    }

    public function __call($method, array $arguments = []) : \Pimcore\Navigation\Renderer\RendererInterface
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__call', array('method' => $method, 'arguments' => $arguments), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->__call($method, $arguments);
    }

    public function setCharset(string $charset)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'setCharset', array('charset' => $charset), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->setCharset($charset);
    }

    public function getCharset()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getCharset', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getCharset();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        unset($instance->charset);

        \Closure::bind(function (\Pimcore\Twig\Extension\Templating\Navigation $instance) {
            unset($instance->builder, $instance->rendererLocator);
        }, $instance, 'Pimcore\\Twig\\Extension\\Templating\\Navigation')->__invoke($instance);

        $instance->initializer9d56b = $initializer;

        return $instance;
    }

    public function __construct(\Pimcore\Navigation\Builder $builder, \Psr\Container\ContainerInterface $rendererLocator)
    {
        static $reflection;

        if (! $this->valueHolder33f7d) {
            $reflection = $reflection ?? new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');
            $this->valueHolder33f7d = $reflection->newInstanceWithoutConstructor();
        unset($this->charset);

        \Closure::bind(function (\Pimcore\Twig\Extension\Templating\Navigation $instance) {
            unset($instance->builder, $instance->rendererLocator);
        }, $this, 'Pimcore\\Twig\\Extension\\Templating\\Navigation')->__invoke($this);

        }

        $this->valueHolder33f7d->__construct($builder, $rendererLocator);
    }

    public function & __get($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__get', ['name' => $name], $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        if (isset(self::$publicProperties0a12f[$name])) {
            return $this->valueHolder33f7d->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder33f7d;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder33f7d;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__isset', array('name' => $name), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder33f7d;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__unset', array('name' => $name), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder33f7d;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder33f7d;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__clone', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        $this->valueHolder33f7d = clone $this->valueHolder33f7d;
    }

    public function __sleep()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__sleep', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return array('valueHolder33f7d');
    }

    public function __wakeup()
    {
        unset($this->charset);

        \Closure::bind(function (\Pimcore\Twig\Extension\Templating\Navigation $instance) {
            unset($instance->builder, $instance->rendererLocator);
        }, $this, 'Pimcore\\Twig\\Extension\\Templating\\Navigation')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer9d56b = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer9d56b;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'initializeProxy', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder33f7d;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder33f7d;
    }
}

if (!\class_exists('Navigation_62d2b4b', false)) {
    \class_alias(__NAMESPACE__.'\\Navigation_62d2b4b', 'Navigation_62d2b4b', false);
}
