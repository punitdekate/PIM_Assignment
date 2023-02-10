<?php

namespace Pimcore\Model\DataObject\PastaFlavour;

use Pimcore\Model;
use Pimcore\Model\DataObject;

/**
 * @method DataObject\PastaFlavour|false current()
 * @method DataObject\PastaFlavour[] load()
 * @method DataObject\PastaFlavour[] getData()
 * @method DataObject\PastaFlavour[] getObjects()
 */

class Listing extends DataObject\Listing\Concrete
{
protected $classId = "20";
protected $className = "PastaFlavour";


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
