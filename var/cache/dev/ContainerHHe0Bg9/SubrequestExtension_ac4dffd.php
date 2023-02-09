<?php

namespace ContainerHHe0Bg9;
include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Twig/Extension/SubrequestExtension.php';

class SubrequestExtension_ac4dffd extends \Pimcore\Twig\Extension\SubrequestExtension implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Pimcore\Twig\Extension\SubrequestExtension|null wrapped object, if the proxy is initialized
     */
    private $valueHolder9cd4c = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerdbe6b = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties51100 = [
        
    ];

    public function getFunctions() : array
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getFunctions', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getFunctions();
    }

    public function getTokenParsers()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getTokenParsers', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getTokenParsers();
    }

    public function getNodeVisitors()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getNodeVisitors', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getNodeVisitors();
    }

    public function getFilters()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getFilters', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getFilters();
    }

    public function getTests()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getTests', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getTests();
    }

    public function getOperators()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'getOperators', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return $this->valueHolder9cd4c->getOperators();
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

        $instance->initializerdbe6b = $initializer;

        return $instance;
    }

    public function __construct(\Pimcore\Twig\Extension\Templating\Inc $incHelper)
    {
        static $reflection;

        if (! $this->valueHolder9cd4c) {
            $reflection = $reflection ?? new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');
            $this->valueHolder9cd4c = $reflection->newInstanceWithoutConstructor();
        unset($this->incHelper);

        }

        $this->valueHolder9cd4c->__construct($incHelper);
    }

    public function & __get($name)
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__get', ['name' => $name], $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        if (isset(self::$publicProperties51100[$name])) {
            return $this->valueHolder9cd4c->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

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

        $targetObject = $this->valueHolder9cd4c;
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
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder9cd4c;
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
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__isset', array('name' => $name), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder9cd4c;
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
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__unset', array('name' => $name), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder9cd4c;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder9cd4c;
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
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__clone', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        $this->valueHolder9cd4c = clone $this->valueHolder9cd4c;
    }

    public function __sleep()
    {
        $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, '__sleep', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;

        return array('valueHolder9cd4c');
    }

    public function __wakeup()
    {
        unset($this->incHelper);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerdbe6b = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerdbe6b;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerdbe6b && ($this->initializerdbe6b->__invoke($valueHolder9cd4c, $this, 'initializeProxy', array(), $this->initializerdbe6b) || 1) && $this->valueHolder9cd4c = $valueHolder9cd4c;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder9cd4c;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder9cd4c;
    }
}

if (!\class_exists('SubrequestExtension_ac4dffd', false)) {
    \class_alias(__NAMESPACE__.'\\SubrequestExtension_ac4dffd', 'SubrequestExtension_ac4dffd', false);
}
