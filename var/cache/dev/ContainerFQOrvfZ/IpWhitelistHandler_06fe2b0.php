<?php

namespace ContainerFQOrvfZ;
include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/TwoFactor/Handler/AuthenticationHandlerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/scheb/2fa-bundle/Security/TwoFactor/Handler/IpWhitelistHandler.php';

class IpWhitelistHandler_06fe2b0 extends \Scheb\TwoFactorBundle\Security\TwoFactor\Handler\IpWhitelistHandler implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Scheb\TwoFactorBundle\Security\TwoFactor\Handler\IpWhitelistHandler|null wrapped object, if the proxy is initialized
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

    public function beginTwoFactorAuthentication(\Scheb\TwoFactorBundle\Security\TwoFactor\AuthenticationContextInterface $context) : \Symfony\Component\Security\Core\Authentication\Token\TokenInterface
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, 'beginTwoFactorAuthentication', array('context' => $context), $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        return $this->valueHolder839a3->beginTwoFactorAuthentication($context);
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

        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Handler\IpWhitelistHandler $instance) {
            unset($instance->authenticationHandler, $instance->ipWhitelistProvider);
        }, $instance, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler')->__invoke($instance);

        $instance->initializeref79f = $initializer;

        return $instance;
    }

    public function __construct(\Scheb\TwoFactorBundle\Security\TwoFactor\Handler\AuthenticationHandlerInterface $authenticationHandler, \Scheb\TwoFactorBundle\Security\TwoFactor\IpWhitelist\IpWhitelistProviderInterface $ipWhitelistProvider)
    {
        static $reflection;

        if (! $this->valueHolder839a3) {
            $reflection = $reflection ?? new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler');
            $this->valueHolder839a3 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Handler\IpWhitelistHandler $instance) {
            unset($instance->authenticationHandler, $instance->ipWhitelistProvider);
        }, $this, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler')->__invoke($this);

        }

        $this->valueHolder839a3->__construct($authenticationHandler, $ipWhitelistProvider);
    }

    public function & __get($name)
    {
        $this->initializeref79f && ($this->initializeref79f->__invoke($valueHolder839a3, $this, '__get', ['name' => $name], $this->initializeref79f) || 1) && $this->valueHolder839a3 = $valueHolder839a3;

        if (isset(self::$publicPropertiese8260[$name])) {
            return $this->valueHolder839a3->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler');

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

        $realInstanceReflection = new \ReflectionClass('Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler');

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
        \Closure::bind(function (\Scheb\TwoFactorBundle\Security\TwoFactor\Handler\IpWhitelistHandler $instance) {
            unset($instance->authenticationHandler, $instance->ipWhitelistProvider);
        }, $this, 'Scheb\\TwoFactorBundle\\Security\\TwoFactor\\Handler\\IpWhitelistHandler')->__invoke($this);
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

if (!\class_exists('IpWhitelistHandler_06fe2b0', false)) {
    \class_alias(__NAMESPACE__.'\\IpWhitelistHandler_06fe2b0', 'IpWhitelistHandler_06fe2b0', false);
}