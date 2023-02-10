<?php

/**
 * Fields Summary:
 * - itemid [input]
 * - Name [input]
 * - types [multiselect]
 * - typ [select]
 * - ingredients [textarea]
 * - packOf [slider]
 * - containerType [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class ChocolateSweet extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "ChocolateSweet";
protected $itemid;
protected $Name;
protected $types;
protected $typ;
protected $ingredients;
protected $packOf;
protected $containerType;


/**
* ChocolateSweet constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
*/
public function setTypes (?array $types)
{
	$this->types = $types;

	return $this;
}

/**
* Get typ - Typ
* @return string|null
*/
public function getTyp(): ?string
{
	$data = $this->typ;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("typ")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("typ");
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
* Set typ - Typ
* @param string|null $typ
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
*/
public function setTyp (?string $typ)
{
	$this->typ = $typ;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
*/
public function setIngredients (?string $ingredients)
{
	$this->ingredients = $ingredients;

	return $this;
}

/**
* Get packOf - Pack Of
* @return float|null
*/
public function getPackOf(): ?float
{
	$data = $this->packOf;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("packOf")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("packOf");
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
* Set packOf - Pack Of
* @param float|null $packOf
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
*/
public function setPackOf (?float $packOf)
{
	$this->packOf = $packOf;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet
*/
public function setContainerType (?string $containerType)
{
	$this->containerType = $containerType;

	return $this;
}

}

