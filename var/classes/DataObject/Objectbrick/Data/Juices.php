<?php

/**
 * Fields Summary:
 * - ItemId [input]
 * - Name [input]
 * - JuiceType [select]
 * - Flavour [select]
 * - IsPulpy [booleanSelect]
 * - Weight [quantityValue]
 * - QuantityOfItem [numeric]
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


class Juices extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "Juices";
protected $ItemId;
protected $Name;
protected $JuiceType;
protected $Flavour;
protected $IsPulpy;
protected $Weight;
protected $QuantityOfItem;
protected $PackOff;
protected $ShelfLife;
protected $Ingrediant;
protected $ContainerType;
protected $EAN;


/**
* Juices constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setName (?string $Name)
{
	$this->Name = $Name;

	return $this;
}

/**
* Get JuiceType - JuiceType
* @return string|null
*/
public function getJuiceType(): ?string
{
	$data = $this->JuiceType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("JuiceType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("JuiceType");
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
* Set JuiceType - JuiceType
* @param string|null $JuiceType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setJuiceType (?string $JuiceType)
{
	$this->JuiceType = $JuiceType;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setFlavour (?string $Flavour)
{
	$this->Flavour = $Flavour;

	return $this;
}

/**
* Get IsPulpy - IsPulpy
* @return bool|null
*/
public function getIsPulpy(): ?bool
{
	$data = $this->IsPulpy;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("IsPulpy")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("IsPulpy");
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
* Set IsPulpy - IsPulpy
* @param bool|null $IsPulpy
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setIsPulpy (?bool $IsPulpy)
{
	$this->IsPulpy = $IsPulpy;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setWeight (?\Pimcore\Model\DataObject\Data\QuantityValue $Weight)
{
	$this->Weight = $Weight;

	return $this;
}

/**
* Get QuantityOfItem - Quantity Of Item
* @return float|null
*/
public function getQuantityOfItem(): ?float
{
	$data = $this->QuantityOfItem;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("QuantityOfItem")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("QuantityOfItem");
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
* Set QuantityOfItem - Quantity Of Item
* @param float|null $QuantityOfItem
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setQuantityOfItem (?float $QuantityOfItem)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Numeric $fd */
	$fd = $this->getDefinition()->getFieldDefinition("QuantityOfItem");
	$this->QuantityOfItem = $fd->preSetData($this, $QuantityOfItem);
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices
*/
public function setEAN (?string $EAN)
{
	$this->EAN = $EAN;

	return $this;
}

}

