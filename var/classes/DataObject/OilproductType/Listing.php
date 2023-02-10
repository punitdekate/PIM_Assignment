<?php

namespace Pimcore\Model\DataObject\OilproductType;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\OilproductType|false current()
 * @method DataObject\OilproductType[] load()
 * @method DataObject\OilproductType[] getData()
 * @method DataObject\OilproductType[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "25";
protected $className = "OilproductType";


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
