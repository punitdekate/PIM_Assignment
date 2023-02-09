<?php

namespace Pimcore\Model\DataObject\JuiceFlavour;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\JuiceFlavour|false current()
 * @method DataObject\JuiceFlavour[] load()
 * @method DataObject\JuiceFlavour[] getData()
 * @method DataObject\JuiceFlavour[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "16";
protected $className = "JuiceFlavour";


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
