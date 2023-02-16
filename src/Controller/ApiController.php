<?php

namespace App\Controller;

use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Model\DataObject\Grocery;
class ApiController extends FrontendController
{

    /**
     * @Route("/groceries", methods={"GET","POST"})
    */
    public function GroceriesData(Request $request): Response
    { //$object_array=[];
        $category = $request->get("category");
        $items = new Grocery\Listing();
        $items->setOrderKey("sku");
        $items->setOrder("asc");

        $Coffee = [];
        $Tea = [];
        $Juice = [];
        $Namkeen = [];
        $Biscuits = [];
        $Rice = [];
        $Pulses = [];
        $Chocolate = [];
        $Water=[];
        $pasta=[];
        $Ghee=[];
        $Sugar=[];
        $Baking=[];
        $JamHoney=[];
        $Spreads=[];


       

        foreach ($items as $item) {
            //$data_one_obj=[];
            $data_one_obj = [
                "SKU" => $item->getSKU(),
                "ProductName" => $item->getProductName(),
        "Description" => $item->getDescription(),
        "FoodType" => $item->getFoodType(),
        // "Price" => $value->getPrice()->getValue(),
        // "ShelfLife" => $value->getShelfLife()->getValue(),
        // "Category" => $value->getCategory(),
        "ManufacturingDate" => $item->getManufacutureDate(),
        "ExpiryDate" => $item->getExpiryDate(),
               
            ];

            if ($item->getFoodCategory()->getBiscuits()) {
                $specific =
                    [
                        'biscuitType' => $item->getFoodCategory()->getBiscuits()->getBiscuitType(),
                        'flavour' => $item->getFoodCategory()->getBiscuits()->getFlavour(),
                        'tasteType' => $item->getFoodCategory()->getBiscuits()->gettasteType(),
                    ];

                $Biscuits[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getNamkeen()) {
                $specific =
                    [
                        'namkeenType' => $item->getFoodCategory()->getNamkeen()->getSnacktype(),
                        'Flavour' => $item->getFoodCategory()->getNamkeen()->getFlavour(),
                        'tasteType' => $item->getFoodCategory()->getNamkeen()->gettasteType(),
                    ];

                $Namkeen[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getCoffee()) {
                $specific =
                    [
                        'BeanType' => $item->getFoodCategory()->getCoffee()->getBeanType(),
                        'Flavour' => $item->getFoodCategory()->getCoffee()->getFlavour(),
                        'formFactor' => $item->getFoodCategory()->getCoffee()->getFormFactor(),
                    ];

                $Coffee[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getJuices()) {
                $specific =
                    [
                        'juiceType' => $item->getFoodCategory()->getJuices()->getJuiceType(),
                        'flavour' => $item->getFoodCategory()->getJuices()->getFlavour(),
                        'isPulpy' => $item->getFoodCategory()->getJuices()->getIsPulpy(),
                    ];

                $Juice[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getTea()) {
                $specific =
                    [
                        'teaType' => $item->getFoodCategory()->getTea()->getTeaType(),
                        // 'form' => $item->getFoodCategory()->getTea()->getForm(),
                        'flavour' => $item->getFoodCategory()->getTea()->getFlavour(),
                    ];

                $Tea[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getDalAndPulses()) {
                $specific =
                    [
                        'ProductType' => $item->getFoodCategory()->getDalAndPulses()->getProductType(),
                        'Polished' => $item->getFoodCategory()->getDalAndPulses()->getPolished(),
                        'form' => $item->getFoodCategory()->getDalAndPulses()->getForm(),
                    ];

                $Pulses[] = array_merge($data_one_obj, $specific);
            } else if ($item->getFoodCategory()->getRiceAndRiceProducts()) {
                $specific =
                    [
                        'riceType' => $item->getFoodCategory()->getRiceAndRiceProducts()->getRiceType(),
                        // 'riceSize' => $item->getFoodCategory()->getRiceAndRiceProducts()->getRiceSize(),
                        // 'texture' => $item->getFoodCategory()->getRiceAndRiceProducts()->getTexture(),
                    ];

                $Rice[] = array_merge($data_one_obj, $specific);
            }  else if ($item->getFoodCategory()->getChocolateSweet()) {
                $specific =
                    [
                        'ProductType' => $item->getFoodCategory()->getChocolateSweet()->getProductType(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        'packOf' => $item->getFoodCategory()->getChocolateSweet()->getPackOf(),
                    ];

                $Chocolate[] = array_merge($data_one_obj, $specific);
            } 
                else if ($item->getFoodCategory()->getWater()) {
                $specific =
                    [
                        'ProductType' => $item->getFoodCategory()->getWater()->getWaterType(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        'packOff' => $item->getFoodCategory()->getWater()->getPackOff(),
                    ];

                $Water[] = array_merge($data_one_obj, $specific);
            }
                else if ($item->getFoodCategory()->getPasta()) {
                    $specific =
                        [
                            'flavour' => $item->getFoodCategory()->getPasta()->getflavour(),
                            // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                            'form' => $item->getFoodCategory()->getPasta()->getform(),
                        ];

                    $pasta[] = array_merge($data_one_obj, $specific);
                }
            else if ($item->getFoodCategory()->getGheeAndOils()) {
                $specific =
                    [
                        'OilType' => $item->getFoodCategory()->getGheeAndOils()->getOilType(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        // 'form' => $item->getFoodCategory()->getGheeAndOils()->getform(),
                    ];

                $Ghee[] = array_merge($data_one_obj, $specific);
            }
            else if ($item->getFoodCategory()->getSugarJaggeryAndSalt()) {
                $specific =
                    [
                        'PeoductType' => $item->getFoodCategory()->getSugarJaggeryAndSalt()->getProductType(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        // 'form' => $item->getFoodCategory()->getGheeAndOils()->getform(),
                    ];

                $Ghee[] = array_merge($data_one_obj, $specific);
            }
            else if ($item->getFoodCategory()->getBaking()) {
                $specific =
                    [
                        'PeoductType' => $item->getFoodCategory()->getBaking()->getflavour(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        'form' => $item->getFoodCategory()->getBaking()->getform(),
                    ];

                $Baking[] = array_merge($data_one_obj, $specific);
            }
            else if ($item->getFoodCategory()->getJamsHoney()) {
                $specific =
                    [
                        'PeoductType' => $item->getFoodCategory()->getJamsHoney()->getflavour(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        'types' => $item->getFoodCategory()->getJamsHoney()->gettypes(),
                    ];

                $JamHoney[] = array_merge($data_one_obj, $specific);
            }
            else if ($item->getFoodCategory()->getSpreads()) {
                $specific =
                    [
                        'PeoductType' => $item->getFoodCategory()->getSpreads()->getflavour(),
                        // 'isGourmet' => $item->getFoodCategory()->getChocolateSweet()->getIsGourmet(),
                        'types' => $item->getFoodCategory()->getSpreads()->gettypes(),
                    ];

                $Spreads[] = array_merge($data_one_obj, $specific);
            }
        }

        if ($category == "Biscuits") {
            return $this->json(['Biscuits' => $Biscuits]);
        } 
         else if ($category == "Namkeen") {
            return $this->json(['Namkeen' => $Namkeen]);
        } else if ($category == "Coffee") {
            return $this->json(['Coffee' => $Coffee]);
        } else if ($category == "Juice") {
            return $this->json(['Juice' => $Juice]);
        } else if ($category == "Tea") {
            return $this->json(['Tea' => $Tea]);
        } else if ($category == "Pulses") {
            return $this->json(['Pulses' => $Pulses]);
        } else if ($category == "Rice") {
            return $this->json(['Rice' => $Rice]);
        }  else if ($category == "Chocolate") {
            return $this->json(['Chocolate' => $Chocolate]);
        }
        else if ($category == "Water") {
            return $this->json(['Water' => $Water]);
            
        } 
        else if ($category == "pasta") {
            return $this->json(['pasta' => $pasta]);
            
        } 
        else if ($category == "Ghee") {
            return $this->json(['Ghee' => $Ghee]);
            
        } 
        else if ($category == "Sugar") {
            return $this->json(['Sugar' => $Sugar]);
            
        } 
        else if ($category == "JamHoney") {
            return $this->json(['JamHoney' => $JamHoney]);
            
        } 
        else if ($category == "Baking") {
            return $this->json(['Baking' => $Baking]);
            
        } 
        else if ($category == "Spreads") {
            return $this->json(['Spreads' => $Spreads]);
            
        }   
        
        else if ($category == "All") {
            return $this->json([
                'Biscuits' => $Biscuits,
                'Namkeen' => $Namkeen,
                'Coffee' => $Coffee,
                'Juice' => $Juice,
                'Tea' => $Tea,
                'Pulses' => $Pulses,
                'Rice' => $Rice,
                'Chocolate' => $Chocolate,
                'Sugar' => $Sugar,
                'Ghee' =>  $Ghee,
                'pasta' => $pasta,
                'Water' => $Water,
                'JamHoney' =>  $JamHoney,
                'Baking' =>  $Baking,
                'Sugar' => $Sugar,
                'Spreads' => $Spreads       
            ]);
        } else {
            return $this->json(['message' => "Please enter a valid category"]);
        }
    }
}



    

    




