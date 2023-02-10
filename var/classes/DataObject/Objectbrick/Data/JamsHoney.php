<?php

/**
 * Fields Summary:
 * - itemid [input]
 * - Name [input]
 * - types [multiselect]
 * - containerType [select]
 * - flavour [select]
 * - ingredients [textarea]
 * - quantity [quantityValue]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class JamsHoney extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "JamsHoney";
protected $itemid;
protected $Name;
protected $types;
protected $containerType;
protected $flavour;
protected $ingredients;
protected $quantity;


/**
* JamsHoney constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get itemid - Itemid
* @return string|null
*/
public function getItemid(): ?string
{
	$data = $this->itemid;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("itemid")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("itemid");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set itemid - Itemid
* @param string|null $itemid
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setItemid (?string $itemid)
{
	$this->itemid = $itemid;

	return $this;
}

/**
* Get Name - Name
* @return string|null
*/
public function getName(): ?string
{
	$data = $this->Name;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Name")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Name");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set Name - Name
* @param string|null $Name
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setName (?string $Name)
{
	$this->Name = $Name;

	return $this;
}

/**
* Get types - Types
* @return string[]|null
*/
public function getTypes(): ?array
{
	$data = $this->types;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("types")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("types");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set types - Types
* @param string[]|null $types
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setTypes (?array $types)
{
	$this->types = $types;

	return $this;
}

/**
* Get containerType - Container Type
* @return string|null
*/
public function getContainerType(): ?string
{
	$data = $this->containerType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("containerType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("containerType");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set containerType - Container Type
* @param string|null $containerType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setContainerType (?string $containerType)
{
	$this->containerType = $containerType;

	return $this;
}

/**
* Get flavour - Flavour
* @return string|null
*/
public function getFlavour(): ?string
{
	$data = $this->flavour;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("flavour")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("flavour");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set flavour - Flavour
* @param string|null $flavour
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setFlavour (?string $flavour)
{
	$this->flavour = $flavour;

	return $this;
}

/**
* Get ingredients - Ingredients
* @return string|null
*/
public function getIngredients(): ?string
{
	$data = $this->ingredients;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ingredients")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ingredients");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ingredients - Ingredients
* @param string|null $ingredients
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setIngredients (?string $ingredients)
{
	$this->ingredients = $ingredients;

	return $this;
}

/**
* Get quantity - Quantity
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getQuantity(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	$data = $this->quantity;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("quantity")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("quantity");
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set quantity - Quantity
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $quantity
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney
*/
public function setQuantity (?\Pimcore\Model\DataObject\Data\QuantityValue $quantity)
{
	$this->quantity = $quantity;

	return $this;
}

}

