<?php

namespace Pimcore\Model\DataObject\SugarProductType;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\SugarProductType|false current()
 * @method DataObject\SugarProductType[] load()
 * @method DataObject\SugarProductType[] getData()
 * @method DataObject\SugarProductType[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "24";
protected $className = "SugarProductType";


/**
* Filter by ProductType (Product Type)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByProductType ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("ProductType")->addListingFilter($this, $data, $operator);
	return $this;
}



}
