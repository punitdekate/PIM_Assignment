<?php

namespace Pimcore\Model\DataObject\Grocery;

use Pimcore\Model\DataObject\Exception\InheritanceParentNotFoundException;

class FoodCategory extends \Pimcore\Model\DataObject\Objectbrick {

protected $brickGetters = ['Biscuits','Coffee','Juices','Namkeen','Tea','Water'];


protected $Biscuits = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Biscuits|null
*/
public function getBiscuits(bool $includeDeletedBricks = false)
{
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

protected $Coffee = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Coffee|null
*/
public function getCoffee(bool $includeDeletedBricks = false)
{
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

protected $Juices = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Juices|null
*/
public function getJuices(bool $includeDeletedBricks = false)
{
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

protected $Tea = null;

/**
* @return \Pimcore\Model\DataObject\Objectbrick\Data\Tea|null
*/
public function getTea(bool $includeDeletedBricks = false)
{
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

