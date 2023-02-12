<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pimcore\Model\DataObject;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Grocery\Listing;


class DefaultController extends FrontendController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function defaultAction(Request $request): Response
    {
        return $this->render('default/default.html.twig');
    }

    /**
     * @Route("/test", methods={"GET", "POST"})
     */

     public function snacksApi(Request $request)
     {
         $data = new DataObject\Grocery\Listing();
         foreach ($data as $key => $value) {
             $Biscuits=$value->getFoodCategory()->getBiscuits();
             $Namkeen=$value->getFoodCategory()->getNamkeen();
             $Cofee=$value->getFoodCategory()->getCoffee();
             $Tea=$value->getFoodCategory()->getTea();
             $Juices=$value->getFoodCategory()->getJuices();
             $Water=$value->getFoodCategory()->getWater();
 
             
 
             if($Biscuits != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Biscuits->getItemId(),
                 "ItemName"=>$Biscuits->getName(),
                 "TasteType"=>$Biscuits->getTasteType(),
                 "BiscuitType"=>$Biscuits->getBiscuitType(),
                 "Flavour"=>$Biscuits->getFlavour(),
                 "Weight"=>$Biscuits->getWeight()->getValue(),
                 "QuantityOfItem"=>$Biscuits->getQuantityOfItem(),
                 "PackOff"=>$Biscuits->getPackOff(),
                 "Ingredients"=>$Biscuits->getIngrediant(),
                 "Container"=>$Biscuits->getContainerType(),
                 "EAN"=>$Biscuits->getEAN()
                 );
             }
             elseif($Namkeen != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Namkeen->getItemId(),
                 "ItemName"=>$Namkeen->getName(),
                 "TasteType"=>$Namkeen->getTasteType(),
                 "BiscuitType"=>$Namkeen->getSnacktype(),
                 "Flavour"=>$Namkeen->getFlavour(),
                 "Weight"=>$Namkeen->getWeight()->getValue(),
                 "QuantityOfItem"=>$Namkeen->getQuantityOfItem(),
                 "PackOff"=>$Namkeen->getPackOff(),
                 "Ingredients"=>$Namkeen->getIngrediant(),
                 "Container"=>$Namkeen->getContainerType(),
                 "EAN"=>$Namkeen->getEAN()
                 );
             }
             $output[] = array(
                 "SKU" => $value->getSKU(),
                 "Description" => $value->getDescription(),
                 "FoodType"=>$value->getFoodType(),
                 "Price"=>$value->getPrice()->getValue(),
                 "ShelfLife"=>$value->getShelfLife()->getValue(),
                 "Category"=>$value->getCategory(),
                 "ManufacturingDate"=>$value->getManufacutureDate(),
                 "ExpiryDate"=>$value->getExpiryDate(),
                 "Snacks"=>$smallOutput
             );  
             $smallOutput=[]; 
         }
 
         return $this->json(["success" => true, "data" => $output]);
     }
     /**
     * @Route("/Beverages", name="beveragesApi", methods={"GET"})
     */
     public function beveragesApi(Request $request)
     {
         $data = new DataObject\Grocery\Listing();
         foreach ($data as $key => $value) {
             $Coffee=$value->getFoodCategory()->getCoffee();
             $Tea=$value->getFoodCategory()->getTea();
             $Juice=$value->getFoodCategory()->getJuices();
             $Water=$value->getFoodCategory()->getWater();
 
             
 
             if($Coffee != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Coffee->getItemId(),
                 "ItemName"=>$Coffee->getName(),
                 "TasteType"=>$Coffee->getBeanType(),
                 "BiscuitType"=>$Coffee->getFormFactor(),
                 "Flavour"=>$Coffee->getFlavour(),
                 "Weight"=>$Coffee->getWeight()->getValue(),
                 "PackOff"=>$Coffee->getPackOff(),
                 "Ingredients"=>$Coffee->getIngrediant(),
                 "Container"=>$Coffee->getContainerType(),
                 "EAN"=>$Coffee->getEAN()
                 );
             }
             elseif($Tea != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Tea->getItemId(),
                 "ItemName"=>$Tea->getName(),
                 "TasteType"=>$Tea->getTeaType(),
                 "Flavour"=>$Tea->getFlavour(),
                 "Weight"=>$Tea->getWeight()->getValue(),
                 "QuantityOfItem"=>$Tea->getQuantityOfItem(),
                 "PackOff"=>$Tea->getPackOff(),
                 "Ingredients"=>$Tea->getIngrediant(),
                 "Container"=>$Tea->getContainerType(),
                 "EAN"=>$Tea->getEAN()
                 );
             }
             elseif($Juice != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Juice->getItemId(),
                 "ItemName"=>$Juice->getName(),
                 "TasteType"=>$Juice->getJuiceType(),
                 "IsPulpy"=>$Juice->getIsPuply(),
                 "Flavour"=>$Juice->getFlavour(),
                 "Weight"=>$Juice->getWeight()->getValue(),
                 "PackOff"=>$Juice->getPackOff(),
                 "Ingredients"=>$Juice->getIngrediant(),
                 "Container"=>$Juice->getContainerType(),
                 "EAN"=>$Juice->getEAN()
                 );
             }
             elseif($Water != NULL)
             {
                 $smallOutput[]=array(
                 "ItemID"=>$Water->getItemId(),
                 "ItemName"=>$Water->getName(),
                 "TasteType"=>$Water->getWaterType(),
                 // "BiscuitType"=>$Water->getSnacktype(),
                 "Flavour"=>$Water->getFlavour(),
                 "Weight"=>$Water->getWeight()->getValue(),
                 // "QuantityOfItem"=>$Water->getQuantityOfItem(),
                 "PackOff"=>$Water->getPackOff(),
                 // "Ingredients"=>$Water->getIngrediant(),
                 "Container"=>$Water->getContainerType(),
                 "EAN"=>$Water->getEAN()
                 );
             }
             $output[] = array(
                 "SKU" => $value->getSKU(),
                 "Description" => $value->getDescription(),
                 "FoodType"=>$value->getFoodType(),
                 "Price"=>$value->getPrice()->getValue(),
                 "ShelfLife"=>$value->getShelfLife()->getValue(),
                 "Category"=>$value->getCategory()[0]->getCategoryType(),
                 "ManufacturingDate"=>$value->getManufacutureDate(),
                 "ExpiryDate"=>$value->getExpiryDate(),
                 "Snacks"=>$smallOutput
             );  
             $smallOutput=[]; 
         }
 
         return $this->json(["success" => true, "data" => $output]);
     }
}
