<?php

namespace Pimcore\Model\DataObject\Grocery;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Grocery|false current()
 * @method DataObject\Grocery[] load()
 * @method DataObject\Grocery[] getData()
 * @method DataObject\Grocery[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "1";
protected $className = "Grocery";


/**
* Filter by SKU (S K U)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterBySKU ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("SKU")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Description (Description)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByDescription ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Description")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Brands (Brands)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByBrands ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Brands")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by FoodType (Food   Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByFoodType ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("FoodType")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Category (Category)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByCategory ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Category")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by MainImage (Main Image)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByMainImage ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("MainImage")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by SellerRelation (Seller Relation)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterBySellerRelation ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("SellerRelation")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by PackerRelation (Packer Relation)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByPackerRelation ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("PackerRelation")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by ManufacutureDate (Manufacuture Date)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByManufacutureDate ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ManufacutureDate")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by ExpiryDate (Expiry Date)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByExpiryDate ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ExpiryDate")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by ManufactureRelation (Manufacture Relation)
* @param mixed $data
* @param string $operator SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByManufactureRelation ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ManufactureRelation")->addListingFilter($this, $data, $operator);
	return $this;
}



}
