<?php

namespace App\Filter;


use App\DTO\PriceEnquiryInterface;
use App\Entity\Promotion;

interface PriceFilterInterface extends promotionsFilterInterface
{
    public function apply(PriceEnquiryInterface $enquiry,Promotion ...$promotions): PriceEnquiryInterface;
}