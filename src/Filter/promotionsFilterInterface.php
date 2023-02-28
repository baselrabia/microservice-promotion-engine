<?php

namespace App\Filter;


use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

interface promotionsFilterInterface
{
    public function apply(PromotionEnquiryInterface $enquiry,Promotion ...$promotions): PromotionEnquiryInterface;

}