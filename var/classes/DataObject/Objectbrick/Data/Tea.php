<?php

/**
 * Fields Summary:
 * - ItemId [input]
 * - Name [input]
 * - TeaType [select]
 * - Flavour [select]
 * - Weight [quantityValue]
 * - PackOff [slider]
 * - ShelfLife [quantityValue]
 * - Ingrediant [textarea]
 * - ContainerType [select]
 * - EAN [input]
 */

namespace Pimcore\Model\DataObject\Objectbrick\Data;

use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;


class Tea extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "Tea";
protected $ItemId;
protected $Name;
protected $TeaType;
protected $Flavour;
protected $Weight;
protected $PackOff;
protected $ShelfLife;
protected $Ingrediant;
protected $ContainerType;
protected $EAN;


/**
* Tea constructor.
* @param DataObject\Concrete $object
*/
public function __construct(DataObject\Concrete $object)
{
	parent::__construct($object);
	$this->markFieldDirty("_self");
}


/**
* Get ItemId - Item Id
* @return string|null
*/
public function getItemId(): ?string
{
	$data = $this->ItemId;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ItemId")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ItemId");
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
* Set ItemId - Item Id
* @param string|null $ItemId
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setItemId (?string $ItemId)
{
	$this->ItemId = $ItemId;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setName (?string $Name)
{
	$this->Name = $Name;

	return $this;
}

/**
* Get TeaType - TeaType
* @return string|null
*/
public function getTeaType(): ?string
{
	$data = $this->TeaType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("TeaType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("TeaType");
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
* Set TeaType - TeaType
* @param string|null $TeaType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setTeaType (?string $TeaType)
{
	$this->TeaType = $TeaType;

	return $this;
}

/**
* Get Flavour - Flavour
* @return string|null
*/
public function getFlavour(): ?string
{
	$data = $this->Flavour;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Flavour")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Flavour");
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
* Set Flavour - Flavour
* @param string|null $Flavour
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setFlavour (?string $Flavour)
{
	$this->Flavour = $Flavour;

	return $this;
}

/**
* Get Weight - Weight
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getWeight(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	$data = $this->Weight;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Weight")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Weight");
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
* Set Weight - Weight
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $Weight
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setWeight (?\Pimcore\Model\DataObject\Data\QuantityValue $Weight)
{
	$this->Weight = $Weight;

	return $this;
}

/**
* Get PackOff - Pack Off
* @return float|null
*/
public function getPackOff(): ?float
{
	$data = $this->PackOff;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("PackOff")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("PackOff");
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
* Set PackOff - Pack Off
* @param float|null $PackOff
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setPackOff (?float $PackOff)
{
	$this->PackOff = $PackOff;

	return $this;
}

/**
* Get ShelfLife - Shelf Life
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getShelfLife(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	$data = $this->ShelfLife;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("ShelfLife")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("ShelfLife");
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
* Set ShelfLife - Shelf Life
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $ShelfLife
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setShelfLife (?\Pimcore\Model\DataObject\Data\QuantityValue $ShelfLife)
{
	$this->ShelfLife = $ShelfLife;

	return $this;
}

/**
* Get Ingrediant - Ingrediant
* @return string|null
*/
public function getIngrediant(): ?string
{
	$data = $this->Ingrediant;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("Ingrediant")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("Ingrediant");
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
* Set Ingrediant - Ingrediant
* @param string|null $Ingrediant
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setIngrediant (?string $Ingrediant)
{
	$this->Ingrediant = $Ingrediant;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setContainerType (?string $ContainerType)
{
	$this->ContainerType = $ContainerType;

	return $this;
}

/**
* Get EAN - E A N
* @return string|null
*/
public function getEAN(): ?string
{
	$data = $this->EAN;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("EAN")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("EAN");
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
* Set EAN - E A N
* @param string|null $EAN
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea
*/
public function setEAN (?string $EAN)
{
	$this->EAN = $EAN;

	return $this;
}

}

