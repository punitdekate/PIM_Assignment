<?php

/**
 * Fields Summary:
 * - ModelName [input]
 * - RiceType [select]
 * - Color [select]
 * - Quantity [quantityValue]
 * - GrainSize [slider]
 * - MaximumShelfLife [input]
 * - Nutrient [input]
 * - ContainerType [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class RiceAndRiceProducts extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "RiceAndRiceProducts";
protected $ModelName;
protected $RiceType;
protected $Color;
protected $Quantity;
protected $GrainSize;
protected $MaximumShelfLife;
protected $Nutrient;
protected $ContainerType;


/**
* RiceAndRiceProducts constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setModelName (?string $ModelName)
{
	$this->ModelName = $ModelName;

	return $this;
}

/**
* Get RiceType - Rice Type
* @return string|null
*/
public function getRiceType(): ?string
{
	$data = $this->RiceType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("RiceType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("RiceType");
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
* Set RiceType - Rice Type
* @param string|null $RiceType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setRiceType (?string $RiceType)
{
	$this->RiceType = $RiceType;

	return $this;
}

/**
* Get Color - Color
* @return string|null
*/
public function getColor(): ?string
{
	$data = $this->Color;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Color")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Color");
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
* Set Color - Color
* @param string|null $Color
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setColor (?string $Color)
{
	$this->Color = $Color;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setQuantity (?\Pimcore\Model\DataObject\Data\QuantityValue $Quantity)
{
	$this->Quantity = $Quantity;

	return $this;
}

/**
* Get GrainSize - Grain Size(mm)
* @return float|null
*/
public function getGrainSize(): ?float
{
	$data = $this->GrainSize;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("GrainSize")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("GrainSize");
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
* Set GrainSize - Grain Size(mm)
* @param float|null $GrainSize
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setGrainSize (?float $GrainSize)
{
	$this->GrainSize = $GrainSize;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setNutrient (?string $Nutrient)
{
	$this->Nutrient = $Nutrient;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts
*/
public function setContainerType (?string $ContainerType)
{
	$this->ContainerType = $ContainerType;

	return $this;
}

}

