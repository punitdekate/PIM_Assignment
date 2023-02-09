<?php

/**
 * Fields Summary:
 * - ItemId [input]
 * - Name [input]
 * - tasteType [select]
 * - BiscuitType [select]
 * - Flavour [select]
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


class Biscuits extends DataObject\Objectbrick\Data\AbstractData
{
protected $type = "Biscuits";
protected $ItemId;
protected $Name;
protected $tasteType;
protected $BiscuitType;
protected $Flavour;
protected $Weight;
protected $QuantityOfItem;
protected $PackOff;
protected $ShelfLife;
protected $Ingrediant;
protected $ContainerType;
protected $EAN;


/**
* Biscuits constructor.
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
*/
public function setName (?string $Name)
{
	$this->Name = $Name;

	return $this;
}

/**
* Get tasteType - Taste Type
* @return string|null
*/
public function getTasteType(): ?string
{
	$data = $this->tasteType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("tasteType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("tasteType");
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
* Set tasteType - Taste Type
* @param string|null $tasteType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
*/
public function setTasteType (?string $tasteType)
{
	$this->tasteType = $tasteType;

	return $this;
}

/**
* Get BiscuitType - BiscuitType
* @return string|null
*/
public function getBiscuitType(): ?string
{
	$data = $this->BiscuitType;
	if(\Pimcore\Model\DataObject::doGetInheritedValues($this->getObject()) && $this->getDefinition()->getFieldDefinition("BiscuitType")->isEmpty($data)) {
		try {
			return $this->getValueFromParent("BiscuitType");
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
* Set BiscuitType - BiscuitType
* @param string|null $BiscuitType
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
*/
public function setBiscuitType (?string $BiscuitType)
{
	$this->BiscuitType = $BiscuitType;

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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
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
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits
*/
public function setEAN (?string $EAN)
{
	$this->EAN = $EAN;

	return $this;
}

}

