<?php

namespace Pimcore\Model\DataObject\Brands;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Brands|false current()
 * @method DataObject\Brands[] load()
 * @method DataObject\Brands[] getData()
 * @method DataObject\Brands[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "2";
protected $className = "Brands";


/**
* Filter by BrandId (Brand Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByBrandId ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("BrandId")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Name (Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByName ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Name")->addListingFilter($this, $data, $operator);
	return $this;
}

/**
* Filter by Logo (Logo)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByLogo ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("Logo")->addListingFilter($this, $data, $operator);
	return $this;
}



}
