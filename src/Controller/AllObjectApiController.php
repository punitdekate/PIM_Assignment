<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Grocery;
class AllObjectApiController extends FrontendController
{
/**
    * @Route("/beveragesApi", name="beveragesApi", methods={"GET"})
    */
   
    public function beveragesApi(Request $request)
    {
    $data = new Grocery\Listing();
    foreach ($data as $key => $value) {
    $Coffee = $value->getFoodCategory()->getCoffee();
    $Tea = $value->getFoodCategory()->getTea();
    $Juice = $value->getFoodCategory()->getJuices();
    $Water = $value->getFoodCategory()->getWater();
    
    
    if ($Coffee != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Coffee->getItemId(),
    // "ItemName" => $Coffee->getName(),
    "TasteType" => $Coffee->getBeanType(),
    "BiscuitType" => $Coffee->getFormFactor(),
    "Flavour" => $Coffee->getFlavour(),
    // "Weight" => $Coffee->getWeight()->getValue(),
    "PackOff" => $Coffee->getPackOff(),
    "Ingredients" => $Coffee->getIngrediant(),
    "Container" => $Coffee->getContainerType(),
    "EAN" => $Coffee->getEAN()
    );
    } elseif ($Tea != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Tea->getItemId(),
    // "ItemName" => $Tea->getName(),
    "TasteType" => $Tea->getTeaType(),
    "Flavour" => $Tea->getFlavour(),
    // "Weight" => $Water->getWeight()->getValue(),
    "QuantityOfItem" => $Tea->getQuantityOfItem(),
    "PackOff" => $Tea->getPackOff(),
    "Ingredients" => $Tea->getIngrediant(),
    "Container" => $Tea->getContainerType(),
    "EAN" => $Tea->getEAN()
    );
    } elseif ($Juice != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Juice->getItemId(),
    // "ItemName" => $Juice->getName(),
    "TasteType" => $Juice->getJuiceType(),
    "IsPulpy" => $Juice->getIsPulpy(),
    "Flavour" => $Juice->getFlavour(),
    // "Weight" => $Water->getWeight()->getValue(),
    "PackOff" => $Juice->getPackOff(),
    "Ingredients" => $Juice->getIngrediant(),
    "Container" => $Juice->getContainerType(),
    "EAN" => $Juice->getEAN()
    );
    } elseif ($Water != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Water->getItemId(),
    // "ItemName" => $Water->getName(),
    "TasteType" => $Water->getWaterType(),
    // "Flavour" => $Water->getFlavour(),
    // "Weight" => $Water->getWeight()->getValue(),
    "PackOff" => $Water->getPackOff(),
    "Container" => $Water->getContainerType(),
    "EAN" => $Water->getEAN()
    );
    }
    $output[] = array(
    "SKU" => $value->getSKU(),
    "Description" => $value->getDescription(),
    "FoodType" => $value->getFoodType(),
    // "Price" => $value->getPrice()->getValue(),
    // "ShelfLife" => $value->getShelfLife()->getValue(),
    // "Category" => $value->getCategory(),
    "ManufacutureDate" => $value->getManufacutureDate(),
    "ExpiryDate" => $value->getExpiryDate(),
    "Snacks" => $smallOutput
    );
    $smallOutput = [];
    }
    
    return $this->json(["success" => true, "data" => $output]);
    }

    /**
    * @Route("/Snacks", name="snacksApi", methods={"GET"})
    */
    public function snacksApi(Request $request)
    {
    $data = new Grocery\Listing();
    $smallOutput = [];
    foreach ($data as $key => $value) {
    $Biscuits = $value->getFoodCategory()->getBiscuits();
    $Namkeen = $value->getFoodCategory()->getNamkeen();
    if ($Biscuits != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Biscuits->getItemId(),
    // "ItemName" => $Biscuits->getName(),
    "TasteType" => $Biscuits->getTasteType(),
    "BiscuitType" => $Biscuits->getBiscuitType(),
    "Flavour" => $Biscuits->getFlavour(),
    // "Weight" => $Biscuits->getWeight()->getValue(),
    "QuantityOfItem" => $Biscuits->getQuantityOfItem(),
    "PackOff" => $Biscuits->getPackOff(),
    "Ingredients" => $Biscuits->getIngrediant(),
    "Container" => $Biscuits->getContainerType(),
    "EAN" => $Biscuits->getEAN()
    );
    } 
    elseif ($Namkeen != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Namkeen->getItemId(),
    // "ItemName" => $Namkeen->getName(),
    "TasteType" => $Namkeen->getTasteType(),
    "BiscuitType" => $Namkeen->getSnacktype(),
    "Flavour" => $Namkeen->getFlavour(),
    // "Weight" => $Namkeen->getWeight()->getValue(),
    "QuantityOfItem" => $Namkeen->getQuantityOfItem(),
    "PackOff" => $Namkeen->getPackOff(),
    "Ingredients" => $Namkeen->getIngrediant(),
    "Container" => $Namkeen->getContainerType(),
    "EAN" => $Namkeen->getEAN()
    );
    }
    if($smallOutput!=NULL){
    $output[] = array(
    "SKU" => $value->getSKU(),
    "Description" => $value->getDescription(),
    // "FoodType" => $value->getFoodType(),
    // "Price" => $value->getPrice()->getValue(),
    // "ShelfLife" => $value->getShelfLife()->getValue(),
    // "Category" => $value->getCategory(),
    "ManufacturingDate" => $value->getManufacutureDate(),
    "ExpiryDate" => $value->getExpiryDate(),
    "Snacks" => $smallOutput
    );
    }

    }

    return $this->json(["success" => true, "data" => $output]);
    }
    /**
    * @Route("/PackagedFood", name="PackagedFoodApi", methods={"GET"})
    */
    public function PackagedFoodApi(Request $request)
    {
    $data = new Grocery\Listing();
    $smallOutput = [];
    foreach ($data as $key => $value) {
    $GheeAndOils = $value->getFoodCategory()->getGheeAndOils();
    $DalAndPulses = $value->getFoodCategory()->getDalAndPulses();
    $RiceAndRiceProducts = $value->getFoodCategory()->getRiceAndRiceProducts();
    $SugarjaggeryAndSalt = $value->getFoodCategory()->getSugarjaggeryAndSalt();
    $Spreads = $value->getFoodCategory()->getSpreads();


    if ($DalAndPulses != NULL) {
    $smallOutput[] = array(
    "ItemID" => $DalAndPulses->getItemId(),
    // "ItemName" => $DalAndPulses->getName(),
    "products" => $DalAndPulses->getproducts(),
    "flavour" => $DalAndPulses->getlavour(),
    // "Weight" => $DalAndPulses->getWeight()->getValue(),
    "PackOff" => $DalAndPulses->getPackOff(),
    "Ingredients" => $DalAndPulses->getingredients(),
    "Container" => $DalAndPulses->getContainerType(),
    "form" => $DalAndPulses->getform()
    );
    } elseif ($GheeAndOils != NULL) {
    $smallOutput[] = array(
    "ItemID" => $GheeAndOils->getItemId(),
    // "ItemName" => $GheeAndOils->getName(),
    "TasteType" => $GheeAndOils->getProducts(),
    "Flavour" => $GheeAndOils->getFlavour(),
    // "Weight" => $GheeAndOils->getWeight()->getValue(),
    "PackOff" => $GheeAndOils->getPackOff(),
    "Ingredients" => $GheeAndOils->getingredients(),
    "Container" => $GheeAndOils->getContainerType(),
    "EAN" => $GheeAndOils->getForm()
    );
    } elseif ($RiceAndRiceProducts != NULL) {
    $smallOutput[] = array(
    "ItemID" => $RiceAndRiceProducts->getItemId(),
    // "ItemName" => $RiceAndRiceProducts->getName(),
    "TasteType" => $RiceAndRiceProducts->getTypes(),
    "Flavour" => $RiceAndRiceProducts->getFlavour(),
    // "Weight" => $RiceAndRiceProducts->getQuantity()->getValue(),
    "Ingredients" => $RiceAndRiceProducts->getingredients(),
    "Container" => $RiceAndRiceProducts->getContainerType(),
    );
    } elseif ($SugarjaggeryAndSalt != NULL) {
    $smallOutput[] = array(
    "ItemID" => $SugarjaggeryAndSalt->getItemId(),
    // "ItemName" => $SugarjaggeryAndSalt->getName(),
    "TasteType" => $SugarjaggeryAndSalt->getTypes(),
    "Flavour" => $SugarjaggeryAndSalt->getingredients(),
    // "Weight" => $SugarjaggeryAndSalt->getQuantity()->getValue(),
    "PackOff" => $SugarjaggeryAndSalt->getFlavour(),
    "Container" => $SugarjaggeryAndSalt->getContainerType()
    );
    } elseif ($Spreads != NULL) {
    $smallOutput[] = array(
    "ItemID" => $Spreads->getItemId(),
    // "ItemName" => $Spreads->getName(),
    "TasteType" => $Spreads->getTypes(),
    "Ingredients" => $Spreads->getingredients(),
    // "Weight" => $Spreads->getQuantity()->getValue(),
    "PackOff" => $Spreads->getFlavour(),
    "Container" => $Spreads->getContainerType()
    );
    }
    
    if($smallOutput!=NULL){
        $output[] = array(
        "SKU" => $value->getSKU(),
        "Description" => $value->getDescription(),
        // "FoodType" => $value->getFoodType(),
        // "Price" => $value->getPrice()->getValue(),
        // "ShelfLife" => $value->getShelfLife()->getValue(),
        // "Category" => $value->getCategory(),
        "ManufacturingDate" => $value->getManufacutureDate(),
        "ExpiryDate" => $value->getExpiryDate(),
        "Snacks" => $smallOutput
        );
        }}
    return $this->json(["success" => true, "data" => $output]);
    }


     /**
    * @Route("/Staples", name="StaplesFoodApi", methods={"GET"})
    */
    public function StaplesFoodApi(Request $request)
    {
    $data = new Grocery\Listing();
    $smallOutput = [];
    foreach ($data as $key => $value) {
    $DalAndPulses = $value->getFoodCategory()->getDalAndPulses();
    $GheeAndOils= $value->getFoodCategory()->getGheeAndOils();
    $RiceAndRiceProducts = $value->getFoodCategory()->getRiceAndRiceProducts();
    $SugarjaggeryAndSalt = $value->getFoodCategory()->getSugarjaggeryAndSalt();
   


    if ($DalAndPulses != NULL) {
    $smallOutput[] = array(
    
    // "Name" => $DalAndPulses->getName(),
    "ProductType" => $DalAndPulses->getProductType(),
    "Form" => $DalAndPulses->getForm(),
    "Polished" => $DalAndPulses->getPolished(),
    "Organic" => $DalAndPulses->getOrganic()
    // "Weight" => $DalAndPulses->getWeight()->getValue(),
    // "PackOff" => $DalAndPulses->getPackOff(),
    // "Ingredients" => $DalAndPulses->getingredients(),
    // "Container" => $DalAndPulses->getContainerType(),
    // "form" => $DalAndPulses->getform()
    );
    } elseif ($GheeAndOils != NULL) {
    $smallOutput[] = array(
        // "Name" => $DalAndPulses->getName(),
        "ProductType" => $DalAndPulses->getProductType(),
        "Form" => $DalAndPulses->getForm(),
        "Polished" => $DalAndPulses->getPolished(),
        "Organic" => $DalAndPulses->getOrganic()
    );
    } elseif ($RiceAndRiceProducts != NULL) {
    $smallOutput[] = array(
        // "Name" => $DalAndPulses->getName(),
        "ProductType" => $DalAndPulses->getProductType(),
        "Form" => $DalAndPulses->getForm(),
        "Polished" => $DalAndPulses->getPolished(),
        "Organic" => $DalAndPulses->getOrganic()
    );
    } elseif ($SugarjaggeryAndSalt != NULL) {
    $smallOutput[] = array(
        // "Name" => $DalAndPulses->getName(),
        "ProductType" => $DalAndPulses->getProductType(),
        "Form" => $DalAndPulses->getForm(),
        "Polished" => $DalAndPulses->getPolished(),
        "Organic" => $DalAndPulses->getOrganic()
    );
    } 
    
    if($smallOutput!=NULL){
        $output[] = array(
        "SKU" => $value->getSKU(),
        "Description" => $value->getDescription(),
        // "FoodType" => $value->getFoodType(),
        // "Price" => $value->getPrice()->getValue(),
        // "ShelfLife" => $value->getShelfLife()->getValue(),
        // "Category" => $value->getCategory(),
        "ManufacturingDate" => $value->getManufacutureDate(),
        "ExpiryDate" => $value->getExpiryDate(),
        "Snacks" => $smallOutput
        );
        }}
    return $this->json(["success" => true, "data" => $output]);
    }
}