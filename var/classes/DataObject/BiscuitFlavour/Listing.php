<?php

namespace Pimcore\Model\DataObject\BiscuitFlavour;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\BiscuitFlavour|false current()
 * @method DataObject\BiscuitFlavour[] load()
 * @method DataObject\BiscuitFlavour[] getData()
 * @method DataObject\BiscuitFlavour[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "13";
protected $className = "BiscuitFlavour";


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
