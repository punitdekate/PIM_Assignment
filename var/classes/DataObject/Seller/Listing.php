<?php

namespace Pimcore\Model\DataObject\Seller;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\Seller|false current()
 * @method DataObject\Seller[] load()
 * @method DataObject\Seller[] getData()
 * @method DataObject\Seller[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "3";
protected $className = "Seller";


/**
* Filter by SellerId (Seller Id)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterBySellerId ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("SellerId")->addListingFilter($this, $data, $operator);
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



}
