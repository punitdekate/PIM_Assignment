<?php

namespace Pimcore\Model\DataObject\ChocolateFlavour;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\ChocolateFlavour|false current()
 * @method DataObject\ChocolateFlavour[] load()
 * @method DataObject\ChocolateFlavour[] getData()
 * @method DataObject\ChocolateFlavour[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "19";
protected $className = "ChocolateFlavour";


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
