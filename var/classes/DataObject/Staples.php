<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - DalsAndPulses [objectbricks]
 * - RiceAndRiceProducts [objectbricks]
 * - OilsAndGhee [objectbricks]
 * - SaltSugarAndJaggery [objectbricks]
 */

namespace Pimcore\Model\DataObject;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;
use Pimcore\Model\DataObject\PreGetValueHookInterface;

/**
* @method static \Pimcore\Model\DataObject\Staples\Listing getList(array $config = [])
*/

class Staples extends Concrete
{
protected $o_classId = "1";
protected $o_className = "Staples";
protected $DalsAndPulses;
protected $RiceAndRiceProducts;
protected $OilsAndGhee;
protected $SaltSugarAndJaggery;


/**
* @param array $values
* @return \Pimcore\Model\DataObject\Staples
*/
public static function create($values = array()) {
	$object = new static();
	$object->setValues($values);
	return $object;
}

/**
* @return \Pimcore\Model\DataObject\Staples\DalsAndPulses
*/
public function getDalsAndPulses(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->DalsAndPulses;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Staples\\DalsAndPulses")) {
			$data = new \Pimcore\Model\DataObject\Staples\DalsAndPulses($this, "DalsAndPulses");
			$this->DalsAndPulses = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("DalsAndPulses");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set DalsAndPulses - Dals And Pulses
* @param \Pimcore\Model\DataObject\Objectbrick|null $DalsAndPulses
* @return \Pimcore\Model\DataObject\Staples
*/
public function setDalsAndPulses(?\Pimcore\Model\DataObject\Objectbrick $DalsAndPulses)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("DalsAndPulses");
	$this->DalsAndPulses = $fd->preSetData($this, $DalsAndPulses);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Staples\RiceAndRiceProducts
*/
public function getRiceAndRiceProducts(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->RiceAndRiceProducts;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Staples\\RiceAndRiceProducts")) {
			$data = new \Pimcore\Model\DataObject\Staples\RiceAndRiceProducts($this, "RiceAndRiceProducts");
			$this->RiceAndRiceProducts = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("RiceAndRiceProducts");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set RiceAndRiceProducts - Rice And Rice Products
* @param \Pimcore\Model\DataObject\Objectbrick|null $RiceAndRiceProducts
* @return \Pimcore\Model\DataObject\Staples
*/
public function setRiceAndRiceProducts(?\Pimcore\Model\DataObject\Objectbrick $RiceAndRiceProducts)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("RiceAndRiceProducts");
	$this->RiceAndRiceProducts = $fd->preSetData($this, $RiceAndRiceProducts);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Staples\OilsAndGhee
*/
public function getOilsAndGhee(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->OilsAndGhee;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Staples\\OilsAndGhee")) {
			$data = new \Pimcore\Model\DataObject\Staples\OilsAndGhee($this, "OilsAndGhee");
			$this->OilsAndGhee = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("OilsAndGhee");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set OilsAndGhee - Oils And Ghee
* @param \Pimcore\Model\DataObject\Objectbrick|null $OilsAndGhee
* @return \Pimcore\Model\DataObject\Staples
*/
public function setOilsAndGhee(?\Pimcore\Model\DataObject\Objectbrick $OilsAndGhee)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("OilsAndGhee");
	$this->OilsAndGhee = $fd->preSetData($this, $OilsAndGhee);
	return $this;
}

/**
* @return \Pimcore\Model\DataObject\Staples\SaltSugarAndJaggery
*/
public function getSaltSugarAndJaggery(): ?\Pimcore\Model\DataObject\Objectbrick
{
	$data = $this->SaltSugarAndJaggery;
	if (!$data) {
		if (\Pimcore\Tool::classExists("\\Pimcore\\Model\\DataObject\\Staples\\SaltSugarAndJaggery")) {
			$data = new \Pimcore\Model\DataObject\Staples\SaltSugarAndJaggery($this, "SaltSugarAndJaggery");
			$this->SaltSugarAndJaggery = $data;
		} else {
			return null;
		}
	}
	if ($this instanceof PreGetValueHookInterface && !\Pimcore::inAdmin()) {
		$preValue = $this->preGetValue("SaltSugarAndJaggery");
		if ($preValue !== null) {
			return $preValue;
		}
	}

	return $data;
}

/**
* Set SaltSugarAndJaggery - Salt Sugar And Jaggery
* @param \Pimcore\Model\DataObject\Objectbrick|null $SaltSugarAndJaggery
* @return \Pimcore\Model\DataObject\Staples
*/
public function setSaltSugarAndJaggery(?\Pimcore\Model\DataObject\Objectbrick $SaltSugarAndJaggery)
{
	/** @var \Pimcore\Model\DataObject\ClassDefinition\Data\Objectbricks $fd */
	$fd = $this->getClass()->getFieldDefinition("SaltSugarAndJaggery");
	$this->SaltSugarAndJaggery = $fd->preSetData($this, $SaltSugarAndJaggery);
	return $this;
}

}

