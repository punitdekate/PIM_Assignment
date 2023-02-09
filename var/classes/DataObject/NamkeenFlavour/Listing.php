<?php

namespace Pimcore\Model\DataObject\NamkeenFlavour;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\NamkeenFlavour|false current()
 * @method DataObject\NamkeenFlavour[] load()
 * @method DataObject\NamkeenFlavour[] getData()
 * @method DataObject\NamkeenFlavour[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "14";
protected $className = "NamkeenFlavour";


/**
* Filter by FlavourName (Flavour Name)
* @param string|int|float|array|Model\Element\ElementInterface $data  comparison data, can be scalar or array (if operator is e.g. "IN (?)")
* @param string $operator  SQL comparison operator, e.g. =, <, >= etc. You can use "?" as placeholder, e.g. "IN (?)"
* @return static
*/
public function filterByFlavourName ($data, $operator = '=')
{
	$this->getClass()->getFieldDefinition("FlavourName")->addListingFilter($this, $data, $operator);
	return $this;
}



}
