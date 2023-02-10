<?php

namespace ContainerYoCZ7ow;
include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Twig/Extension/Templating/Navigation.php';

class Navigation_62d2b4b extends \Pimcore\Twig\Extension\Templating\Navigation implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Pimcore\Twig\Extension\Templating\Navigation|null wrapped object, if the proxy is initialized
     */
    private $valueHolder839a3 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializeref79f = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiese8260 = [
        
    ];

    public function build(array $params) : \Pimcore\Navigation\Container
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'build', array('params' => $params), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->build($params);
    }

    public function getRenderer(string $alias) : \Pimcore\Navigation\Renderer\RendererInterface
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getRenderer', array('alias' => $alias), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getRenderer($alias);
    }

    public function render(\Pimcore\Navigation\Container $container, string $rendererName = 'menu', string $renderMethod = 'render', ... $rendererArguments)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'render', array('container' => $container, 'rendererName' => $rendererName, 'renderMethod' => $renderMethod, 'rendererArguments' => $rendererArguments), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->render($container, $rendererName, $renderMethod, ...$rendererArguments);
    }

    public function __call($method, array $arguments = []) : \Pimcore\Navigation\Renderer\RendererInterface
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__call', array('method' => $method, 'arguments' => $arguments), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->__call($method, $arguments);
    }

    public function setCharset(string $charset)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'setCharset', array('charset' => $charset), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->setCharset($charset);
    }

    public function getCharset()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getCharset', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getCharset();
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

        $instance->initializeref79f = $initializer;

        return $instance;
    }

    public function __construct(\Pimcore\Navigation\Builder $builder, \Psr\Container\ContainerInterface $rendererLocator)
    {
        static $reflection;

        if (! $this->valueHolder839a3) {
            $reflection = $reflection ?? new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');
            $this->valueHolder839a3 = $reflection->newInstanceWithoutConstructor();
        unset($this->charset);

        \Closure::bind(function (\Pimcore\Twig\Extension\Templating\Navigation $instance) {
            unset($instance->builder, $instance->rendererLocator);
        }, $this, 'Pimcore\\Twig\\Extension\\Templating\\Navigation')->__invoke($this);

        }

        $this->valueHolder839a3->__construct($builder, $rendererLocator);
    }

    public function & __get($name)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__get', ['name' => $name], $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        if (isset(self::$publicPropertiese8260[$name])) {
            return $this->valueHolder839a3->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

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

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__set', array('name' => $name, 'value' => $value), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__isset', array('name' => $name), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__unset', array('name' => $name), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\Templating\\Navigation');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder839a3;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder839a3;
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
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__clone', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        $this->valueHolder839a3 = clone $this->valueHolder839a3;
    }

    public function __sleep()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__sleep', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return array('valueHolder839a3');
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
        $this->initializeref79f = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializeref79f;
    }

    public function initializeProxy() : bool
    {
        return $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'initializeProxy', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder839a3;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder839a3;
    }
}

if (!\class_exists('Navigation_62d2b4b', false)) {
    \class_alias(__NAMESPACE__.'\\Navigation_62d2b4b', 'Navigation_62d2b4b', false);
}
