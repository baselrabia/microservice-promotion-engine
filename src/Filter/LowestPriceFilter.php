<?php

namespace App\Filter;


use App\DTO\PriceEnquiryInterface;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;
use App\Filter\Modifier\Factory\PriceModifierFactoryInterface;

class LowestPriceFilter implements promotionsFilterInterface
{

    public function __construct(private PriceModifierFactoryInterface $priceModifierFactory)
    {
    }


    // loop over the coming promotions
        // run the promotions modifications logic against the enquiry
        // 1. check does the promotion apply e.g is it in date range / is the voucher code valid
        // 2. apply the price modifications to obtain a $modified Price (how?)
    // $modifiedPrice = $priceModifier->modify($enquiry , $promotion);
        // 3. check if the $modifiedPrice < $lowest price
        //  // 1. sane the Enquiry Properties
        //  // 2. update $lowestPrice
        //

    public function apply(PromotionEnquiryInterface $enquiry,Promotion ...$promotions): PriceEnquiryInterface
    {
        $price = $enquiry->getProduct()->getPrice();
        $enquiry->setPrice($price);
        $quantity = $enquiry->getQuantity();
        $lowestPrice = $quantity * $price;
        foreach ($promotions as $promotion) {

            $priceModifier = $this->priceModifierFactory->create($promotion->getType());

            $modifiedPrice = $priceModifier->modify($price, $quantity, $promotion, $enquiry);

            if($modifiedPrice < $lowestPrice) {

                $enquiry->setDiscountedPrice($modifiedPrice);
                $enquiry->setPromotionId($promotion->getId());
                $enquiry->setPromotionName($promotion->getName());

                $lowestPrice = $modifiedPrice;
            }
        }

        return $enquiry;

        $enquiry->setDiscountedPrice(50);
        $enquiry->setPrice(100);
        $enquiry->setPromotionId(3);
        $enquiry->setPromotionName('Black Friday half price sale');

        return $enquiry;
    }
}