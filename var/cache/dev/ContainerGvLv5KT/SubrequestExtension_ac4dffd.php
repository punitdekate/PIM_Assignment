<?php

namespace ContainerGvLv5KT;
include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Twig/Extension/SubrequestExtension.php';

class SubrequestExtension_ac4dffd extends \Pimcore\Twig\Extension\SubrequestExtension implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Pimcore\Twig\Extension\SubrequestExtension|null wrapped object, if the proxy is initialized
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

    public function getFunctions() : array
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getFunctions', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getFunctions();
    }

    public function getTokenParsers()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getTokenParsers', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getTokenParsers();
    }

    public function getNodeVisitors()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getNodeVisitors', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getNodeVisitors();
    }

    public function getFilters()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getFilters', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getFilters();
    }

    public function getTests()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getTests', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getTests();
    }

    public function getOperators()
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'getOperators', array(), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->getOperators();
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

        unset($instance->incHelper);

        $instance->initializer9d56b = $initializer;

        return $instance;
    }

    public function __construct(\Pimcore\Twig\Extension\Templating\Inc $incHelper)
    {
        static $reflection;

        if (! $this->valueHolder33f7d) {
            $reflection = $reflection ?? new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');
            $this->valueHolder33f7d = $reflection->newInstanceWithoutConstructor();
        unset($this->incHelper);

        }

        $this->valueHolder33f7d->__construct($incHelper);
    }

    public function & __get($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__get', ['name' => $name], $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        if (isset(self::$publicProperties0a12f[$name])) {
            return $this->valueHolder33f7d->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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
        unset($this->incHelper);
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

if (!\class_exists('SubrequestExtension_ac4dffd', false)) {
    \class_alias(__NAMESPACE__.'\\SubrequestExtension_ac4dffd', 'SubrequestExtension_ac4dffd', false);
}
