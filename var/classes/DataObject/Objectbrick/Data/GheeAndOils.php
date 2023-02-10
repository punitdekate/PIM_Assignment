<?php

/**
 * Fields Summary:
 * - ModelName [input]
 * - OilType [select]
 * - Quantity [quantityValue]
 * - UsedFor [input]
 * - ProcessingType [input]
 * - MaximumShelfLife [input]
 * - FoodPreference [input]
 * - Organic [booleanSelect]
 * - AddedPreservatives [input]
 * - Ingredients [input]
 * - Nutrient [input]
 * - ContainerType [select]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class GheeAndOils extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "GheeAndOils";
protected $ModelName;
protected $OilType;
protected $Quantity;
protected $UsedFor;
protected $ProcessingType;
protected $MaximumShelfLife;
protected $FoodPreference;
protected $Organic;
protected $AddedPreservatives;
protected $Ingredients;
protected $Nutrient;
protected $ContainerType;


/**
* GheeAndOils constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setModelName (?string $ModelName)
{
	$this->ModelName = $ModelName;

	return $this;
}

/**
* Get OilType - OilType
* @return string|null
*/
public function getOilType(): ?string
{
	$data = $this->OilType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("OilType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("OilType");
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
* Set OilType - OilType
* @param string|null $OilType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setOilType (?string $OilType)
{
	$this->OilType = $OilType;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setQuantity (?\Pimcore\Model\DataObject\Data\QuantityValue $Quantity)
{
	$this->Quantity = $Quantity;

	return $this;
}

/**
* Get UsedFor - Used For
* @return string|null
*/
public function getUsedFor(): ?string
{
	$data = $this->UsedFor;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("UsedFor")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("UsedFor");
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
* Set UsedFor - Used For
* @param string|null $UsedFor
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setUsedFor (?string $UsedFor)
{
	$this->UsedFor = $UsedFor;

	return $this;
}

/**
* Get ProcessingType - Processing Type
* @return string|null
*/
public function getProcessingType(): ?string
{
	$data = $this->ProcessingType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ProcessingType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ProcessingType");
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
* Set ProcessingType - Processing Type
* @param string|null $ProcessingType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setProcessingType (?string $ProcessingType)
{
	$this->ProcessingType = $ProcessingType;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setMaximumShelfLife (?string $MaximumShelfLife)
{
	$this->MaximumShelfLife = $MaximumShelfLife;

	return $this;
}

/**
* Get FoodPreference - Food Preference
* @return string|null
*/
public function getFoodPreference(): ?string
{
	$data = $this->FoodPreference;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("FoodPreference")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("FoodPreference");
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
* Set FoodPreference - Food Preference
* @param string|null $FoodPreference
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setFoodPreference (?string $FoodPreference)
{
	$this->FoodPreference = $FoodPreference;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setOrganic (?bool $Organic)
{
	$this->Organic = $Organic;

	return $this;
}

/**
* Get AddedPreservatives - Added Preservatives
* @return string|null
*/
public function getAddedPreservatives(): ?string
{
	$data = $this->AddedPreservatives;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("AddedPreservatives")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("AddedPreservatives");
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
* Set AddedPreservatives - Added Preservatives
* @param string|null $AddedPreservatives
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setAddedPreservatives (?string $AddedPreservatives)
{
	$this->AddedPreservatives = $AddedPreservatives;

	return $this;
}

/**
* Get Ingredients - Ingredients
* @return string|null
*/
public function getIngredients(): ?string
{
	$data = $this->Ingredients;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Ingredients")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Ingredients");
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
* Set Ingredients - Ingredients
* @param string|null $Ingredients
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setIngredients (?string $Ingredients)
{
	$this->Ingredients = $Ingredients;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils
*/
public function setContainerType (?string $ContainerType)
{
	$this->ContainerType = $ContainerType;

	return $this;
}

}

