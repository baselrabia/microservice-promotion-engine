<?php

namespace App\DTO;


interface PriceEnquiryInterface extends PromotionEnquiryInterface
{
    public function setPrice(int $price);

    public function getQuantity();

    public function setDiscountedPrice(int $price);
}