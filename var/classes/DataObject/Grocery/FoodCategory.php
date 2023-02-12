<?php

namespace Pimcore\Model\DataObject\Grocery;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class FoodCategory extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['Baking','Biscuits','ChocolateSweet','Coffee','DalAndPules','GheeAndOils','JamsHoney','Juices','Namkeen','Pasta','RiceAndRiceProducts','Spreads','SugarJaggeryAndSalt','Tea','Water'];


protected $Baking = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Baking|null
*/
public function getBaking(bool $includeDeletedBricks = false)
{
	if(!$this->Baking && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getBaking($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setBaking($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Baking) &&
		$this->Baking->getDoDelete()) {
			return null;
	}
	return $this->Baking;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Baking $Baking
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setBaking($Baking)
{
	$this->Baking = $Baking;
	return $this;
}

protected $Biscuits = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits|null
*/
public function getBiscuits(bool $includeDeletedBricks = false)
{
	if(!$this->Biscuits && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getBiscuits($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setBiscuits($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Biscuits) &&
		$this->Biscuits->getDoDelete()) {
			return null;
	}
	return $this->Biscuits;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits $Biscuits
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setBiscuits($Biscuits)
{
	$this->Biscuits = $Biscuits;
	return $this;
}

protected $ChocolateSweet = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet|null
*/
public function getChocolateSweet(bool $includeDeletedBricks = false)
{
	if(!$this->ChocolateSweet && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getChocolateSweet($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setChocolateSweet($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->ChocolateSweet) &&
		$this->ChocolateSweet->getDoDelete()) {
			return null;
	}
	return $this->ChocolateSweet;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\ChocolateSweet $ChocolateSweet
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setChocolateSweet($ChocolateSweet)
{
	$this->ChocolateSweet = $ChocolateSweet;
	return $this;
}

protected $Coffee = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Coffee|null
*/
public function getCoffee(bool $includeDeletedBricks = false)
{
	if(!$this->Coffee && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getCoffee($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setCoffee($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Coffee) &&
		$this->Coffee->getDoDelete()) {
			return null;
	}
	return $this->Coffee;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Coffee $Coffee
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setCoffee($Coffee)
{
	$this->Coffee = $Coffee;
	return $this;
}

protected $DalAndPules = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPules|null
*/
public function getDalAndPules(bool $includeDeletedBricks = false)
{
	if(!$this->DalAndPules && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getDalAndPules($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setDalAndPules($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->DalAndPules) &&
		$this->DalAndPules->getDoDelete()) {
			return null;
	}
	return $this->DalAndPules;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\DalAndPules $DalAndPules
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setDalAndPules($DalAndPules)
{
	$this->DalAndPules = $DalAndPules;
	return $this;
}

protected $GheeAndOils = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils|null
*/
public function getGheeAndOils(bool $includeDeletedBricks = false)
{
	if(!$this->GheeAndOils && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getGheeAndOils($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setGheeAndOils($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->GheeAndOils) &&
		$this->GheeAndOils->getDoDelete()) {
			return null;
	}
	return $this->GheeAndOils;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\GheeAndOils $GheeAndOils
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setGheeAndOils($GheeAndOils)
{
	$this->GheeAndOils = $GheeAndOils;
	return $this;
}

protected $JamsHoney = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney|null
*/
public function getJamsHoney(bool $includeDeletedBricks = false)
{
	if(!$this->JamsHoney && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getJamsHoney($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setJamsHoney($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->JamsHoney) &&
		$this->JamsHoney->getDoDelete()) {
			return null;
	}
	return $this->JamsHoney;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\JamsHoney $JamsHoney
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setJamsHoney($JamsHoney)
{
	$this->JamsHoney = $JamsHoney;
	return $this;
}

protected $Juices = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices|null
*/
public function getJuices(bool $includeDeletedBricks = false)
{
	if(!$this->Juices && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getJuices($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setJuices($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Juices) &&
		$this->Juices->getDoDelete()) {
			return null;
	}
	return $this->Juices;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Juices $Juices
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setJuices($Juices)
{
	$this->Juices = $Juices;
	return $this;
}

protected $Namkeen = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Namkeen|null
*/
public function getNamkeen(bool $includeDeletedBricks = false)
{
	if(!$this->Namkeen && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getNamkeen($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setNamkeen($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Namkeen) &&
		$this->Namkeen->getDoDelete()) {
			return null;
	}
	return $this->Namkeen;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Namkeen $Namkeen
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setNamkeen($Namkeen)
{
	$this->Namkeen = $Namkeen;
	return $this;
}

protected $Pasta = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Pasta|null
*/
public function getPasta(bool $includeDeletedBricks = false)
{
	if(!$this->Pasta && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getPasta($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setPasta($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Pasta) &&
		$this->Pasta->getDoDelete()) {
			return null;
	}
	return $this->Pasta;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Pasta $Pasta
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setPasta($Pasta)
{
	$this->Pasta = $Pasta;
	return $this;
}

protected $RiceAndRiceProducts = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts|null
*/
public function getRiceAndRiceProducts(bool $includeDeletedBricks = false)
{
	if(!$this->RiceAndRiceProducts && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getRiceAndRiceProducts($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setRiceAndRiceProducts($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->RiceAndRiceProducts) &&
		$this->RiceAndRiceProducts->getDoDelete()) {
			return null;
	}
	return $this->RiceAndRiceProducts;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\RiceAndRiceProducts $RiceAndRiceProducts
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setRiceAndRiceProducts($RiceAndRiceProducts)
{
	$this->RiceAndRiceProducts = $RiceAndRiceProducts;
	return $this;
}

protected $Spreads = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Spreads|null
*/
public function getSpreads(bool $includeDeletedBricks = false)
{
	if(!$this->Spreads && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getSpreads($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setSpreads($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Spreads) &&
		$this->Spreads->getDoDelete()) {
			return null;
	}
	return $this->Spreads;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Spreads $Spreads
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setSpreads($Spreads)
{
	$this->Spreads = $Spreads;
	return $this;
}

protected $SugarJaggeryAndSalt = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt|null
*/
public function getSugarJaggeryAndSalt(bool $includeDeletedBricks = false)
{
	if(!$this->SugarJaggeryAndSalt && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getSugarJaggeryAndSalt($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setSugarJaggeryAndSalt($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->SugarJaggeryAndSalt) &&
		$this->SugarJaggeryAndSalt->getDoDelete()) {
			return null;
	}
	return $this->SugarJaggeryAndSalt;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\SugarJaggeryAndSalt $SugarJaggeryAndSalt
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setSugarJaggeryAndSalt($SugarJaggeryAndSalt)
{
	$this->SugarJaggeryAndSalt = $SugarJaggeryAndSalt;
	return $this;
}

protected $Tea = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea|null
*/
public function getTea(bool $includeDeletedBricks = false)
{
	if(!$this->Tea && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getTea($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setTea($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Tea) &&
		$this->Tea->getDoDelete()) {
			return null;
	}
	return $this->Tea;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Tea $Tea
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setTea($Tea)
{
	$this->Tea = $Tea;
	return $this;
}

protected $Water = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Water|null
*/
public function getWater(bool $includeDeletedBricks = false)
{
	if(!$this->Water && \Pimcore\Model\DataObject::doGetInheritedValues($this->getObject())) { 
		try {
			$brickContainer = $this->getObject()->getValueFromParent("FoodCategory");
			if(!empty($brickContainer)) {
				//check if parent object has brick, and if so, create an empty brick to enable inheritance
				$parentBrick = $this->getObject()->getValueFromParent("FoodCategory")->getWater($includeDeletedBricks);
				if (!empty($parentBrick)) {
					$brickType = "\\Pimcore\\Model\\DataObject\\Objectbrick\\Data\\" . ucfirst($parentBrick->getType());
					$brick = new $brickType($this->getObject());
					$brick->setFieldname("FoodCategory");
					$this->setWater($brick);
					return $brick;
				}
			}
		} catch (InheritanceParentNotFoundException $e) {
			// no data from parent available, continue ...
		}
	}
	if(!$includeDeletedBricks &&
		isset($this->Water) &&
		$this->Water->getDoDelete()) {
			return null;
	}
	return $this->Water;
}

/**
* @param \Pimcore\Model\DataObject\Objectbrick\Data\Water $Water
* @return \Pimcore\Model\DataObject\Grocery\FoodCategory
*/
public function setWater($Water)
{
	$this->Water = $Water;
	return $this;
}

}

