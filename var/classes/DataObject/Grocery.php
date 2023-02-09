<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - localizedfields [localizedfields]
 * -- SKU [input]
 * -- Description [textarea]
 * - FoodType [select]
 * - Price [quantityValue]
 * - ShelfLife [quantityValue]
 * - Category [select]
 * - FoodCategory [objectbricks]
 * - MainImage [image]
 * - SellerRelation [manyToManyObjectRelation]
 * - ManufacutureDate [date]
 * - ExpiryDate [date]
 * - ManufactureRelation [manyToOneRelation]
 * - PackerRelation [manyToManyObjectRelation]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Grocery\Listing getList(array $config = [])
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByLocalizedfields($field, $value, $locale = null, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getBySKU($value, $locale = null, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByDescription($value, $locale = null, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByFoodType($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByCategory($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByMainImage($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getBySellerRelation($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByManufacutureDate($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByExpiryDate($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByManufactureRelation($value, $limit = 0, $offset = 0, $objectTypes = null)
* @method static \Pimcore\Model\DataObject\Grocery\Listing|\Pimcore\Model\DataObject\Grocery|null getByPackerRelation($value, $limit = 0, $offset = 0, $objectTypes = null)
*/

class Grocery extends Concrete
{
protected $o_classId = "1";
protected $o_className = "Grocery";
protected $localizedfields;
protected $FoodType;
protected $Price;
protected $ShelfLife;
protected $Category;
protected $FoodCategory;
protected $MainImage;
protected $SellerRelation;
protected $ManufacutureDate;
protected $ExpiryDate;
protected $ManufactureRelation;
protected $PackerRelation;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Grocery
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* Get localizedfields - 
* @return \Pimcore\Model\DataObject\Localizedfield|null
*/
public function getLocalizedfields(): ?\Pimcore\Model\DataObject\Localizedfield
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("localizedfields");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("localizedfields")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Get SKU - S K U
* @return string|null
*/
public function getSKU($language = null): ?string
{
	$data = $this->getLocalizedfields()->getLocalizedValue("SKU", $language);
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("SKU");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Get Description - Description
* @return string|null
*/
public function getDescription($language = null): ?string
{
	$data = $this->getLocalizedfields()->getLocalizedValue("Description", $language);
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("Description");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set localizedfields - 
* @param \Pimcore\Model\DataObject\Localizedfield|null $localizedfields
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setLocalizedfields(?\Pimcore\Model\DataObject\Localizedfield $localizedfields)
{
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getLocalizedfields();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$this->markFieldDirty("localizedfields", true);
	$this->localizedfields = $localizedfields;

	return $this;
}

/**
* Set SKU - S K U
* @param string|null $SKU
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setSKU (?string $SKU, $language = null)
{
	$isEqual = false;
	$this->getLocalizedfields()->setLocalizedValue("SKU", $SKU, $language, !$isEqual);

	return $this;
}

/**
* Set Description - Description
* @param string|null $Description
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setDescription (?string $Description, $language = null)
{
	$isEqual = false;
	$this->getLocalizedfields()->setLocalizedValue("Description", $Description, $language, !$isEqual);

	return $this;
}

/**
* Get FoodType - Food   Type
* @return string|null
*/
public function getFoodType(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("FoodType");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->FoodType;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set FoodType - Food   Type
* @param string|null $FoodType
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setFoodType(?string $FoodType)
{
	$this->FoodType = $FoodType;

	return $this;
}

/**
* Get Price - Price
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getPrice(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("Price");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->Price;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set Price - Price
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $Price
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setPrice(?\Pimcore\Model\DataObject\Data\QuantityValue $Price)
{
	$this->Price = $Price;

	return $this;
}

/**
* Get ShelfLife - Shelf Life
* @return \Pimcore\Model\DataObject\Data\QuantityValue|null
*/
public function getShelfLife(): ?\Pimcore\Model\DataObject\Data\QuantityValue
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ShelfLife");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ShelfLife;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ShelfLife - Shelf Life
* @param \Pimcore\Model\DataObject\Data\QuantityValue|null $ShelfLife
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setShelfLife(?\Pimcore\Model\DataObject\Data\QuantityValue $ShelfLife)
{
	$this->ShelfLife = $ShelfLife;

	return $this;
}

/**
* Get Category - Category
* @return string|null
*/
public function getCategory(): ?string
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("Category");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->Category;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set Category - Category
* @param string|null $Category
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setCategory(?string $Category)
{
	$this->Category = $Category;

	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function getFoodCategory(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->FoodCategory;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Grocery\\FoodCategory")) {
			$data = new \Pimcore\Model\DataObject\Grocery\FoodCategory($this, "FoodCategory");
			$this->FoodCategory = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("FoodCategory");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set FoodCategory - Food Category
* @param \Pimcore\Model\DataObject\Objectbrick|null $FoodCategory
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setFoodCategory(?\Pimcore\Model\DataObject\Objectbrick $FoodCategory)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("FoodCategory");
	$this->FoodCategory = $fd->preSetData($this, $FoodCategory);
	return $this;
}

/**
* Get MainImage - Main Image
* @return \Pimcore\Model\Asset\Image|null
*/
public function getMainImage(): ?\Pimcore\Model\Asset\Image
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("MainImage");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->MainImage;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set MainImage - Main Image
* @param \Pimcore\Model\Asset\Image|null $MainImage
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setMainImage(?\Pimcore\Model\Asset\Image $MainImage)
{
	$this->MainImage = $MainImage;

	return $this;
}

/**
* Get SellerRelation - Seller Relation
* @return \Pimcore\Model\DataObject\Seller[]
*/
public function getSellerRelation(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("SellerRelation");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("SellerRelation")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set SellerRelation - Seller Relation
* @param \Pimcore\Model\DataObject\Seller[] $SellerRelation
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setSellerRelation(?array $SellerRelation)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("SellerRelation");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getSellerRelation();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $SellerRelation);
	if (!$isEqual) {
		$this->markFieldDirty("SellerRelation", true);
	}
	$this->SellerRelation = $fd->preSetData($this, $SellerRelation);
	return $this;
}

/**
* Get ManufacutureDate - Manufacuture Date
* @return \Carbon\Carbon|null
*/
public function getManufacutureDate(): ?\Carbon\Carbon
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ManufacutureDate");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ManufacutureDate;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ManufacutureDate - Manufacuture Date
* @param \Carbon\Carbon|null $ManufacutureDate
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setManufacutureDate(?\Carbon\Carbon $ManufacutureDate)
{
	$this->ManufacutureDate = $ManufacutureDate;

	return $this;
}

/**
* Get ExpiryDate - Expiry Date
* @return \Carbon\Carbon|null
*/
public function getExpiryDate(): ?\Carbon\Carbon
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ExpiryDate");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->ExpiryDate;

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ExpiryDate - Expiry Date
* @param \Carbon\Carbon|null $ExpiryDate
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setExpiryDate(?\Carbon\Carbon $ExpiryDate)
{
	$this->ExpiryDate = $ExpiryDate;

	return $this;
}

/**
* Get ManufactureRelation - Manufacture Relation
* @return \Pimcore\Model\DataObject\Manufacturer|null
*/
public function getManufactureRelation(): ?\Pimcore\Model\Element\AbstractElement
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("ManufactureRelation");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("ManufactureRelation")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set ManufactureRelation - Manufacture Relation
* @param \Pimcore\Model\DataObject\Manufacturer|null $ManufactureRelation
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setManufactureRelation(?\Pimcore\Model\Element\AbstractElement $ManufactureRelation)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToOneRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("ManufactureRelation");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getManufactureRelation();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $ManufactureRelation);
	if (!$isEqual) {
		$this->markFieldDirty("ManufactureRelation", true);
	}
	$this->ManufactureRelation = $fd->preSetData($this, $ManufactureRelation);
	return $this;
}

/**
* Get PackerRelation - Packer Relation
* @return \Pimcore\Model\DataObject\Packer[]
*/
public function getPackerRelation(): array
{
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("PackerRelation");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	$data = $this->getClass()->getFieldDefinition("PackerRelation")->preGetData($this);

	if ($data instanceof \Pimcore\Model\DataObject\Data\EncryptedField) {
		return $data->getPlain();
	}

	return $data;
}

/**
* Set PackerRelation - Packer Relation
* @param \Pimcore\Model\DataObject\Packer[] $PackerRelation
* @return \Pimcore\Model\DataObject\Grocery
*/
public function setPackerRelation(?array $PackerRelation)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation $fd */
	$fd = $this->getClass()->getFieldDefinition("PackerRelation");
	$hideUnpublished = \Pimcore\Model\DataObject\Concrete::getHideUnpublished();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished(false);
	$currentData = $this->getPackerRelation();
	\Pimcore\Model\DataObject\Concrete::setHideUnpublished($hideUnpublished);
	$isEqual = $fd->isEqual($currentData, $PackerRelation);
	if (!$isEqual) {
		$this->markFieldDirty("PackerRelation", true);
	}
	$this->PackerRelation = $fd->preSetData($this, $PackerRelation);
	return $this;
}

}

