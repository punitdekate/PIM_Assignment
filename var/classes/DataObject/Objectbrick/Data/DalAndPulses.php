<?php

/**
 * Fields Summary:
 * - ProductType [input]
 * - Quantity [quantityValue]
 * - Form [select]
 * - Polished [booleanSelect]
 * - Organic [booleanSelect]
 * - MaximumShelf [input]
 * - NutrientContent [input]
 * - ModelName [input]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class DalAndPulses extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "DalAndPulses";
protected $ProductType;
protected $Quantity;
protected $Form;
protected $Polished;
protected $Organic;
protected $MaximumShelf;
protected $NutrientContent;
protected $ModelName;


/**
* DalAndPulses constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get ProductType - Product Type
* @return string|null
*/
public function getProductType(): ?string
{
	$data = $this->ProductType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ProductType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ProductType");
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
* Set ProductType - Product Type
* @param string|null $ProductType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setProductType (?string $ProductType)
{
	$this->ProductType = $ProductType;

	return $this;
}

/**
* Get Quantity - Quantity
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getQuantity(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	$data = $this->Quantity;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Quantity")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Quantity");
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
* Set Quantity - Quantity
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $Quantity
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setQuantity (?\Pimcore\Model\DataObject\Data\QuantityValue $Quantity)
{
	$this->Quantity = $Quantity;

	return $this;
}

/**
* Get Form - Form
* @return string|null
*/
public function getForm(): ?string
{
	$data = $this->Form;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Form")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Form");
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
* Set Form - Form
* @param string|null $Form
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setForm (?string $Form)
{
	$this->Form = $Form;

	return $this;
}

/**
* Get Polished - Polished
* @return bool|null
*/
public function getPolished(): ?bool
{
	$data = $this->Polished;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Polished")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Polished");
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
* Set Polished - Polished
* @param bool|null $Polished
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setPolished (?bool $Polished)
{
	$this->Polished = $Polished;

	return $this;
}

/**
* Get Organic - Organic
* @return bool|null
*/
public function getOrganic(): ?bool
{
	$data = $this->Organic;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Organic")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Organic");
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
* Set Organic - Organic
* @param bool|null $Organic
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setOrganic (?bool $Organic)
{
	$this->Organic = $Organic;

	return $this;
}

/**
* Get MaximumShelf - Maximum Shelf
* @return string|null
*/
public function getMaximumShelf(): ?string
{
	$data = $this->MaximumShelf;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("MaximumShelf")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("MaximumShelf");
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
* Set MaximumShelf - Maximum Shelf
* @param string|null $MaximumShelf
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setMaximumShelf (?string $MaximumShelf)
{
	$this->MaximumShelf = $MaximumShelf;

	return $this;
}

/**
* Get NutrientContent - Nutrient Content
* @return string|null
*/
public function getNutrientContent(): ?string
{
	$data = $this->NutrientContent;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("NutrientContent")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("NutrientContent");
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
* Set NutrientContent - Nutrient Content
* @param string|null $NutrientContent
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setNutrientContent (?string $NutrientContent)
{
	$this->NutrientContent = $NutrientContent;

	return $this;
}

/**
* Get ModelName - Model Name
* @return string|null
*/
public function getModelName(): ?string
{
	$data = $this->ModelName;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ModelName")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ModelName");
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
* Set ModelName - Model Name
* @param string|null $ModelName
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPulses
*/
public function setModelName (?string $ModelName)
{
	$this->ModelName = $ModelName;

	return $this;
}

}

