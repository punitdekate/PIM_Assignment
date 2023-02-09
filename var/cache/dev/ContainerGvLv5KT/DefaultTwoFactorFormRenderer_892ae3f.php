<?php

namespace ContainerGvLv5KT;
include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/TwoFactor/Provider/TwoFactorFormRendererInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/TwoFactor/Provider/DefaultTwoFactorFormRenderer.php';

class DefaultTwoFactorFormRenderer_892ae3f extends \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\DefaultTwoFactorFormRenderer implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Scheb\TwoFactorBundle\Security\TwoFactor\Provider\DefaultTwoFactorFormRenderer|null wrapped object, if the proxy is initialized
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

    public function renderForm(\Symfony\Component\HttpFoundation\Request $request, array $templateVars) : \Symfony\Component\HttpFoundation\Response
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, 'renderForm', array('request' => $request, 'templateVars' => $templateVars), $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        return $this->valueHolder33f7d->renderForm($request, $templateVars);
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

        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Provider\DefaultTwoFactorFormRenderer $instance) {
            unset($instance->twigEnvironment, $instance->template, $instance->templateVars);
        }, $instance, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer')->__invoke($instance);

        $instance->initializer9d56b = $initializer;

        return $instance;
    }

    public function __construct(\Twig\Environment $twigRenderer, string $template, array $templateVars = [])
    {
        static $reflection;

        if (! $this->valueHolder33f7d) {
            $reflection = $reflection ?? new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer');
            $this->valueHolder33f7d = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Provider\DefaultTwoFactorFormRenderer $instance) {
            unset($instance->twigEnvironment, $instance->template, $instance->templateVars);
        }, $this, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer')->__invoke($this);

        }

        $this->valueHolder33f7d->__construct($twigRenderer, $template, $templateVars);
    }

    public function & __get($name)
    {
        $this->initializer9d56b && ($this->initializer9d56b->__invoke($valueHolder33f7d, $this, '__get', ['name' => $name], $this->initializer9d56b) || 1) && $this->valueHolder33f7d = $valueHolder33f7d;

        if (isset(self::$publicProperties0a12f[$name])) {
            return $this->valueHolder33f7d->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer');

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
        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Provider\DefaultTwoFactorFormRenderer $instance) {
            unset($instance->twigEnvironment, $instance->template, $instance->templateVars);
        }, $this, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Provider\\DefaultTwoFactorFormRenderer')->__invoke($this);
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

if (!\class_exists('DefaultTwoFactorFormRenderer_892ae3f', false)) {
    \class_alias(__NAMESPACE__.'\\DefaultTwoFactorFormRenderer_892ae3f', 'DefaultTwoFactorFormRenderer_892ae3f', false);
}
