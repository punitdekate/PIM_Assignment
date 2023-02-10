<?php

namespace ContainerYoCZ7ow;
include_once \dirname(__DIR__, 4).'/vendor/pimcore/pimcore/lib/Twig/Extension/SubrequestExtension.php';

class SubrequestExtension_ac4dffd extends \Pimcore\Twig\Extension\SubrequestExtension implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Pimcore\Twig\Extension\SubrequestExtension|null wrapped object, if the proxy is initialized
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

    public function getFunctions() : array
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getFunctions', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getFunctions();
    }

    public function getTokenParsers()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getTokenParsers', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getTokenParsers();
    }

    public function getNodeVisitors()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getNodeVisitors', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getNodeVisitors();
    }

    public function getFilters()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getFilters', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getFilters();
    }

    public function getTests()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getTests', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getTests();
    }

    public function getOperators()
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'getOperators', array(), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->getOperators();
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

        $instance->initializeref79f = $initializer;

        return $instance;
    }

    public function __construct(\Pimcore\Twig\Extension\Templating\Inc $incHelper)
    {
        static $reflection;

        if (! $this->valueHolder839a3) {
            $reflection = $reflection ?? new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');
            $this->valueHolder839a3 = $reflection->newInstanceWithoutConstructor();
        unset($this->incHelper);

        }

        $this->valueHolder839a3->__construct($incHelper);
    }

    public function & __get($name)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__get', ['name' => $name], $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        if (isset(self::$publicPropertiese8260[$name])) {
            return $this->valueHolder839a3->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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

        $realInstanceReflection = new \ReflectionClass('Pimcore\\Twig\\Extension\\SubrequestExtension');

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
        unset($this->incHelper);
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

if (!\class_exists('SubrequestExtension_ac4dffd', false)) {
    \class_alias(__NAMESPACE__.'\\SubrequestExtension_ac4dffd', 'SubrequestExtension_ac4dffd', false);
}
