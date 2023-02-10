<?php

/**
 * Fields Summary:
 * - ModelName [input]
 * - ProductType [select]
 * - Quantity [quantityValue]
 * - MaximumShelfLife [input]
 * - Nutrient [input]
 * - Form [input]
 * - Organic [booleanSelect]
 * - DietaryPreferance [booleanSelect]
 * - ContainerType [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class SugarJaggeryAndSalt extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "SugarJaggeryAndSalt";
protected $ModelName;
protected $ProductType;
protected $Quantity;
protected $MaximumShelfLife;
protected $Nutrient;
protected $Form;
protected $Organic;
protected $DietaryPreferance;
protected $ContainerType;


/**
* SugarJaggeryAndSalt constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setModelName (?string $ModelName)
{
	$this->ModelName = $ModelName;

	return $this;
}

/**
* Get ProductType - ProductType
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
* Set ProductType - ProductType
* @param string|null $ProductType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setQuantity (?\Pimcore\Model\DataObject\Data\QuantityValue $Quantity)
{
	$this->Quantity = $Quantity;

	return $this;
}

/**
* Get MaximumShelfLife - Maximum Shelf Life
* @return string|null
*/
public function getMaximumShelfLife(): ?string
{
	$data = $this->MaximumShelfLife;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("MaximumShelfLife")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("MaximumShelfLife");
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
* Set MaximumShelfLife - Maximum Shelf Life
* @param string|null $MaximumShelfLife
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setMaximumShelfLife (?string $MaximumShelfLife)
{
	$this->MaximumShelfLife = $MaximumShelfLife;

	return $this;
}

/**
* Get Nutrient - Nutrient
* @return string|null
*/
public function getNutrient(): ?string
{
	$data = $this->Nutrient;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Nutrient")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Nutrient");
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
* Set Nutrient - Nutrient
* @param string|null $Nutrient
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setNutrient (?string $Nutrient)
{
	$this->Nutrient = $Nutrient;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setForm (?string $Form)
{
	$this->Form = $Form;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setOrganic (?bool $Organic)
{
	$this->Organic = $Organic;

	return $this;
}

/**
* Get DietaryPreferance - Dietary Preferance
* @return bool|null
*/
public function getDietaryPreferance(): ?bool
{
	$data = $this->DietaryPreferance;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("DietaryPreferance")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("DietaryPreferance");
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
* Set DietaryPreferance - Dietary Preferance
* @param bool|null $DietaryPreferance
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setDietaryPreferance (?bool $DietaryPreferance)
{
	$this->DietaryPreferance = $DietaryPreferance;

	return $this;
}

/**
* Get ContainerType - Container Type
* @return string|null
*/
public function getContainerType(): ?string
{
	$data = $this->ContainerType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ContainerType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ContainerType");
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
* Set ContainerType - Container Type
* @param string|null $ContainerType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt
*/
public function setContainerType (?string $ContainerType)
{
	$this->ContainerType = $ContainerType;

	return $this;
}

}

