<?php

/**
 * Fields Summary:
 * - itemid [input]
 * - Name [input]
 * - products [multiselect]
 * - weight [quantityValue]
 * - packOff [slider]
 * - flavour [select]
 * - form [select]
 * - ingredients [textarea]
 * - containerType [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class Baking extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "Baking";
protected $itemid;
protected $Name;
protected $products;
protected $weight;
protected $packOff;
protected $flavour;
protected $form;
protected $ingredients;
protected $containerType;


/**
* Baking constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setName (?string $Name)
{
	$this->Name = $Name;

	return $this;
}

/**
* Get products - 
* @return string[]|null
*/
public function getProducts(): ?array
{
	$data = $this->products;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("products")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("products");
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
* Set products - 
* @param string[]|null $products
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setProducts (?array $products)
{
	$this->products = $products;

	return $this;
}

/**
* Get weight - Weight
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getWeight(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	$data = $this->weight;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("weight")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("weight");
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
* Set weight - Weight
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $weight
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setWeight (?\Pimcore\Model\DataObject\Data\QuantityValue $weight)
{
	$this->weight = $weight;

	return $this;
}

/**
* Get packOff - Pack Off
* @return float|null
*/
public function getPackOff(): ?float
{
	$data = $this->packOff;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("packOff")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("packOff");
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
* Set packOff - Pack Off
* @param float|null $packOff
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setPackOff (?float $packOff)
{
	$this->packOff = $packOff;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setFlavour (?string $flavour)
{
	$this->flavour = $flavour;

	return $this;
}

/**
* Get form - Form
* @return string|null
*/
public function getForm(): ?string
{
	$data = $this->form;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("form")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("form");
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
* Set form - Form
* @param string|null $form
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setForm (?string $form)
{
	$this->form = $form;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setIngredients (?string $ingredients)
{
	$this->ingredients = $ingredients;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking
*/
public function setContainerType (?string $containerType)
{
	$this->containerType = $containerType;

	return $this;
}

}

